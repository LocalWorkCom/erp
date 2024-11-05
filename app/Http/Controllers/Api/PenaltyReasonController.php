<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenaltyReason;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenaltyReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        $reasons = PenaltyReason::all();

        $response = $reasons->map(function ($reason) use ($lang) {
            return [
                'id' => $reason->id,
                'reason' => $lang === 'ar' ? $reason->reason_ar : $reason->reason_en,
                'punishment' => $lang === 'ar' ? $reason->punishment_ar : $reason->punishment_en,
                'note' => $reason->note,
            ];
        });

        return ResponseWithSuccessData($lang, $response, 1);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lang = $request->header('lang', 'ar');

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        $data = $request->validate([
            'reason_ar' => 'required|string',
            'reason_en' => 'required|string',
            'punishment_ar' => 'required|string',
            'punishment_en' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $userId = Auth::guard('api')->user()->id;
//        dd($userId);
        $reason = new PenaltyReason();
        $reason->reason_ar = $data['reason_ar'];
        $reason->reason_en = $data['reason_en'];
        $reason->punishment_ar = $data['punishment_ar'];
        $reason->punishment_en = $data['punishment_en'];
        $reason->note = $data['note'];
        $reason->created_by = $userId;
        $reason->created_at = Carbon::now();
//        dd($reason);
        $reason->save();

//        $response = [
//            'id' => $reason->id,
//            'reason' => $lang === 'ar' ? $reason->reason_ar : $reason->reason_en,
//            'punishment' => $lang === 'ar' ? $reason->punishment_ar : $reason->punishment_en,
//            'note' => $reason->note,
//        ];

        return ResponseWithSuccessData($lang, $reason, 1);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $lang = $request->header('lang', 'ar');

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        $reason = PenaltyReason::find($id);

        if (!$reason) {
            return RespondWithBadRequestData($lang, 2);
        }

        $response = [
            'id' => $reason->id,
            'reason' => $lang === 'ar' ? $reason->reason_ar : $reason->reason_en,
            'punishment' => $lang === 'ar' ? $reason->punishment_ar : $reason->punishment_en,
            'note' => $reason->note,
        ];
        return ResponseWithSuccessData($lang, $response, 1);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lang = $request->header('lang', 'ar');

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        $data = $request->validate([
            'reason_ar' => 'sometimes|required|string',
            'reason_en' => 'sometimes|required|string',
            'punishment_ar' => 'sometimes|required|string',
            'punishment_en' => 'sometimes|required|string',
            'note' => 'nullable|string',
        ]);

        $reason = PenaltyReason::find($id);

        if (!$reason) {
            return RespondWithBadRequestData($lang, 2);
        }

        if (isset($data['reason_ar'])) {
            $reason->reason_ar = $data['reason_ar'];
        }
        if (isset($data['reason_en'])) {
            $reason->reason_en = $data['reason_en'];
        }
        if (isset($data['punishment_ar'])) {
            $reason->punishment_ar = $data['punishment_ar'];
        }
        if (isset($data['punishment_en'])) {
            $reason->punishment_en = $data['punishment_en'];
        }
        if (isset($data['note'])) {
            $reason->note = $data['note'];
        }
        $reason->updated_at = Carbon::now();
        $reason->modified_by = Auth::guard('api')->user()->id;
        $reason->save();

        $response = [
            'id' => $reason->id,
            'reason' => $lang === 'ar' ? $reason->reason_ar : $reason->reason_en,
            'punishment' => $lang === 'ar' ? $reason->punishment_ar : $reason->punishment_en,
            'note' => $reason->note,
        ];

        return ResponseWithSuccessData($lang, $response, 1);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lang = request()->header('lang', 'ar');

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        $reason = PenaltyReason::find($id);

        if (!$reason) {
            return RespondWithBadRequestData($lang, 2);
        }
        $reason->deleted_by = Auth::guard('api')->user()->id;
        $reason->save();
        $reason->delete();

        $response = [
            'id' => $reason->id,
            'reason' => $lang === 'ar' ? $reason->reason_ar : $reason->reason_en,
            'punishment' => $lang === 'ar' ? $reason->punishment_ar : $reason->punishment_en,
            'note' => $reason->note,
        ];

        return ResponseWithSuccessData($lang, $response, 1);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id, Request $request)
    {
        $lang = $request->header('lang', 'ar');

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        $reason = PenaltyReason::withTrashed()->find($id);

        if (!$reason) {
            return RespondWithBadRequestData($lang, 2);
        }

        $reason->restore();

        return ResponseWithSuccessData($lang, $reason, 1);
    }

}
