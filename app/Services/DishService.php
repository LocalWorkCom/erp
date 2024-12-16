<?php

namespace App\Services;

use App\Models\Dish;
use App\Models\DishSize;
use App\Models\DishDetail;
use App\Models\DishAddon;
use Illuminate\Support\Facades\Storage;
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
            ->with(['category', 'cuisine', 'sizes', 'details.recipe', 'addons'])
            ->findOrFail($id);
    }

    public function store($data, $image)
    {
        // Validate main dish data
        $validatedData = $this->validateDishData($data);
    
        // Upload the image if provided
        if ($image) {
            $imagePath = 'images/dishes/' . $image->getClientOriginalName();
            $image->move(public_path('images/dishes'), $image->getClientOriginalName());
            $validatedData['image'] = $imagePath;
        }
    
        // Create main dish
        $dish = Dish::create($validatedData);
    
        // Store dish sizes if `has_sizes` is enabled
        if ($dish->has_sizes && isset($data['sizes'])) {
            foreach ($data['sizes'] as $size) {
                $dishSize = DishSize::create([
                    'dish_id' => $dish->id,
                    'size_name_en' => $size['size_name_en'],
                    'size_name_ar' => $size['size_name_ar'],
                    'price' => $size['price'],
                ]);
    
                // Add details for each size
                if (isset($size['details'])) {
                    foreach ($size['details'] as $detail) {
                        DishDetail::create([
                            'dish_id' => $dish->id,
                            'dish_size_id' => $dishSize->id,
                            'recipe_id' => $detail['recipe_id'],
                            'quantity' => $detail['quantity'],
                        ]);
                    }
                }
            }
        }
    
        // Store dish details for non-size dishes
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
    
        // Store dish addons
        if (isset($data['addons'])) {
            foreach ($data['addons'] as $addon) {
                DishAddon::create([
                    'dish_id' => $dish->id,
                    'addon_id' => $addon['addon_id'],
                    'quantity' => $addon['quantity'],
                    'price' => $addon['price'],
                    'addon_category_id' => $addon['addon_category_id'],
                ]);
            }
        }
    
        return $dish;
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
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'required|boolean',
            'has_sizes' => 'required|boolean',
            'sizes.*.size_name_en' => 'required_if:has_sizes,1|string|max:255',
            'sizes.*.size_name_ar' => 'required_if:has_sizes,1|string|max:255',
            'sizes.*.price' => 'required_if:has_sizes,1|numeric|min:0',
            'sizes.*.details.*.recipe_id' => 'required_if:has_sizes,1|integer|exists:recipes,id',
            'sizes.*.details.*.quantity' => 'required_if:has_sizes,1|numeric|min:0',
            'details.*.recipe_id' => 'required_if:has_sizes,0|integer|exists:recipes,id',
            'details.*.quantity' => 'required_if:has_sizes,0|numeric|min:0',
            'addons.*.addon_id' => 'required|integer|exists:addons,id',
            'addons.*.quantity' => 'required|numeric|min:0',
            'addons.*.price' => 'required|numeric|min:0',
            'addons.*.addon_category_id' => 'required|integer|exists:addon_categories,id',
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
