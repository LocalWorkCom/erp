<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RecipeCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RecipeCategoryController extends Controller
{
    /**
     * Get all recipe categories.
     */
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $categories = RecipeCategory::all(); // Fetch all categories

            return ResponseWithSuccessData($lang, $categories, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching recipe categories: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Store a new recipe category.
     */
    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $request->merge([
                'is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000', // Image validation
                'is_active' => 'required|boolean',
            ]);

            // Upload the image
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('recipe_categories', 'public');
            }

            $category = RecipeCategory::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'image_path' => $imagePath,
                'is_active' => $request->is_active,
                'created_by' => auth()->id(),
            ]);

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error creating recipe category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Get a specific recipe category by ID.
     */
    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $category = RecipeCategory::findOrFail($id);

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching recipe category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Update a recipe category by ID.
     */
    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $request->merge([
                'is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
                'is_active' => 'required|boolean',
            ]);

            $category = RecipeCategory::findOrFail($id);

            // Upload new image and delete the old one
            if ($request->hasFile('image')) {
                if (Storage::exists($category->image_path)) {
                    Storage::delete($category->image_path);
                }
                $imagePath = $request->file('image')->store('recipe_categories', 'public');
            } else {
                $imagePath = $category->image_path;
            }

            $category->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'image_path' => $imagePath,
                'is_active' => $request->is_active,
                'modified_by' => auth()->id(),
            ]);

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error updating recipe category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Soft delete a recipe category.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $category = RecipeCategory::findOrFail($id);
            $category->update(['deleted_by' => auth()->id()]);
            $category->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting recipe category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Restore a soft-deleted recipe category.
     */
    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $category = RecipeCategory::withTrashed()->findOrFail($id);
            $category->restore();

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring recipe category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
