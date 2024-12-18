<?php

namespace App\Services;

use App\Models\Dish;
use App\Models\DishSize;
use App\Models\DishDetail;
use App\Models\DishAddon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class DishService
{
    public function index($withTrashed = false)
    {
        return $withTrashed
            ? Dish::withTrashed()->with(['dishCategory', 'cuisine', 'sizes', 'details.recipe', 'addons'])->get()
            : Dish::with(['dishCategory', 'cuisine', 'sizes', 'details.recipe', 'addons'])->get();
    }

    public function show($id)
    {
        return Dish::withTrashed()
            ->with(['dishCategory', 'cuisine', 'sizes', 'details.recipe', 'addons'])
            ->findOrFail($id);
    }

    public function store($data, $image)
    {
        return DB::transaction(function () use ($data, $image) {
            // Validate dish data
            $validatedData = $this->validateDishData($data);

            // Handle image upload
            $validatedData['image'] = $image ? $image->store('images/dishes', 'public') : null;

            // Create the main dish
            $dish = Dish::create($validatedData);

            // Handle dish sizes
            if ($dish->has_sizes && isset($data['sizes'])) {
                foreach ($data['sizes'] as $sizeIndex => $size) {
                    $dishSize = DishSize::create([
                        'dish_id' => $dish->id,
                        'size_name_en' => $size['size_name_en'],
                        'size_name_ar' => $size['size_name_ar'],
                        'price' => $size['price'],
                        'default_size' => isset($data['default_size']) && $data['default_size'] == $sizeIndex,
                    ]);

                    // Handle recipes for the size
                    if (isset($size['recipes'])) {
                        foreach ($size['recipes'] as $recipe) {
                            DishDetail::create([
                                'dish_id' => $dish->id,
                                'dish_size_id' => $dishSize->id,
                                'recipe_id' => $recipe['recipe_id'],
                                'quantity' => $recipe['quantity'],
                            ]);
                        }
                    }
                }
            }

            // Handle dish details for dishes without sizes
            if (!$dish->has_sizes && isset($data['details'])) {
                foreach ($data['details'] as $detail) {
                    DishDetail::create([
                        'dish_id' => $dish->id,
                        'dish_size_id' => null,
                        'recipe_id' => $detail['recipe_id'],
                        'quantity' => $detail['quantity'],
                    ]);
                }
            }

            // Handle addons
            if ($dish->has_addon && isset($data['addon_categories'])) {
                foreach ($data['addon_categories'] as $addonCategoryIndex => $addonCategory) {
                    foreach ($addonCategory['addons'] as $addonIndex => $addon) {
                        DishAddon::create([
                            'dish_id' => $dish->id,
                            'addon_id' => $addon['addon_id'],
                            'quantity' => $addon['quantity'],
                            'price' => $addon['price'],
                            'addon_category_id' => $addonCategory['addon_category_id'],
                            'min_addons' => $addonCategory['min_addons'] ?? null,
                            'max_addons' => $addonCategory['max_addons'] ?? null,
                        ]);
                    }
                }
            }

            return $dish;
        });
    }

    private function validateDishData($data)
    {
        return validator($data, [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'category_id' => 'required|integer|exists:dish_categories,id',
            'cuisine_id' => 'required|integer|exists:cuisines,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'required|boolean',
            'has_sizes' => 'required|boolean',
            'has_addon' => 'required|boolean',
            'sizes.*.size_name_en' => 'required_if:has_sizes,1|string|max:255',
            'sizes.*.size_name_ar' => 'required_if:has_sizes,1|string|max:255',
            'sizes.*.price' => 'required_if:has_sizes,1|numeric|min:0',
            'sizes.*.recipes.*.recipe_id' => 'required_if:has_sizes,1|integer|exists:recipes,id',
            'sizes.*.recipes.*.quantity' => 'required_if:has_sizes,1|numeric|min:0',
            'addon_categories.*.min_addons' => 'nullable|integer|min:0|lte:addon_categories.*.max_addons',
            'addon_categories.*.max_addons' => 'nullable|integer|min:0',
            'addon_categories.*.addons.*.addon_id' => 'required_if:has_addon,1|integer|exists:addons,id',
            'addon_categories.*.addons.*.quantity' => 'required_if:has_addon,1|numeric|min:0',
            'addon_categories.*.addons.*.price' => 'required_if:has_addon,1|numeric|min:0',
        ])->validate();
    }

    

    public function update($id, $data)
    {
        $dish = Dish::findOrFail($id);

        $dish->update([
            'name_en' => $data['name_en'],
            'name_ar' => $data['name_ar'],
            'description_en' => $data['description_en'] ?? null,
            'description_ar' => $data['description_ar'] ?? null,
            'category_id' => $data['category_id'],
            'cuisine_id' => $data['cuisine_id'],
            'price' => $data['price'] ?? 0,
            'image' => $data['image'] ?? $dish->image,
            'is_active' => $data['is_active'] ?? 1,
            'has_sizes' => $data['has_sizes'] ?? 0,
            'modified_by' => auth()->id(),
        ]);

        return $dish;
    }

    public function delete($id)
    {
        $dish = Dish::findOrFail($id);
        $dish->update(['deleted_by' => auth()->id()]);
        $dish->delete();

        return true;
    }

    public function restore($id)
    {
        $dish = Dish::withTrashed()->findOrFail($id);
        $dish->restore();

        return $dish;
    }
}
