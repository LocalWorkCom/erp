<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request)
    {
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided

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
                $data['image'] = BaseUrl() . $data['image'];
            }
            return $data;
        });

        return ResponseWithSuccessData($lang, $categories, 1);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable',  // Adjust this rule based on your requirements
            'is_freeze' => 'required|boolean',
            'parent_id' => 'nullable|integer',
        ]);
    
        $GetLastID = GetLastID('categories');
        // dd($GetLastID);

        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided

        $name_ar = $validatedData['name_ar'];
        $name_en = $validatedData['name_en'];
        $description_ar = $validatedData['description_ar'] ?? null;
        $description_en = $validatedData['description_en'] ?? null;
        $image = $request->file('image');  // Handle file upload if necessary
        $code = GenerateCategoryCode(($GetLastID == 1) ? 0 : $GetLastID);
        $is_freeze = $validatedData['is_freeze'];
        $parent_id = isset($request->parent_id) && !empty($request->parent_id) ? $request->parent_id : null;
        $created_by = '1';
        
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
        UploadFile('images/categories', 'image', $category, $image);

        return RespondWithSuccessRequest($lang, 1);
    }
}
