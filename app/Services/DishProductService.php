<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Dish;
use App\Models\DishDetail;
use App\Models\Ingredient;
use App\Models\ProductUnit;
use App\Models\Recipe;
use App\Models\RecipeImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DishProductService
{
    public function store($data)
    {
        DB::beginTransaction();

        try {
            $dish = Dish::create($data);

            Log::info('Dish created', ['dish_id' => $dish->id]);

            if (isset($data['branches']) && in_array('all', $data['branches'])) {
                $allBranchIds = Branch::pluck('id')->toArray();
                // AddBranchMenu($dish->id, $allBranchIds);
            } elseif (isset($data['branches'])) {
                // AddBranchMenu($dish->id, $data['branches']);
            }

            Log::info('Branches assigned', ['branches' => $data['branches']]);

            $addon = Recipe::create([
                'name_ar' => $data['name_ar'],
                'name_en' => $data['name_en'],
                'description_ar' => $data['description_ar'] ?? null,
                'description_en' => $data['description_en'] ?? null,
                'type' => 1, 
                'is_active' => $data['is_active'],
                'created_by' => auth()->id(),
            ]);

            Log::info('Addon created', ['addon_id' => $addon->id]);

            Ingredient::create([
                'recipe_id' => $addon->id,
                'product_id' => $data['complete_product'], 
                'product_unit_id' => ProductUnit::where('product_id', $data['complete_product'])->firstOrFail()->id,
                'quantity' => 1, 
                'loss_percent' => 0.00, 
            ]);

            Log::info('Ingredient added to addon', ['addon_id' => $addon->id, 'product_id' => $data['complete_product']]);

            if (isset($data['image'])) {
                $image = $data['image'];
                $imagePath = 'images/addons/' . $image->getClientOriginalName();
                $image->move(public_path('images/addons'), $image->getClientOriginalName());

                RecipeImage::create([
                    'recipe_id' => $addon->id,
                    'image_path' => $imagePath,
                ]);

                Log::info('Image added to addon', ['addon_id' => $addon->id, 'image_path' => $imagePath]);
            }

            DishDetail::create([
                'dish_id' => $dish->id,
                'dish_size_id' => null,
                'recipe_id' => $addon->id,
                'quantity' => 1, 
            ]);

            Log::info('Addon linked to dish', ['dish_id' => $dish->id, 'addon_id' => $addon->id]);

            DB::commit();

            return $dish;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating dish product', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
