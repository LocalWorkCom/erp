<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BrandService
{
    public function index(Request $request, $checkToken)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $withTrashed = $request->query('withTrashed', false);

            $brands = $withTrashed ? Brand::withTrashed()->get() : Brand::all();

            return ResponseWithSuccessData($lang, $brands, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching brands: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $brand = Brand::withTrashed()->findOrFail($id);

            return ResponseWithSuccessData($lang, $brand, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching brand: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $request->merge(['is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)]);

            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'is_active' => 'required|boolean',
                'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
            ]);

            $brandData = [
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'is_active' => $request->is_active,
                'created_by' => auth()->id(),
            ];

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('brands', 'public');
                $brandData['logo_path'] = $logoPath;
            }

            $brand = Brand::create($brandData);

            return ResponseWithSuccessData($lang, $brand, 1);
        } catch (\Exception $e) {
            Log::error('Error creating brand: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $request->merge(['is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)]);

            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'is_active' => 'required|boolean',
                'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
            ]);

            $brand = Brand::findOrFail($id);

            $brandData = [
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'is_active' => $request->is_active,
                'modified_by' => auth()->id(),
            ];

            if ($request->hasFile('logo')) {
                if ($brand->logo_path && Storage::exists($brand->logo_path)) {
                    Storage::delete($brand->logo_path);
                }
                $logoPath = $request->file('logo')->store('brands', 'public');
                $brandData['logo_path'] = $logoPath;
            }

            $brand->update($brandData);

            return ResponseWithSuccessData($lang, $brand, 1);
        } catch (\Exception $e) {
            Log::error('Error updating brand: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $brand = Brand::findOrFail($id);
            $brand->update(['deleted_by' => auth()->id()]);
            $brand->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting brand: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $brand = Brand::withTrashed()->findOrFail($id);
            $brand->restore();

            return ResponseWithSuccessData($lang, $brand, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring brand: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
