<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use Exception;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $gift = Gift::all();
            return ResponseWithSuccessData($lang, $gift, 1);
        } catch (\Exception $e) {
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
            $gift = Gift::find($id);
            if (!$gift) {
                return RespondWithBadRequestData($lang, 22);
            }
            $request->validate([
                'name' => 'required|string',
                'expiration_date' => 'required|date|after:created_at'
            ]);

            $gift->update($request->all());

            return ResponseWithSuccessData($lang, $gift, 1);
        } catch (Exception $e) {
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
