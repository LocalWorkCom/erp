<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientAddress;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function viewProfile(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $user = Auth::user();

        $userWithDetails = $user->load(['addresses', 'clientDetails']);

        if (!$userWithDetails->clientDetails) {
            return RespondWithBadRequest($lang, 17);
        }

        return ResponseWithSuccessData($lang, $userWithDetails, 18);
    }

    public function updateProfile(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $user = Auth::user();
        $clientDetails = $user->clientDetails;

        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
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
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        if ($request->filled('phone')) {
            $user->phone = $request->phone;
        }

        if ($clientDetails) {
            if ($request->filled('first_name')) {
                $clientDetails->first_name = $request->first_name;
            }
            if ($request->filled('last_name')) {
                $clientDetails->last_name = $request->last_name;
            }
            if ($request->filled('date_of_birth')) {
                $clientDetails->date_of_birth = $request->date_of_birth;
            }
            $clientDetails->save();
        }

        // For address fields
        if ($request->filled(['address', 'city', 'postal_code', 'state'])) {
            $userAddress = $user->addresses()->first();
            if (!$userAddress) {
                $userAddress = new ClientAddress();
                $userAddress->user_id = $user->id;
            }

            if ($request->filled('address')) {
                $userAddress->address = $request->address;
            }
            if ($request->filled('city')) {
                $userAddress->city = $request->city;
            }
            if ($request->filled('postal_code')) {
                $userAddress->postal_code = $request->postal_code;
            }
            if ($request->filled('state')) {
                $userAddress->state = $request->state;
            }
            $userAddress->save();
        }

        $user->save();

        return ResponseWithSuccessData($lang, $clientDetails, 19);
    }

    public function listOrders(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $user = Auth::user();

        $orders = Order::where('client_id', $user->id)
            ->with(['orderDetails', 'orderDetails.orderAddons'])
            ->get();

        if ($orders->isEmpty()) {
            return RespondWithBadRequest($lang, 20);
        }

        return response()->json([
            'status' => true,
            'data' => $orders
        ]);
    }

    public function reorder(Request $request, $orderId)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $user = Auth::user();
        $oldOrder = Order::where('id', $orderId)->where('client_id', $user->id)->first();

        if (!$oldOrder) {
            return RespondWithBadRequest($lang, 22);
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

        return ResponseWithSuccessData($lang, $newOrder, 21);
    }

    public function trackOrder(Request $request, $orderId)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $user = Auth::user();

        $order = Order::where('id', $orderId)
            ->where('client_id', $user->id)
            ->first();

        if (!$order) {
            return RespondWithBadRequest($lang, 22);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'order_id' => $order->id,
                'status' => $order->status,
            ]
        ]);
    }
}
