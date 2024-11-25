<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Unit;
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
    protected $checkToken;
    protected $lang;


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
        $Brands = Brand::all();
        $Categories = Category::all();
        $Stores = Store::all();
        $Units = Unit::all();
        $Currencies = [
            "EGP", "USD", "EUR", "EUR", "EUR", "EUR", "CAD", "AUD", "JPY", "CNY", "BRL", "MXN",
            "RUB", "INR", "ZAR", "SEK", "CHF", "ARS", "NOK", "EUR", "PLN", "IDR", "MYR", "VND",
            "CLP", "COP", "PEN", "UYU", "SGD", "TRY", "LKR", "LBP", "JOD", "IQD", "SAR", "AED",
            "QAR", "KWD", "OMR", "BHD", "EUR", "EUR", "EUR", "EUR", "ILS", "SYP", "YER", "IRR",
            "TMT", "UZS", "KGS", "BYN", "UAH", "MDL", "AMD", "GEL", "EUR", "EUR", "EUR", "MKD",
            "EUR", "EUR", "ALL", "BAM", "HRK", "EUR", "EUR", "HUF", "KMF", "MUR", "MGA", "TZS",
            "KES", "UGX", "RWF", "BIF", "SBD", "PGK", "TOP", "FJD", "NZD", "WST", "CKD", "NZD",
            "NZD", "DKK", "DKK", "ISK"
        ];
        return view('dashboard.product.add', compact('Brands', 'Categories','Units','Currencies','Stores'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $response = $this->productService->store($request, $this->checkToken);
//        dd($response);
        $responseData = $response->original;
        $message= $responseData['apiMsg'];
        return redirect('products')->with('message',$message);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
//        dd($product);
        $Brands = Brand::all();
        $Categories = Category::all();
        $Stores = Store::all();
        $Units = Unit::all();
        $Currencies = [
            "EGP", "USD", "EUR", "EUR", "EUR", "EUR", "CAD", "AUD", "JPY", "CNY", "BRL", "MXN",
            "RUB", "INR", "ZAR", "SEK", "CHF", "ARS", "NOK", "EUR", "PLN", "IDR", "MYR", "VND",
            "CLP", "COP", "PEN", "UYU", "SGD", "TRY", "LKR", "LBP", "JOD", "IQD", "SAR", "AED",
            "QAR", "KWD", "OMR", "BHD", "EUR", "EUR", "EUR", "EUR", "ILS", "SYP", "YER", "IRR",
            "TMT", "UZS", "KGS", "BYN", "UAH", "MDL", "AMD", "GEL", "EUR", "EUR", "EUR", "MKD",
            "EUR", "EUR", "ALL", "BAM", "HRK", "EUR", "EUR", "HUF", "KMF", "MUR", "MGA", "TZS",
            "KES", "UGX", "RWF", "BIF", "SBD", "PGK", "TOP", "FJD", "NZD", "WST", "CKD", "NZD",
            "NZD", "DKK", "DKK", "ISK"
        ];
        return view('dashboard.product.edit', compact('product',  'Categories','Units','Currencies','Stores','Brands'));
    }

    public function show($id)
    {
        $product = Product::with(['brand','productLimit'])->findOrFail($id);
//        dd($product);
        return view('dashboard.product.show', compact('product'));
    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        $response = $this->productService->update($request, $id, $this->checkToken);
//        dd($response);
        $responseData = $response->original;
        $message= $responseData['apiMsg'];
        return redirect('products')->with('message',$message);
    }

    public function delete(Request $request, $id)
    {
//        dd($request->all());
        $response = $this->productService->delete($request, $id, $this->checkToken,true);
//        dd($response);
        $responseData = $response->original;
        $message= $responseData['apiMsg'];
        return redirect('products')->with('message',$message);
    }
}
