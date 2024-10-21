<?php

namespace App\Actions;

class ProductInventoryAction
{
    public static function getProductInventory($lang,$transactions,$productId)
    {

        $product = $transactions->first()->products;
        $productName = $lang === 'en' ? $product->name_en : $product->name_ar;

        $incomingTotal = 0;
        $outgoingTotal = 0;
        $previousCount = 0;

        $incomingTransactions = [];
        $outgoingTransactions = [];

        foreach ($transactions as $transaction) {
            $currentCount = $transaction->count;
            $date = $transaction->created_at;

            if ($previousCount < $currentCount) {
                $incomingAmount = $currentCount - $previousCount;
                $incomingTotal += $incomingAmount;
                $incomingTransactions[] = [
                    'amount' => $incomingAmount,
                    'date' => $date
                ];
            } elseif ($previousCount > $currentCount) {
                $outgoingAmount = $previousCount - $currentCount;
                $outgoingTotal += $outgoingAmount;
                $outgoingTransactions[] = [
                    'amount' => $outgoingAmount,
                    'date' => $date
                ];
            }
            $previousCount = $currentCount;
        }

        $balance = $incomingTotal - $outgoingTotal;

        // data returned
        $inventoryData = [
            'product_id' => $productId,
            'product_name' => $productName,
            'incoming' => [
                'total' => $incomingTotal,
                'transactions' => $incomingTransactions,
            ],
            'outgoing' => [
                'total' => $outgoingTotal,
                'transactions' => $outgoingTransactions,
            ],
            'balance' => $balance,
        ];
        return $inventoryData;
    }

}
