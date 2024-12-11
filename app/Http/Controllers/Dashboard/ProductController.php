<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Unit;
use App\Models\Brand;
use App\Models\Store;
use App\Models\Country;
use App\Models\Product;

use App\Models\Category;
use App\Models\ProductLimit;
use Illuminate\Http\Request;
use App\Services\UnitService;
use App\Services\BrandService;
use App\Services\CountryService;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;

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
    protected $unitService;
    protected $categoryService;
    protected $countryService;



    public function __construct(ProductService $productService, BrandService $brandService, UnitService $unitService, CategoryService $categoryService, CountryService $countryService)
    {
        $this->productService = $productService;
        $this->brandService = $brandService;
        $this->unitService = $unitService;
        $this->countryService = $countryService;
        $this->categoryService = $categoryService;
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

        $response  = $this->unitService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $Units = Unit::hydrate($responseData['data']);


        $response  = $this->categoryService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $Categories = Category::hydrate($responseData['data']);

        $response  = $this->countryService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $Countries = Country::hydrate($responseData['data']);
        $Currencies = [];

        foreach ($Countries as $country) {
            // Check if currency_code exists and add it to the array
            if (isset($country->currency_code)) {
                $Currencies[] = $country->currency_code;
            }
        }

        // $Stores = Store::all();

        return view('dashboard.product.add', compact('Brands', 'Categories', 'Units', 'Currencies'));
    }

    public function store(Request $request)
    {
        //        dd($request->all());
        $response = $this->productService->store($request, $this->checkToken);
        //        dd($response);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message = $responseData['message'];
        return redirect('dashboard/products')->with('message', $message);
    }

    public function edit(Request $request, $id)
    {

        $product = Product::findOrFail($id);
        $product_limit = ProductLimit::where('product_id', $product->id)->first();

        $response  = $this->brandService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $Brands = Brand::hydrate($responseData['data']);

        $response  = $this->unitService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $Units = Unit::hydrate($responseData['data']);

        $response  = $this->categoryService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $Categories = Category::hydrate($responseData['data']);

        $response  = $this->countryService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $Countries = Country::hydrate($responseData['data']);
        $Currencies = [];

        foreach ($Countries as $country) {
            // Check if currency_code exists and add it to the array
            if (isset($country->currency_code)) {
                $Currencies[] = $country->currency_code;
            }
        }
        // $Stores = Store::all();

        return view('dashboard.product.edit', compact('product',  'Categories', 'Units', 'Currencies', 'Brands', 'product_limit','id'));
    }

    public function show($id)
    {
        $request = new Request(); // Create a blank request object if needed

        $product = Product::with(['brand', 'productLimit', 'images'])->findOrFail($id);

        $response = $this->countryService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $Countries = Country::hydrate($responseData['data']);
        $Currencies = [];

        foreach ($Countries as $country) {
            // Check if currency_code exists and add it to the array
            if (isset($country->currency_code)) {
                $Currencies[] = $country->currency_code;
            }
        }

        return view('dashboard.product.show', compact('product', 'Currencies','id'));
    }

    // public function show($id)
    // {
    //     $request = new Request(); // Create a blank request object if needed

    //     $product = Product::with(['brand', 'productLimit'])->findOrFail($id);


    //     $response  = $this->countryService->index($request, $this->checkToken);
    //     $responseData = json_decode($response->getContent(), true);
    //     $Countries = Country::hydrate($responseData['data']);
    //     $Currencies = [];

    //     foreach ($Countries as $country) {
    //         // Check if currency_code exists and add it to the array
    //         if (isset($country->currency_code)) {
    //             $Currencies[] = $country->currency_code;
    //         }
    //     }

    //     return view('dashboard.product.show', compact('product', 'Currencies'));
    // }

    public function update(Request $request, $id)
    {
        $response = $this->productService->update($request, $id, $this->checkToken);
        // dd($response);
        //        dd($response);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message = $responseData['message'];
        return redirect('dashboard/products')->with('message', $message);
    }

    public function delete(Request $request, $id)
    {
        //        dd($request->all());
        $response = $this->productService->delete($request, $id, $this->checkToken, true);
        //        dd($response);
        $responseData = $response->original;
        $message = $responseData['message'];
        return redirect('dashboard/products')->with('message', $message);
    }
}
