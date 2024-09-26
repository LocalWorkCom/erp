<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cuisine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CuisineController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $cuisines = Cuisine::all();
            return ResponseWithSuccessData($lang, $cuisines, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching cuisines: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show($id)
    {
        try {
            $lang = request()->header('lang', 'ar');
            $cuisine = Cuisine::findOrFail($id);
            return ResponseWithSuccessData($lang, $cuisine, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching cuisine: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $request->merge([
                'is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'is_active' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000', 
            ]);
    
            $cuisineData = [
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'is_active' => $request->is_active,
                'created_by' => auth()->id(),
            ];
    
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('cuisines', 'public'); 
                $cuisineData['image_path'] = $imagePath;
            }
    
            $cuisine = Cuisine::create($cuisineData);
    
            return ResponseWithSuccessData($lang, $cuisine, 1);
        } catch (\Exception $e) {
            Log::error('Error creating cuisine: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $request->merge([
                'is_active' => filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN),
            ]);
            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'is_active' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000', 
            ]);
    
            $cuisine = Cuisine::findOrFail($id);
    
            $cuisineData = [
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'is_active' => $request->is_active,
                'modified_by' => auth()->id(),
            ];
    
            if ($request->hasFile('image')) {
                if ($cuisine->image_path && Storage::exists($cuisine->image_path)) {
                    Storage::delete($cuisine->image_path); // Delete old image
                }
                $imagePath = $request->file('image')->store('cuisines', 'public');
                $cuisineData['image_path'] = $imagePath;
            }
    
            $cuisine->update($cuisineData);
    
            return ResponseWithSuccessData($lang, $cuisine, 1);
        } catch (\Exception $e) {
            Log::error('Error updating cuisine: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function destroy($id)
    {
        try {
            $lang = request()->header('lang', 'ar');
            $cuisine = Cuisine::findOrFail($id);
            $cuisine->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting cuisine: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
