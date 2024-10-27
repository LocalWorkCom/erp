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
        //try {
            $lang =  $request->header('lang', 'en');
            $overtime_settings = LeaveRequest::with(['employees', 'leaveTypes', 'agreementBys'])->get();
            return ResponseWithSuccessData($lang, $overtime_settings, 1);
        // } catch (\Exception $e) {
        //     return RespondWithBadRequestData($lang, 2);
        // }
    }

    public function index_by_employee(Request $request, $employee_id)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $employee_details = Employee::find($employee_id);
            if (!$employee_details) {
                return  RespondWithBadRequestNotExist();
            }

            $overtime_settings = LeaveRequest::where('employee_id', $employee_id)->with(['employees', 'leaveTypes', 'agreementBys'])->get();
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
                'id' => 'required|exists:overtime_settings,id',
                'overtime_type_id' => 'required|exists:overtime_types,id',
                'quentity' => 'integer|nullable',
                'percent' => 'integer|nullable'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $overtime_setting = LeaveRequest::findOrFail($request->id);
            $overtime_setting->overtime_type_id = $request->overtime_type_id;
            $overtime_setting->quentity = $request->quentity;
            $overtime_setting->percent = $request->percent;
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

            $overtime_setting = LeaveRequest::findOrFail($request->id);
            if (!$overtime_setting) {
                return  RespondWithBadRequestNotExist();
            }

            $overtime_setting->deleted_by = $user_id;
            $overtime_setting->save();

            $overtime_setting->delete();

            return RespondWithSuccessRequest($lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
