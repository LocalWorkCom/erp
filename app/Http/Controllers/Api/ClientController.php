<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientAddress;
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

    // public function listOrders()
    // {
    //     $user = Auth::user();
    //     $orders = $user->orders()->with('items')->get();

    //     return response()->json(['status' => true, 'data' => $orders]);
    // }
}
