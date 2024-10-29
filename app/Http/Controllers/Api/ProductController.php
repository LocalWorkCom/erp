<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductLimit;
use App\Models\ProductSize;
use App\Models\ProductTransaction;
use App\Models\ProductUnit;
use App\Models\Store;
use App\Models\StoreTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use PDO;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request)
    {
        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided

        $products = Product::all();
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Define columns that need translation
        $translateColumns = ['name', 'description']; // Add other columns as needed

        // Define columns to remove (translated columns)
        $columnsToRemove = array_map(function ($col) {
            return [$col . '_ar', $col . '_en'];
        }, $translateColumns);
        $columnsToRemove = array_merge(...$columnsToRemove);

        // Map categories to include translated columns and remove unnecessary columns
        $products = $products->map(function ($category) use ($lang, $translateColumns, $columnsToRemove) {
            // Convert category model to an array
            $data = $category->toArray();

            // Get translated data
            $data = translateDataColumns($data, $lang, $translateColumns);

            // Remove translated columns from data
            $data = removeColumns($data, $columnsToRemove);

            // Update main_image key by concatenating with base URL
            if (isset($data['main_image']) && !empty($data['main_image'])) {
                $data['main_image'] = BaseUrl() . '/' . $data['main_image'];
            }
            $product_images = ProductImage::where('product_id', $data['id'])->get();
            foreach ($product_images as $key => $value) {
                $value->image = BaseUrl() . '/' . $value->image;
            }
            $product_limits = ProductLimit::where('product_id', $data['id'])->get();

            $data['product_images'] = $product_images;
            $data['limits'] = $product_limits;
            return $data;
        });

        return ResponseWithSuccessData($lang, $products, 1);
    }
    public function store(Request $request)
    {
        // Set locale based on header
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Validate the input
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'main_image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validate main image
            'is_have_expired' => 'required|boolean',
            'type' => 'required|string|in:complete,raw',
            'is_remind' => 'required|boolean',
            'sku' => 'required|string|unique:products',  // Correct unique rule
            'barcode' => 'required|string|unique:products',  // Correct unique rule
            'limit_quantity' => 'nullable|integer',
            'main_unit_id' => 'required|integer',
            'currency_code' => 'required|string',
            'category_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Generate product code
        $GetLastID = GetLastID('products');
        $code = GenerateCode('products', $GetLastID);
        if (CheckExistColumnValue('products', 'name_ar', $request->name_ar) || CheckExistColumnValue('categories', 'name_en', $request->name_en)) {
            return RespondWithBadRequest($lang, 9);
        }
        $category = Category::find($request->category_id);
        if (!$category) {
            return  RespondWithBadRequestData($lang, 8);
        }
        $store = Store::find($request->store_id);
        if (!$store) {
            return  RespondWithBadRequestData($lang, 8);
        }
        
        // Create a new product
        $product = new Product();
        $product->name_ar = $request->name_ar;
        $product->name_en = $request->name_en;
        $product->description_ar = $request->description_ar;
        $product->description_en = $request->description_en;
        $product->code = $code;
        $product->brand_id = $request->brand_id;
        $product->type = $request->type;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->is_have_expired = $request->is_have_expired;
        $product->is_remind = $request->is_remind;
        $product->main_unit_id = $request->main_unit_id;
        $product->currency_code = $request->currency_code;
        $product->category_id = $request->category_id;
        $product->created_by = Auth::guard('api')->user()->id;
        $product->save();

        $product_limit = new ProductLimit();
        $product_limit->product_id = $product->id;
        $product_limit->min_limit = $request->min_limit;
        $product_limit->max_limit = $request->max_limit;
        $product_limit->store_id = $request->store_id;
        $product_limit->save();


        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $main_image = $request->file('main_image');
            UploadFile('images/products', 'main_image', $product, $main_image);
        }

        // Handle gallery images upload
        if ($request->hasFile('images')) {
            // Validate image extensions for all files in the 'images' array
            $validator = Validator::make($request->all(), [
                'images.*' => 'mimes:jpeg,jpg,png,gif,svg|max:2048'  // Validate each image in the 'images' array
            ]);

            if ($validator->fails()) {
                return RespondWithBadRequestWithData($validator->errors());
            }
            $images = $request->file('images');

            foreach ($images as $image) {
                if ($image->isValid()) {
                    $product_image = new ProductImage();
                    $product_image->product_id = $product->id;
                    $product_image->created_by = Auth::guard('api')->user()->id;
                    $product_image->save();
                    UploadFile('images/products/gallery', 'image', $product_image, $image);
                }
            }
        }


        return RespondWithSuccessRequest($lang, 1);
    }

    public function update(Request $request, $id)
    {
        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'main_image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validate main image
            'is_have_expired' => 'required|boolean',
            'type' => 'required|string|in:complete,raw',  // Enforce enum-like values
            'is_remind' => 'required|boolean',
            'code' => 'nullable',
            'sku' => 'required',
            'barcode' => 'required',
            'main_unit_id' => 'required|integer',
            'currency_code' => 'required|string',  // Assuming this should also be required
            'category_id' => 'required|integer'  // Assuming this should also be required
        ]);
        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Find the product by ID
        $product = Product::find($id);
        if (!$product) {
            return  RespondWithBadRequestData($lang, 8);
        }
        // dd($category, $request);
        if (
            $product->name_ar == $request->name_ar && $product->name_en == $request->name_en &&  $product->description_ar == $request->description_ar
            &&  $product->description_en == $request->description_en && $product->is_have_expired == $request->is_have_expired  && $product->type == $request->type
            && $product->is_remind == $request->is_remind  && $product->main_unit_id == $request->main_unit_id  && $product->currency_code == $request->currency_code  && $product->category_id == $request->category_id
            && $product->sku == $request->sku  && $product->barcode == $request->barcode
        ) {
            return  RespondWithBadRequestData($lang, 10);
        }
        if (CheckExistColumnValue('products', 'name_ar', $request->name_ar) || CheckExistColumnValue('categories', 'name_en', $request->name_en)) {
            return RespondWithBadRequest($lang, 9);
        }
        // Update the product attributes
        $product->name_ar = $request->name_ar;
        $product->name_en = $request->name_en;
        $product->description_ar = $request->description_ar ?? null;
        $product->description_en = $request->description_en ?? null;
        $product->is_have_expired = $request->is_have_expired;
        $product->type = $request->type;
        $product->is_remind = $request->is_remind;
        $product->main_unit_id = $request->main_unit_id;
        $product->currency_code = $request->currency_code;
        $product->category_id = $request->category_id;
        $product->sku = $request->sku;
        $product->brand_id = $request->brand_id;

        $product->barcode = $request->barcode;
        // Handle the image upload if a new image is provided
        $main_image = $request->file('main_image');
        if ($main_image) {
            // Assuming you have a method to delete the old image if necessary
            DeleteFile('images/products', $product->main_image);
            // Upload the new image
            UploadFile('images/products', 'main_image', $product, $main_image);
        }

        // Save the updated product
        $product->save();
        // Handle gallery images upload
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $validator = Validator::make($request->all(), [
                'images.*' => 'mimes:jpeg,jpg,png,gif,svg|max:2048'  // Validate each image in the 'images' array
            ]);

            if ($validator->fails()) {
                return RespondWithBadRequestWithData($validator->errors());
            }
            foreach ($images as $image) {
                if ($image->isValid()) {
                    $product_image = new ProductImage();
                    $product_image->product_id = $product->id;
                    $product_image->created_by = Auth::guard('api')->user()->id;
                    $product_image->save();
                    UploadFile('images/products/gallery', 'image', $product_image, $image);
                }
            }
        }
        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
    function DeleteExistProductImage(Request $request) {}
    public function delete(Request $request, $id)
    {
        // Fetch the language header for response
        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Find the category by ID, or throw a 404 if not found
        $product = Product::find($id);
        if (!$product) {
            return  RespondWithBadRequestData($lang, 8);
        }
        $CheckIfExist1 = ProductTransaction::where('product_id', $id)->get();
        // $CheckIfExist2 = StoreTransaction::where('product_id', $id)->get();
        if ($CheckIfExist1->count()) {
            $response_array = array(
                'success' => false,  // Set success to false to indicate an error
                'apiTitle' => trans('validation.NotAllow'),
                'apiMsg' => trans('validation.NotAllowMessage'),
                'apiCode' => -1,
                'data'   => []
            );

            // Change the response code to 404 for "Not Found"
            $response_code = 401;

            return Response::json($response_array, $response_code);
        }
        // Handle deletion of associated image if it exists
        if ($product->image) {
            $imagePath = public_path('images/products/' . $product->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $ProductImages = ProductImage::where('product_id', $id)->delete();
        $ProductSize = ProductSize::where('product_id', $id)->delete();
        $ProductColor = ProductColor::where('product_id', $id)->delete();
        $ProductUnit = ProductUnit::where('product_id', $id)->delete();

        // Delete the category
        $product->delete();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
