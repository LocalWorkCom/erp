<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Gift;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\BranchMenuCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{


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
