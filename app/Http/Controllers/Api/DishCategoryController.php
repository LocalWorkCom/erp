<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BranchMenuCategory;
use App\Models\DishCategory;
use App\Models\Offer;
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
    public function menuDishes(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        $categoryId = $request->query('categoryId', 'all');
        $offers = $request->query('offers', 0);

        // Validate inputs
        if (!is_numeric($categoryId) && $categoryId !== 'all' || !in_array($offers, [0, 1])) {
            return RespondWithBadRequestData($lang, 2, 'Invalid input values.');
        }

        // Scenario 1: If categoryId is greater than 0, fetch dishes for the category
        if (is_numeric($categoryId) && $categoryId > 0) {
            $dishCategory = DishCategory::with(['dishes' => function ($query) {
                $query->where('is_active', true);
            }])->where('id', $categoryId)->first();

            if (!$dishCategory) {
                return RespondWithBadRequestData($lang, 2, 'Category not found.');
            }

            return ResponseWithSuccessData($lang, $dishCategory, 1);
        }

        // Scenario 2: If categoryId is 'all', fetch all categories
        if ($categoryId === 'all') {
            $dishCategories = DishCategory::with(['dishes' => function ($query) {
                $query->where('is_active', true);
            }])->get();

            return ResponseWithSuccessData($lang, $dishCategories, 1);
        }

        // Scenario 3: If offers = 1, fetch active offers with details
        if ($offers == 1) {
            $activeOffers = Offer::with('details')
                ->whereHas('details')
                ->where('is_active', 1)
                ->get()
                ->map(function ($offer) {
                    // Assuming you want to add the translated name for each detail
                    $offer->details->each(function ($detail) {
                        $detail->type_name_en = $detail->getTypeName('en'); // Add English name
                        $detail->type_name_ar = $detail->getTypeName('ar'); // Add Arabic name
                    });
                    return $offer;
                }) ?? collect();

            return ResponseWithSuccessData($lang, $activeOffers, 1);
        }

        // Default fallback
        return RespondWithBadRequestData($lang, 2, 'Invalid scenario.');
    }

}


