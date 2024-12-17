<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
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
        $response = $this->countryService->store($request, $this->checkToken);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message = $responseData['message'];
        return redirect()->route('countries.list')->with('message', $message);
    }

    public function update(Request $request, $id)
    {
        $response = $this->countryService->update($request, $id, $this->checkToken);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message = $responseData['message'];
        return redirect()->route('countries.list')->with('message', $message);
    }
    public function destroy(Request $request, $id)
    {
        $response = $this->countryService->destroy($request,$id, $this->checkToken);
        $responseData = $response->original;

        // Handle errors and validation
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }

        // Success response
        $message = $responseData['message'];
        return redirect()->route('countries.list')->with('message', $message);
    }
}
