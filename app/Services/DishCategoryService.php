<?php

namespace App\Services;

use App\Models\DishCategory;
use Illuminate\Support\Facades\Storage;

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
        return DishCategory::withTrashed()->with(['parent', 'children'])->findOrFail($id);
    }

    public function store($data, $image)
    {
        if ($image) {
            $data['image_path'] = $image->store('dish_categories', 'public');
        }

        return DishCategory::create($data);
    }

    public function update($id, $data, $image)
    {
        $category = DishCategory::findOrFail($id);

        if ($image) {
            if ($category->image_path && Storage::exists($category->image_path)) {
                Storage::delete($category->image_path);
            }
            $data['image_path'] = $image->store('dish_categories', 'public');
        }

        $category->update($data);

        return $category;
    }

    public function destroy($id)
    {
        $category = DishCategory::findOrFail($id);
        $category->update(['deleted_by' => auth()->id()]);
        $category->delete();

        return true;
    }

    public function restore($id)
    {
        $category = DishCategory::withTrashed()->findOrFail($id);
        $category->restore();

        return $category;
    }
}
