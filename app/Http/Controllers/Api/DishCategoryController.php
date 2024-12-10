<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DishCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DishCategoryController extends Controller
{
    protected $dishCategoryService;

    public function __construct(DishCategoryService $dishCategoryService)
    {
        $this->dishCategoryService = $dishCategoryService;
    }

    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $withTrashed = $request->query('withTrashed', false);

            $categories = $this->dishCategoryService->index($withTrashed);

            return ResponseWithSuccessData($lang, $categories, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching dish categories: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $category = $this->dishCategoryService->show($id);

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function create(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $categories = $this->dishCategoryService->index();

            return ResponseWithSuccessData($lang, ['parent_categories' => $categories], 1);
        } catch (\Exception $e) {
            Log::error('Error preparing data for creating dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $category = $this->dishCategoryService->show($id);
            $categories = $this->dishCategoryService->index();

            return ResponseWithSuccessData($lang, ['category' => $category, 'parent_categories' => $categories], 1);
        } catch (\Exception $e) {
            Log::error('Error preparing data for editing dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $data = $request->all();
            $data['created_by'] = auth()->id();

            $category = $this->dishCategoryService->store($data, $request->file('image'));

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return RespondWithBadRequestWithData($e->errors());
        } catch (\Exception $e) {
            Log::error('Error creating dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $data = $request->all();
            $data['modified_by'] = auth()->id();

            $category = $this->dishCategoryService->update($id, $data, $request->file('image'));

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return RespondWithBadRequestWithData($e->errors());
        } catch (\Exception $e) {
            Log::error('Error updating dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');

            $this->dishCategoryService->destroy($id);

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $category = $this->dishCategoryService->restore($id);

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
