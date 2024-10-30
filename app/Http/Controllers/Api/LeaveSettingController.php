<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LeaveSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $leave_settings = LeaveSetting::with(['countries', 'leaveTypes'])->get();
            return ResponseWithSuccessData($lang, $leave_settings, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function add(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'leave_type_id' => 'required|exists:leave_types,id',
                'country_id' => 'required|exists:countries,id',
                'min_leave' => 'required|integer',
                'max_leave' => 'required|integer'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $leave_setting = new LeaveSetting();
            $leave_setting->leave_type_id = $request->leave_type_id;
            $leave_setting->country_id = $request->country_id;
            $leave_setting->min_leave = $request->min_leave;
            $leave_setting->max_leave = $request->max_leave;
            $leave_setting->created_by = $user_id;
            $leave_setting->save();

            return ResponseWithSuccessData($lang, $leave_setting, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function edit(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'id' => 'required|exists:leave_settings,id',
                'leave_type_id' => 'required|exists:leave_types,id',
                'country_id' => 'required|exists:countries,id',
                'min_leave' => 'required|integer',
                'max_leave' => 'required|integer'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $leave_setting = LeaveSetting::findOrFail($request->id);
            $leave_setting->leave_type_id = $request->leave_type_id;
            $leave_setting->country_id = $request->country_id;
            $leave_setting->min_leave = $request->min_leave;
            $leave_setting->max_leave = $request->max_leave;
            $leave_setting->modified_by = $user_id;
            $leave_setting->save();

            return ResponseWithSuccessData($lang, $leave_setting, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $user_id = Auth::guard('api')->user()->id;

            $leave_setting = LeaveSetting::find($request->id);
            if (!$leave_setting) {
                return  RespondWithBadRequestNotExist();
            }

            $leave_setting->deleted_by = $user_id;
            $leave_setting->save();

            $leave_setting->delete();

            return RespondWithSuccessRequest($lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
