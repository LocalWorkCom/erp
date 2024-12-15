<?php
namespace App\Services;

use App\Models\AddonCategory;
use Illuminate\Support\Facades\Validator;

class AddonCategoryService
{
    public function index($withTrashed = false)
    {
        return $withTrashed
            ? AddonCategory::withTrashed()->get()
            : AddonCategory::all();
    }

    public function show($id)
    {
        return AddonCategory::withTrashed()->findOrFail($id);
    }

    public function store($data)
    {
        $validatedData = $this->validateData($data);
        return AddonCategory::create($validatedData);
    }

    public function update($id, $data)
    {
        $addonCategory = AddonCategory::findOrFail($id);
        $validatedData = $this->validateData($data);
        $addonCategory->update($validatedData);
        return $addonCategory;
    }

    public function delete($id)
    {
        $addonCategory = AddonCategory::findOrFail($id);
        $addonCategory->delete();
        return true;
    }

    public function restore($id)
    {
        $addonCategory = AddonCategory::withTrashed()->findOrFail($id);
        $addonCategory->restore();
        return $addonCategory;
    }

    private function validateData($data)
    {
        $validator = Validator::make($data, [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
