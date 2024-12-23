<?php

namespace App\Services;

use App\Models\Cuisine;
use Illuminate\Support\Facades\Storage;

class CuisineService
{
    public function index($withTrashed = false)
    {
        return $withTrashed
            ? Cuisine::withTrashed()->get()
            : Cuisine::all();
    }

    public function show($id)
    {
        return Cuisine::withTrashed()->findOrFail($id);
    }

    public function store($data, $image = null)
{
    try {
        if ($image) {
            $destinationPath = 'images/cuisines';

            $imageName = time() . '_' . $image->getClientOriginalName();

            $image->move(public_path($destinationPath), $imageName);

            $data['image_path'] = $destinationPath . '/' . $imageName;
        }

        $data['created_by'] = auth()->id();

        return Cuisine::create($data);
    } catch (\Exception $e) {
        Log::error('Error storing cuisine', ['error' => $e->getMessage()]);
        throw $e;
    }
}

    public function update($id, $data, $image = null)
    {
        $cuisine = Cuisine::findOrFail($id);

        if ($image) {
            if ($cuisine->image_path && Storage::exists($cuisine->image_path)) {
                Storage::delete($cuisine->image_path); // Delete old image
            }
            $imagePath = $image->store('cuisines', 'public');
            $data['image_path'] = $imagePath;
        }

        $data['modified_by'] = auth()->id();

        $cuisine->update($data);

        return $cuisine;
    }

    public function delete($id)
    {
        $cuisine = Cuisine::findOrFail($id);
        $cuisine->delete();

        return true;
    }

    public function restore($id)
    {
        $cuisine = Cuisine::withTrashed()->findOrFail($id);
        $cuisine->restore();

        return $cuisine;
    }
}
