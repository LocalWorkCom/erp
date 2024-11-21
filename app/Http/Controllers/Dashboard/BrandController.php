<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Services\BrandService ;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    protected $BrandService ;
    protected $checkToken;  // Set to true or false based on your need
    protected $lang;  // Set to true or false based on your need

    
    public function __construct(BrandService  $BrandService)
    {
        $this->BrandService  = $BrandService ;
        $this->checkToken = false;
        $this->lang =  app()->getLocale();
    }

    public function index(Request $request)
    {

        // Pass it to the service
        $response  = $this->BrandService ->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $brands = Brand::hydrate($responseData['data']);

        return view('dashboard.brand.list', compact('brands'));
    }

    public function create()
    {

        // Pass it to the service
        // $response  = $this->BrandService ->create($request, $this->checkToken);
        // $responseData = json_decode($response->getContent(), true);
        // $products = $responseData['data'];
        return view('dashboard.brand.add');
 
    }    

    public function store(Request $request)
    {
        return $this->BrandService ->store($request, $this->checkToken);
    }

    public function update(Request $request, $id)
    {
        return $this->BrandService ->update($request, $id, $this->checkToken);
    }
}
