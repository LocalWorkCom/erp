<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Services\BrandService;
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
    protected $lang;  // Set to true or false based on your need
    protected $brandService;


    public function __construct(ProductService $productService, BrandService $brandService)
    {
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->checkToken = false;
        $this->lang =  app()->getLocale();
    }

    public function index(Request $request)
    {

        // Pass it to the service
        $response  = $this->productService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $products = Product::hydrate($responseData['data']);

        return view('dashboard.product.list', compact('products'));
    }

    public function create(Request $request)
    {
        $response  = $this->brandService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $Brands = Brand::hydrate($responseData['data']);
        $lang = $this->lang;
        return view('dashboard.product.add', compact('Brands', 'lang'));
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
