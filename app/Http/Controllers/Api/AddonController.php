<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Addon;
use App\Models\RecipeAddon;
use App\Models\ProductUnit;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AddonController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $addons = Addon::with(['recipes'])->get();

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
            $addon = Addon::with(['recipes.addons'])->findOrFail($id);

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
            $request->merge([
                'is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);

            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'is_active' => 'required|boolean',
                'price' => 'required|numeric|min:0', // Addon price
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000', // Image validation
                'products' => 'required|array',
                'products.*.product_id' => 'required|integer|exists:products,id',
                'products.*.quantity' => 'required|numeric|min:0',
                'recipes' => 'required|array', // Multiple recipes
                'recipes.*' => 'required|integer|exists:recipes,id', // Validate each recipe
            ]);

            // Handle the image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('addons', 'public');
            }

            $addon = Addon::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'is_active' => $request->is_active,
                'price' => $request->price, // Addon price
                'image_path' => $imagePath, // Store image path
                'created_by' => auth()->id(),
            ]);

            foreach ($request->recipes as $recipeId) {
                foreach ($request->products as $productData) {
                    $productUnit = ProductUnit::where('product_id', $productData['product_id'])->firstOrFail();

                    RecipeAddon::create([
                        'recipe_id' => $recipeId,
                        'addon_id' => $addon->id,
                        'product_id' => $productData['product_id'],
                        'product_unit_id' => $productUnit->id,
                        'quantity' => $productData['quantity'],
                    ]);
                }
            }

            return ResponseWithSuccessData($lang, $addon, 1);
        } catch (\Exception $e) {
            Log::error('Error creating addon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function update(Request $request, $addonId)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $request->merge([
                'is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);

            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'is_active' => 'required|boolean',
                'price' => 'required|numeric|min:0', // Addon price
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000', // Image validation
                'products' => 'required|array',
                'products.*.product_id' => 'required|integer|exists:products,id',
                'products.*.quantity' => 'required|numeric|min:0',
                'recipes' => 'required|array', // Multiple recipes
                'recipes.*' => 'required|integer|exists:recipes,id', // Validate each recipe
            ]);

            $addon = Addon::findOrFail($addonId);

            // Handle the image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($addon->image_path && Storage::exists($addon->image_path)) {
                    Storage::delete($addon->image_path);
                }

                // Store the new image
                $imagePath = $request->file('image')->store('addons', 'public');
                $addon->update(['image_path' => $imagePath]);
            }

            $addon->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'is_active' => $request->is_active,
                'price' => $request->price, // Addon price
                'modified_by' => auth()->id(),
            ]);

            RecipeAddon::where('addon_id', $addon->id)->delete();

            foreach ($request->recipes as $recipeId) {
                foreach ($request->products as $productData) {
                    $productUnit = ProductUnit::where('product_id', $productData['product_id'])->firstOrFail();

                    RecipeAddon::create([
                        'recipe_id' => $recipeId,
                        'addon_id' => $addon->id,
                        'product_id' => $productData['product_id'],
                        'product_unit_id' => $productUnit->id,
                        'quantity' => $productData['quantity'],
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
            $addon = Addon::findOrFail($id);
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

            $addon = Addon::withTrashed()->findOrFail($id);
            $addon->restore();

            return ResponseWithSuccessData($lang, $addon, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring addon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
