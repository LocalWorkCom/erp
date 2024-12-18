<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\LeaveSettingService;
use App\Models\LeaveType;
use App\Models\Country;
use Illuminate\Http\Request;

class LeaveSettingController extends Controller
{
    protected $leaveSettingService;

    public function __construct(LeaveSettingService $leaveSettingService)
    {
        $this->leaveSettingService = $leaveSettingService;
    }

    public function index(Request $request)
    {
        $response = $this->leaveSettingService->index($request);
        $responseData = $response->original;
        $LeaveSetting = $responseData['data'];
        $leaveTypes = LeaveType::all();
        $countries = Country::all();
        return view('dashboard.leave_setting.list', compact('LeaveSetting', 'countries', 'leaveTypes'));
    }

    public function show($id)
    {
        $response = $this->leaveSettingService->show($id);
        $responseData = $response->original;
        return $LeaveType = $responseData['data'];
    }

    public function store(Request $request)
    {
        $response = $this->leaveSettingService->add($request);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->route('leave-settings.list')->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('leave-settings.list')->with('message',$message);
    }

    public function update(Request $request, $id)
    {
        $response = $this->leaveSettingService->edit($request, $id);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->route('leave-settings.list')->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('leave-settings.list')->with('message',$message);
    }
    public function delete(Request $request, $id)
    {
        $response = $this->leaveSettingService->delete($request, $id);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect()->route('leave-settings.list')->with('message',$message);
    }
}
