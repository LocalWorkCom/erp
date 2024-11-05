<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenaltyResource;
use App\Models\Penalty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenaltyController extends Controller
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
        $reasonField = $lang === 'en' ? 'reason_en' : 'reason_ar';

        $penalties = Penalty::with([
            "reason:id,{$reasonField}",
            'employee:id,first_name,last_name',
        ])->get();

        return ResponseWithSuccessData($lang, PenaltyResource::collection($penalties), 1);
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
            'reason_id' => 'required|exists:penalty_reasons,id',
            'employee_id' => 'required|exists:employees,id',
            'note' => 'nullable|string',
        ]);

        $penalty = new Penalty();
        $penalty->reason_id = $data['reason_id'];
        $penalty->employee_id = $data['employee_id'];
        $penalty->note = $data['note'];
        $penalty->created_by = Auth::guard('api')->user()->id;
        $penalty->save();

        return ResponseWithSuccessData($lang, PenaltyResource::make($penalty), 1);

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

        $penalty = Penalty::with(['reason', 'employee:id,first_name,last_name'])->find($id);

        if (!$penalty) {
            return RespondWithBadRequestData($lang, 2);
        }

        return ResponseWithSuccessData($lang, PenaltyResource::make($penalty), 1);
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

        // Validation rules
        $data = $request->validate([
            'reason_id' => 'sometimes|required|exists:penalty_reasons,id',
            'employee_id' => 'sometimes|required|exists:employees,id',
            'note' => 'nullable|string',
        ]);
        $penalty = Penalty::find($id);
        if (!$penalty) {
            return RespondWithBadRequestData($lang, 8);
        }
        if(isset($data['reason_id'])){
            $penalty->reason_id = $data['reason_id'];
        }
        if(isset($data['employee_id'])){
            $penalty->employee_id = $data['employee_id'];
        }
        if(isset($data['note'])){
            $penalty->note = $data['note'];
        }
        $penalty->modified_by = Auth::guard('api')->user()->id;
        $penalty->save();

        return ResponseWithSuccessData($lang, PenaltyResource::make($penalty), 1);

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

        $penalty = Penalty::find($id);

        if (!$penalty) {
            return RespondWithBadRequestData($lang, 2);
        }
        $penalty->deleted_by = Auth::guard('api')->user()->id;
        $penalty->save();
        $penalty->delete();

        return ResponseWithSuccessData($lang, PenaltyResource::make($penalty), 1);
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

        $penalty = Penalty::withTrashed()->find($id);

        if (!$penalty) {
            return RespondWithBadRequestData($lang, 2);
        }

        $penalty->restore();

        return ResponseWithSuccessData($lang, PenaltyResource::make($penalty), 1);
    }
}
