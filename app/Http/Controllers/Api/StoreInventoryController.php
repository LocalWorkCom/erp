<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StoreTransaction;
use App\Services\StoreInventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StoreInventoryController extends Controller
{
    public function getInventory(Request $request, $storeId)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $transactions = StoreTransaction::with('stores')
                ->with('allStoreTransactionDetails')
                ->with('allStoreTransactionDetails.products')
                ->where('store_id', $storeId)
                ->where('type',2)
                ->get();
//            dd($lang);
//            dd($transactions);
            if ($transactions->isEmpty()) {
                return RespondWithBadRequestData($lang, 2);
            }

            $data = StoreInventoryService::getStoreInventory($lang, $transactions, $storeId);

            return ResponseWithSuccessData($lang, $data, 1);

        } catch (\Exception $e) {
            Log::error('Error fetching inventory: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}

