<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CuisineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CuisineController extends Controller
{
    protected $cuisineService;

    public function __construct(CuisineService $cuisineService)
    {
        $this->cuisineService = $cuisineService;
    }

    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $cuisines = $this->cuisineService->index();
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
            $cuisine = $this->cuisineService->show($id);
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
            $data = $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'is_active' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
            ]);

            $cuisine = $this->cuisineService->store($data, $request->file('image'));

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
            $data = $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'is_active' => 'required|boolean',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
            ]);

            $cuisine = $this->cuisineService->update($id, $data, $request->file('image'));

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
            $this->cuisineService->delete($id);

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting cuisine: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore($id)
    {
        try {
            $lang = request()->header('lang', 'ar');
            $cuisine = $this->cuisineService->restore($id);

            return ResponseWithSuccessData($lang, $cuisine, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring cuisine: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
