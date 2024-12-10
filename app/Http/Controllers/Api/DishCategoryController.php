<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DishCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DishCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $withTrashed = $request->query('withTrashed', false);

            $categories = $withTrashed ? DishCategory::withTrashed()->with(['parent', 'children'])->get() : DishCategory::with(['parent', 'children'])->get();

            return ResponseWithSuccessData($lang, $categories, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching dish categories: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $category = DishCategory::withTrashed()->with(['parent', 'children'])->findOrFail($id);

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $request->merge(['is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)]);

            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'is_active' => 'required|boolean',
                'parent_id' => 'nullable|exists:dish_categories,id',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
            ]);


            
            $categoryData = [
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'parent_id' => $request->parent_id,
                'is_active' => $request->is_active,
                'created_by' => auth()->id(),
            ];

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('dish_categories', 'public');
                $categoryData['image_path'] = $imagePath;
            }

            $category = DishCategory::create($categoryData);

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error creating dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $request->merge(['is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)]);

            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'is_active' => 'required|boolean',
                'parent_id' => 'nullable|exists:dish_categories,id',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
            ]);

            $category = DishCategory::findOrFail($id);

            $categoryData = [
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'parent_id' => $request->parent_id,
                'is_active' => $request->is_active,
                'modified_by' => auth()->id(),
            ];

            if ($request->hasFile('image')) {
                if ($category->image_path && Storage::exists($category->image_path)) {
                    Storage::delete($category->image_path);
                }
                $imagePath = $request->file('image')->store('dish_categories', 'public');
                $categoryData['image_path'] = $imagePath;
            }

            $category->update($categoryData);

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error updating dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $category = DishCategory::findOrFail($id);
            $category->update(['deleted_by' => auth()->id()]);
            $category->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $category = DishCategory::withTrashed()->findOrFail($id);
            $category->restore();

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
