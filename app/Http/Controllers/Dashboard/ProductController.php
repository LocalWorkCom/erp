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
use App\Models\Color;
use App\Models\ProductUnit;
use App\Models\Size;

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
// dd($Brands);
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
                $Currencies[] = ['id'=>$country->id, 'code'=>$country->currency_code];
            }
        }

        //return $Currencies;

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
        $product_unit = ProductUnit::where('product_id', $product->id)->first();

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

        return view('dashboard.product.edit', compact('product',  'Categories', 'Units', 'Currencies', 'Brands', 'product_limit', 'product_unit', 'id'));
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

        return view('dashboard.product.show', compact('product', 'Currencies', 'id'));
    }

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

    public function unit(Request $request, $productId)
    {
        $response = $this->productService->list($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $product = Product::with('units')->findOrFail($productId); // Load product with units
        $units = Unit::all();  // Retrieve all units

        foreach ($product->units as $unit) {
            if ($unit->pivot) {
                $factor = $unit->pivot->factor ?? null;  // Safely access pivot data
                $unitId = $unit->pivot->unit_id ?? null;
            }
        }
        // dd($productId, $unitId);  // Debugging output

        return view('dashboard.product.unit.list', compact('product', 'units'));
    }

    public function saveUnits(Request $request, $productId)
    {
        // Call the service method to save the units
        $response = $this->productService->saveProductUnits($request, $productId);

        // Ensure the response is in the expected format
        $responseData = $response->original ?? [];

        // Check if the response has a 'status' key
        if (isset($responseData['status']) && !$responseData['status']) {
            // If 'data' key exists, handle validation errors
            if (isset($responseData['data'])) {
                $validationErrors = $responseData['data'];
                return redirect()->back()->withErrors($validationErrors)->withInput();
            } else {
                return redirect()->back()->withErrors($responseData['message'])->withInput();
            }

            // If no 'data' key is present, handle it gracefully
        }

        // Success message
        $message = $responseData['message'] ?? __('Operation completed successfully.');

        // Redirect with success message
        return redirect()->route('products.list', ['id' => $productId])->with('message', $message);
    }

    public function size(Request $request, $productId)
    {
        $response = $this->productService->listSize($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $product = Product::with('product_sizes')->findOrFail($productId); // Load product with sizes
        $sizes = Size::all();  // Retrieve all sizes

        foreach ($product->sizes as $size) {
            if ($size->pivot) {
                $code_size = $size->pivot->code_size ?? null;  // Safely access pivot data
                $sizeId = $size->pivot->size_id ?? null;
            }
        }
        // dd($productId, $unitId);  // Debugging output

        return view('dashboard.product.size.list', compact('product', 'sizes'));
    }

    public function saveSizes(Request $request, $productId)
    {
        // Call the service method to save the units
        $response = $this->productService->saveProductSizes($request, $productId);

        // Ensure the response is in the expected format
        $responseData = $response->original ?? [];

        // Check if the response has a 'status' key
        if (isset($responseData['status']) && !$responseData['status']) {
            // If 'data' key exists, handle validation errors
            if (isset($responseData['data'])) {
                $validationErrors = $responseData['data'];
                return redirect()->back()->withErrors($validationErrors)->withInput();
            } else {
                // dd(0);
                return redirect()->back()->withErrors($responseData['message'])->withInput();
            }

            // If no 'data' key is present, handle it gracefully
        }

        // Success message
        $message = $responseData['message'] ?? __('Operation completed successfully.');

        // Redirect with success message
        return redirect()->route('products.list', ['id' => $productId])->with('message', $message);
    }

    public function color(Request $request, $productId)
    {
        $response = $this->productService->listColor($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $product = Product::with('product_colors')->findOrFail($productId); // Load product with sizes
        $colors = Color::all();  // Retrieve all sizes

        foreach ($product->colors as $color) {
            if ($color->pivot) {
                $colorId = $color->pivot->color_id ?? null;
            }
        }
        // dd($productId, $unitId);  // Debugging output

        return view('dashboard.product.color.list', compact('product', 'colors'));
    }


    public function saveColors(Request $request, $productId)
    {
        // Call the service method to save the units
        $response = $this->productService->saveProductColors($request, $productId);

        // Ensure the response is in the expected format
        $responseData = $response->original ?? [];

        // Check if the response has a 'status' key
        if (isset($responseData['status']) && !$responseData['status']) {
            // If 'data' key exists, handle validation errors
            if (isset($responseData['data'])) {
                $validationErrors = $responseData['data'];
                return redirect()->back()->withErrors($validationErrors)->withInput();
            } else {
                // dd(0);
                return redirect()->back()->withErrors($responseData['message'])->withInput();
            }

            // If no 'data' key is present, handle it gracefully
        }

        // Success message
        $message = $responseData['message'] ?? __('Operation completed successfully.');

        // Redirect with success message
        return redirect()->route('products.list', ['id' => $productId])->with('message', $message);
    }
}
