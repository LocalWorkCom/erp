<?php

namespace App\Services;
use App\Models\Dish;
use App\Models\DishSize;
use App\Models\DishDetail;
use App\Models\DishAddon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



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
        try {
        return DB::transaction(function () use ($data, $image) {
            try {
                // Log the initial data
                Log::info('Starting Dish Creation', ['data' => $data]);
    
               
                $validatedData = $this->validateDishData($data);
                Log::info('Validated Data', ['validated_data' => $validatedData]);    
                if ($image) {
                    $imagePath = 'images/dishes/' . $image->getClientOriginalName(); 
                    $image->move(public_path('images/dishes'), $image->getClientOriginalName()); 
                    Log::info('New image uploaded', ['path' => $imagePath]);
                    $validatedData['image'] = $imagePath;
                }

                $validatedData['is_active'] = $validatedData['is_active'] ?? 1;
                $validatedData['has_sizes'] = $validatedData['has_sizes'] ?? 0;
                $validatedData['has_addon'] = $validatedData['has_addon'] ?? 0;
                $validatedData['created_by'] = auth()->id();
                Log::info('Default Values Set', ['validated_data' => $validatedData]);
    
                // Create the main dish
                $dish = Dish::create($validatedData);
                Log::info('Dish Created', ['dish_id' => $dish->id]);
    
                // Process sizes
                if (isset($data['sizes'])) {
                    Log::info('Processing Sizes for Dish', ['dish_id' => $dish->id, 'sizes' => $data['sizes']]);
                
                    foreach ($data['sizes'] as $sizeIndex => $size) {
                        try {
                            $dishSize = DishSize::create([
                                'dish_id' => $dish->id,
                                'size_name_en' => $size['size_name_en'],
                                'size_name_ar' => $size['size_name_ar'],
                                'price' => $size['price'],
                                'default_size' => isset($data['default_size']) && $data['default_size'] == $sizeIndex,
                            ]);
                            Log::info('Dish Size Created', ['dish_size_id' => $dishSize->id]);
                        } catch (\Exception $e) {
                            Log::error('Error Creating Dish Size', ['error' => $e->getMessage()]);
                        }
                
                        // Handle recipes for this size
                        if (isset($size['recipes'])) {
                            foreach ($size['recipes'] as $recipe) {
                                try {
                                    DishDetail::create([
                                        'dish_id' => $dish->id,
                                        'dish_size_id' => $dishSize->id,
                                        'recipe_id' => $recipe['recipe_id'],
                                        'quantity' => $recipe['quantity'],
                                    ]);
                                    Log::info('Dish Recipe Added', [
                                        'dish_id' => $dish->id,
                                        'dish_size_id' => $dishSize->id,
                                        'recipe_id' => $recipe['recipe_id'],
                                        'quantity' => $recipe['quantity'],
                                    ]);
                                } catch (\Exception $e) {
                                    Log::error('Error Creating Dish Detail', ['error' => $e->getMessage()]);
                                }
                            }
                        }
                    }
                }
                // Handle recipes for dishes without sizes
                if (!$dish->has_sizes && isset($data['details'])) {
                    foreach ($data['details'] as $detail) {
                        DishDetail::create([
                            'dish_id' => $dish->id,
                            'dish_size_id' => null,
                            'recipe_id' => $detail['recipe_id'],
                            'quantity' => $detail['quantity'],
                        ]);
                        Log::info('Dish Recipe Added', [
                            'dish_id' => $dish->id,
                            'recipe_id' => $detail['recipe_id'],
                            'quantity' => $detail['quantity'],
                        ]);
                    }
                }
    
                if (isset($data['addon_categories'])) {
                    foreach ($data['addon_categories'] as $addonCategory) {
                        foreach ($addonCategory['addons'] as $addon) {
                            Log::info('Processing Addon', [
                                'addon_id' => $addon['addon_id'],
                                'quantity' => $addon['quantity'],
                                'price' => $addon['price'],
                                'addon_category_id' => $addonCategory['addon_category_id'],
                            ]);
                
                            DishAddon::create([
                                'dish_id' => $dish->id,
                                'addon_id' => $addon['addon_id'], 
                                'quantity' => $addon['quantity'],
                                'price' => $addon['price'],
                                'addon_category_id' => $addonCategory['addon_category_id'],
                                'min_addons' => $addonCategory['min_addons'],
                                'max_addons' => $addonCategory['max_addons'],
                            ]);
                        }
                    }
                }
                
    
                Log::info('Dish Creation Completed Successfully', ['dish_id' => $dish->id]);
                return $dish;
    
            } catch (\Exception $e) {
                Log::error('Dish Creation Failed', ['error' => $e->getMessage()]);
                throw $e;
            }

            
        });

    } catch (\Exception $e) {
        Log::error('Transaction Failed', ['error' => $e->getMessage()]);
        throw $e;
    }
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'required',
            'has_sizes' => 'required',
            'has_addon' => 'required',
            'sizes.*.size_name_en' => 'required_if:has_sizes,1|string|max:255',
            'sizes.*.size_name_ar' => 'required_if:has_sizes,1|string|max:255',
            'sizes.*.price' => 'required_if:has_sizes,1|numeric|min:0',
            'sizes.*.recipes.*.recipe_id' => 'required_if:has_sizes,1|integer|exists:recipes,id',
            'sizes.*.recipes.*.quantity' => 'required_if:has_sizes,1|numeric|min:0',
            'addon_categories.*.min_addons' => 'nullable|integer|min:0|lte:addon_categories.*.max_addons',
            'addon_categories.*.max_addons' => 'nullable|integer|min:0',
            'addon_categories.*.addons.*.addon_id' => 'required_if:has_addon,1|integer',
            'addon_categories.*.addons.*.quantity' => 'required_if:has_addon,1|numeric|min:0',
            'addon_categories.*.addons.*.price' => 'required_if:has_addon,1|numeric|min:0',
        ])->validate();
    }
    

    

    public function update(Request $request, $id)
{
    try {
        return DB::transaction(function () use ($request, $id) {
            try {
                // Log the initial request
                Log::info('Starting Dish Update', ['dish_id' => $id, 'data' => $request->all()]);
                
                // Fetch the existing dish
                $dish = Dish::findOrFail($id);

                // Validate incoming data
                $validatedData = $this->validateDishData($request->all());
                Log::info('Validated Data', ['validated_data' => $validatedData]);

                // Process the image
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imagePath = 'images/dishes/' . $image->getClientOriginalName();
                    $image->move(public_path('images/dishes'), $image->getClientOriginalName());
                    $validatedData['image'] = $imagePath;
                    Log::info('Image Uploaded', ['path' => $imagePath]);
                }

                // Update dish details
                $validatedData['modified_by'] = auth()->id();
                $dish->update($validatedData);
                Log::info('Dish Updated', ['dish_id' => $dish->id]);

                // Process sizes
                if (isset($request->sizes)) {
                    Log::info('Processing Sizes', ['dish_id' => $dish->id, 'sizes' => $request->sizes]);

                    // Delete existing sizes
                    $dish->sizes()->delete();

                    foreach ($request->sizes as $sizeIndex => $size) {
                        $dishSize = DishSize::create([
                            'dish_id' => $dish->id,
                            'size_name_en' => $size['size_name_en'],
                            'size_name_ar' => $size['size_name_ar'],
                            'price' => $size['price'],
                            'default_size' => isset($request->default_size) && $request->default_size == $sizeIndex,
                        ]);
                        Log::info('Dish Size Created', ['dish_size_id' => $dishSize->id]);

                        // Process size recipes
                        if (isset($size['recipes'])) {
                            foreach ($size['recipes'] as $recipe) {
                                DishDetail::create([
                                    'dish_id' => $dish->id,
                                    'dish_size_id' => $dishSize->id,
                                    'recipe_id' => $recipe['recipe_id'],
                                    'quantity' => $recipe['quantity'],
                                ]);
                                Log::info('Dish Recipe Added', [
                                    'dish_id' => $dish->id,
                                    'dish_size_id' => $dishSize->id,
                                    'recipe_id' => $recipe['recipe_id'],
                                    'quantity' => $recipe['quantity'],
                                ]);
                            }
                        }
                    }
                }

                // Process recipes for dishes without sizes
                if (!$dish->has_sizes && isset($request->details)) {
                    $dish->details()->delete(); // Delete existing details

                    foreach ($request->details as $detail) {
                        DishDetail::create([
                            'dish_id' => $dish->id,
                            'dish_size_id' => null,
                            'recipe_id' => $detail['recipe_id'],
                            'quantity' => $detail['quantity'],
                        ]);
                        Log::info('Dish Recipe Added', [
                            'dish_id' => $dish->id,
                            'recipe_id' => $detail['recipe_id'],
                            'quantity' => $detail['quantity'],
                        ]);
                    }
                }

                // Process addon categories and addons
                if (isset($request->addon_categories)) {
                    Log::info('Processing Addon Categories', ['dish_id' => $dish->id, 'addon_categories' => $request->addon_categories]);

                    $dish->addons()->delete(); // Delete existing addons

                    foreach ($request->addon_categories as $addonCategory) {
                        foreach ($addonCategory['addons'] as $addon) {
                            DishAddon::create([
                                'dish_id' => $dish->id,
                                'addon_id' => $addon['addon_id'],
                                'quantity' => $addon['quantity'],
                                'price' => $addon['price'],
                                'addon_category_id' => $addonCategory['addon_category_id'],
                                'min_addons' => $addonCategory['min_addons'],
                                'max_addons' => $addonCategory['max_addons'],
                            ]);
                            Log::info('Dish Addon Added', [
                                'dish_id' => $dish->id,
                                'addon_id' => $addon['addon_id'],
                                'quantity' => $addon['quantity'],
                                'price' => $addon['price'],
                                'addon_category_id' => $addonCategory['addon_category_id'],
                            ]);
                        }
                    }
                }

                Log::info('Dish Update Completed Successfully', ['dish_id' => $dish->id]);
                return redirect()->route('dashboard.dishes.index')->with('success', __('dishes.DishUpdated'));

            } catch (\Exception $e) {
                Log::error('Dish Update Failed', ['error' => $e->getMessage()]);
                throw $e;
            }
        });
    } catch (\Exception $e) {
        Log::error('Transaction Failed', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', __('dishes.DishUpdateFailed'));
    }
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
