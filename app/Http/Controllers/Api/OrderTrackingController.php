<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderTracking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Events\OrderTransactionEvent;

class OrderTrackingController extends Controller
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
        $order_id = $request->order_id;
        $order_trackings = OrderTracking::where('order_id', $order_id)->get();
        return ResponseWithSuccessData($lang, $order_trackings, 1);
    }
    public function store(Request $request)
    {
        $lang = $request->header('lang', 'ar');  // Default to 'ar' if not provided
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
            'order_id' => 'required|exists:orders,id', // Ensure order_id exists in the 'orders' table
            'order_status' => 'required|string|in:pending,in_progress,completed,canceled', // Order status must be one of the specified values
        ]);
    
        // Check for validation errors
        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }
    
        // Extract validated fields
        $order_id = $request->order_id;
        $order_status = $request->order_status;
    
        // Create a new OrderTracking entry
        $order_tracking = new OrderTracking();
        $order_tracking->order_id = $order_id;
        $order_tracking->order_status = $order_status;
        $order_tracking->created_by = $created_by;
        $order_tracking->save();
    
        // Trigger event if the order status is in_progress
        if ($order_status === 'in_progress') {
            event(new OrderTransactionEvent($order_tracking));
        }
    
        // Update the order status to 'completed' if applicable
        if ($order_status === 'completed') {
            $order = Order::find($order_id);
            if ($order) {
                $order->status = 'completed';
                $order->save();
            }
        }
    
        return RespondWithSuccessRequest($lang, 1);
    }
    
}
