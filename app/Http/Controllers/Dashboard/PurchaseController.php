<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\PurchaseInvoice;
use App\Services\PurchaseService;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected $purchaseService;
    protected $checkToken;


    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
        $this->checkToken = false;
    }

    public function index()
    {
        $purchases = $this->purchaseService->getAllPurchases($this->checkToken);
        return view('dashboard.purchases.index', compact('purchases'));
    }
    public function show($id)
    {
        $purchase = $this->purchaseService->getPurchase($id);
        return view('dashboard.purchases.show', compact('purchase'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('dashboard.purchases.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address_en' => 'nullable|string',
            'address_ar' => 'nullable|string',
            'country_id' => 'required|integer|exists:countries,id',
        ]);

        $this->purchaseService->createPurchase($validatedData, $this->checkToken);
        return redirect()->route('purchases.index')->with('success', 'purchase created successfully!');
    }
    public function edit($id)
    {
        $purchase = PurchaseInvoice::with('country')->findOrFail($id);
        $countries = Country::all();
        return view('dashboard.purchases.edit', compact('countries', 'purchase'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address_en' => 'nullable|string',
            'address_ar' => 'nullable|string',
            'country_id' => 'nullable|integer|exists:countries,id',
        ]);

        $this->purchaseService->updatePurchase($validatedData, $id, $this->checkToken);
        return redirect()->route('purchases.index')->with('success', 'purchase updated successfully!');
    }
    public function destroy($id)
    {
        $this->purchaseService->deletePurchase($id, $this->checkToken);
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully!');
    }
}
