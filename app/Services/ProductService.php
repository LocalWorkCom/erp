<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductLimit;
use App\Models\ProductImage;
use App\Models\ProductTransaction;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductUnit;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductService
{
    // In ProductService.php

    // Helper method to check if the product data hasn't changed
    protected function isProductUnchanged($product, $request)
    {
        return $product->name_ar == $request->name_ar &&
            $product->name_en == $request->name_en &&
            $product->description_ar == $request->description_ar &&
            $product->description_en == $request->description_en &&
            $product->is_have_expired == $request->is_have_expired &&
            $product->type == $request->type &&
            $product->is_remind == $request->is_remind &&
            $product->main_unit_id == $request->main_unit_id &&
            $product->currency_code == $request->currency_code &&
            $product->category_id == $request->category_id &&
            $product->sku == $request->sku &&
            $product->barcode == $request->barcode;
    }

    // Method to get all products with their limits
    public function index(Request $request)
    {
        $lang = $request->header('lang', 'ar');  // Default to 'ar' if not provided
        $products = Product::all();

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        foreach ($products as $product) {
            $product_limits = ProductLimit::where('product_id', $product->id)->get();
            $product['limits'] = $product_limits;
        }

        return ResponseWithSuccessData($lang, $products, 1);
    }

    // Method to store a new product
    public function store(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'main_image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_have_expired' => 'required|boolean',
            'type' => 'required|string|in:complete,raw',
            'is_remind' => 'required|boolean',
            'sku' => 'required|string|unique:products',
            'barcode' => 'required|string|unique:products',
            'limit_quantity' => 'nullable|integer',
            'main_unit_id' => 'required|integer',
            'currency_code' => 'required|string',
            'category_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Check if product or category name already exists
        if (CheckExistColumnValue('products', 'name_ar', $request->name_ar) || CheckExistColumnValue('categories', 'name_en', $request->name_en)) {
            return RespondWithBadRequest($lang, 9);
        }

        // Check if category exists
        $category = Category::find($request->category_id);
        if (!$category) {
            return RespondWithBadRequestData($lang, 8);
        }

        // Check if store exists
        $store = Store::find($request->store_id);
        if (!$store) {
            return RespondWithBadRequestData($lang, 8);
        }

        // Check if brand exists
        $brand = Brand::find($request->brand_id);
        if (!$brand) {
            return RespondWithBadRequestData($lang, 8);
        }

        // Generate product code
        $GetLastID = GetLastID('products');
        $code = GenerateCode('products', $GetLastID);

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

        // Save product limits
        $product_limit = new ProductLimit();
        $product_limit->product_id = $product->id;
        $product_limit->min_limit = $request->min_limit;
        $product_limit->max_limit = $request->max_limit;
        $product_limit->store_id = $request->store_id;
        $product_limit->save();

        // Handle file upload (main image)
        if ($request->hasFile('main_image')) {
            $main_image = $request->file('main_image');
            UploadFile('images/products', 'main_image', $product, $main_image);
        }

        // Handle gallery images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $validator = Validator::make($request->all(), [
                'images.*' => 'mimes:jpeg,jpg,png,gif,svg|max:2048'
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

        return RespondWithSuccessRequest($lang, 1);
    }

    // Method to update an existing product
    public function update(Request $request, $id)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'main_image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_have_expired' => 'required|boolean',
            'type' => 'required|string|in:complete,raw',
            'is_remind' => 'required|boolean',
            'sku' => 'required|string',
            'barcode' => 'required|string',
            'main_unit_id' => 'required|integer',
            'currency_code' => 'required|string',
            'category_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        $product = Product::find($id);
        if (!$product) {
            return RespondWithBadRequestData($lang, 8);
        }

        // Check if data hasn't changed
        if ($this->isProductUnchanged($product, $request)) {
            return RespondWithBadRequestData($lang, 10);
        }

        // Validate product name
        if (CheckExistColumnValue('products', 'name_ar', $request->name_ar)) {
            return RespondWithBadRequest($lang, 9);
        }

        // Update product attributes
        $product->update($request->only([
            'name_ar',
            'name_en',
            'description_ar',
            'description_en',
            'type',
            'is_have_expired',
            'is_remind',
            'sku',
            'barcode',
            'main_unit_id',
            'currency_code',
            'category_id'
        ]));

        // Handle image upload (main image)
        if ($request->hasFile('main_image')) {
            $main_image = $request->file('main_image');
            DeleteFile('images/products', $product->main_image);
            UploadFile('images/products', 'main_image', $product, $main_image);
        }

        // Handle gallery images
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
        ProductImage::where('product_id', $id)->delete();
        ProductSize::where('product_id', $id)->delete();
        ProductColor::where('product_id', $id)->delete();
        ProductUnit::where('product_id', $id)->delete();

        // Delete the category
        $product->delete();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
