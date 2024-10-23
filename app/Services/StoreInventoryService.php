<?php

namespace App\Services;

use App\Models\StoreTransaction;

class StoreInventoryService
{
    public static function getStoreInventory($lang, $transactions, $storeId)
    {
        $store= $transactions->first()->stores;
//        dd($store);
//        dd($transactions);
        $storeName = $lang == 'en' ? $store->name_en : $store->name_ar;
//        dd($storeName);
        $incomingTotal = 0;
        $outgoingTotal = 0;
        $inventoryDetails = [];

        foreach ($transactions as $transaction) {
            foreach ($transaction->allStoreTransactionDetails as $detail) {
                $product = $detail->products;
                if($transaction->type == 2) {
                    $incomingTotal += $detail->count;
                    $inventoryDetails[] = [
                        'productId' => $detail->product_id,
                        'productName' => $lang == 'en' ? $product->name_en : $product->name_ar,
                        'count' => $detail->count,
                        'price' => $detail->price,
                        'totalPrice' => $detail->total_price,
                        'date' => $transaction->date,
                    ];
                } else if ($transaction->type == 1) {
//                    dd($detail->count);
                    $outgoingTotal += $detail->count;
                    $inventoryDetails[] = [
                        'productId' => $detail->product_id,
                        'productName' => $lang == 'en' ? $product->name_en : $product->name_ar,
                        'count' => -$detail->count,
                        'price' => $detail->price,
                        'totalPrice' => -$detail->total_price,
                        'date' => $transaction->date,
                    ];
                }

            }
        }

        $currentBalance = $incomingTotal - $outgoingTotal;

        return [
            'storeId' => $storeId,
            'storeName' => $storeName,
            'incomingTotal' => $incomingTotal,
            'outgoingTotal' => $outgoingTotal,
            'currentBalance' => $currentBalance,
            'inventoryDetails' => $inventoryDetails,
        ];
    }
}
