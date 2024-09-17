<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use Illuminate\Http\Request;

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

            return $data;
        });

        return ResponseWithSuccessData($lang, $products, 1);
    }
    public function store(Request $request)
    {
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

        $GetLastID = GetLastID('products');

        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided

        $name_ar = $validatedData['name_ar'];
        $name_en = $validatedData['name_en'];
        $description_ar = $validatedData['description_ar'] ?? null;
        $description_en = $validatedData['description_en'] ?? null;
        $main_image = $request->file('main_image');  // Handle file upload if necessary
        $is_valid = $validatedData['is_valid'];
        $type = $validatedData['type'];
        $is_remind = $validatedData['is_remind'];
        $limit_quantity = $validatedData['limit_quantity'];
        $main_unit_id = $validatedData['main_unit_id'];  // Correctly pulling from validated data
        $currency_code = $validatedData['currency_code'];
        $category_id = $validatedData['category_id'];

        $code = GenerateCategoryCode(($GetLastID == 1) ? 0 : $GetLastID);
        $sku = GenerateCategoryCode(($GetLastID == 1) ? 0 : $GetLastID);
        $barcode = GenerateCategoryCode(($GetLastID == 1) ? 0 : $GetLastID);

        // Assuming 'created_by' is hardcoded or based on the authenticated user
        $created_by = '1';

        $product = new Product();
        $product->name_ar = $name_ar;
        $product->name_en = $name_en;
        $product->description_ar = $description_ar;
        $product->description_en = $description_en;
        $product->code = $code;
        $product->type = $type;
        $product->sku = $sku;
        $product->barcode = $barcode;
        $product->is_valid = $is_valid;
        $product->is_remind = $is_remind;
        $product->limit_quantity = $limit_quantity;
        $product->main_unit_id = $main_unit_id;  // Ensure this is set
        $product->currency_code = $currency_code;
        $product->category_id = $category_id;
        $product->created_by = $created_by;

        $product->save();

        UploadFile('images/products', 'main_image', $product, $main_image);  // Handle image upload

        return RespondWithSuccessRequest($lang, 1);
    }
    public function update(Request $request, $id)
    {
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
        $product->limit_quantity = $validatedData['limit_quantity'];
        $product->main_unit_id = $validatedData['main_unit_id'];
        $product->currency_code = $validatedData['currency_code'];
        $product->category_id = $validatedData['category_id'];

        // Handle the image upload if a new image is provided
        $main_image = $request->file('main_image');
        if ($main_image) {
            // Assuming you have a method to delete the old image if necessary
            // $this->deleteOldImage($product->main_image);

            // Upload the new image
            UploadFile('images/products', 'main_image', $product, $main_image);
        }

        // Save the updated product
        $product->save();

        // Return success response
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided
        return RespondWithSuccessRequest($lang, 1);
    }
    public function delete(Request $request, $id)
    {
        // Fetch the language header for response
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided

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
