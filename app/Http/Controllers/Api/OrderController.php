<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderAddon;
use App\Models\OrderDetail;
use App\Models\OrderTracking;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class OrderController extends Controller
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
        $orders = Order::all();

        foreach ($orders as $order) {
            $order['details'] = OrderDetail::where('order_id', $order->id)->get();
            $order['addons'] = OrderAddon::where('order_id', $order->id)->get();
        }


        return ResponseWithSuccessData($lang, $orders, 1);
    }

    public function store(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);
        if (Auth::guard('api')->user()->flag == 0) {
            return RespondWithBadRequest($lang, 5);
        } else {
            $created_by = Auth::guard('api')->user()->id;
        }
        $discount_id = 0;
        $total_price_befor_tax = 0;
        $total_addon_price_befor_tax = 0;
        $DataOrderDetails = $request->details;
        $DataAddons = $request->addons;
        $done = false;


        //settings
        $tax_percentage = 0;
        $tax_application = getSetting('tax_application');
        if ($tax_application) {
            $tax_percentage = getSetting('tax_percentage');
        }
        $discount_application = getSetting('discount_application');
        $service_fees = getSetting('service_fees');


        //validation
        $validator = Validator::make($request->all(), [
            'type' => 'required|string', // Required and must be a string
            'note' => 'nullable|string', // Optional but must be a string
            'delivery_fees' => 'nullable|numeric', // Must be a number
            'table_id' => 'nullable|exists:tables,id', // Optional but must exist in the 'tables' table
            'branch_id' => 'required|exists:branches,id', // Optional but must exist in the 'discounts' table
            'coupon_code' => 'nullable|exists:coupons,code', // Optional but must exist in the 'coupons' table
            'details' => 'required|array', // Must be an array (contains order details)
            'details.*.quantity' => 'required|integer', // Every detail must have a quantity
            'details.*.total' => 'required|numeric', // Every detail must have a total
            'details.*.note' => 'nullable|string', // Optional note in details
            'details.*.coupon_code' => 'nullable|exists:coupons,code', // Optional coupon in details
            'details.*.product_id' => 'nullable|exists:products,id', // Product ID must exist in the 'products' table
            'details.*.recipe_id' => 'nullable|exists:recipes,id', // Optional recipe ID
            'details.*.unit_id' => 'required|exists:units,id', // Unit ID must exist in the 'units' table
            'addons' => 'nullable|array', // Add-ons can be optional but must be an array if provided
            'addons.*.quantity' => 'required|integer', // Add-ons must have a quantity
            'addons.*.recipe_addon_id' => 'required|exists:recipe_addons,id', // Add-on recipe must exist
            'addons.*.price' => 'required|numeric', // Add-on price must be numeric
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
            $discount_id = CheckDiscountValid()->id;
        }


        //order
        $Order = new Order();
        $Order->date = date('Y-m-d');
        $Order->type = $request->type;
        $Order->note = $request->note;
        $Order->delivery_fees = 0;
        // $request->delivery_fees;
        $Order->fees = $service_fees;
        $Order->table_id = $request->table_id ?? null;
        $Order->client_id = $created_by;
        $Order->discount_id = ($discount_id) ? $discount_id : null;
        $Order->branch_id = $request->branch_id;

        $Order->coupon_id = ($coupon) ? $coupon->id : null;
        $Order->created_by = $created_by;
        // while (Order::where('order_number', $Order->order_number)->exists()) {
        $Order->order_number = "#" . rand(1111, 9999); // Generate a new number if it exists
        $Order->invoice_number = "INV-" . GetNextID("orders") . "-" . rand(1111, 9999); // Generate a new number if it exists
        // }
        $Order->save();


        foreach ($DataOrderDetails as $DataOrderDetail) {
            $OrderDetails = new OrderDetail();
            $OrderDetails->order_id = $Order->id;
            $OrderDetails->quantity = $DataOrderDetail['quantity'];
            $OrderDetails->total = $DataOrderDetail['total'];
            $OrderDetails->price_befor_tax = $DataOrderDetail['total'];
            $OrderDetails->tax_value = CalculateTax($tax_percentage, $DataOrderDetail['total']);
            $OrderDetails->note = $DataOrderDetail['note'];
            $OrderDetails->product_id = $DataOrderDetail['product_id'] ?? null;
            $OrderDetails->recipe_id = $DataOrderDetail['recipe_id'] ?? null;
            $OrderDetails->unit_id = $DataOrderDetail['unit_id'];
            $OrderDetails->created_by = $created_by;
            $total_product_price_after_tax = $tax_application == 0 ? applyTax($DataOrderDetail['total'], $tax_percentage) : $DataOrderDetail['total'];
            $total_product_price_after_tax *=  $DataOrderDetail['quantity'];
            $OrderDetails->price_after_tax = $total_product_price_after_tax;
            $OrderDetails->save();
        }

        foreach ($DataAddons as $DataAddon) {
            $OrderAddons = new OrderAddon();
            $OrderAddons->order_id = $Order->id;
            $OrderAddons->quantity = $DataAddon['quantity'];
            $OrderAddons->recipe_addon_id = $DataAddon['recipe_addon_id'];
            $OrderAddons->price_before_tax = $DataAddon['price'];

            $price_after_tax = $tax_application == 0 ? applyTax($DataAddon['price'], $tax_percentage) : $DataAddon['price'];
            $price_after_tax *=  $DataAddon['quantity'];

            $OrderAddons->price_after_tax = $price_after_tax;
            $OrderAddons->created_by = $created_by;
            $OrderAddons->save();
        }

        $total_addon_price_befor_tax = array_sum(array_column($DataAddons, 'price'));
        $total_price_befor_tax = array_sum(array_column($DataOrderDetails, 'total')) + $total_addon_price_befor_tax;

        if ($coupon && CheckCouponValid($coupon->id, $total_price_befor_tax)) {
            return RespondWithBadRequest($lang, 11);
        }

        // Apply coupon before tax (if applicable)
        if ($coupon && $discount_application == 0) {
            $total_price_befor_tax = applyCoupon($total_price_befor_tax, $coupon);
        }

        // Apply tax (if applicable)
        $total_price_after_tax = $tax_application == 0 ? applyTax($total_price_befor_tax, $tax_percentage) : $total_price_befor_tax;
        // $total_addon_price_after_tax = $tax_application == 0 ? applyTax($total_addon_price_befor_tax, $tax_percentage) : $total_addon_price_befor_tax;

        // $total_price_after_tax += $total_addon_price_after_tax;
        // Apply coupon after tax (if applicable)
        if ($coupon && $discount_application == 1) {
            $total_price_after_tax = applyCoupon($total_price_after_tax, $coupon);
        }

        $Order->tax_value = CalculateTax($tax_percentage, $total_price_after_tax);
        $Order->total_price_befor_tax = $total_price_befor_tax;
        $Order->total_price_after_tax = $total_price_after_tax + $service_fees;
        $Order->save();




        // add event order tracking
        $OrderTracking = new OrderTracking();
        $OrderTracking->order_id = $Order->id;
        $OrderTracking->created_by = $created_by;
        $OrderTracking->save();

        $transactionId = Str::uuid()->toString();

        if ($request->payment_method != 'cash') {

            $order_transaction = new OrderTransaction();
            $order_transaction->order_id = $Order->id;
            $order_transaction->payment_method = $request->payment_method;
            $order_transaction->transaction_id = $transactionId;
            $order_transaction->created_by = $created_by;
            $order_transaction->paid = $total_price_after_tax;
            $order_transaction->date = date('Y-m-d');
            // $order_transaction->refund = $request->refund;
            $order_transaction->discount_id = ($discount_id) ? $discount_id : null;
            $order_transaction->coupon_id = $request->coupon_id;
            if ($request->paid >= $Order->total_price_after_tax) {
                $done = true;
            }
            if ($order_transaction && $done) {
                $order_transaction->payment_status = "paid";
                $order_tracking = new OrderTracking();
                $order_tracking->order_id = $Order->id;
                $order_tracking->status = 'in_progress';
                $order_tracking->created_by = $created_by;
                $order_tracking->save();
            } else {
                $order_transaction->payment_status = "unpaid";
            }
            $order_transaction->created_by = $created_by;

            $order_transaction->save();
        }


        // Update the payment status based on the paid amount

        $Order['details'] = $OrderDetails;
        $Order['addon'] = $OrderAddons;

        return ResponseWithSuccessData($lang, $Order, 1);
    }
}
