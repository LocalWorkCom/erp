<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OpeningBalance;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class OpeningBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $balance = OpeningBalance::where('deleted_at', null)->get();

            return ResponseWithSuccessData($lang, $balance, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale($lang);
            $validator = Validator::make($request->all(), [
                'amount' => 'required|integer',
                "price" => "required|integer",
                "date" => "required||date_format:Y-m-d",
                "product" => "required|exists:products,id",
                "store" => "required|exists:stores,id",

            ]);

            if ($validator->fails()) {
                return RespondWithBadRequestWithData($validator->errors());
            }
            $balances = new OpeningBalance();
            $balances->product_id  = $request->product;
            $balances->store_id  = $request->store;
            $balances->amount = $request->amount;
            $balances->price = $request->price;
            $balances->date = $request->date;
            $balances->created_by = auth()->id();
            $balances->save();
            return ResponseWithSuccessData($lang, $balances, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale($lang);

            $validator = Validator::make($request->all(), [
                "product_id" => "required|exists:products,id",
                "store" => "required|exists:stores,id",
                'amount' => 'required|integer',
                "price" => "required|integer",
                "date" => "required||date_format:Y-m-d",
            ]);

            if ($validator->fails()) {
                return RespondWithBadRequestWithData($validator->errors());
            }
            // Find the opening balance
            $balances = OpeningBalance::findOrFail($request->input('id'));

            // Check if there are any transactions for the product in this store, on or after the creation date
            $existingTransactions = ProductTransaction::where('product_id', $balances->product_id)
                ->where('store_id', $balances->store_id)
                ->whereDate('created_at', '>=', $balances->date)
                ->exists(); // Check if such transactions exist

            if ($existingTransactions) {
                return RespondWithBadRequest($lang, 7);
                // return response()->json([
                //     "status" => false,
                //     "message" => $lang == 'ar'
                //         ? "لا يمكنك تعديل الرصيد الافتتاحي لأن هناك معاملات على المنتج في هذا المتجر بعد هذا التاريخ."
                //         : "You cannot update the opening balance because there are transactions on this product in this store after the creation date."
                // ], 400);
            }
            $balances = OpeningBalance::findOrFail($request->input('id'));
            $balances->product_id  = $request->product_id;
            $balances->store_id  = $request->store;
            $balances->amount = $request->amount;
            $balances->price = $request->price;
            $balances->date = $request->date;
            $balances->modified_by = auth()->id();
            $balances->save();

            return ResponseWithSuccessData($lang, $balances, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
