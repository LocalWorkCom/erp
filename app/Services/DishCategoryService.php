<?php

namespace App\Services;

use App\Models\DishCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DishCategoryService
{
    public function index($withTrashed = false)
    {
        
        return $withTrashed
            ? DishCategory::withTrashed()->with(['parent', 'children'])->get()
            : DishCategory::with(['parent', 'children'])->get();
    }

    public function show($id)
    {
        Log::info("Fetching category with ID: $id");
        return DishCategory::withTrashed()->with(['parent', 'children'])->findOrFail($id);
    }

    public function store($data, $image)
    {
        Log::info('Storing new category', ['data' => $data]);

        $this->validateData($data);
    
        if ($image) {
            // Save the image to 'public/images/dish_category'
            $imagePath = 'images/dish_category/' . $image->getClientOriginalName();
            $image->move(public_path('images/dish_category'), $image->getClientOriginalName());
            $data['image_path'] = $imagePath; // Save the relative path to the database
        }
        $data['created_by'] = auth()->id() ?? 1; 
        try {
            $category = DishCategory::create($data);
            Log::info('Dish category created successfully', ['id' => $category->id]);
            return $category;
        } catch (\Exception $e) {
            Log::error('Error storing dish category', ['error' => $e->getMessage()]);
            throw $e;
        }
    
    }
    
    public function update($id, $data, $image)
    {
        // Validate incoming data
        $this->validateData($data, $id);
    
        // Fetch the existing category
        $category = DishCategory::findOrFail($id);
    
        // Check if a new image is uploaded
        if ($image) {
            // Delete the old image if it exists
            if ($category->image_path && file_exists(public_path($category->image_path))) {
                unlink(public_path($category->image_path));
                Log::info('Old image deleted', ['path' => $category->image_path]);
            }
    
            // Save the new image
            $imagePath = 'images/dish_category/' . $image->getClientOriginalName();
            $image->move(public_path('images/dish_category'), $image->getClientOriginalName());
            Log::info('New image uploaded', ['path' => $imagePath]);
    
            // Update image path in the data
            $data['image_path'] = $imagePath;
        }
    
        // Update the category record
        $category->update($data);
        Log::info('Category updated', ['id' => $id, 'data' => $data]);
    
        return $category;
    }
    
    public function delete($id)
    {
        $category = DishCategory::findOrFail($id);
    
        $category->deleted_by = auth()->id();
        $category->save();
    
        $category->delete();
    
        return true;
    }
    

    public function restore($id)
    {
        $category = DishCategory::withTrashed()->findOrFail($id);
    
        $category->restore();
    
        return true;
    }

    private function validateData($data, $id = null)
    {
        Log::info('Validating data', ['data' => $data, 'id' => $id]);

        $rules = [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_active' => 'required|boolean',
            'parent_id' => 'nullable|exists:dish_categories,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        Log::info('Validation passed');
    }
}
