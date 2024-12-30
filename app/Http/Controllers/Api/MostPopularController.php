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
        $popularDishes = getMostDishesOrdered(1, 5);
        if (!$popularDishes) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        return ResponseWithSuccessData($this->lang, $popularDishes, 1);
    }
}
