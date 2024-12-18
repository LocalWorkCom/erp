<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClientAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClientAddressController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $withTrashed = $request->query('withTrashed', false);

            $user = Auth::user();

            if (!$user) {
                return RespondWithBadRequestData($lang, 3);
            }

            $addresses = $withTrashed
                ? ClientAddress::where('user_id', $user->id)->withTrashed()->get()
                : ClientAddress::where('user_id', $user->id)->get();

            return ResponseWithSuccessData($lang, $addresses, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching addresses: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $user = Auth::user();

            if (!$user) {
                return RespondWithBadRequestData($lang, 3);
            }

            $address = ClientAddress::where('user_id', $user->id)
                ->withTrashed()
                ->findOrFail($id);

            return ResponseWithSuccessData($lang, $address, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching address: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                "address" => "required|string",
                "city" => "required|string",
                "state" => "required|string",
                "postal_code" => "nullable|string",
                "is_default" => "nullable|integer"
            ]);

            if ($validator->fails()) {
                return respondError('Validation Error.', 400, $validator->errors());
            }

            $clientAddress = new ClientAddress();
            $clientAddress->user_id = $user->id;
            $clientAddress->address = $request->address;
            $clientAddress->city = $request->city;
            $clientAddress->state = $request->state;
            $clientAddress->postal_code = $request->postal_code ?? null;
            $clientAddress->is_default = $request->is_default ?? 0;

            $clientAddress->save();

            return ResponseWithSuccessData($lang, $clientAddress, 1);
        } catch (\Exception $e) {
            Log::error('Error creating brand: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');

            $request->validate([
                "address" => "nullable|string",
                "city" => "nullable|string",
                "state" => "nullable|string",
                "postal_code" => "nullable|string",
                "is_default" => "nullable|integer"
            ]);

            $clientAddress = ClientAddress::findOrFail($id);
            $clientAddress->address = $request->address ?? $clientAddress->address;
            $clientAddress->city = $request->city ?? $clientAddress->city;
            $clientAddress->state = $request->state ?? $clientAddress->state;
            $clientAddress->postal_code = $request->postal_code ?? $clientAddress->postal_code;
            $clientAddress->is_default = $request->is_default ?? $clientAddress->is_default;

            $clientAddress->save();

            return ResponseWithSuccessData($lang, $clientAddress, 1);
        } catch (\Exception $e) {
            Log::error('Error updating Address: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $address = ClientAddress::findOrFail($id);
            $address->update(['deleted_by' => auth()->id()]);
            $address->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting address: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $address = ClientAddress::withTrashed()->findOrFail($id);
            $address->restore();

            return ResponseWithSuccessData($lang, $address, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring brand: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
