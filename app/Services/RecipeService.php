<?php

namespace App\Services;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\RecipeImage;
use App\Models\ProductUnit;
use Illuminate\Support\Facades\Storage;

class RecipeService
{
    public function index($withTrashed = false)
    {
        return $withTrashed
            ? Recipe::withTrashed()->with(['ingredients.product', 'images'])->get()
            : Recipe::with(['ingredients.product', 'images'])->get();
    }

    public function show($id)
    {
        return Recipe::withTrashed()->with(['ingredients.product', 'images'])->findOrFail($id);
    }

    public function store($data, $images)
    {
        $recipe = Recipe::create([
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'description_ar' => $data['description_ar'] ?? null,
            'description_en' => $data['description_en'] ?? null,
            'type' => $data['type'],
            'price' => $data['price'],
            'is_active' => $data['is_active'],
            'created_by' => auth()->id(),
        ]);

        foreach ($data['ingredients'] as $ingredientData) {
            $productUnit = ProductUnit::where('product_id', $ingredientData['product_id'])->firstOrFail();

            Ingredient::create([
                'recipe_id' => $recipe->id,
                'product_id' => $ingredientData['product_id'],
                'product_unit_id' => $productUnit->id,
                'quantity' => $ingredientData['quantity'],
                'loss_percent' => $ingredientData['loss_percent'] ?? 0.00,
            ]);
        }

        if ($images) {
            foreach ($images as $image) {
                $imagePath = $image->store('recipes', 'public');
                RecipeImage::create([
                    'recipe_id' => $recipe->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return $recipe;
    }

    public function update($id, $data, $images)
    {
        $recipe = Recipe::findOrFail($id);

        $recipe->update([
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'description_ar' => $data['description_ar'] ?? null,
            'description_en' => $data['description_en'] ?? null,
            'type' => $data['type'],
            'price' => $data['price'],
            'is_active' => $data['is_active'],
            'modified_by' => auth()->id(),
        ]);

        Ingredient::where('recipe_id', $recipe->id)->delete();
        foreach ($data['ingredients'] as $ingredientData) {
            $productUnit = ProductUnit::where('product_id', $ingredientData['product_id'])->firstOrFail();

            Ingredient::create([
                'recipe_id' => $recipe->id,
                'product_id' => $ingredientData['product_id'],
                'product_unit_id' => $productUnit->id,
                'quantity' => $ingredientData['quantity'],
                'loss_percent' => $ingredientData['loss_percent'] ?? 0.00,
            ]);
        }

        if ($images) {
            foreach ($recipe->images as $image) {
                if (Storage::exists($image->image_path)) {
                    Storage::delete($image->image_path);
                }
                $image->delete();
            }

            foreach ($images as $image) {
                $imagePath = $image->store('recipes', 'public');
                RecipeImage::create([
                    'recipe_id' => $recipe->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return $recipe;
    }

    public function delete($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->update(['deleted_by' => auth()->id()]);
        Ingredient::where('recipe_id', $recipe->id)->delete();

        foreach ($recipe->images as $image) {
            if (Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
            $image->delete();
        }

        $recipe->delete();

        return true;
    }

    public function restore($id)
    {
        $recipe = Recipe::withTrashed()->findOrFail($id);
        $recipe->restore();

        return $recipe;
    }
}
