<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dish;
use App\Models\DishDetail;
use App\Models\Branch;
use Illuminate\Support\Facades\Log;

class DishController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            // Remove the reference to `dishAddons` from the recipe relationship
            $dishes = Dish::with(['dishCategory', 'cuisine', 'recipes.recipe', 'branches'])->get();
            return ResponseWithSuccessData($lang, $dishes, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching dishes: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            // Remove the reference to `dishAddons` from the recipe relationship
            $dish = Dish::with(['dishCategory', 'cuisine', 'recipes.recipe', 'branches'])->findOrFail($id);
            return ResponseWithSuccessData($lang, $dish, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching dish: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'category_id' => 'required|integer|exists:dish_categories,id',
                'cuisine_id' => 'required|integer|exists:cuisines,id',
                'price' => 'required|numeric|min:0',
                'recipes' => 'required|array',
                'recipes.*.recipe_id' => 'required|integer|exists:recipes,id',
                'recipes.*.quantity' => 'required|numeric|min:0',
                'addons' => 'nullable|array',  // Addons are optional
                'addons.*.addon_id' => 'required|integer|exists:addons,id',
                'branches' => 'required|array', // Array of branch IDs
                'branches.*' => 'required|integer|exists:branches,id',
            ]);

            $dish = Dish::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'category_id' => $request->category_id,
                'cuisine_id' => $request->cuisine_id,
                'price' => $request->price,
                'created_by' => auth()->id(),
            ]);

            // Store Recipes
            foreach ($request->recipes as $recipeData) {
                DishDetail::create([
                    'dish_id' => $dish->id,
                    'recipe_id' => $recipeData['recipe_id'],
                    'quantity' => $recipeData['quantity'],
                ]);
            }

            // Store Addons if provided
            if ($request->has('addons')) {
                foreach ($request->addons as $addonData) {
                    DishAddon::create([
                        'dish_id' => $dish->id,
                        'addon_id' => $addonData['addon_id'],
                    ]);
                }
            }

            $dish->branches()->sync($request->branches);

            return ResponseWithSuccessData($lang, $dish, 1);
        } catch (\Exception $e) {
            Log::error('Error creating dish: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'category_id' => 'required|integer|exists:dish_categories,id',
                'cuisine_id' => 'required|integer|exists:cuisines,id',
                'price' => 'required|numeric|min:0',
                'recipes' => 'required|array',
                'recipes.*.recipe_id' => 'required|integer|exists:recipes,id',
                'recipes.*.quantity' => 'required|numeric|min:0',
                'addons' => 'nullable|array',  // Addons are optional
                'addons.*.addon_id' => 'required|integer|exists:addons,id',
                'branches' => 'required|array', // Array of branch IDs
                'branches.*' => 'required|integer|exists:branches,id',
            ]);

            $dish = Dish::findOrFail($id);

            $dish->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'category_id' => $request->category_id,
                'cuisine_id' => $request->cuisine_id,
                'price' => $request->price,
                'modified_by' => auth()->id(),
            ]);

            // Update Recipes
            DishDetail::where('dish_id', $dish->id)->delete();
            foreach ($request->recipes as $recipeData) {
                DishDetail::create([
                    'dish_id' => $dish->id,
                    'recipe_id' => $recipeData['recipe_id'],
                    'quantity' => $recipeData['quantity'],
                ]);
            }

            // Update Addons
            DishAddon::where('dish_id', $dish->id)->delete();
            if ($request->has('addons')) {
                foreach ($request->addons as $addonData) {
                    DishAddon::create([
                        'dish_id' => $dish->id,
                        'addon_id' => $addonData['addon_id'],
                    ]);
                }
            }

            $dish->branches()->sync($request->branches);

            return ResponseWithSuccessData($lang, $dish, 1);
        } catch (\Exception $e) {
            Log::error('Error updating dish: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $dish = Dish::findOrFail($id);
            $dish->update(['deleted_by' => auth()->id()]);
            $dish->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting dish: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $dish = Dish::withTrashed()->findOrFail($id);
            $dish->restore();

            return ResponseWithSuccessData($lang, $dish, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring dish: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
