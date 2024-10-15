<?php

namespace App\Http\Controllers\Api;

use App\Events\ProductTransactionEvent;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoicesDetails;
use App\Models\StoreTransaction;
use App\Models\StoreTransactionDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PurchaseInvoiceController extends Controller
{
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

        //Create a new store transaction
        // $storeTransaction = StoreTransaction::create([
        //     'user_id' => Auth::id(),
        //     'store_id' => $request->store_id,
        //     'type' => 2,  // Incoming type for purchasing
        //     'to_type' => 3, // From vendor
        //     'to_id' => $request->vendor_id,
        //     'date' => $request->date,
        //     'total' => 0,
        //     'total_price' => 0,
        //     'created_by' => Auth::id(),
        // ]);

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

            // Create store transaction details
            // StoreTransactionDetails::create([
            //     // 'store_transaction_id' => $storeTransaction->id,
            //     'product_id' => $productData['product_id'],
            //     'product_unit_id' => $productData['unit_id'],
            //     'price' => $productData['price'],
            //     'count' => $productData['quantity'],
            //     'total_price' => $productData['price'] * $productData['quantity'],  // Total price for this product
            //     'expired_date' => $productData['expiry_date'] ?? null,
            // ]);

            $totalQuantity += $productData['quantity'];
            $totalPrice += $productData['price'] * $productData['quantity'];

            // Trigger the ProductTransactionEvent for each product added to inventory
            // $storeTransactionDetails = new StoreTransactionDetails([
            //     'product_id' => $productData['product_id'],
            //     'store_id' => $request->store_id,
            //     'count' => $productData['quantity'],
            //     'expired_date' => $productData['expiry_date'] ?? null,
            //     'type' => 2,  // Type 2 for purchasing from the vendor
            // ]);

            // Trigger the event for inventory update
            // event(new ProductTransactionEvent($storeTransactionDetails));
        }

        //Update the total quantity and price in the purchase invoice and store transaction
        $purchaseInvoice->update([
            'total_quantity' => $totalQuantity,
            'total_price' => $totalPrice,
        ]);

        // $storeTransaction->update([
        //     'total' => $totalQuantity,
        //     'total_price' => $totalPrice,
        // ]);
        return ResponseWithSuccessData($lang, [
            'purchase_invoice' => $purchaseInvoice->load('purchaseInvoiceDetails'),
            // 'store_transaction' => $storeTransaction->load('storeTransactionDetails'),
        ], 27);
    }
}
