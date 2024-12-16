<?php


namespace App\Services;
use App\Models\LeaveType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeaveTypeService
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
            $leave_types = LeaveType::get();
            return ResponseWithSuccessData($this->lang, $leave_types, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function show($id)
    {
        try {
            $leave_type = LeaveType::findOrFail($id);
            $leave_type->makeHidden(['name'])->makeVisible(['name_ar', 'name_en']);
            return ResponseWithSuccessData($this->lang, $leave_type, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function add(Request $request)
    {
        try {
            $validateData = Validator::make($request->all(), [
                'name_ar' => 'required',
                'name_en' => 'required'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('admin')->user()->id;
            $leave_type = new LeaveType();
            $leave_type->name_ar = $request->name_ar;
            $leave_type->name_en = $request->name_en;
            $leave_type->created_by = $user_id;
            $leave_type->save();

            return ResponseWithSuccessData($this->lang, $leave_type, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function edit(Request $request)
    {
        try {
            $validateData = Validator::make($request->all(), [
                'id' => 'required|exists:leave_types,id',
                'name_ar' => 'required',
                'name_en' => 'required'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('admin')->user()->id;
            $leave_type = LeaveType::findOrFail($request->id);
            $leave_type->name_ar = $request->name_ar;
            $leave_type->name_en = $request->name_en;
            $leave_type->modified_by = $user_id;
            $leave_type->save();

            return ResponseWithSuccessData($this->lang, $leave_type, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $user_id = Auth::guard('admin')->user()->id;

            $leave_type = LeaveType::find($id);
            if (!$leave_type) {
                return  RespondWithBadRequestNotExist();
            }

            if ($leave_type->id <= 4) {
                return  RespondWithBadRequestNotAvailable();
            }

            $leave_type->deleted_by = $user_id;
            $leave_type->save();

            $leave_type->delete();

            return RespondWithSuccessRequest($this->lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }
}
