<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Opening_balance;
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
            $lang = $request->header('lang', 'en');
            $balance = Opening_balance::where('deleted_at', null)->get();

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
            $lang = $request->header('lang', 'en');
            App::setLocale($lang);

            $validator = Validator::make($request->all(), [
                "product" => "required|exists:products,id",
                "store" => "required|exists:stores,id",
                'amount' => 'required|integer',
                "price" => "required|integer",
                "date" => "required|date",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validator->errors()->first()
                ]);
            }
            $balances = new Opening_balance();
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
            $lang = $request->header('lang', 'en');
            App::setLocale($lang);

            $validator = Validator::make($request->all(), [
                "product" => "required|exists:products,id",
                "store" => "required|exists:stores,id",
                'amount' => 'required|integer',
                "price" => "required|integer",
                "date" => "required|date",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validator->errors()->first()
                ]);
            }
            //befor update should check there is not transactions on this product to enable to update
            $balances = Opening_balance::findOrFail($request->input('id'));
            $balances->product_id  = $request->product;
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
