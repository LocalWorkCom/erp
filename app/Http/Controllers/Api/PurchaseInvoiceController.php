<?php

namespace App\Http\Controllers\Api;

use App\Events\ProductTransactionEvent;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoicesDetails;
use App\Models\StoreTransaction;
use App\Models\StoreTransactionDetails;
use App\Traits\StoreTransactionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PurchaseInvoiceController extends Controller
{
    use StoreTransactionTrait;

    public function index(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        $purchaseInvoices = PurchaseInvoice::with('purchaseInvoicesDetails')->get();

        return ResponseWithSuccessData($lang, $purchaseInvoices, 26);
    }

    public function show(Request $request, $id)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        $purchaseInvoice = PurchaseInvoice::with('purchaseInvoicesDetails')->findOrFail($id);

        return ResponseWithSuccessData($lang, $purchaseInvoice, 26);
    }

    public function store(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'vendor_id' => 'required|exists:vendors,id',
            'store_id' => 'required|exists:stores,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.unit_id' => 'required|exists:units,id',
            'products.*.quantity' => 'required|numeric|min:0',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.expiry_date' => 'nullable|date',
            'type' => 'required|in:0,1',  // 0 for purchase, 1 for refund
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequest($lang, $validator->errors());
        }

        //Create the purchase invoice
        $purchaseInvoice = new PurchaseInvoice();
        $purchaseInvoice->Date = $request->date;
        $purchaseInvoice->invoice_number = "INV-" . rand(1000, 9999);
        $purchaseInvoice->vendor_id = $request->vendor_id;
        $purchaseInvoice->type = $request->type;
        $purchaseInvoice->store_id = $request->store_id;
        $purchaseInvoice->created_by = Auth::id();

        $totalQuantity = 0;
        $totalPrice = 0;

        //Loop through the products and create purchase invoice details & store transaction details
        foreach ($request->products as $productData) {
            PurchaseInvoicesDetails::create([
                'purchase_invoice_id' => $purchaseInvoice->id,
                'product_id' => $productData['product_id'],
                'unit_id' => $productData['unit_id'],
                'price' => $productData['price'],
                'quantity' => $productData['quantity'],
                'expiry_date' => $productData['expiry_date'] ?? null,
            ]);

            $totalQuantity += $productData['quantity'];
            $totalPrice += $productData['price'] * $productData['quantity'];
        }

        //Update the total quantity and price in the purchase invoice and store transaction
        $purchaseInvoice->update([
            'total_quantity' => $totalQuantity,
            'total_price' => $totalPrice,
        ]);

        // Handle store transactions using the trait
        $this->add_item_tostore($purchaseInvoice->id, $request->type); // 0 = purchase, 1 = refund

        return ResponseWithSuccessData($lang, [
            'purchase_invoice' => $purchaseInvoice->load('purchaseInvoiceDetails'),
        ], 27);
    }
}
