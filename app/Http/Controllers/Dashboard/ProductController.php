<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $data = $this->productService->index($request);
        $products = $data['data'];
        dd($products);
    }

    public function store(Request $request)
    {
        return $this->productService->store($request);
    }

    public function update(Request $request, $id)
    {
        return $this->productService->update($request, $id);
    }
}
