<?php

namespace App\Services;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\RecipeImage;
use App\Models\ProductUnit;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
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

    public function getAllProducts()
    {
        $products = Product::all();
        Log::info('Fetching all raw products', [
            'count' => $products->count(),
            'products' => $products->toArray()
        ]);
        return $products;
    }
    
    public function store($data, $images)
    {
        \Log::info('Starting recipe creation', ['data' => $data]);
    
        $recipe = Recipe::create([
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'description_ar' => $data['description_ar'] ?? null,
            'description_en' => $data['description_en'] ?? null,
            'type' => $data['type'],
            // 'price' => $data['price'],
            'is_active' => $data['is_active'],
            'created_by' => auth()->id(),
        ]);
    
        \Log::info('Recipe created', ['recipe_id' => $recipe->id]);
    
        foreach ($data['ingredients'] as $ingredientData) {
            try {
                \Log::info('Adding ingredient', ['recipe_id' => $recipe->id, 'ingredient_data' => $ingredientData]);
    
                $productUnit = ProductUnit::where('product_id', $ingredientData['product_id'])->firstOrFail();
    
                Ingredient::create([
                    'recipe_id' => $recipe->id,
                    'product_id' => $ingredientData['product_id'],
                    'product_unit_id' => $productUnit->id,
                    'quantity' => $ingredientData['quantity'],
                    'loss_percent' => $ingredientData['loss_percent'] ?? 0.00,
                ]);
    
                \Log::info('Ingredient added', ['recipe_id' => $recipe->id, 'ingredient_data' => $ingredientData]);
            } catch (\Exception $e) {
                \Log::error('Failed to add ingredient', [
                    'recipe_id' => $recipe->id,
                    'ingredient_data' => $ingredientData,
                    'message' => $e->getMessage(),
                ]);
    
                throw $e; 
            }
        }
    
        if ($images) {
            foreach ($images as $image) {
                $imagePath = 'images/recipes/' . $image->getClientOriginalName();
                $image->move(public_path('images/recipes'), $image->getClientOriginalName());
    
                \Log::info('New image uploaded', ['path' => $imagePath]);
    
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
        \Log::info('Starting recipe update', ['recipe_id' => $id, 'data' => $data]);
    
        $recipe = Recipe::findOrFail($id);
    
        $recipe->update([
            'name_ar' => $data['name_ar'],
            'name_en' => $data['name_en'],
            'description_ar' => $data['description_ar'] ?? null,
            'description_en' => $data['description_en'] ?? null,
            'type' => $data['type'],
            // 'price' => $data['price'],
            'is_active' => $data['is_active'],
            'modified_by' => auth()->id(),
        ]);
    
        \Log::info('Recipe details updated', ['recipe_id' => $recipe->id]);
    
        // Update Ingredients
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
    
        \Log::info('Ingredients updated', ['recipe_id' => $recipe->id]);
    
    
     
       if ($images) {
        foreach ($recipe->images as $image) {
            $oldImagePath = public_path($image->image_path);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $image->delete();
        }

        foreach ($images as $image) {
            $imagePath = 'images/recipes/' . $image->getClientOriginalName();
            $image->move(public_path('images/recipes'), $image->getClientOriginalName());

            \Log::info('New image uploaded', ['path' => $imagePath]);

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
