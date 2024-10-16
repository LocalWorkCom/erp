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


class OrderReportController extends Controller
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
        $orders = Order:: // Load only necessary fields
            select(
                'orders.invoice_number as inv_num',
                'orders.type as order_type',
                'orders.status as order_status',
                'orders.total_price_befor_tax as price_before_tax',
                'orders.total_price_after_tax as price_after_tax',
                'orders.date as order_date',
                'orders.tax_value as tax_value',
                'orders.order_number as order_number',
                'users.name as client_name',
                'branches.name_ar as branch_name',
                'order_transactions.payment_status as payment_status',
                'order_transactions.payment_method  as payment_method'
            )
            ->leftJoin('users', 'orders.client_id', '=', 'users.id')
            ->leftJoin('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('order_transactions', 'orders.id', '=', 'order_transactions.order_id')
            ->get();


        return ResponseWithSuccessData($lang, $orders, 1);
    }
    public function ReportDetails(Request $request)
    {

        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        $orders = Order::where('id', $request->order_id)
        ->select(
                'orders.invoice_number as inv_num',
                'orders.type as order_type',
                'orders.status as order_status',
                'orders.total_price_befor_tax as price_before_tax',
                'orders.total_price_after_tax as price_after_tax',
                'orders.date as order_date',
                'orders.tax_value as tax_value',
                'orders.order_number as order_number',
                'users.name as client_name',
                'branches.name_ar as branch_name',
                'order_transactions.payment_status as payment_status',
                'order_transactions.payment_method  as payment_method'
            )
            ->leftJoin('users', 'orders.client_id', '=', 'users.id')
            ->leftJoin('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('order_transactions', 'orders.id', '=', 'order_transactions.order_id')
            ->first();


        return ResponseWithSuccessData($lang, $orders, 1);
    }
}
