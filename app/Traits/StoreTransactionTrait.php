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
use App\Models\OrderRefund;
use App\Models\Dish;
use App\Models\OrderProduct;
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

        if ($order) {
            
            //recipes
            if($order->orderDetails){
                foreach($order->orderDetails as $order_details){
                    //return $order_details->dishes->recipes->recipe->ingredients;
                    if($order_details->dishes){
                        if($order_details->dishes->recipes){
                            foreach($order_details->dishes->recipes as $recipe_details)
                            {
                                if($recipe_details->recipe->ingredients){
                                    foreach($recipe_details->recipe->ingredients as $ingredients){
                                        $product = array(
                                            "product_id" => $ingredients->product_id,
                                            "product_unit_id" => $ingredients->product_unit_id,
                                            "product_size_id" => "",
                                            "product_color_id" => "",
                                            "country_id" => $ingredients->product->currency_code,
                                            "count" => $ingredients->quantity,
                                            "expired_date" => ""
                                        );
                                        array_push($products, $product);
                                    }
                                }
                            }
                        }
                    }
                    
                }
            }
            
            //products
            if($order->orderProducts){
                foreach($order->orderProducts as $order_products){
                    $product = array(
                        "product_id" => $order_products->product_id,
                        //"product_unit_id" => $order_products->product_unit_id,
                        "product_unit_id" => $order_products->unit_id,
                        "product_size_id" => "",
                        "product_color_id" => "",
                        "country_id" => $order_products->products->currency_code,
                        "count" => $order_products->quantity,
                        "expired_date" => ""
                    );
                    array_push($products, $product);  
                }
            }

            //addons
            if($order->orderAddons){
                foreach($order->orderAddons as $order_addons){
                    //return $order_details->dishes->recipes->recipe->ingredients;
                    if($order_addons->Addon){
                        if($order_addons->Addon->addon){
                            if($order_addons->Addon->addon->ingredients){
                                foreach($order_addons->Addon->addon->ingredients as $ingredients){
                                    $product = array(
                                        "product_id" => $ingredients->product_id,
                                        "product_unit_id" => $ingredients->product_unit_id,
                                        "product_size_id" => "",
                                        "product_color_id" => "",
                                        "country_id" => $ingredients->product->currency_code,
                                        "count" => $ingredients->quantity,
                                        "expired_date" => ""
                                    );
                                    array_push($products, $product);
                                }                                
                            }
                        }
                    }
                }
            }


            $order_array['type'] = 1;
            $order_array['to_type'] = 2;
            $order_array['to_id'] = $order->client_id;
            $order_array['date'] = $order->date;
            $order_array['store_id'] = $store->id;
            $order_array['user_id'] = $order->created_by;
            $order_array['created_by'] = $order->created_by;
            $order_array['products'] = $products;
            
        }
<<<<<<< HEAD
=======


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

>>>>>>> d9a618c90e8da382d54a04205905c42b074671fb
        return $order_array;
    }

    public function refund_order_to_store($order_id) {
        $total_price = 0;
        $price = 0;
        $user_id = Auth::guard('api')->user()->id;

        $order_refunds = OrderRefund::where('order_id', $order_id)->get();
        $order_array = [];
        $products = [];

        if ($order_refunds) {
            foreach($order_refunds as $order){
                $store = Store::with('branch')->where('branch_id', $order->orders->branch_id)->where('is_kitchen', 1)->first();
            
                //dish
                if($order->item_type == "dish"){
                    $order_quantity = $order->quantity;
                    $order_dish = Dish::with('recipes')->where('id', $order->item_id)->first();
                    if($order_dish){
                        if($order_dish->recipes){
                            foreach($order_dish->recipes as $recipe_details)
                            {
                                $recipe_quantity = $recipe_details->quantity * $order_quantity;
                                if($recipe_details->recipe->ingredients){
                                    foreach($recipe_details->recipe->ingredients as $ingredients){
                                        $product = array(
                                            "product_id" => $ingredients->product_id,
                                            "product_unit_id" => $ingredients->product_unit_id,
                                            "product_size_id" => "",
                                            "product_color_id" => "",
                                            "country_id" => $ingredients->product->currency_code,
                                            "count" => $ingredients->quantity * $recipe_quantity,
                                            "expired_date" => ""
                                        );
                                        array_push($products, $product);
                                    }
                                }
                            }
                        }
                    }
                }
                
                //products
                if($order->item_type == "product"){
                    $order_quantity = $order->quantity;
                    $order_product = OrderProduct::where('id', $order->item_id)->first();
                    $product = array(
                        "product_id" => $order_product->product_id,
                        //"product_unit_id" => $order_product->product_unit_id,
                        "product_unit_id" => $order_product->unit_id,
                        "product_size_id" => "",
                        "product_color_id" => "",
                        "country_id" => $order_product->products->currency_code,
                        "count" => $order_quantity,
                        "expired_date" => ""
                    );
                    array_push($products, $product); 
                }

                //addons
                if($order->item_type == "addon"){
                    $order_quantity = $order->quantity;
                    $order_addon = Recipe::with('ingredients')->where('id', $order->item_id)->first();
                    if($order_addon){
                        if($order_addon->ingredients){
                            foreach($order_addon->ingredients as $ingredients)
                            {
                                $product = array(
                                    "product_id" => $ingredients->product_id,
                                    "product_unit_id" => $ingredients->product_unit_id,
                                    "product_size_id" => "",
                                    "product_color_id" => "",
                                    "country_id" => $ingredients->product->currency_code,
                                    "count" => $ingredients->quantity * $order_quantity,
                                    "expired_date" => ""
                                );
                                array_push($products, $product);                       
                            }
                        }
                    }
                }
            }
            


            $order_array['type'] = 2;
            $order_array['to_type'] = 1;
            $order_array['to_id'] = $order->client_id;
            $order_array['date'] = $order->date;
            $order_array['store_id'] = $store->id;
            $order_array['user_id'] = $order->created_by;
            $order_array['created_by'] = $order->created_by;
            $order_array['products'] = $products;
            
        }

        return $order_array;
    }
    
    public function add_item_to_store($data = array()) {
        $price = 0;
        $total_price = 0;
        $user_id = Auth::guard('api')->user()->id;

        $add_store_bill = new StoreTransaction();
        $add_store_bill->type = $data['type'];
        $add_store_bill->to_type = $data['to_type'];
        $add_store_bill->to_id = $data['to_id'];
        $add_store_bill->date = $data['date'];
        $add_store_bill->total = count($data['products']);
        $add_store_bill->store_id = $data['store_id'];
        $add_store_bill->user_id = $data['user_id'];
        $add_store_bill->created_by = $data['created_by'];
        $add_store_bill->total_price = $total_price;
        $add_store_bill->save();

        $store_transaction_id = $add_store_bill->id;

        foreach($data['products'] as $product)
        {

            $add_store_items = new StoreTransactionDetails();
            $add_store_items->store_transaction_id = $store_transaction_id;
            $add_store_items->product_id = $product['product_id'];
            $add_store_items->product_unit_id = $product['product_unit_id'];
            $add_store_items->product_size_id = $product['product_size_id'];
            $add_store_items->product_color_id = $product['product_color_id'];
            $add_store_items->country_id = $product['country_id'];
            $add_store_items->count = $product['count'];
            $add_store_items->price = $price;
            $add_store_items->total_price = $total_price;
            $add_store_items->save();
            $add_store_items->type = $add_store_bill->type;
            $add_store_items->to_type = $add_store_bill->to_type;
            $add_store_items->user_id = $add_store_bill->user_id;
            $add_store_items->store_id = $data['store_id'];
            $add_store_items->expired_date = $product['expired_date'];
            $add_store_items->order_id = "";
            $add_store_items->order_details_id = "";
            $add_store_items->order_addon_id = "";

            event(new ProductTransactionEvent($add_store_items));
        }

        return $data;

    }

}
