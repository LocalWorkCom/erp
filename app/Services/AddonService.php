<?php
namespace App\Services;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\RecipeImage;
use App\Models\ProductUnit;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AddonService
{
    public function index($withTrashed = false)
    {
        Log::info('Fetching addons (type 2)', ['withTrashed' => $withTrashed]);

        $query = Recipe::where('type', 2)->with(['ingredients.product', 'images']);
        
        return $withTrashed ? $query->withTrashed()->get() : $query->get();
    }

    public function show($id)
    {
        return Recipe::withTrashed()
            ->with(['ingredients.product', 'images'])
            ->where('type', 2)
            ->findOrFail($id);
    }

    public function getAllProducts()
    {
        $products = Product::all();
        Log::info('Fetching all products', [
            'count' => $products->count(),
            'products' => $products->toArray(),
        ]);

        return $products;
    }

    public function store($data, $images)
    {
        Log::info('Starting addon creation', ['data' => $data]);

        $addon = Recipe::create([
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'description_ar' => $data['description_ar'] ?? null,
            'description_en' => $data['description_en'] ?? null,
            'type' => 2, // Ensures it's always an addon
            // 'price' => $data['price'],
            'is_active' => $data['is_active'],
            'created_by' => auth()->id(),
        ]);

        Log::info('Addon created', ['addon_id' => $addon->id]);

        $this->storeIngredients($addon->id, $data['ingredients']);
        $this->storeImages($addon->id, $images);

        return $addon;
    }

    public function update($id, $data, $images)
    {
        Log::info('Starting addon update', ['addon_id' => $id, 'data' => $data]);

        $addon = Recipe::findOrFail($id);

        $addon->update([
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'description_ar' => $data['description_ar'] ?? null,
            'description_en' => $data['description_en'] ?? null,
            'type' => 2, // Ensures it remains an addon
            // 'price' => $data['price'],
            'is_active' => $data['is_active'],
            'modified_by' => auth()->id(),
        ]);

        Log::info('Addon details updated', ['addon_id' => $addon->id]);

        $this->updateIngredients($addon->id, $data['ingredients']);
        $this->updateImages($addon, $images);

        return $addon;
    }

    public function delete($id)
    {
        $addon = Recipe::findOrFail($id);
        $addon->update(['deleted_by' => auth()->id()]);

        Ingredient::where('recipe_id', $addon->id)->delete();

        foreach ($addon->images as $image) {
            if (Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
            $image->delete();
        }

        $addon->delete();

        Log::info('Addon deleted', ['addon_id' => $addon->id]);

        return true;
    }

    public function restore($id)
    {
        $addon = Recipe::withTrashed()->findOrFail($id);
        $addon->restore();

        Log::info('Addon restored', ['addon_id' => $addon->id]);

        return $addon;
    }

    private function storeIngredients($addonId, $ingredients)
    {
        foreach ($ingredients as $ingredientData) {
            $productUnit = ProductUnit::where('product_id', $ingredientData['product_id'])->firstOrFail();

            Ingredient::create([
                'recipe_id' => $addonId,
                'product_id' => $ingredientData['product_id'],
                'product_unit_id' => $productUnit->id,
                'quantity' => $ingredientData['quantity'],
                'loss_percent' => $ingredientData['loss_percent'] ?? 0.00,
            ]);

            Log::info('Ingredient added to addon', ['addon_id' => $addonId, 'ingredient_data' => $ingredientData]);
        }
    }

    private function storeImages($addonId, $images)
    {
        if ($images) {
            foreach ($images as $image) {
                $imagePath = 'images/addons/' . $image->getClientOriginalName();
                $image->move(public_path('images/addons'), $image->getClientOriginalName());

                RecipeImage::create([
                    'recipe_id' => $addonId,
                    'image_path' => $imagePath,
                ]);

                Log::info('Image added to addon', ['addon_id' => $addonId, 'image_path' => $imagePath]);
            }
        }
    }

    private function updateIngredients($addonId, $ingredients)
    {
        Ingredient::where('recipe_id', $addonId)->delete();

        $this->storeIngredients($addonId, $ingredients);
    }

    private function updateImages($addon, $images)
    {
        if ($images) {
            foreach ($addon->images as $image) {
                $oldImagePath = public_path($image->image_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $image->delete();
            }

            $this->storeImages($addon->id, $images);
        }
    }
}
