<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request)
    {

        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        $categories = Category::all();

        // Define columns that need translation
        $translateColumns = ['name', 'description']; // Add other columns as needed

        // Define columns to remove (translated columns)
        $columnsToRemove = array_map(function ($col) {
            return [$col . '_ar', $col . '_en'];
        }, $translateColumns);
        $columnsToRemove = array_merge(...$columnsToRemove);

        // Map categories to include translated columns and remove unnecessary columns
        $categories = $categories->map(function ($category) use ($lang, $translateColumns, $columnsToRemove) {
            // Convert category model to an array
            $data = $category->toArray();

            // Get translated data
            $data = translateDataColumns($data, $lang, $translateColumns);

            // Remove translated columns from data
            $data = removeColumns($data, $columnsToRemove);
            if (isset($data['image']) && !empty($data['image'])) {
                $data['image'] = BaseUrl() . '/' . $data['image'];
            }
            return $data;
        });

        return ResponseWithSuccessData($lang, $categories, 1);
    }
    public function store(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',  // Restrict image extensions
            'is_freeze' => 'required|boolean',
            'parent_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }
        if (CheckExistColumnValue('categories', 'name_ar', $request->name_ar) || CheckExistColumnValue('categories', 'name_en', $request->name_en)) {
            return RespondWithBadRequest($lang, 9);
        }

        $GetLastID = GetLastID('categories');
        // dd($GetLastID);

        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided

        $name_ar = $request->name_ar;
        $name_en = $request->name_en;
        $description_ar = $request->description_ar;
        $description_en = $request->description_en;
        $image = $request->file('image');  // Handle file upload if necessary
        $code = GenerateCode('categories', ($GetLastID == 1) ? 0 : $GetLastID);
        $is_freeze = $request->is_freeze;
        $parent_id = isset($request->parent_id) && !empty($request->parent_id) ? $request->parent_id : null;
        if ($parent_id) {
            $category = Category::find($parent_id);
            if (!$category) {
                $category_valid['parent_id'] = ['الفئة غير موجودة'];
                return  RespondWithBadRequestWithData($category_valid);
            }
        }
        $created_by = Auth::guard('api')->user()->id;

        $category = new Category();
        $category->name_ar = $name_ar;
        $category->name_en =  $name_en;
        $category->description_ar = $description_ar;
        $category->description_en =  $description_en;
        $category->code = $code;
        $category->is_freeze = $is_freeze;
        $category->parent_id =  $parent_id;
        $category->created_by =  $created_by;
        $category->save();
        if ($request->hasFile('image')) {

            UploadFile('images/categories', 'image', $category, $image);
        }

        return RespondWithSuccessRequest($lang, 1);
    }
    public function update(Request $request, $id)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Validate the input
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',  // Restrict image extensions
            'is_freeze' => 'required|boolean',
            'parent_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Retrieve the category by ID, or throw an exception if not found
        $category = Category::find($id);
        if (!$category) {
            return  RespondWithBadRequestData($lang, 8);
        }
        // dd($category, $request);
        if ($category->name_ar == $request->name_ar && $category->name_en == $request->name_en &&  $category->description_ar == $request->description_ar &&  $category->description_en == $request->description_en && $category->is_freeze == $request->is_freeze  && $category->parent_id == $request->parent_id) {
            return  RespondWithBadRequestData($lang,10);
        }
        if (CheckExistColumnValue('categories', 'name_ar', $request->name_ar) || CheckExistColumnValue('categories', 'name_en', $request->name_en)) {
            return RespondWithBadRequest($lang, 9);
        }
        $modify_by = Auth::guard('api')->user()->id;

        // Assign the updated values to the category model
        $category->name_ar = $request->name_ar;
        $category->name_en = $request->name_en;
        $category->description_ar = $request->description_ar;
        $category->description_en = $request->description_en;
        $category->is_freeze = $request->is_freeze;
        $category->modify_by = $modify_by;
        $category->parent_id = isset($request->parent_id) && !empty($request->parent_id) ? $request->parent_id : null;

        // Handle file upload for the image if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            DeleteFile('images/categories', $category->image);
            UploadFile('images/categories', 'image', $category, $image);
        }

        // Update the category in the database
        $category->save();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
    public function delete(Request $request, $id)
    {
        // Fetch the language header for response
        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Find the category by ID, or throw a 404 if not found
        $category = Category::find($id);
        if (!$category) {
            return  RespondWithBadRequestData($lang, 8);
        }
        // Check if there are any products associated with this category
        if ($category->products()->count() > 0) {
            return RespondWithBadRequest($lang, 6);
        }

        // Handle deletion of associated image if it exists
        if ($category->image) {
            $imagePath = public_path('images/categories/' . $category->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        // Delete the category
        $category->delete();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
