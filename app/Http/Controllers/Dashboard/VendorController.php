<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Services\VendorService;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    protected $vendorService;
    protected $checkToken;


    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
        $this->checkToken = false;
    }

    public function index()
    {
        $vendors = $this->vendorService->getAllvendors($this->checkToken);
        $countries = Country::get();
        return view('dashboard.vendor.index', compact('vendors', 'countries'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department_id' => 'required|integer|exists:departments,id',
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $this->vendorService->createVendor($validatedData, $this->checkToken);
        return redirect()->route('vendors.index')->with('success', 'vendor created successfully!');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'department_id' => 'nullable|integer|exists:departments,id',
            'name_ar' => 'nullable|string',
            'name_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $this->vendorService->updateVendor($validatedData, $id, $this->checkToken);
        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully!');
    }
    public function destroy($id)
    {
        $this->vendorService->deleteVendor($id, $this->checkToken);
        return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully!');
    }
}
