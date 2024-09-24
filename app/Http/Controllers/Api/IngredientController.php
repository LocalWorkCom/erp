<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Log;

class IngredientController extends Controller
{

    public function index(Request $request, $recipeId)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $ingredients = Ingredient::where('recipe_id', $recipeId)->with(['product', 'productUnit'])->get();

            return ResponseWithSuccessData($lang, $ingredients, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching ingredients: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

 
    public function store(Request $request, $recipeId)
    {
        try {
            $lang = $request->header('lang', 'ar');

            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'product_unit_id' => 'required|integer|exists:product_units,id',
                'quantity' => 'required|numeric',
            ]);

            $ingredient = Ingredient::create([
                'recipe_id' => $recipeId,
                'product_id' => $request->product_id,
                'product_unit_id' => $request->product_unit_id,
                'quantity' => $request->quantity,
            ]);

            return ResponseWithSuccessData($lang, $ingredient, 1);
        } catch (\Exception $e) {
            Log::error('Error creating ingredient: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');

            $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'product_unit_id' => 'required|integer|exists:product_units,id',
                'quantity' => 'required|numeric',
            ]);

            $ingredient = Ingredient::findOrFail($id);

            $ingredient->update([
                'product_id' => $request->product_id,
                'product_unit_id' => $request->product_unit_id,
                'quantity' => $request->quantity,
            ]);

            return ResponseWithSuccessData($lang, $ingredient, 1);
        } catch (\Exception $e) {
            Log::error('Error updating ingredient: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $ingredient = Ingredient::findOrFail($id);
            $ingredient->delete(); 

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting ingredient: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $ingredient = Ingredient::withTrashed()->findOrFail($id);
            $ingredient->restore();

            return ResponseWithSuccessData($lang, $ingredient, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring ingredient: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
