<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MostPopularController extends Controller
{
    protected $lang;
    public function index(Request $request)
{
    $this->lang = $request->header('lang', 'ar');
    $branchController = new BranchController();
    $branchesResponse = $branchController->listBranchAndNear($request);
    $branchesData = $branchesResponse->getData()->data; // LAT AND LONG OPTIONAL
    $branch = $branchesData->branch ?? null;
    $branchId = $branch->id ?? null;
    $popularDishes = getMostDishesOrdered($branchId);
    
    foreach ($popularDishes as $popularDish) {
        if ($popularDish) {
            // Hide unused fields
            $popularDish->makeHidden(['name_ar', 'description_ar', 'name_en', 'description_en']);
            
            // Transform language-specific fields
            if (request()->header('lang', 'ar') === 'en') {
                $popularDish['name'] = $popularDish->name_en;
                $popularDish['description'] = $popularDish->description_en;
            } else {
                $popularDish['name'] = $popularDish->name_ar;
                $popularDish['description'] = $popularDish->description_ar;
            }

            // Add transformations for boolean fields
            $popularDish->is_active = (bool) $popularDish->is_active;
            $popularDish->has_sizes = (bool) $popularDish->has_sizes;
            $popularDish->has_addon = (bool) $popularDish->has_addon;
        }
    }

    if (!$popularDishes) {
        return RespondWithBadRequestData($this->lang, 2);
    }
    
    return ResponseWithSuccessData($this->lang, $popularDishes, 1);
}

}
