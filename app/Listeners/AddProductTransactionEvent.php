<?php

namespace App\Listeners;

use App\Events\ProductTransactionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\ProductTransaction;

class AddProductTransactionEvent
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductTransactionEvent $event): void
    {
        $product = $event->product;
        $today = date('Y-m-d');
        $now_product_count = 0;
        $product_count = $product->count;
        //$type == 1
        if($product->type == 1){
            $all_product_transactions = ProductTransaction::where('product_id', $product->product_id)->where('store_id', $product->store_id)->where('count', '>', 0)->whereDate('expired_date','>=',$today)->get();
            if($all_product_transactions){

                foreach($all_product_transactions as $all_product_transaction)
                {
                    $now_product_count = $all_product_transaction->count - $product_count;

                    if($now_product_count <= 0){
                        $product_transaction_count = 0;
                    }else{
                        $product_transaction_count = $now_product_count;
                    }

                    if($now_product_count < 0){
                        $product_count = $product_count - $all_product_transaction->count;
                    }

                    $update_product_transaction = ProductTransaction::find($all_product_transaction->id);
                    $update_product_transaction->count = $product_transaction_count;
                    $update_product_transaction->modified_by = $product->user_id;
                    $update_product_transaction->save();

                    if ($now_product_count >= 0){
                        break;
                    }

                }
            }

        //end of $type == 1
        }else{//if $type == 2
            $update_product_transaction = ProductTransaction::where('product_id', $product->product_id)->where('store_id', $product->store_id)->whereDate('expired_date',date($product->expired_date))->first();
            if($update_product_transaction){
                $now_product_count = $update_product_transaction->count + $product_count;
                $update_product_transaction->count = $now_product_count;
                $update_product_transaction->modified_by = $product->user_id;
                $update_product_transaction->save();
            }else{
                $add_product_transaction = new ProductTransaction();
                $add_product_transaction->product_id = $product->product_id;
                $add_product_transaction->store_id = $product->store_id;
                $add_product_transaction->count = $product_count;
                $add_product_transaction->expired_date = $product->expired_date;
                $add_product_transaction->created_by = $product->user_id;
                $add_product_transaction->save();
            }
        }
        //end of $type == 2

    }

}
