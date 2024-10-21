<?php

namespace App\Traits;

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

use Illuminate\Support\Facades\DB;
use App\Events\ProductTransactionEvent;

//use DB;
use Illuminate\Support\Facades\Auth;

trait StoreTransactionTrait
{
    /*public function add_item_tostore($data=array()) { //order_type -> 1 add order, 2 add purchase, 3 refund order, 4 refund purchase
        switch($order_type)
        {
            case 1:
                $this->add_order_to_store($order_id, $order_type); 
                break;
            case 2:
                $this->add_purchase_to_store($order_id, $order_type); 
                break;
            case 3:
                $this->refund_order_to_store($order_id, $order_type); 
                break;
            default:
            $this->refund_purchase_to_store($order_id, $order_type); 

        }      
    } */

    public function handel_order_to_store($order_id)
    {
        $total_price = 0;
        $price = 0;
        $user_id = Auth::guard('api')->user()->id;

        $order = Order::with('orderDetails', 'orderAddons')->where('id', $order_id)->first();
        $store = Store::with('branch')->where('branch_id', $order->branch_id)->where('is_kitchen', 1)->first();

        $order_array = [];
        $products = [];

        /*
        {
            "product_id":1,
            "product_unit_id":1,
            "product_size_id":"",
            "product_color_id":"",
            "country_id":1,
            "count":10,
            "expired_date":"2024-10-24"
        }*/

        if ($order) {
            $order_array['type'] = 1;
            $order_array['to_type'] = 2;
            $order_array['to_id'] = $order->client_id;
            $order_array['date'] = $order->date;
            $order_array['store_id'] = $store->id;
            $order_array['user_id'] = $order->created_by;
            $order_array['created_by'] = $order->created_by;


            if($order->orderDetails){
                foreach($order->orderDetails as $order_details){
                    //return $order_details->dishes->recipes->recipe->ingredients;
                    if($order_details->dishes){
                        if($order_details->dishes->recipes){
                            foreach($order_details->dishes->recipes as $recipe_details)
                            {
                                if($recipe_details->recipe->ingredients){
                                    foreach($recipe_details->recipe->ingredients as $ingredients){
                                        $products = array(
                                            "product_id" => $ingredients->product_id,
                                            "product_unit_id" => $ingredients->product_id,
                                            "product_size_id" => "",
                                            "product_color_id" => "",
                                            "country_id" => 1,
                                            "count" => $ingredients->product_id,
                                            "expired_date" => ""
                                        );
                                    }
                                }
                            }
                            /*if($order_details->dish_id != null){
                                //iuf order is recipe
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
                                        $add_store_items->order_id = $order->id;
                                        $add_store_items->order_details_id = $order_details->id;
                                        $add_store_items->order_addon_id = "";
            
                                    }
                                }
                                //end of order is recipe
                            }*/
                        }
                    }
                    
                }
            }
            
                /* else{

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
                    $add_store_items->order_id = $order->id;
                    $add_store_items->order_details_id = $order_details->id;
                    $add_store_items->order_addon_id = "";

                    event(new ProductTransactionEvent($add_store_items));
                    //end if order is poduct
                }   
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
                    $add_store_items->order_id = $order->id;
                    $add_store_items->order_details_id = "";
                    $add_store_items->order_addon_id = $addons_details->id;

                    event(new ProductTransactionEvent($add_store_items));
                }
            }*/
        }


        /*{
            "type":1,
            "to_type":1,
            "to_id":2,
            "date":"2024-09-26",
            "store_id":2,
            "products":[
                {
                    "product_id":1,
                    "product_unit_id":1,
                    "product_size_id":"",
                    "product_color_id":"",
                    "country_id":1,
                    "count":10,
                    "expired_date":"2024-10-24"
                },
                {
                    "product_id":2,
                    "product_unit_id":2,
                    "product_size_id":"",
                    "product_color_id":"",
                    "country_id":1,
                    "count":1,
                    "expired_date":"2024-10-24"
                },
                {
                    "product_id":3,
                    "product_unit_id":3,
                    "product_size_id":"",
                    "product_color_id":"",
                    "country_id":1,
                    "count":1,
                    "expired_date":"2024-10-24"
                } 
            ]
        }*/

        return $order_array;
    }

    public function add_item_to_store($data = array()) {}

    public function refund_order_to_store($order_id, $order_type) {}

    public function refund_purchase_to_store($order_id, $order_type) {}
}
