<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\RecipeImage;
use App\Models\ProductUnit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AddonController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $withTrashed = $request->query('withTrashed', false);

            $addons = $withTrashed
                ? Recipe::withTrashed()->onlyAddons()->with(['ingredients', 'images'])->get()
                : Recipe::onlyAddons()->with(['ingredients', 'images'])->get();

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
            $addon = Recipe::onlyAddons()->with(['ingredients.product', 'ingredients.productUnit', 'images'])->findOrFail($id);

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
            $request->merge(['is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)]);

            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                // 'price' => 'required|numeric|min:0',
                'is_active' => 'required|boolean',
                'ingredients' => 'required|array',
                'ingredients.*.product_id' => 'required|integer|exists:products,id',
                'ingredients.*.quantity' => 'required|numeric|min:0',
                'ingredients.*.loss_percent' => 'nullable|numeric|min:0|max:100',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpg,png,jpeg|max:5000',
            ]);

            $addon = Recipe::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'type' => 2,
                // 'price' => $request->price,
                'is_active' => $request->is_active,
                'created_by' => auth()->id(),
            ]);

            // Store Ingredients
            foreach ($request->ingredients as $ingredientData) {
                $productUnit = ProductUnit::where('product_id', $ingredientData['product_id'])->firstOrFail();

                Ingredient::create([
                    'recipe_id' => $addon->id,
                    'product_id' => $ingredientData['product_id'],
                    'product_unit_id' => $productUnit->id,
                    'quantity' => $ingredientData['quantity'],
                    'loss_percent' => $ingredientData['loss_percent'] ?? 0.00,
                ]);
            }

            // Store Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('addons', 'public');
                    RecipeImage::create([
                        'recipe_id' => $addon->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            return ResponseWithSuccessData($lang, $addon, 1);
        } catch (\Exception $e) {
            Log::error('Error creating addon: ' . $e->getMessage());
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
                // 'price' => 'required|numeric|min:0',
                'is_active' => 'required|boolean',
                'ingredients' => 'required|array',
                'ingredients.*.product_id' => 'required|integer|exists:products,id',
                'ingredients.*.quantity' => 'required|numeric|min:0',
                'ingredients.*.loss_percent' => 'nullable|numeric|min:0|max:100',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpg,png,jpeg|max:5000',
            ]);

            $addon = Recipe::onlyAddons()->findOrFail($id);

            $addon->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                // 'price' => $request->price,
                'is_active' => $request->is_active,
                'modified_by' => auth()->id(),
            ]);

            Ingredient::where('recipe_id', $addon->id)->delete();
            foreach ($request->ingredients as $ingredientData) {
                $productUnit = ProductUnit::where('product_id', $ingredientData['product_id'])->firstOrFail();

                Ingredient::create([
                    'recipe_id' => $addon->id,
                    'product_id' => $ingredientData['product_id'],
                    'product_unit_id' => $productUnit->id,
                    'quantity' => $ingredientData['quantity'],
                    'loss_percent' => $ingredientData['loss_percent'] ?? 0.00,
                ]);
            }

            // Update Images
            if ($request->hasFile('images')) {
                foreach ($addon->images as $image) {
                    if (Storage::exists($image->image_path)) {
                        Storage::delete($image->image_path);
                    }
                    $image->delete();
                }

                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('addons', 'public');
                    RecipeImage::create([
                        'recipe_id' => $addon->id,
                        'image_path' => $imagePath,
                    ]);
                }
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

            Ingredient::where('recipe_id', $addon->id)->delete();

            foreach ($addon->images as $image) {
                if (Storage::exists($image->image_path)) {
                    Storage::delete($image->image_path);
                }
                $image->delete();
            }

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
