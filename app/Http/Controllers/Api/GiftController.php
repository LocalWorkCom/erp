<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

    public function applyGiftToUsers(Request $request)
    {
        $lang = $request->header('lang', 'en');

        $validated = $request->validate([
            'gift_id' => 'required|exists:gifts, id',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        $gift = Gift::find($validated['gift_id']);

        //Apply to users based on branch id
        if ($request->user_ids) {
            $users = User::whereIn('id', $validated['user_ids'])->get();
        } else {
            return RespondWithBadRequestData($lang, 'No users specified.');
        }
    }

    public function applyGiftByBranch(Request $request)
    {
        $lang = $request->header('lang', 'ar');

        $request->validate([
            'branch_id' => 'required|exists:branches, id',
            'gift_id' => 'required|exists:gifts, id'
        ]);

        $gift = Gift::find($request->gift_id);

        if (!$gift) {
            return RespondWithBadRequestData($lang, 'Gift not found');
        }

        // Get all users who have placed orders in the specified branch
        $users = User::whereHas('orders', function ($query) use ($request) {
            $query->where('branch_id', $request->branch_id);
        })->get();

        foreach ($users as $user) {
            // Check if the gift is already applied to this user
            $userGiftExists = DB::table('user_gifts')
                ->where('user_id', $user->id)
                ->where('gift_id', $request->gift_id)
                ->exists();

            if (!$userGiftExists) {
                DB::table('user_gifts')->insert([
                    'user_id' => $user->user_id,
                    'gift_id' => $request->gift_id,
                    'used' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        return ResponseWithSuccessData($lang, 'Gift applied successfully to all users in the specified branch', 1);
    }
}
