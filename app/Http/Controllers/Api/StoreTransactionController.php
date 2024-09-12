<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\StoreTransaction;
use Illuminate\Http\Request;

class StoreTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request)
    {
        try{
            $lang =  $request->header('lang', 'en');
            $stores = StoreTransaction::with('storeTransactionDetails')->get();
            return ResponseWithSuccessData($lang, $stores, 1);
        }catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try{
            $lang =  $request->header('lang', 'en');
            $stores = StoreTransaction::with(['storeTransactionDetails'])->firstOrFail($id);
            return ResponseWithSuccessData($lang, $stores, 1);
        }catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        try{
            $lang =  $request->header('lang', 'en');
            $stores = [];
            return ResponseWithSuccessData($lang, $stores, 1);    
        }catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
