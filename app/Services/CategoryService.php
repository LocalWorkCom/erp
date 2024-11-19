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

class CategoryService
{
    
    public function index(Request $request, $checkToken)
    {

        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $categories = Category::all();

        // dd($categories);
        
        if (!$checkToken) {
            $categories = $categories->makeVisible(['name_en', 'name_ar', 'image', 'description_ar', 'description_en']);
        }
    
        return ResponseWithSuccessData($lang, $categories, 1);
    }
    public function store(Request $request, $checkToken)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);
        if (!CheckToken() && $checkToken) {
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
    public function update(Request $request, $id, $checkToken)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);
        if (!CheckToken() && $checkToken) {
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
    public function delete(Request $request, $id, $checkToken)
    {
        // Fetch the language header for response
        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        App::setLocale($lang);

        if (!CheckToken() && $checkToken) {
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
