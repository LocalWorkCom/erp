<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientAddress;
use App\Models\Order;
use App\Models\OrderTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function viewProfile(Request $request)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale($lang);

        $user = Auth::user();

        $clientDetails = $user->clientDetails()->with('addresses')->first();

        // Check if the client details exist
        if (!$clientDetails) {
            return response()->json([
                "status" => false,
                "message" => $lang == 'ar'
                    ? 'لم يتم العثور على تفاصيل العميل'
                    : "Client details not found"
            ], 404);
        }

        // Return the client details along with related addresses
        return response()->json([
            "status" => true,
            "message" => $lang == 'ar'
                ? 'تم عرض تفاصيل العميل بنجاح'
                : "Client details retrieved successfully",
            "data" => $clientDetails
        ]);
    }

    public function updateProfile(Request $request)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale($lang);

        $user = Auth::user();
        $clientDetails = $user->clientDetails;

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            "email" => "nullable|email|unique:users,email," . $user->id,
            "phone" => "nullable|string|unique:users,phone," . $user->id,
            'city' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'address' => 'nullable|string',
            'state' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Update only the fields that were provided
        if ($request->filled('first_name')) {
            $clientDetails->first_name = $request->first_name;
        }
        if ($request->filled('last_name')) {
            $clientDetails->last_name = $request->last_name;
        }
        if ($request->filled('email')) {
            $clientDetails->email = $request->email;
            $user->email = $request->email;
        }
        if ($request->filled('phone')) {
            $clientDetails->phone_number = $request->phone;
            $user->phone = $request->phone;
        }
        if ($request->filled('date_of_birth')) {
            $clientDetails->date_of_birth = $request->date_of_birth;
        }

        // For address fields
        if ($request->filled('address') || $request->filled('city') || $request->filled('postal_code') || $request->filled('state')) {
            $clientAddress = $clientDetails->addresses()->first(); // Assuming the first address is the primary one
            if (!$clientAddress) {
                $clientAddress = new ClientAddress();
                $clientAddress->client_details_id = $clientDetails->id;
            }

            if ($request->filled('address')) {
                $clientAddress->address = $request->address;
            }
            if ($request->filled('city')) {
                $clientAddress->city = $request->city;
            }
            if ($request->filled('postal_code')) {
                $clientAddress->postal_code = $request->postal_code;
            }
            if ($request->filled('state')) {
                $clientAddress->state = $request->state;
            }
            $clientAddress->save();
        }

        $clientDetails->save();
        $user->save();

        return response()->json([
            "status" => true,
            "message" => $lang == 'ar' ? 'تم تحديث البيانات بنجاح' : "Profile updated successfully",
            "data" => $clientDetails
        ]);
    }

    public function listOrders(Request $request)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale($lang);

        $user = Auth::user();

        $orders = Order::where('client_id', $user->id)
            ->with(['orderDetails', 'orderDetails.orderAddons'])
            ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => $lang == 'ar' ? 'لا توجد طلبات' : 'No orders found'
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => $orders
        ]);
    }

    public function reorder(Request $request, $orderId)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale($lang);

        $user = Auth::user();
        $oldOrder = Order::where('id', $orderId)->where('client_id', $user->id)->first();

        if (!$oldOrder) {
            return response()->json([
                'status' => false,
                'message' => $lang == 'ar' ? 'الطلب غير موجود' : 'Order not found'
            ]);
        }

        // Create a new order based on the old one
        $newOrder = $oldOrder->replicate();
        $newOrder->order_number = "#" . rand(1111, 9999);
        $newOrder->status = 'pending';
        $newOrder->save();

        // Replicate the order details
        foreach ($oldOrder->orderDetails as $oldDetail) {
            $newDetail = $oldDetail->replicate();
            $newDetail->order_id = $newOrder->id;
            $newDetail->save();

            // Replicate the add-ons
            foreach ($oldDetail->orderAddons as $oldAddon) {
                $newAddon = $oldAddon->replicate();
                $newAddon->order_id = $newOrder->id;
                $newAddon->save();
            }
        }

        return response()->json([
            'status' => true,
            'message' => $lang == 'ar' ? 'تمت إعادة الطلب بنجاح' : 'Order reordered successfully',
            'data' => $newOrder
        ]);
    }

    public function trackOrder(Request $request)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale($lang);

        $request->validate([
            'order_id' => 'nullable|integer',
        ]);

        $user = auth()->user();

        // Check if order_id is provided to track a specific order
        if ($request->has('order_id')) {
            $order = Order::where('id', $request->order_id)
                ->where('client_id', $user->id)
                ->first();

            if (!$order) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found',
                ], 404);
            }
            return response()->json([
                'status' => 'success',
                'order_id' => $order->id,
                'order_status' => $order->status,
            ], 200);
        }

        // If no order_id is provided, return all orders for the user
        $orders = Order::where('client_id', $user->id)->get();

        return response()->json([
            'status' => 'success',
            'orders' => $orders->map(function ($order) {
                return [
                    'order_id' => $order->id,
                    'order_status' => $order->status,
                ];
            }),
        ], 200);
    }
}
