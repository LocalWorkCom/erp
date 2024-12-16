<?php


namespace App\Services;
use App\Models\LeaveType;
use App\Models\LeaveSetting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeaveSettingService
{
    private $lang;
    public function __construct()
    {
        $this->lang = app()->getLocale();
        app()->setLocale($this->lang);
    }

    public function index(Request $request)
    {
        try {
            $leave_settings = LeaveSetting::with(['countries', 'leaveTypes'])->get();
            return ResponseWithSuccessData($this->lang, $leave_settings, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function add(Request $request)
    {
        try {
            $validateData = Validator::make($request->all(), [
                // 'leave_type_id' => 'required|exists:leave_types,id',
                // 'country_id' => 'required|exists:countries,id',
                // 'min_leave' => 'required|integer',
                // 'max_leave' => 'required|integer'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('admin')->user()->id;
            $leave_setting = new LeaveSetting();
            $leave_setting->leave_type_id = $request->leave_type_id;
            $leave_setting->country_id = $request->country_id;
            $leave_setting->min_leave = $request->min_leave;
            $leave_setting->max_leave = $request->max_leave;
            $leave_setting->created_by = $user_id;
            $leave_setting->save();

            return ResponseWithSuccessData($this->lang, $leave_setting, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function edit(Request $request)
    {
        try {
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

            $user_id = Auth::guard('admin')->user()->id;
            $leave_setting = LeaveSetting::findOrFail($request->id);
            $leave_setting->leave_type_id = $request->leave_type_id;
            $leave_setting->country_id = $request->country_id;
            $leave_setting->min_leave = $request->min_leave;
            $leave_setting->max_leave = $request->max_leave;
            $leave_setting->modified_by = $user_id;
            $leave_setting->save();

            return ResponseWithSuccessData($this->lang, $leave_setting, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $user_id = Auth::guard('admin')->user()->id;

            $leave_setting = LeaveSetting::find($request->id);
            if (!$leave_setting) {
                return  RespondWithBadRequestNotExist();
            }

            $leave_setting->deleted_by = $user_id;
            $leave_setting->save();

            $leave_setting->delete();

            return RespondWithSuccessRequest($this->lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }
}
