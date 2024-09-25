<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\StoreTransaction;
use App\Models\StoreTransactionDetails;
use App\Models\ProductTransaction;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\ProductCheck;
use DB;
use App\Events\ProductTransactionEvent;
use Illuminate\Support\Facades\Validator;
use Auth;

class StoreTransactionController extends Controller
{
    use ProductCheck;
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request)
    {
        try{
            $lang =  $request->header('lang', 'en');
            $stores = StoreTransaction::with(['allStoreTransactionDetails', 'allStoreTransactionDetails.products', 'allStoreTransactionDetails.products.unites', 'allStoreTransactionDetails.products.colors', 'allStoreTransactionDetails.products.sizes'])->get();
            return ResponseWithSuccessData($lang, $stores, 1);
        }catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try{
            $lang =  $request->header('lang', 'en');
            $stores = StoreTransaction::with(['allStoreTransactionDetails', 'allStoreTransactionDetails.products'])->findOrFail($id);
            return ResponseWithSuccessData($lang, $stores, 1);
        }catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        //try{
            $lang =  $request->header('lang', 'en');

            $validateData = Validator::make($request->all(), [
                'products' => 'required|array',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.product_unit_id' => 'required|integer|exists:product_units,id',
                'products.*.product_size_id' => 'nullable|integer|exists:product_sizes,id',
                'products.*.product_color_id' => 'nullable|inyeger|exists:product_colors,id',
                'products.*.country_id' => 'required|integer|exists:countries,id',
                'products.*.count' => 'required|integer|min:1',
                'products.*.expired_date' => 'required|date'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $price = 0;
            $total_price = 0;
            $user_id = Auth::guard('api')->user()->id;

            //product is not in this store
            /*$transaction_check_instore = $this->check_product_instore($request['products'], $request['store_id']);
            if($transaction_check_instore == 0){
                return RespondWithBadRequestWithData( __('validation.product_not_instore'));
            }*/

            //in outgoing return products is expirt date
            /*$transaction_check_expirt = $this->check_expirt($request['products'], $request['type'], $request['store_id']);
            if($transaction_check_expirt == 0){
                return RespondWithBadRequestWithData( __('validation.product_expired'));
            }*/

            //in outgoing return products is not enough
            /*$transaction_check_one_enough = $this->check_not_enough($request['products'], $request['type'], $request['store_id']);
            if($transaction_check_one_enough == 0){
                return RespondWithBadRequestWithData( __('validation.product_not_enough'));
            }*/

            $add_store_bill = new StoreTransaction();
            $add_store_bill->type = $request['type'];
            $add_store_bill->to_type = $request['to_type'];
            $add_store_bill->to_id = $request['to_id'];
            $add_store_bill->date = $request['date'];
            $add_store_bill->total = count($request['products']);
            $add_store_bill->store_id = $request['store_id'];
            $add_store_bill->user_id = $user_id;
            $add_store_bill->created_by = $user_id;
            $add_store_bill->total_price = $total_price;
            $add_store_bill->save();

            $store_transaction_id = $add_store_bill->id;

            foreach($request['products'] as $product)
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
                $add_store_items->store_id = $request['store_id'];
                $add_store_items->expired_date = $product['expired_date'];

                event(new ProductTransactionEvent($add_store_items));
            }

            $stores = $add_store_bill;
            return ResponseWithSuccessData($lang, $stores, 1);
        /*}catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }*/
    }
}
