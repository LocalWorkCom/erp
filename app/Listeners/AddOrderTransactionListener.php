<?php

namespace App\Listeners;

use App\Events\OrderTransactionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Addon;
use App\Models\Recipe;
use App\Models\RecipeAddon;
use App\Models\StoreTransaction;
use App\Models\StoreTransactionDetails;
use App\Models\ProductTransaction;
use App\Models\Store;
use Auth;

class AddOrderTransactionListener
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
    public function handle(OrderTransactionEvent $event): void
    {
        $tracking_order = $event->order_tracking;
        $total_price = 0;
        $price = 0;
        $user_id = Auth::guard('api')->user()->id;

        $order = Order::with('orderDetails', 'orderAddons')->where('id', $tracking_order->order_id)->first();
        $store = Store::with('branch')->where('branch_id', $order->branch_id)->where('is_kitchen', 1)->first();
        if($order){
                $add_store_bill = new StoreTransaction();
                $add_store_bill->type = 1;
                $add_store_bill->to_type = 2;
                $add_store_bill->to_id = $order->client_id;
                $add_store_bill->date = $order->date;
                $add_store_bill->total = $order->orderDetails->count();
                $add_store_bill->store_id = $store->id;
                $add_store_bill->user_id = $order->client_id;
                $add_store_bill->created_by = $order->created_by;
                $add_store_bill->total_price = $total_price;
                $add_store_bill->save();
                $store_transaction_id = $add_store_bill->id;

            foreach($order->orderDetails as $order_details){
                $recipe_details = Recipe::with('ingredients')->where('id', $order_details->recipe_id)->first();

                $add_store_items = new StoreTransactionDetails();
                $add_store_items->store_transaction_id = $store_transaction_id;
                $add_store_items->product_id = $order_details->product_id;
                $add_store_items->product_unit_id = $order_details->unit_id;
                $add_store_items->product_size_id = "";
                $add_store_items->product_color_id = "";
                $add_store_items->country_id = $store->branch->country_id;
                $add_store_items->count = $recipe_details->ingredients->quantity;
                $add_store_items->price = $price;
                $add_store_items->total_price = $total_price;
                $add_store_items->save();
                $add_store_items->type = 1;
                $add_store_items->to_type = 2;
                $add_store_items->user_id = $order->client_id;
                $add_store_items->store_id = $store->id;
                $add_store_items->expired_date = "";

                event(new OrderTransactionEvent($add_store_items));

                if(count($order_details->orderAddons) > 0){
                    foreach($order_details->orderAddons as $addons_details){

                        $recipe_addons_details = RecipeAddon::findOrFail($addons_details->recipe_addon_id);

                        $add_store_items = new StoreTransactionDetails();
                        $add_store_items->store_transaction_id = $store_transaction_id;
                        $add_store_items->product_id = $recipe_addons_details->product_id;
                        $add_store_items->product_unit_id = $recipe_addons_details->unit_id;
                        $add_store_items->product_size_id = "";
                        $add_store_items->product_color_id = "";
                        $add_store_items->country_id = $store->branch->country_id;
                        $add_store_items->count = $recipe_addons_details->quantity;
                        $add_store_items->price = $price;
                        $add_store_items->total_price = $total_price;
                        $add_store_items->save();
                        $add_store_items->type = 1;
                        $add_store_items->to_type = 2;
                        $add_store_items->user_id = $order->client_id;
                        $add_store_items->store_id = $store->id;
                        $add_store_items->expired_date = "";
                        event(new OrderTransactionEvent($add_store_items));
                    }
                }
            }
        }

    }
}
