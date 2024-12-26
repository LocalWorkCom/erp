<?php

namespace App\Http\Controllers\Api;

use App\Services\DishCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(DishCategoryService $dishCategoryService)
    {
        $this->dishCategoryService = $dishCategoryService;
    }
    public function index(Request $request)
    {
        $lang = $request->header('lang', 'ar');

        $branchController = new BranchController();
        $branchesResponse = $branchController->listBranchAndNear($request);
        $branchesData = $branchesResponse->getData()->data; //LAT AND LONG OPTIONAL
        $branches = [
            'branch' => $branchesData->branch ?? null,
            'branches' => $branchesData->branches ?? null,
        ];

        $sliderController = new SliderController();
        $sliderResponse = $sliderController->index($request);
        $slider = $sliderResponse->getData()->data;

        $menuController = new DishCategoryController($this->dishCategoryService);
        $menuResponse = $menuController->menuDishes($request);
        $menu = array_slice($menuResponse->getData()->data, -4); // 4

        $mostPopularController = new MostPopularController();
        $mostPopularResponse = $mostPopularController->index($request);
        $mostPopular = $mostPopularResponse->getData()->data; //5 //if auth return favourite

        if (CheckToken()) {
            $user = auth('api')->user(); // Get authenticated user

            if ($user) {
                $mostPopular = collect($mostPopular)->map(function ($dish) use ($user) {
                    $isFavorite = DB::table('user_favorite_dishes')
                        ->where('user_id', $user->id)
                        ->where('dish_id', $dish->id)
                        ->get(); // Check if the dish is in user's favorites
                    if ($isFavorite->isNotEmpty()) {
                        $flag = 1;
                    }

                    $dish->is_favorite = $flag ?? 0;
                    return $dish;
                })->toArray();
            }
        }

        $data = [
            'branches' => $branches,
            'slider' => $slider,
            'menu' => $menu,
            'mostPopular' => $mostPopular,
        ];

        if (empty($data['branches']) || empty($data['slider']) || empty($data['menu']) || empty($data['mostPopular'])) {
            return RespondWithBadRequestData($lang, 2); // Unauthorized response
        }
        return ResponseWithSuccessData($lang,$data,1);
    }
    public function showFavorites(Request $request)
    {
        $lang = $request->header('lang', 'ar');

        try {
            // Validate token-based user authentication
            $user = Auth::guard('api')->user();
            if (!$user) {
                Log::error('Unauthorized access attempt.');
                return RespondWithBadRequestData($lang, 2); // Unauthorized response
            }

            // Retrieve user's favorite dishes with details
            $userFavorites = DB::table('user_favorite_dishes')
                ->join('dishes', 'user_favorite_dishes.dish_id', '=', 'dishes.id')
                ->select('dishes.id', 'dishes.name', 'dishes.description', 'dishes.price', 'dishes.image', 'dishes.is_active')
                ->where('user_favorite_dishes.user_id', $user->id)
                ->where('dishes.is_active', true)
                ->get();

            // Log retrieved data
            Log::info('User ID: ' . $user->id);
            Log::info('Favorite dishes data: ', ['favorites' => $userFavorites]);

            if ($userFavorites->isEmpty()) {
                Log::warning('No favorite dishes found for user ID: ' . $user->id);
                return RespondWithBadRequestData($lang, 2); // No favorites found
            }

            // Prepare the response
            $menus = [
                'favorite_dishes' => $userFavorites
            ];

            return ResponseWithSuccessData($lang, $menus, 1);
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Error fetching favorite dishes: ' . $e->getMessage());

            return RespondWithBadRequestData($lang, 2); // Generic error response
        }
    }
}
