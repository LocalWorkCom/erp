<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchMenuCategory;
use App\Models\Discount;
use App\Models\DishDiscount;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::all();
        $discounts = DishDiscount::with(['dish', 'discount'])->get();
        $popularDishes = getMostDishesOrdered(5);
        $menuCategories = BranchMenuCategory::with('dish_categories')
            ->where('is_active', true)->get();
        return view(
            'website.landing',
            compact(['sliders', 'discounts', 'popularDishes', 'menuCategories'])
        );
    }

    public function showMenu()
    {
        $menuCategories = BranchMenuCategory::with(['dish_categories' => function ($query) {
            $query->where('is_active', true);
        }, 'dish_categories.dishes' => function ($query) {
            $query->where('is_active', true);
        }])->get();
        return view(
            'website.menu',
            compact(['menuCategories'])
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}