<?php

namespace App\Traits;

use App\Models\StoreTransaction;
use App\Models\StoreTransactionDetails;
use App\Models\Product;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use App\Events\ProductTransactionEvent;

// use DB;

trait StoreTransactionTrait
{
    public function add_item_tostore($order_id, $order_type) { //order_type -> 1 add order, 2 add purchase, 3 refund order, 4 refund purchase
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
    } 

    public function add_order_to_store($order_id, $order_type)
    {

    }

    public function add_purchase_to_store($order_id, $order_type)
    {

    }

    public function refund_order_to_store($order_id, $order_type)
    {

    }

    public function refund_purchase_to_store($order_id, $order_type)
    {

    }
}
