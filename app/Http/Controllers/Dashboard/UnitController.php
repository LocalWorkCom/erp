<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Unit;
use App\Services\UnitService;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    protected $UnitService;
    protected $checkToken;  // Set to true or false based on your need
    protected $lang;

    public function __construct(UnitService $UnitService)
    {
        $this->UnitService = $UnitService;
        $this->checkToken = false;
        $this->lang =  app()->getLocale();
    }

    public function index(Request $request)
    {

        // Pass it to the service
        $response  = $this->UnitService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $Units = Unit::hydrate($responseData['data']);

        return view('dashboard.unit.list', compact('Units'));
    }

    public function create()
    {

        // Pass it to the service
        // $response  = $this->UnitService->create($request, $this->checkToken);
        // $responseData = json_decode($response->getContent(), true);
        // $products = $responseData['data'];

        return view('dashboard.unit.add', compact('lang'));
    }

    public function store(Request $request)
    {
        return $this->UnitService->store($request, $this->checkToken);
    }

    public function update(Request $request, $id)
    {
        return $this->UnitService->update($request, $id, $this->checkToken);
    }
}
