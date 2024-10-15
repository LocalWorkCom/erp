<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderAddon;
use App\Models\OrderDetail;
use App\Models\OrderTracking;
use App\Models\OrderTransaction;
use App\Models\RecipeAddon;
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
        $discount = null;
        $total_price_befor_tax = 0;
        $total_addon_price_befor_tax = 0;
        $DataOrderDetails = $request->details;
        $DataAddons = $request->addons;
        $done = false;


        //settings
        $tax_percentage = 0;
        $tax_application = getSetting('tax_application');
        $tax_percentage = getSetting('tax_percentage');
        $coupon_application = getSetting('coupon_application');
        $service_fees = getSetting('service_fees');


        //validation
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:takeaway,online,in_resturant',  // Enforce enum-like values
            'note' => 'nullable|string', // Optional but must be a string
            'delivery_fees' => 'nullable|numeric', // Must be a number
            'table_id' => 'nullable|exists:tables,id', // Optional but must exist in the 'tables' table
            'branch_id' => 'required|exists:branches,id', // Optional but must exist in the 'discounts' table
            'coupon_code' => 'nullable|exists:coupons,code', // Optional but must exist in the 'coupons' table
            'details' => 'required|array', // Must be an array (contains order details)
            'details.*.quantity' => 'required|integer', // Every detail must have a quantity
            // 'details.*.total' => 'required|numeric', // Every detail must have a total
            'details.*.note' => 'nullable|string', // Optional note in details
            'details.*.coupon_code' => 'nullable|exists:coupons,code', // Optional coupon in details
            'details.*.product_id' => 'nullable|exists:products,id', // Product ID must exist in the 'products' table
            'details.*.dish_id' => 'nullable|exists:dishes,id', // Optional recipe ID
            'details.*.unit_id' => 'required|exists:units,id', // Unit ID must exist in the 'units' table
            'addons' => 'nullable|array', // Add-ons can be optional but must be an array if provided
            'addons.*.quantity' => 'required|integer', // Add-ons must have a quantity
            'addons.*.recipe_addon_id' => 'required|exists:recipe_addons,id', // Add-on recipe must exist
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
        $Order->discount_id = ($discount) ? $discount->id : null;
        $Order->branch_id = $request->branch_id;

        $Order->coupon_id = ($coupon) ? $coupon->id : null;
        $Order->created_by = $created_by;
        // while (Order::where('order_number', $Order->order_number)->exists()) {
        $Order->order_number = "#" . rand(1111, 9999); // Generate a new number if it exists
        $Order->invoice_number = "INV-" . GetNextID("orders") . "-" . rand(1111, 9999); // Generate a new number if it exists
        // }
        $Order->save();


        foreach ($DataOrderDetails as $DataOrderDetail) {
            $Dish = Dish::find($DataOrderDetail['dish_id']);
            if ($Dish) {
                $total = $Dish->price;
            }
            $OrderDetails = new OrderDetail();
            $OrderDetails->order_id = $Order->id;
            $OrderDetails->quantity = $DataOrderDetail['quantity'];
            $OrderDetails->total = $total;
            $OrderDetails->price_befor_tax = $tax_application == 1 ? applyTax($total, $tax_percentage, $tax_application) : $total;
            $OrderDetails->tax_value = CalculateTax($tax_percentage, $total);
            $OrderDetails->note = $DataOrderDetail['note'];
            $OrderDetails->product_id = $DataOrderDetail['product_id'] ?? null;
            $OrderDetails->dish_id = $DataOrderDetail['dish_id'] ?? null;
            $OrderDetails->unit_id = $DataOrderDetail['unit_id'];
            $OrderDetails->created_by = $created_by;
            $total_product_price_after_tax = $tax_application == 0 ? applyTax($total, $tax_percentage, $tax_application) * $DataOrderDetail['quantity'] : $total * $DataOrderDetail['quantity'];
            $OrderDetails->price_after_tax = $total_product_price_after_tax;
            $OrderDetails->save();
        }

        foreach ($DataAddons as $DataAddon) {
            $addon = RecipeAddon::with('addon')->where('recipe_addons.id', $DataAddon['recipe_addon_id'])->first();
            if ($addon) {
                $price = $addon->price;
            }
            $OrderAddons = new OrderAddon();
            $OrderAddons->order_id = $Order->id;
            $OrderAddons->quantity = $DataAddon['quantity'];
            $OrderAddons->recipe_addon_id = $DataAddon['recipe_addon_id'];
            $OrderAddons->price_before_tax = $tax_application == 1 ? applyTax($price, $tax_percentage, $tax_application) : $price;
            $price_after_tax = $tax_application == 0 ? applyTax($price, $tax_percentage, $tax_application) * $DataAddon['quantity'] : $price * $DataAddon['quantity'];
            $OrderAddons->price_after_tax = $price_after_tax;
            $OrderAddons->created_by = $created_by;
            $OrderAddons->save();
        }

        $total_addon_price_befor_tax = array_sum(
            array_map(
                function ($addon) {
                    return $addon['price'] * $addon['quantity'];
                },
                $DataAddons
            )
        );
        $total_price_befor_tax = $total_price_befor_tax2 = array_sum(
            array_map(
                function ($detail) {
                    return $detail['total'] * $detail['quantity'];
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
            $order_transaction->discount_id = ($discount) ? $discount->id : null;
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
        $order = Order::find($Order->id);

        $order['details'] = OrderDetail::where('order_id', $order->id)->get();
        $order['addons'] = OrderAddon::where('order_id', $order->id)->get();

        // Update the payment status based on the paid amount

        return ResponseWithSuccessData($lang, $order, 1);
    }
}
