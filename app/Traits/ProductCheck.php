<?php

namespace App\Traits;
use App\Models\StoreTransaction;
use App\Models\StoreTransactionDetails;
use App\Models\Product;
use App\Models\ProductTransaction;

trait ProductCheck
{
    /*public function check_expirt($transaction_products, $type, $to_type) {
        $today = date('Y-m-d');
        $all_product_not_expirt = [];
        $xx = [];
        foreach($transaction_products as $check_product)
        {
            //check if outgoing and product is expirt date
            if($type == 1)
            {
                if($to_type == 2 || $to_type == 4)
                {
                    $product_details = ProductTransaction::where('product_id', $check_product['product_id'])->whereDate('expired_date','>=',$today)->get()->pluck('product_id')->toArray();
                    $xx = array_merge($all_product_not_expirt,$product_details);
                }
            }
        }

        return $xx;
    }*/

    public function check_expirt($transaction_products, $type, $store_id) {
        $today = date('Y-m-d');
        $all_product_not_expirt = 0;
        foreach($transaction_products as $check_product)
        {
            //check if outgoing and product is expirt date
            if($type == 1)
            {
                $product_details = ProductTransaction::where('product_id', $check_product['product_id'])->where('store_id', $store_id)->whereDate('expired_date','>=',$today)->get();
                if(count($product_details < 0))
                {
                    $all_product_not_expirt = 1;
                }
                if($all_product_not_expirt == 0){
                    return $all_product_not_expirt;
                }
            }
        }
    }

    public function product_enough($transaction_products, $type, $to_type) {
        $today = date('Y-m-d');
        foreach($transaction_products as $check_product)
        {
            //check if outgoing and product is expirt date
            if($type == 1)
            {
                if($to_type == 2 || $to_type == 4)
                {
                    return $product_details = ProductTransaction::where('product_id', $check_product['product_id'])->whereDate('expired_date','>=',$today)->get();
                }

            }

        }
    }

}
