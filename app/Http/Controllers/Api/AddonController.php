<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Log;

class AddonController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $addons = Recipe::onlyAddons()->with('ingredients')->get();
            return ResponseWithSuccessData($lang, $addons, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching addons: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $addon = Recipe::onlyAddons()->with('ingredients')->findOrFail($id);
            return ResponseWithSuccessData($lang, $addon, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching addon: ' . $e->getMessage());
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
                'price' => 'required|numeric|min:0',
                'is_active' => 'required|boolean',
                'ingredients' => 'required|array', 
                'ingredients.*.product_id' => 'required|integer|exists:products,id',
                'ingredients.*.quantity' => 'required|numeric|min:0',
            ]);

            $addon = Recipe::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'type' => 2, 
                'price' => $request->price,
                'is_active' => $request->is_active,
                'created_by' => auth()->id(),
            ]);

            // Store Ingredients
            foreach ($request->ingredients as $ingredientData) {
                Ingredient::create([
                    'recipe_id' => $addon->id,
                    'product_id' => $ingredientData['product_id'],
                    'product_unit_id' => $ingredientData['product_unit_id'], 
                    'quantity' => $ingredientData['quantity'],
                ]);
            }

            return ResponseWithSuccessData($lang, $addon, 1);
        } catch (\Exception $e) {
            Log::error('Error creating addon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    // Update an addon with ingredients
    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'is_active' => 'required|boolean',
                'ingredients' => 'required|array', 
                'ingredients.*.product_id' => 'required|integer|exists:products,id',
                'ingredients.*.quantity' => 'required|numeric|min:0',
            ]);

            $addon = Recipe::onlyAddons()->findOrFail($id);

            $addon->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'price' => $request->price,
                'is_active' => $request->is_active,
                'modified_by' => auth()->id(),
            ]);

            Ingredient::where('recipe_id', $addon->id)->delete();
            foreach ($request->ingredients as $ingredientData) {
                Ingredient::create([
                    'recipe_id' => $addon->id,
                    'product_id' => $ingredientData['product_id'],
                    'product_unit_id' => $ingredientData['product_unit_id'], 
                    'quantity' => $ingredientData['quantity'],
                ]);
            }

            return ResponseWithSuccessData($lang, $addon, 1);
        } catch (\Exception $e) {
            Log::error('Error updating addon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $addon = Recipe::onlyAddons()->findOrFail($id);
            $addon->update(['deleted_by' => auth()->id()]);
            $addon->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting addon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $addon = Recipe::onlyAddons()->withTrashed()->findOrFail($id);
            $addon->restore();

            return ResponseWithSuccessData($lang, $addon, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring addon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
