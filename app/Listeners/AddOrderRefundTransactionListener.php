<?php

namespace App\Listeners;

use App\Events\OrderRefundTransactionEvent;
use App\Events\ProductTransactionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Addon;
use App\Models\Recipe;
use App\Models\RecipeAddon;
use App\Models\StoreTransaction;
use App\Models\StoreTransactionDetails;
use App\Models\ProductTransaction;
use App\Models\Store;
use App\Models\Product;
use Auth;

class AddOrderRefundTransactionListener
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
    public function handle(OrderRefundTransactionEvent $event): void
    {
        $order_details = $event->order_details;
        $total_price = 0;
        $price = 0;
        $user_id = Auth::guard('api')->user()->id;

        $details_order = OrderDetail::with('order', 'recipe')->where('id', $order_details->id)->first();
        $store = Store::with('branch')->where('branch_id', $details_order->order->branch_id)->where('is_kitchen', 1)->first();
        
        if($details_order){
            $add_store_bill = new StoreTransaction();
            $add_store_bill->type = 2;
            $add_store_bill->to_type = 1;
            $add_store_bill->to_id = $store->id;
            $add_store_bill->date = $details_order->order->date;
            $add_store_bill->total = 1;
            $add_store_bill->store_id = $store->id;
            $add_store_bill->user_id = $details_order->order->client_id;
            $add_store_bill->created_by = $details_order->order->created_by;
            $add_store_bill->total_price = $total_price;
            $add_store_bill->save();
            $store_transaction_id = $add_store_bill->id;

            if($order_details->recipe_id != null){
                //if order is recipe
                $recipe_details_ingredients = Recipe::with('ingredients')->where('id', $order_details->recipe_id)->first();
                if($recipe_details_ingredients->ingredients){
                    foreach($recipe_details_ingredients->ingredients as $recipe_details_ingredient){

                        $add_store_items = new StoreTransactionDetails();
                        $add_store_items->store_transaction_id = $store_transaction_id;
                        $add_store_items->product_id = $recipe_details_ingredient->product_id;
                        $add_store_items->product_unit_id = $recipe_details_ingredient->product_unit_id ;
                        $add_store_items->country_id = $store->branch->country_id;
                        $add_store_items->count = ($recipe_details_ingredient->quantity * $order_details->quantity);
                        $add_store_items->price = $price;
                        $add_store_items->total_price = $total_price;
                        $add_store_items->save();
                        $add_store_items->type = 1;
                        $add_store_items->to_type = 2;
                        $add_store_items->user_id = $order->client_id;
                        $add_store_items->store_id = $store->id;
                        $add_store_items->expired_date = "";
    
                        event(new ProductTransactionEvent($add_store_items));
                    }
                }
                //end of if order is recipe
            }else{

                //if order is product
                $add_store_items = new StoreTransactionDetails();
                $add_store_items->store_transaction_id = $store_transaction_id;
                $add_store_items->product_id = $order_details->product_id;
                $add_store_items->product_unit_id = $order_details->unit_id;
                $add_store_items->country_id = $store->branch->country_id;
                $add_store_items->count = $order_details->quantity;
                $add_store_items->price = $price;
                $add_store_items->total_price = $total_price;
                $add_store_items->save();
                $add_store_items->type = 1;
                $add_store_items->to_type = 2;
                $add_store_items->user_id = $order->client_id;
                $add_store_items->store_id = $store->id;
                $add_store_items->expired_date = "";

                event(new ProductTransactionEvent($add_store_items));
                //end if order is poduct
            }   
            

            if(count($order->orderAddons) > 0){
                foreach($order->orderAddons as $addons_details){

                    $recipe_addons_details = RecipeAddon::findOrFail($addons_details->recipe_addon_id);

                    $add_store_items = new StoreTransactionDetails();
                    $add_store_items->store_transaction_id = $store_transaction_id;
                    $add_store_items->product_id = $recipe_addons_details->product_id;
                    $add_store_items->product_unit_id = $recipe_addons_details->product_unit_id;
                    $add_store_items->country_id = $store->branch->country_id;
                    $add_store_items->count = ($recipe_addons_details->quantity * $addons_details->quantity);
                    $add_store_items->price = $price;
                    $add_store_items->total_price = $total_price;
                    $add_store_items->save();
                    $add_store_items->type = 1;
                    $add_store_items->to_type = 2;
                    $add_store_items->user_id = $order->client_id;
                    $add_store_items->store_id = $store->id;
                    $add_store_items->expired_date = "";
                    event(new ProductTransactionEvent($add_store_items));
                }
            }
        }
    }
}