<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $leave_types = LeaveType::get();
            return ResponseWithSuccessData($lang, $leave_types, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function add(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'name_ar' => 'required',
                'name_en' => 'required'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $leave_type = new LeaveType();
            $leave_type->name_ar = $request->name_ar;
            $leave_type->name_en = $request->name_en;
            $leave_type->created_by = $user_id;
            $leave_type->save();

            return ResponseWithSuccessData($lang, $leave_type, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function edit(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'id' => 'required|exists:leave_types,id',
                'name_ar' => 'required',
                'name_en' => 'required'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $leave_type = LeaveType::findOrFail($request->id);
            $leave_type->name_ar = $request->name_ar;
            $leave_type->name_en = $request->name_en;
            $leave_type->modified_by = $user_id;
            $leave_type->save();

            return ResponseWithSuccessData($lang, $leave_type, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $user_id = Auth::guard('api')->user()->id;

            $leave_type = LeaveType::find($request->id);
            if (!$leave_type) {
                return  RespondWithBadRequestNotExist();
            }

            if ($leave_type->id < 4) {
                return  RespondWithBadRequestNotExist();
            }

            $leave_type->deleted_by = $user_id;
            $leave_type->save();

            $leave_type->delete();

            return RespondWithSuccessRequest($lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
