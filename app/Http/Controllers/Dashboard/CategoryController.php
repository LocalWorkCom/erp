<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    protected $categoryService;
    protected $checkToken;  // Set to true or false based on your need


    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->checkToken = false;
    }

    // public function index(Request $request)
    // {

    //     // Pass it to the service
    //     $response  = $this->categoryService->index($request, $this->checkToken);
    //     // dd($response);
    //     // $responseData = json_decode($response->getContent(), true);
    //     $categories = Category::hydrate($response->original);
    //     dd($categories);

    //     return view('dashboard.category.list', compact('categories'));
    // }

    public function index(Request $request)
{
    // Pass it to the service
    $response = $this->categoryService->index($request, $this->checkToken);

    // Extract the 'data' field from the response's original array (if 'data' exists)
    $responseData = $response->original;

    // If 'data' exists and is an array of items, extract it
    $categories = $responseData['data'];

    return view('dashboard.category.list', compact('categories'));
}

    public function store(Request $request)
    {
        return $this->categoryService->store($request, $this->checkToken);
    }

    public function update(Request $request, $id)
    {
        return $this->categoryService->update($request, $id, $this->checkToken);
    }
}
