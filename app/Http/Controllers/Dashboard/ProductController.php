<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    protected $productService;
    protected $checkToken;  // Set to true or false based on your need


    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->checkToken = false;
    }

    public function index(Request $request)
    {

        // Pass it to the service
        $response  = $this->productService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        // $products = collect($responseData['data']);
        $products = Product::hydrate($responseData['data']);

        return view('dashboard.products.list', compact('products'));
    }

    public function store(Request $request)
    {
        return $this->productService->store($request, $this->checkToken);
    }

    public function update(Request $request, $id)
    {
        return $this->productService->update($request, $id, $this->checkToken);
    }
}
