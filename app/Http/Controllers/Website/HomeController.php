<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaticPageResource;
use App\Models\Branch;
use App\Models\BranchMenuCategory;
use App\Models\Discount;
use App\Models\DishDiscount;
use App\Models\PrivacyPolicy;
use App\Models\ReturnPolicy;
use App\Models\Slider;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::all();
        $branches = Branch::all();
        $discounts = DishDiscount::with(['dish', 'discount'])->get();
        // $lastThreeDiscounts = DishDiscount::with(['dish', 'discount'])->get();
        // $discounts = $lastThreeDiscounts->reverse()->take(3);
        // $discounts = $discounts->reverse();
        $popularDishes = getMostDishesOrdered(5);
        $menuCategories = BranchMenuCategory::with('dish_categories')
            ->where('is_active', true)->get();
        return view(
            'website.landing',
            compact(['sliders', 'discounts', 'popularDishes', 'menuCategories', 'branches'])
        );
    }

    public function showMenu()
    {
        $branches = Branch::all();
        $menuCategories = BranchMenuCategory::with(['dish_categories' => function ($query) {
            $query->where('is_active', true);
        }, 'dish_categories.dishes' => function ($query) {
            $query->where('is_active', true);
        }])->get();
        return view(
            'website.menu',
            compact(['menuCategories', 'branches'])
        );
    }
    public function contactUs()
    {
        $branches = Branch::all();
        return view(
            'website.contact-us',
            compact(['branches'])
        );
    }

    public function privacy()
    {
        $privacies = StaticPageResource::collection(PrivacyPolicy::all());
        $privaciesArray = $privacies->toArray(request());
        return view('website.privacy', compact('privaciesArray'));
    }

    public function return()
    {
        $returns = StaticPageResource::collection(ReturnPolicy::all());
        $returnsArray = $returns->toArray(request());
        return view('website.return', compact('returnsArray'));
    }
    public function terms()
    {
        $terms = StaticPageResource::collection(TermsAndCondition::all());
        $termsArray = $terms->toArray(request());
        return view('website.terms', compact('termsArray'));
    }
}
