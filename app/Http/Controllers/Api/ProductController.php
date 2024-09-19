<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request)
    {
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided

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
            $data['product_images'] = $product_images;
            return $data;
        });

        return ResponseWithSuccessData($lang, $products, 1);
    }
    public function store(Request $request)
    {
        // Set locale based on header
        $lang = $request->header('lang', 'en');
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
            'main_image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validate main image
            'is_valid' => 'required|boolean',
            'type' => 'required|string|in:complete,raw',
            'is_remind' => 'required|boolean',
            'code' => 'nullable|string',
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
        $code = GenerateCode('products', ($GetLastID == 1) ? 0 : $GetLastID);

        // Create a new product
        $product = new Product();
        $product->name_ar = $request->name_ar;
        $product->name_en = $request->name_en;
        $product->description_ar = $request->description_ar;
        $product->description_en = $request->description_en;
        $product->code = $code;
        $product->type = $request->type;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->is_valid = $request->is_valid;
        $product->is_remind = $request->is_remind;
        $product->main_unit_id = $request->main_unit_id;
        $product->currency_code = $request->currency_code;
        $product->category_id = $request->category_id;
        $product->created_by =Auth::guard('api')->user()->id;
        $product->save();

        // Handle main image upload
        if ($request->hasFile('main_image')) {
            $main_image = $request->file('main_image');
            UploadFile('images/products', 'main_image', $product, $main_image);
        }

        // Handle gallery images upload
        if ($request->hasFile('images')) {
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
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Validate the request data
        $validatedData = $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'main_image' => 'nullable|file',  // Ensure it's a file upload
            'is_valid' => 'required|boolean',
            'type' => 'required|string|in:complete,raw',  // Enforce enum-like values
            'is_remind' => 'required|boolean',
            'code' => 'nullable',
            'sku' => 'nullable',
            'barcode' => 'nullable',
            'limit_quantity' => 'nullable|integer',
            'main_unit_id' => 'required|integer',
            'currency_code' => 'required|string',  // Assuming this should also be required
            'category_id' => 'required|integer'  // Assuming this should also be required
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update the product attributes
        $product->name_ar = $validatedData['name_ar'];
        $product->name_en = $validatedData['name_en'];
        $product->description_ar = $validatedData['description_ar'] ?? null;
        $product->description_en = $validatedData['description_en'] ?? null;
        $product->is_valid = $validatedData['is_valid'];
        $product->type = $validatedData['type'];
        $product->is_remind = $validatedData['is_remind'];
        $product->main_unit_id = $validatedData['main_unit_id'];
        $product->currency_code = $validatedData['currency_code'];
        $product->category_id = $validatedData['category_id'];
        $product->sku = $request->sku;
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

            foreach ($images as $image) {
                if ($image->isValid()) {
                    $product_image = new ProductImage();
                    $product_image->product_id = $product->id;
                    $product_image->created_by =Auth::guard('api')->user()->id;
                    $product_image->save();
                    UploadFile('images/products/gallery', 'image', $product_image, $image);
                }
            }
        }
        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
    function DeleteExistProductImage(Request $request) 
    {

    }
    public function delete(Request $request, $id)
    {
        // Fetch the language header for response
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Find the category by ID, or throw a 404 if not found
        $product = Product::findOrFail($id);
        // Handle deletion of associated image if it exists
        if ($product->image) {
            $imagePath = public_path('images/categories/' . $product->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        // Delete the category
        $product->delete();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
