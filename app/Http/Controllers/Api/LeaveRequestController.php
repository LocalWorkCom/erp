<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'leave_type_id' => 'nullable|exists:leave_types,id',
                'employee_id' => 'nullable|exists:employees,id',
                'from' => 'nullable|date',
                'to' => 'nullable|date'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $overtime_settings = LeaveRequest::Query();
            if($request->has('leave_type_id')){
                $overtime_settings = $overtime_settings->where('leave_type_id', $request->leave_type_id);
            }
            if($request->has('employee_id')){
                $overtime_settings = $overtime_settings->where('employee_id', $request->employee_id);
            }
            if($request->has('from')){
                $overtime_settings = $overtime_settings->where('from', '<=', $request->from);
            }
            if($request->has('to')){
                $overtime_settings = $overtime_settings->where('to', '>=', $request->to);
            }
            if($request->has('agreement')){
                $overtime_settings = $overtime_settings->where('agreement', $request->agreement);
            }
            $overtime_settings = $overtime_settings->with(['employees', 'leaveTypes', 'agreementBys'])->get();
            return ResponseWithSuccessData($lang, $overtime_settings, 1);
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
                'employee_id' => 'required|exists:employees,id',
                'date' => 'required|date',
                'from' => 'required|date|after:today',
                'leave_count' => 'required|integer',
                'resone' => 'string|nullable'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $overtime_setting = new LeaveRequest();
            $overtime_setting->leave_type_id = $request->leave_type_id;
            $overtime_setting->employee_id = $request->employee_id;
            $overtime_setting->date = $request->date;
            $overtime_setting->from = $request->from;
            $overtime_setting->leave_count = $request->leave_count;
            $overtime_setting->resone = $request->resone;
            $overtime_setting->created_by = $user_id;
            $overtime_setting->save();

            return ResponseWithSuccessData($lang, $overtime_setting, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function edit(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'id' => 'required|exists:leave_requests,id',
                'leave_type_id' => 'required|exists:leave_types,id',
                'employee_id' => 'required|exists:employees,id',
                'date' => 'required|date',
                'from' => 'required|date|after:today',
                'leave_count' => 'required|integer',
                'resone' => 'string|nullable'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $date = date('Y-m-d');
            $overtime_setting = LeaveRequest::find($request->id);

            if($overtime_setting->agreement != 1){
                return  RespondWithBadRequestNotHavePermeation();
            }

            if($overtime_setting->from <= $date){
                return  RespondWithBadRequestNotDate();
            }

            $overtime_setting->leave_type_id = $request->leave_type_id;
            $overtime_setting->employee_id = $request->employee_id;
            $overtime_setting->date = $request->date;
            $overtime_setting->from = $request->from;
            $overtime_setting->leave_count = $request->leave_count;
            $overtime_setting->resone = $request->resone;
            $overtime_setting->modified_by = $user_id;
            $overtime_setting->save();

            return ResponseWithSuccessData($lang, $overtime_setting, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $user_id = Auth::guard('api')->user()->id;
            $date = date('Y-m-d');

            $overtime_setting = LeaveRequest::find($request->id);
            if (!$overtime_setting) {
                return  RespondWithBadRequestNotExist($lang, 9);
            }

            if($overtime_setting->agreement != 1){
                return  RespondWithBadRequestNotHavePermeation($lang, 9);
            }

            if($overtime_setting->from <= $date){
                return  RespondWithBadRequestNotDate($lang, 9);
            }

            $overtime_setting->deleted_by = $user_id;
            $overtime_setting->save();

            $overtime_setting->delete();

            return RespondWithSuccessRequest($lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function change_status(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'id' => 'required|exists:leave_requests,id',
                'agreement' => 'required|integer',
                'agreement_date' => 'required|date|after:yesterday',
                'agreement_resone' => 'string|nullable'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $overtime_setting = LeaveRequest::find($request->id);

            if (!$overtime_setting) {
                return  RespondWithBadRequestNotExist($lang, 9);
            }

            // if($overtime_setting->from < $request->agreement_date){
            //     return  RespondWithBadRequestNotDate($lang, 9);
            // }

            $overtime_setting->agreement = $request->agreement;
            $overtime_setting->agreement_date = $request->agreement_date;
            $overtime_setting->agreement_resone = $request->agreement_resone;
            $overtime_setting->agreement_by = $user_id;
            $overtime_setting->modified_by = $user_id;
            $overtime_setting->save();

            return ResponseWithSuccessData($lang, $overtime_setting, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
