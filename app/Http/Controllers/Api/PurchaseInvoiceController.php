<?php

namespace App\Http\Controllers\Api;

use App\Events\ProductTransactionEvent;
use App\Http\Controllers\Controller;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoicesDetails;
use App\Models\StoreTransaction;
use App\Models\StoreTransactionDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            return RespondWithBadRequest($lang, code: 5);
        }

        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'invoice_number' => 'required|string|unique:purchase_invoices,invoice_number',
            'vendor_id' => 'required|exists:vendors,id',
            'type' => 'required|boolean', // 0: Purchase, 1: Refund
            'store_id' => 'required|exists:stores,id',
            'category_id' => 'required|exists:categories,id',
            'product_id' => 'required|exists:products,id',
            'unit_id' => 'required|exists:units,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'expiry_date' => 'date',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Create the purchase invoice
        $purchaseInvoice = PurchaseInvoice::create([
            'date' => $request->date,
            'invoice_number' => $request->invoice_number,
            'vendor_id' => $request->vendor_id,
            'type' => $request->type,
            'store_id' => $request->store_id,
            'created_by' => Auth::id(),
        ]);

        // Create the purchase invoice details
        PurchaseInvoicesDetails::create([
            'purchase_invoices_id' => $purchaseInvoice->id,
            'category_id' => $request->category_id,
            'product_id' => $request->product_id,
            'unit_id' => $request->unit_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        return ResponseWithSuccessData($lang, $purchaseInvoice->load('purchaseInvoicesDetails'), 27);
    }


    private function checkStoreTransactionExists($purchaseInvoiceId)
    {
        return StoreTransaction::where('purchase_invoice_id', $purchaseInvoiceId)->exists();
    }


    public function update(Request $request, $id)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        $purchaseInvoice = PurchaseInvoice::findOrFail($id);



        // Check if a store transaction is linked to the purchase invoice
        // if ($this->checkStoreTransactionExists($purchaseInvoice->id)) {
        // If the type is not a refund (0: Purchase), block the update
        if ($purchaseInvoice->type == 0) {
            return RespondWithBadRequestData($lang, 28);
        }
        // If the type is a refund (1: Refund), allow the update
        if ($purchaseInvoice->type == 1) {
            $validator = Validator::make($request->all(), [
                'date' => 'required|date',
                'invoice_number' => 'required|string|unique:purchase_invoices,invoice_number,' . $purchaseInvoice->id,
                'vendor_id' => 'required|exists:vendors,id',
                'store_id' => 'required|exists:stores,id',
                'category_id' => 'required|exists:categories,id',
                'product_id' => 'required|exists:products,id',
                'unit_id' => 'required|exists:units,id',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|numeric|min:0',
                'expiry_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return RespondWithBadRequestWithData($validator->errors());
            }
            $purchaseInvoice->update([
                'date' => $request->date,
                'invoice_number' => $request->invoice_number,
                'vendor_id' => $request->vendor_id,
                'type' => $request->type,
                'store_id' => $request->store_id,
                'modified_by' => Auth::id(),
            ]);

            // Update purchase invoice details
            $purchaseInvoiceDetail = PurchaseInvoicesDetails::where('purchase_invoices_id', $purchaseInvoice->id)->first();
            $purchaseInvoiceDetail->update([
                'category_id' => $request->category_id,
                'product_id' => $request->product_id,
                'unit_id' => $request->unit_id,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ]);

            $productTransaction = new StoreTransactionDetails();
            $productTransaction->product_id = $request->product_id;
            $productTransaction->store_id = $request->store_id;
            $productTransaction->count = $request->quantity;
            $productTransaction->expired_date = $request->expiry_date ?? null;
            $productTransaction->type = 1; // Type 1 for refund

            event(new ProductTransactionEvent($productTransaction));


            return ResponseWithSuccessData($lang, $purchaseInvoice->load('purchaseInvoicesDetails'), 29);
        }
    }
    // }
    // If no store transaction exists, allow updates
    // $validator = Validator::make($request->all(), [
    //     'date' => 'required|date',
    //     'invoice_number' => 'required|string|unique:purchase_invoices,invoice_number,' . $purchaseInvoice->id,
    //     'vendor_id' => 'required|exists:vendors,id',
    //     'store_id' => 'required|exists:stores,id',
    //     'category_id' => 'required|exists:categories,id',
    //     'product_id' => 'required|exists:products,id',
    //     'unit_id' => 'required|exists:units,id',
    //     'price' => 'required|numeric|min:0',
    //     'quantity' => 'required|numeric|min:0',
    //     'expiry_date' => 'required|date',
    // ]);

    // if ($validator->fails()) {
    //     return RespondWithBadRequestWithData($validator->errors());
    // }

    // try {
    //     DB::beginTransaction();

    //     // Update the purchase invoice and details
    //     $purchaseInvoice->update($request->all());
    //     $purchaseInvoiceDetail = PurchaseInvoicesDetails::where('purchase_invoices_id', $purchaseInvoice->id)->first();
    //     $purchaseInvoiceDetail->update($request->all());

    //     DB::commit();

    //     return ResponseWithSuccessData($lang, $purchaseInvoice->load('purchaseInvoicesDetails'), 27);
    // } catch (\Exception $e) {
    //     DB::rollBack();
    //     return RespondWithBadRequest($lang, 2);
    // }
}
