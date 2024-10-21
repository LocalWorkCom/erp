<?php

namespace App\Http\Controllers\Api;

use App\Actions\ProductInventoryAction;
use App\Http\Controllers\Controller;
use App\Models\ProductTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductInventoryController extends Controller
{
    public function getInventory(Request $request,$productId)
    {
        try {
            $lang = $request->header('lang', 'ar');

            $transactions = ProductTransaction::with('products')
            ->select('product_id','count', 'created_at')
            ->where('product_id', $productId)
                ->orderBy('created_at') // tracking the count values along with time
                ->get();

            if ($transactions->isEmpty()) {
                return RespondWithBadRequestData($lang, 2);
            }

            $data = ProductInventoryAction::getProductInventory($lang, $transactions,$productId); ;

            return ResponseWithSuccessData($lang, $data, 1);

        } catch (\Exception $e) {
            Log::error('Error fetching inventory: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
