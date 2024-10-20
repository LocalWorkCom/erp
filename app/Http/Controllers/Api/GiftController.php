<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GiftController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $gift = Gift::all();
            return ResponseWithSuccessData($lang, $gift, 1);
        } catch (Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');

            $request->validate([
                'name' => 'required|string',
                'expiration_date' => 'required|date|after:created_at'
            ]);

            $gift = Gift::create($request->all());

            return ResponseWithSuccessData($lang, $gift, 1);
        } catch (Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $gift = Gift::find($id);
            if (!$gift) {
                return RespondWithBadRequestData($lang, 22);
            }

            return ResponseWithSuccessData($lang, $gift, 1);
        } catch (Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

            $validatedData = $request->validate([
                'name' => 'required|string',
                'expiration_date' => 'required|date',
            ]);

            $gift = Gift::find($id);
            if (!$gift) {
                return RespondWithBadRequestData($lang, 22);
            }

            // Check if expiration date is after the creation date
            if (strtotime($validatedData['expiration_date']) <= strtotime($gift->created_at)) {
                return RespondWithBadRequestData($lang, 'Expiration date must be after the creation date');
            }

            $gift->update([
                'name' => $validatedData['name'],
                'expiration_date' => $validatedData['expiration_date']
            ]);

            return ResponseWithSuccessData($lang, $gift, 1);
        } catch (Exception $e) {
            Log::error('Gift update error: ' . $e->getMessage());

            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $gift = Gift::find($id);
            if (!$gift) {
                return RespondWithBadRequestData($lang, 22);
            }
            $gift->delete();
            return RespondWithSuccessRequest($lang, 1);
        } catch (Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
