<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $countryService;
    protected $checkToken;  // Set to true or false based on your need


    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
        $this->checkToken = false;
    }

    public function index(Request $request)
    {
        $response = $this->countryService->index($request, $this->checkToken);

        $responseData = $response->original;

        $countries = $responseData['data'];

        return view('dashboard.country.list', compact('countries'));
    }

    public function store(Request $request)
    {
        return $this->countryService->store($request, $this->checkToken);
    }

    public function update(Request $request, $id)
    {
        return $this->countryService->update($request, $id, $this->checkToken);
    }
}
