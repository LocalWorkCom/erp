<?php

namespace App\Listeners;

use App\Events\ProductTransactionEvent;
use App\Models\Notification;
use App\Models\Product;
use App\Models\ProductLimit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\ProductTransaction;
use App\Models\User;

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
        if ($product->type == 1) {
            $all_product_transactions = ProductTransaction::with('products.productUnites')->where('product_id', $product->product_id)->where('store_id', $product->store_id)->where('count', '>', 0)->whereDate('expired_date', '>=', $today)->get();
            if ($all_product_transactions) {

                foreach ($all_product_transactions as $all_product_transaction) {
                    $now_product_count = $all_product_transaction->count - ($product_count * $all_product_transaction->products->productUnites->factor);

                    if ($now_product_count <= 0) {
                        $product_transaction_count = 0;
                    } else {
                        $product_transaction_count = $now_product_count;
                    }

                    if ($now_product_count < 0) {
                        $product_count = ($product_count * $all_product_transaction->products->productUnites->factor) - $all_product_transaction->count;
                        $product_count = $product_count / $all_product_transaction->products->productUnites->factor;
                    }

                    $update_product_transaction = ProductTransaction::find($all_product_transaction->id);
                    $update_product_transaction->count = $product_transaction_count;
                    $update_product_transaction->modified_by = $product->user_id;
                    $update_product_transaction->save();

                    if ($now_product_count >= 0) {
                        $this->checkProductStock($product->product_id, $product->user_id);
                        break;
                    }
                }
            }

            //end of $type == 1
        } else { //if $type == 2
            $update_product_transaction = ProductTransaction::with('products.productUnites')->where('product_id', $product->product_id)->where('store_id', $product->store_id)->whereDate('expired_date', date($product->expired_date))->first();
            if ($update_product_transaction) {
                $now_product_count = $update_product_transaction->count + ($product_count * $update_product_transaction->products->productUnites->factor);
                $update_product_transaction->count = $now_product_count;
                $update_product_transaction->modified_by = $product->user_id;
                $update_product_transaction->save();
                $this->checkProductStock($product->product_id, $product->user_id);
            } else {
                $show_product = Product::with('productUnites')->where('product_id', $product->product_id)->first();
                $add_product_transaction = new ProductTransaction();
                $add_product_transaction->product_id = $product->product_id;
                $add_product_transaction->store_id = $product->store_id;
                $add_product_transaction->count = ($product_count * $show_product->productUnites->factor);
                $add_product_transaction->expired_date = $product->expired_date;
                $add_product_transaction->created_by = $product->user_id;
                $add_product_transaction->save();
                $this->checkProductStock($product->product_id, $product->user_id);
            }
        }
        //end of $type == 2

    }

    private function checkProductStock($productId, $userId)
    {
        $currentStock = ProductTransaction::where('product_id', $productId)->sum('count');
        $productLimit = ProductLimit::where('product_id', $productId)->first();

        // If current stock is less than min_limit, send a notification
        if ($productLimit && $currentStock < $productLimit->min_limit) {

            $product = Product::find($productId);
            $users = User::where('flag', 0)->get();

            foreach ($users as $user) {

                Notification::create([
                    'title_ar' => 'المنتج أقل من الكمية المحددة',
                    'title_en' => 'Product Below Minimum Limit',
                    'type' => 'stock_alert',
                    'description_ar' => "الكمية المتاحة للمنتج {$product->name_ar} أقل من الحد الأدنى المطلوب.",
                    'description_en' => "The available quantity of product {$product->name_en} is below the required minimum limit.",
                    'status' => 0, // Unread
                    'user_id' => $user->id,
                    'created_by' => $userId, // The user who triggered this event
                    'product_id' => $productId,
                    'date_time' => now(),
                ]);
            }
        }
    }
}