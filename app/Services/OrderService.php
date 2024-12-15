<?php


namespace App\Services;

use App\Models\ClientAddress;
use App\Models\Dish;
use App\Models\DishAddon;
use App\Models\Gift;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderAddon;
use App\Models\OrderDetail;
use App\Models\OrderProduct;
use App\Models\OrderTracking;
use App\Models\OrderTransaction;
use App\Models\ProductUnit;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderService
{

    public function index(Request $request, $checkToken)
    {

        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $orders = Order::all();

        foreach ($orders as $order) {
            $order['details'] = OrderDetail::where('order_id', $order->id)->get();
            $order['addons'] = OrderAddon::where('order_id', $order->id)->get();
            $order['transaction'] = OrderTransaction::where('order_id', $order->id)->first();
            $order_tracking = OrderTracking::where('order_id', $order->id)->orderby('id', 'desc')->first();
            $order['last_status'] = $order_tracking->order_status;
            $order['next_status'] = $this->getNextStatus($order_tracking->order_status);
        }


        return ResponseWithSuccessData($lang, $orders, 1);
    }

    public function store(Request $request, $checkToken)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);
        if (Auth::guard('api')->user()->flag == 0) {
            return RespondWithBadRequest($lang, 5);
        } else {
            $UserType =  CheckUserType();
            $client_id = Auth::guard('api')->user()->id;
            if ($UserType != '') {
                $unknown_user = User::where('flag', $UserType)->first()->id;
                $client_id = ($UserType == 'admin') ? $unknown_user : Auth::guard('api')->user()->id;
            }
            $created_by = Auth::guard('api')->user()->id;
        }
        $discount = null;
        $total_price_befor_tax = 0;
        $total_addon_price_befor_tax = 0;
        $DataOrderDetails = $request->details;
        $DataAddons = $request->addons;
        $done = false;
        $DataProducts = $request->Products;

        //settings
        $tax_application = getSetting('tax_application');
        $tax_percentage = getSetting('tax_percentage');
        $coupon_application = getSetting('coupon_application');
        $service_fees = getSetting('service_fees');
        $redeem_total = 0;

        //validation
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:Takeaway,Online,InResturant,Delivery,CallCenter',  // Enforce enum-like values
            'note' => 'nullable|string', // Optional but must be a string
            'use_point' => 'nullable|integer', // Optional but must be a string
            'delivery_fees' => 'nullable|numeric', // Must be a number
            'table_id' => 'nullable|exists:tables,id', // Optional but must exist in the 'tables' table
            'branch_id' => 'required|exists:branches,id', // Optional but must exist in the 'discounts' table
            'coupon_code' => 'nullable|exists:coupons,code', // Optional but must exist in the 'coupons' table
            'details' => 'required|array', // Must be an array (contains order details)
            'details.*.quantity' => 'required|integer', // Every detail must have a quantity
            // 'details.*.total' => 'required|numeric', // Every detail must have a total
            'details.*.note' => 'nullable|string', // Optional note in details
            'details.*.coupon_code' => 'nullable|exists:coupons,code', // Optional coupon in details
            // 'details.*.product_id' => 'nullable|exists:products,id', // Product ID must exist in the 'products' table
            'details.*.dish_id' => 'nullable|exists:dishes,id', // Optional recipe ID
            // 'details.*.unit_id' => 'required|exists:units,id', // Unit ID must exist in the 'units' table
            'addons' => 'nullable|array', // Add-ons can be optional but must be an array if provided
            'addons.*.quantity' => 'required|integer', // Add-ons must have a quantity
            'addons.*.dish_addon_id' => 'required|exists:dish_addons,id', // Add-on recipe must exist
            // 'addons.*.price' => 'required|numeric', // Add-on price must be numeric
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Handle coupons
        $coupon = null;
        if (isset($request->coupon_code)) {
            $coupon = GetCouponId($request->coupon_code);
            if ($coupon && !CountCouponUsage($coupon->id)) {
                return RespondWithBadRequest($lang, 11);
            }
        }

        if (CheckDiscountValid()) {
            $discount = CheckDiscountValid();
        }
        $IDBranch = 0;
        $delivery_fees = 0;

        if ($UserType == 'admin') {
            $IDBranch = 1;
        } else {
            $user = Auth::guard('api')->user();
            $client_address = ClientAddress::where('user_id', $user->id)->where('is_default', 1)->first();
            if ($client_address) {
                $IDBranch = getNearestBranch($client_address->latitude, $client_address->longtitude)->id;
            } else {

                $IDBranch = 1;
            }
        }

        if ($request->type == 'Delivery' || $request->type == 'CallCenter' || $request->type == 'Online') {

            $delivery_fees = scopeNearest($IDBranch, $client_address->latitude, $client_address->longtitude)->price;
        }


        // this based on type of user >> if it not client 
        if ($request->type == 'Online') {
            $status = 'cart';
        } else if ($request->type == 'Delivery' || $request->type == 'CallCenter' || $request->type == 'InResturant') {

            $status = 'open';
        } else {
            $status = 'pending'; //takeaway
        }
        if (!CheckExistOrder($client_id)) {

            //order
            $Order = new Order();
            $Order->date = date('Y-m-d');
            $Order->time = date('H:i:s');
            $Order->type = $request->type;
            $Order->note = $request->note;
            $Order->delivery_fees = $delivery_fees;
            $Order->fees = $service_fees;
            $Order->table_id = $request->table_id ?? null;
            $Order->client_id = $client_id;
            $Order->discount_id = ($discount) ? $discount->id : null;
            $Order->branch_id = $IDBranch;
            $Order->coupon_id = ($coupon) ? $coupon->id : null;
            $Order->created_by = $created_by;
            $Order->order_number = "#" . rand(1111, 9999); // Generate a new number if it exists
            $Order->invoice_number = "INV-" . GetNextID("orders") . "-" . rand(1111, 9999); // Generate a new number if it exists
            $Order->save();
        } else {
            $Order = CheckExistOrder($client_id);
        }


        if ($DataOrderDetails->count()) {

            foreach ($DataOrderDetails as $DataOrderDetail) {
                $Dish = Menu::where('dish_id', $DataOrderDetail['dish_id'])->where('branch_id', $request->branch_id)->first();
                if ($Dish) {
                    $total = $Dish->price;
                }
                $OrderDetails = new OrderDetail();
                $OrderDetails->order_id = $Order->id;
                $OrderDetails->quantity = $DataOrderDetail['quantity'];
                $OrderDetails->total = $total;
                $OrderDetails->price_befor_tax = $tax_application == 1 ? applyTax($total, $tax_percentage, $tax_application) : $total;
                $OrderDetails->tax_value = CalculateTax($tax_percentage, $total);
                $OrderDetails->note = $DataOrderDetail['note'] ?? null;
                $OrderDetails->dish_id = $DataOrderDetail['dish_id'] ?? null;
                $OrderDetails->created_by = $created_by;
                $total_product_price_after_tax = $tax_application == 0 ? applyTax($total, $tax_percentage, $tax_application) * $DataOrderDetail['quantity'] : $total * $DataOrderDetail['quantity'];
                $OrderDetails->price_after_tax = $total_product_price_after_tax;
                $OrderDetails->save();
            }
        }

        if ($DataAddons->count()) {

            foreach ($DataAddons as $DataAddon) {
                $addon = DishAddon::with('addon')->where('dish_addons.id', $DataAddon['dish_addon_id'])->first();
                if ($addon) {
                    $price = $addon->recipe->price;

                    $OrderAddons = new OrderAddon();
                    $OrderAddons->order_id = $Order->id;
                    $OrderAddons->quantity = $DataAddon['quantity'];
                    $OrderAddons->dish_addon_id = $DataAddon['dish_addon_id'];
                    $OrderAddons->price_before_tax = $tax_application == 1 ? applyTax($price, $tax_percentage, $tax_application) : $price;
                    $price_after_tax = $tax_application == 0 ? applyTax($price, $tax_percentage, $tax_application) * $DataAddon['quantity'] : $price * $DataAddon['quantity'];
                    $OrderAddons->price_after_tax = $price_after_tax;
                    $OrderAddons->created_by = $created_by;
                    $OrderAddons->save();
                    // dd($price_after_tax);
                }
            }
        }
        $store_id = 0;
        if ($DataProducts->count()) {

            foreach ($DataProducts as $DataProduct) {

                $store = Store::where('branch_id', $IDBranch)->where('is_kitchen', 1)->first();
                if ($store) {
                    $store_id = $store->store_id;
                }
                $unit_id = ProductUnit::find($DataProduct['product_unit_id'])->unit_id;
                $OrderProducts = new OrderProduct();
                $OrderProducts->order_id = $Order->id;
                $OrderProducts->product_id = $DataProduct['product_id'];
                $OrderProducts->quantity = $DataProduct['quantity'];
                $OrderProducts->product_unit_id = $DataProduct['product_unit_id'];
                $OrderProducts->price = getProductPrice($DataProduct['product_id'], $store_id, $unit_id);
                $OrderProducts->created_by = $created_by;

                $OrderProducts->save();
            }
        }

        $total_addon_price_befor_tax = array_sum(
            array_map(
                function ($addon) {
                    $data = DishAddon::with('addon')->where('dish_addons.id', $addon['dish_addon_id'])->first();
                    return $data->recipe['price'] * $addon['quantity'];
                },
                $DataAddons
            )
        );
        // dd($total_addon_price_befor_tax);

        $total_price_befor_tax = $total_price_befor_tax2 = array_sum(
            array_map(
                function ($detail) {
                    $Dish = Dish::find($detail['dish_id']);

                    return $Dish['price'] * $detail['quantity'];
                },
                $DataOrderDetails
            )
        ) + $total_addon_price_befor_tax;

        if ($coupon && CheckCouponValid($coupon->id, $total_price_befor_tax)) {
            return RespondWithBadRequest($lang, 11);
        }

        if ($tax_application == 1) {
            $total_price_befor_tax = applyTax($total_price_befor_tax, $tax_percentage, $tax_application);
        }
        // Apply coupon before tax (if applicable)
        if ($coupon && $coupon_application == 0) {
            $total_price_befor_tax = applyCoupon($total_price_befor_tax, $coupon);
        }

        if ($discount) {
            $total_price_befor_tax = $total_price_befor_tax2 = applyDiscount($total_price_befor_tax, $discount);
        }


        // Apply tax (if applicable)
        // Apply coupon after tax (if applicable)
        if ($tax_application == 0) {
            $total_price_after_tax = applyTax(($coupon && $coupon_application == 0) ? $total_price_befor_tax : $total_price_befor_tax2, $tax_percentage, $tax_application);
        } else {
            $total_price_after_tax = $total_price_befor_tax2;
        }
        if ($coupon && $coupon_application == 1) {
            $total_price_after_tax = applyCoupon($total_price_after_tax, $coupon);
        }

        // use point call pointredeem function else point redeem=0   return point num and amount of redeem
        if ($request->use_points && $UserType == 'client' && isActive($Order->branch_id)) {
            $redeem_total =   calculateRedeemPoint($total_price_after_tax, $Order->branch_id, $Order->id, $client_id);
        }
        $Order->tax_value = CalculateTax($tax_percentage, $total_price_after_tax);
        $Order->total_price_befor_tax = $total_price_befor_tax;
        $Order->total_price_after_tax = ($total_price_after_tax + $service_fees) - $redeem_total;
        $Order->save();

        // add event order tracking
        $OrderTracking = new OrderTracking();
        $OrderTracking->order_id = $Order->id;
        $OrderTracking->created_by = $created_by;
        $OrderTracking->save();

        if ($status == 'pending' && $request->type == 'Takeaway') {
            $OrderTracking = new OrderTracking();
            $OrderTracking->order_id = $Order->id;
            $OrderTracking->created_by = $created_by;
            $OrderTracking->order_status = 'in_progress';
            $OrderTracking->save();
        }


        $transactionId = Str::uuid()->toString();
        $points_num = 0;
        if ($request->payment_method != 'cash') {
            $paid = $Order->total_price_after_tax; // we will get this value after payment get way

            $order_transaction = new OrderTransaction();
            $order_transaction->order_id = $Order->id;
            $order_transaction->order_type = 'order';
            $order_transaction->payment_method = $request->payment_method;
            $order_transaction->transaction_id = $transactionId;
            $order_transaction->paid = $paid;
            $order_transaction->date = date('Y-m-d');
            // $order_transaction->refund = $request->refund;
            $order_transaction->discount_id = ($discount) ? $discount->id : null;
            $order_transaction->coupon_id = $request->coupon_id;
            if ($paid >= $Order->total_price_after_tax) {
                $done = true;
            }
            if ($order_transaction && $done && $request->type != 'Takeaway') {
                $order_transaction->payment_status = "paid";
                $order_tracking = new OrderTracking();
                $order_tracking->order_id = $Order->id;
                $order_tracking->order_status = 'in_progress';
                $order_tracking->created_by = $created_by;
                $order_tracking->save();
                // call point function   $UserType == client

                if ($UserType == 'client' && isValid($Order->branch_id)) {
                    if (isActive($Order->branch_id)) {
                        $points_num =   calculateEarnPoint($Order->total_price_after_tax, $Order->branch_id, $Order->id, $client_id);
                    }
                }
            } else {
                $order_transaction->payment_status = "unpaid";
            }
            $order_transaction->points_num = $points_num;
            $order_transaction->created_by = $created_by;
            $order_transaction->save();
        }
        $order = Order::find($Order->id);

        $order['details'] = OrderDetail::where('order_id', $order->id)->get();
        $order['addons'] = OrderAddon::where('order_id', $order->id)->get();

        // Update the payment status based on the paid amount

        return ResponseWithSuccessData($lang, $order, 1);
    }
    public function show($lang, $id, $checkToken)
    {
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $order = Order::find($id);

        $order['details'] = OrderDetail::where('order_id', $id)->get();
        $order['addons'] = OrderAddon::where('order_id', $id)->get();
        $order['transaction'] = OrderTransaction::where('order_id', $id)->first();
        $order['address'] = ClientAddress::where('id', $order->client_address_id)->first();
        $order['tracking'] = OrderTracking::where('order_id', $id)->get();


        return ResponseWithSuccessData($lang, $order, 1);
    }
    public function cancel_order(Request $request, $checkToken)
    {

        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);
        if (Auth::guard('api')->user()->flag == 0) {
            return RespondWithBadRequest($lang, 5);
        } else {
            $UserType =  CheckUserType();
            $client_id = Auth::guard('api')->user()->id;
            if ($UserType != '') {
                $unknown_user = User::where('flag', $UserType)->first()->id;
                $client_id = ($UserType == 'admin') ? $unknown_user : Auth::guard('api')->user()->id;
            }
            $created_by = Auth::guard('api')->user()->id;
        }
        $cancel_time = getSetting('time_cancellation');

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id', // Optional but must exist in the 'coupons' table
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        $order = Order::find($request->order_id);
        $minutesDifference = $order->created_at->diffInMinutes(Carbon::now());

        if ($cancel_time < $minutesDifference && !CheckOrderPaid($order->order_id) && $created_by == $order->created_by) {
            $order->status = 'cancelled';
            $order->save();
        } else {
            return RespondWithBadRequest($lang, 34);
        }
        return RespondWithSuccessRequest($lang, 1);
    }
    public function getNextStatus($status)
    {
        $next_status = array();
        if ($status == 'pending') {
            array_push($next_status, 'in_progress');
            array_push($next_status, 'cancelled');
        } else if ($status == 'cancelled' || $status == 'completed') {
            $next_status = array();
        } else if ($status == 'in_progress') {
            array_push($next_status, 'on_way');
            array_push($next_status, 'deliverd');
            array_push($next_status, 'completed');
        } else if ($status == 'on_way') {
            array_push($next_status, 'deliverd');
        } else if ($status == 'deliverd') {

            array_push($next_status, 'completed');
        }
        return $next_status;
    }
}
