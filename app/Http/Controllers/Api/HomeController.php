<?php

namespace App\Http\Controllers\Api;

use App\Models\Offer;
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
        $branchesData = $branchesResponse->getData()->data; // LAT AND LONG OPTIONAL
        $branches = [
            'branch' => $branchesData->branch ?? null,
            'branches' => $branchesData->branches ?? null,
        ];

        // Check if the branch is provided and lat/long is available
        $branchId = $branches['branch']->id ?? null;
//        dd($branchId);

        $sliderController = new SliderController();
        $sliderResponse = $sliderController->index($request);
        $slider = $sliderResponse->getData()->data; //**************

        $menuController = new DishCategoryController($this->dishCategoryService);
        $menuResponse = $menuController->menuDishes($request);
        $menu = array_slice($menuResponse->getData()->data, -4); // 4 //**************
        $menu = array_map(function ($item) {
            unset($item->dishes); // Remove the dishes array
            return $item;
        }, $menu);


        $mostPopularController = new MostPopularController();
        $mostPopularResponse = $mostPopularController->index($request);
        $mostPopular = $mostPopularResponse->getData()->data; //5 //if auth return favourite //**************

//        $isOffers = $request->query('offers');
////        dd($isOffers);
//
//        if ($isOffers == 1) {
//            // Check if lat/long are provided and if branch is not null
//            if ($branchId && isset($request->lat) && isset($request->long)) {
//                // Filter offers by branch if lat/long is provided and branch is not null
//                $offers = Offer::where(function ($query) use ($branchId) {
//                    if ($branchId) {
//                        // Check if the offer is specific to the branch or is available in all branches
//                        $query->where('branch_id', $branchId)
//                            ->orWhere('branch_id', -1);  // Include offers available in all branches
//                    }
//                })
//                    ->get(); // Get offers based on the branch filter
//
//                // If offers exist, set them as the menu
//                if ($offers->isNotEmpty()) {
//                    $menu = $offers;
//                }
//            }
//            else{
//                $offers = Offer::where('branch_id', -1)
//                    ->get(); // Get offers based on the branch filter
//
//                // If offers exist, set them as the menu
//                if ($offers->isNotEmpty()) {
//                    $menu = $offers;
//                }
//            }
//        }

        // Check if the user is authenticated and mark favorites for popular dishes
        if (CheckToken()) {
            $user = auth('api')->user(); // Get authenticated user
//            dd($user);

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
            'branches' => $branches ?? null,
            'slider' => $slider ?? null,
            'menu' => $menu ?? null,
            'mostPopular' => $mostPopular ?? null,
        ];

        if (empty($data['branches']) && empty($data['slider']) && empty($data['menu']) && empty($data['mostPopular'])) {
            return RespondWithBadRequestData($lang, 2); // Unauthorized response
        }

        return ResponseWithSuccessData($lang, $data, 1);
    }
    public function showFavorites(Request $request)
    {
        $lang = $request->header('lang', 'ar');

        try {
            // Validate token-based user authentication
            $user = auth('api')->user();
            if (!$user) {
                return RespondWithBadRequestData($lang, 2); // Unauthorized response
            }
//            dd($user);

            $lang = $request->header('lang', 'ar'); // Get language preference from the request, default to Arabic (ar)

// Query the user favorites with all dish details
            $userFavorites = DB::table('user_favorite_dishes')
                ->join('dishes', 'user_favorite_dishes.dish_id', '=', 'dishes.id') // Join with dishes table
                ->where('user_favorite_dishes.user_id', $user->id)
                ->select('user_favorite_dishes.id', 'user_favorite_dishes.user_id', 'user_favorite_dishes.dish_id',
                    'dishes.id as dish_id', 'dishes.category_id', 'dishes.cuisine_id', 'dishes.price',
                    'dishes.image', 'dishes.name_en', 'dishes.name_ar', 'dishes.description_en', 'dishes.description_ar',
                    'dishes.is_active', 'dishes.has_sizes', 'dishes.has_addon', 'dishes.created_by', 'dishes.modified_by',
                    'dishes.deleted_by', 'dishes.created_at', 'dishes.updated_at') // Select all relevant dish columns
                ->get()
                ->map(function ($favorite) use ($lang) {
                    // Depending on the language, set the dish name and description
                    if ($lang == 'en') {
                        $favorite->dish_name = $favorite->name_en;
                        $favorite->dish_description = $favorite->description_en;
                    } else {
                        $favorite->dish_name = $favorite->name_ar;
                        $favorite->dish_description = $favorite->description_ar;
                    }

                    // Remove unnecessary columns if you want (we only need the dish name and description)
                    unset($favorite->name_en, $favorite->name_ar, $favorite->description_en, $favorite->description_ar);

                    return $favorite;
                });

            if ($userFavorites->isEmpty()) {
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

    public function storeFavorite(Request $request)
    {
        $lang = $request->header('lang', 'ar');

        try {
            $user = auth('api')->user();
//            dd($user);
            if (!$user) {
                return RespondWithBadRequestData($lang, 4); // Unauthorized response
            }

            // Get the dish_id from the request
            $dishId = $request->input('dish_id');

            // Validate that dish_id is provided and is a valid number
            if (!$dishId || !is_numeric($dishId)) {
                return respondError('Validation Error', 400,[
                    'dish_id' => $lang == 'en' ? ['invalid number'] : ['رقم غير صحيح'],
                ]); // Invalid dish_id
            }

            // Check if the dish already exists in the user's favorites
            $existingFavorite = DB::table('user_favorite_dishes')
                ->where('user_id', $user->id)
                ->where('dish_id', $dishId)
                ->first();

            if ($existingFavorite) {
                // If the dish is already a favorite, return a response indicating that
                return RespondWithBadRequestData($lang, 9); // Favorite already exists
            }

            // Store the new favorite dish in the database
            DB::table('user_favorite_dishes')->insert([
                'user_id' => $user->id,
                'dish_id' => $dishId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Return success response
            return RespondWithSuccessRequest($lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 8); // Generic error response
        }
    }

    public function deleteFavorite($id, Request $request)
    {
        $lang = $request->header('lang', 'ar');

        try {
            // Authenticate user using token
            $user = auth('api')->user();
            if (!$user) {
                return RespondWithBadRequestData($lang, 4); // Unauthorized response
            }

            // Check if the favorite dish exists for the given user
            $favorite = DB::table('user_favorite_dishes')
                ->where('user_id', $user->id)
                ->where('dish_id', $id) // Use the dish ID from the URL parameter
                ->first();

            if (!$favorite) {
                // If the dish is not in the user's favorites
                return RespondWithBadRequestData($lang, 8); // Favorite not found
            }

            // Delete the favorite dish record
            DB::table('user_favorite_dishes')
                ->where('user_id', $user->id)
                ->where('dish_id', $id)
                ->delete();

            // Return success response
            return RespondWithSuccessRequest($lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 8); // Generic error response
        }
    }


}
