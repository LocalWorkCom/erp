<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeImage;
use App\Models\Ingredient;
use App\Models\ProductUnit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $withTrashed = $request->query('withTrashed', false);

            // Fetch recipes with ingredients, images, and branches
            $recipes = $withTrashed
                ? Recipe::withTrashed()->onlyRecipes()->with(['ingredients', 'images', 'branches'])->get()
                : Recipe::onlyRecipes()->with(['ingredients', 'images', 'branches'])->get();

            return ResponseWithSuccessData($lang, $recipes, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching recipes: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            
            $recipe = Recipe::withTrashed()
                ->with(['ingredients.product', 'ingredients.productUnit', 'images', 'recipeAddons', 'branches'])
                ->findOrFail($id);
    
            return ResponseWithSuccessData($lang, $recipe, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching recipe: ' . $e->getMessage());
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
                'type' => 'required|in:1,2', // Type (1 = recipe, 2 = addon)
                'price' => 'required|numeric|min:0',
                'is_active' => 'required|boolean',
                'ingredients' => 'required|array',
                'ingredients.*.product_id' => 'required|integer|exists:products,id',
                'ingredients.*.quantity' => 'required|numeric|min:0',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpg,png,jpeg|max:5000',
                'branches' => 'required|array', // Array of branch IDs
                'branches.*' => 'required|integer|exists:branches,id',
            ]);

            $recipe = Recipe::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'type' => $request->type,
                'price' => $request->price,
                'is_active' => $request->is_active,
                'created_by' => auth()->id(),
            ]);

            // Store Ingredients
            foreach ($request->ingredients as $ingredientData) {
                $productUnit = ProductUnit::where('product_id', $ingredientData['product_id'])->firstOrFail();

                Ingredient::create([
                    'recipe_id' => $recipe->id,
                    'product_id' => $ingredientData['product_id'],
                    'product_unit_id' => $productUnit->id,
                    'quantity' => $ingredientData['quantity'],
                ]);
            }

            // Store Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('recipes', 'public');
                    RecipeImage::create([
                        'recipe_id' => $recipe->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            // Attach Branches
            $recipe->branches()->sync($request->branches);

            return ResponseWithSuccessData($lang, $recipe, 1);
        } catch (\Exception $e) {
            Log::error('Error creating recipe: ' . $e->getMessage());
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
                'type' => 'required|in:1,2',
                'price' => 'required|numeric|min:0',
                'is_active' => 'required|boolean',
                'ingredients' => 'required|array',
                'ingredients.*.product_id' => 'required|integer|exists:products,id',
                'ingredients.*.quantity' => 'required|numeric|min:0',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpg,png,jpeg|max:5000',
                'branches' => 'required|array',
                'branches.*' => 'required|integer|exists:branches,id',
            ]);

            $recipe = Recipe::findOrFail($id);

            $recipe->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'type' => $request->type,
                'price' => $request->price,
                'is_active' => $request->is_active,
                'modified_by' => auth()->id(),
            ]);

            // Update Ingredients
            Ingredient::where('recipe_id', $recipe->id)->delete();
            foreach ($request->ingredients as $ingredientData) {
                $productUnit = ProductUnit::where('product_id', $ingredientData['product_id'])->firstOrFail();

                Ingredient::create([
                    'recipe_id' => $recipe->id,
                    'product_id' => $ingredientData['product_id'],
                    'product_unit_id' => $productUnit->id,
                    'quantity' => $ingredientData['quantity'],
                ]);
            }

            // Update Images
            if ($request->hasFile('images')) {
                foreach ($recipe->images as $image) {
                    if (Storage::exists($image->image_path)) {
                        Storage::delete($image->image_path);
                    }
                    $image->delete();
                }

                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('recipes', 'public');
                    RecipeImage::create([
                        'recipe_id' => $recipe->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            // Update Branches
            $recipe->branches()->sync($request->branches);

            return ResponseWithSuccessData($lang, $recipe, 1);
        } catch (\Exception $e) {
            Log::error('Error updating recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $recipe = Recipe::findOrFail($id);
            $recipe->update(['deleted_by' => auth()->id()]);
            $recipe->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $recipe = Recipe::withTrashed()->findOrFail($id);
            $recipe->restore();

            return ResponseWithSuccessData($lang, $recipe, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
