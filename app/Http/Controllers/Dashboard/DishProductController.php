<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DishCategoryService;
use App\Services\CuisineService;
use App\Models\Branch;
use App\Services\DishProductService;
use App\Models\Product;


class DishProductController extends Controller
{
    protected $dishCategoryService;
    protected $cuisineService;
    protected $dishProductService;

    public function __construct(DishCategoryService $dishCategoryService, CuisineService $cuisineService, DishProductService $dishProductService)
    {
        $this->dishCategoryService = $dishCategoryService;
        $this->cuisineService = $cuisineService;
        $this->dishProductService = $dishProductService;
    }

    public function create()
    {
        $categories = $this->dishCategoryService->index();
        $cuisines = $this->cuisineService->index();
        $branches = Branch::all(); 
        $products = Product::where('type', 'complete')->get(); 

        return view('dashboard.dish_products.create', compact('categories', 'cuisines', 'branches', 'products'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = auth()->id(); 
            $this->dishProductService->store($data);

            return redirect()->route('dashboard.dishes.index')->with('success', __('dishes.ProductCreated'));
        } catch (\Exception $e) {
            \Log::error('Product creation failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('dishes.ProductCreationFailed'));
        }
    }
}
