<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Recipe;
use App\Models\RecipeImage;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{

    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $withTrashed = $request->query('withTrashed', false);

            // Fetch recipes with images
            $recipes = $withTrashed
                ? Recipe::withTrashed()->with(['ingredients', 'images'])->get()
                : Recipe::with(['ingredients', 'images'])->get();

            return ResponseWithSuccessData($lang, $recipes, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching recipes: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

            $recipe = Recipe::withTrashed()->with(['ingredients', 'images'])->findOrFail($id);

            return ResponseWithSuccessData($lang, $recipe, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

 
    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');

            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'category_flag' => 'required|integer',
                'price' => 'required|numeric|min:0',
                'is_active' => 'required|boolean',
                'images' => 'nullable|array', 
                'images.*' => 'image|mimes:jpg,png,jpeg|max:2048', 
            ]);

            $recipe = Recipe::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'category_flag' => $request->category_flag,
                'price' => $request->price,
                'is_active' => $request->is_active,
                'created_by' => auth()->id(),
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('recipes', 'public');
                    RecipeImage::create([
                        'recipe_id' => $recipe->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            return ResponseWithSuccessData($lang, $recipe, 1);
        } catch (\Exception $e) {
            Log::error('Error creating recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'category_flag' => 'required|integer',
                'price' => 'required|numeric|min:0',
                'is_active' => 'required|boolean',
                'images' => 'nullable|array', 
                'images.*' => 'image|mimes:jpg,png,jpeg|max:2048', 
            ]);

            $recipe = Recipe::findOrFail($id);

            $recipe->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'category_flag' => $request->category_flag,
                'price' => $request->price,
                'is_active' => $request->is_active,
                'modified_by' => auth()->id(),
            ]);

            if ($request->hasFile('images')) {
                // Delete old images from the storage
                foreach ($recipe->images as $image) {
                    if (Storage::exists($image->image_path)) {
                        Storage::delete($image->image_path);
                    }
                    $image->delete(); 
                }

                // Add new images
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('recipes', 'public');
                    RecipeImage::create([
                        'recipe_id' => $recipe->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            return ResponseWithSuccessData($lang, $recipe, 1);
        } catch (\Exception $e) {
            Log::error('Error updating recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Soft delete the specified recipe.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

            // Find the recipe
            $recipe = Recipe::findOrFail($id);

            // Soft delete the recipe (which cascades to its images)
            $recipe->update(['deleted_by' => auth()->id()]);
            $recipe->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Restore a soft-deleted recipe.
     */
    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

            // Find the soft-deleted recipe
            $recipe = Recipe::withTrashed()->findOrFail($id);
            $recipe->restore();

            return ResponseWithSuccessData($lang, $recipe, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
