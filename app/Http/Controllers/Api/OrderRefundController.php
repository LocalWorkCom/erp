<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderRefund;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Events\OrderRefundTransactionEvent;

use App\Models\Store;

class OrderRefundController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request)
    {

        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        $orderRefunds = OrderRefund::all();
        foreach ($orderRefunds as $orderRefund) {
            # code...
            $orderRefund['details'] = OrderDetail::with('Order')->find($orderRefund->order_detail_id);
            // dd($orderRefund);
        }
        return ResponseWithSuccessData($lang, $orderRefunds, 1);
    }
    public function store(Request $request)
    {

        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        if (Auth::guard('api')->user()->flag == 0) {
            return RespondWithBadRequest($lang, 5);
        } else {
            $created_by = Auth::guard('api')->user()->id;
        }
        // Validation
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:255', // Ensure reason is provided, a string, and not too long
            'order_detail_id' => 'required|exists:order_details,id', // Ensure the order detail ID exists in the 'order_details' table
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        $orderRefund = new OrderRefund();
        $orderRefund->date = date('Y-m-d');
        $orderRefund->reason = $request->reason;
        $orderRefund->order_detail_id = $request->order_detail_id;
        $orderRefund->created_by = $created_by;
        $orderRefund->invoice_number = "INV-" . GetNextID("order_refunds") . "-" . rand(1111, 9999); // Generate a new number if it exists


        $orderRefund->save();

        return RespondWithSuccessRequest($lang, 1);
    }
    public function change_status(Request $request)
    {
        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        App::setLocale($lang);

        /*if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        if (Auth::guard('api')->user()->flag == 0) {
            return RespondWithBadRequest($lang, 5);
        } else {
            $created_by = Auth::guard('api')->user()->id;
        }*/

        $created_by = Auth::guard('api')->user()->id;


        return $details_order = OrderDetail::with('Order', 'Recipe')->where('id', 1)->first();
        return $details_order->order;
        return $store = Store::with('branch')->where('branch_id', $details_order->Order->Branch->id)->where('is_kitchen', 1)->first();


        $order_refund_id = $request->order_refund_id;
        $orderRefund = OrderRefund::find($order_refund_id);
        $orderRefund->status = $request->status;
        $orderRefund->created_by = $created_by;

        $orderRefund->save();


        if ($orderRefund->status == 'accepted') {
            $order_details = OrderDetail::find($orderRefund->order_detail_id);
            $order_details->status = 'refund';
            $order_details->save();
            event(new OrderRefundTransactionEvent($order_details));
        }

        return RespondWithSuccessRequest($lang, 1);
    }
}
