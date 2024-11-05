<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeSchedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EmployeeScheduleController extends Controller
{
    
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $schedules = EmployeeSchedule::with(['employee', 'shift.details.timetable'])->get();
            return ResponseWithSuccessData($lang, $schedules, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching employee schedules: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

 
    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $schedule = EmployeeSchedule::with(['employee', 'shift.details.timetable'])->findOrFail($id);
            return ResponseWithSuccessData($lang, $schedule, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching employee schedule: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

  
    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');

            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'shift_id' => 'required|exists:shifts,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $schedule = EmployeeSchedule::create([
                'employee_id' => $request->employee_id,
                'shift_id' => $request->shift_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'created_by' => Auth::id(),
            ]);

            return ResponseWithSuccessData($lang, $schedule->load('employee', 'shift.details.timetable'), 1);
        } catch (\Exception $e) {
            Log::error('Error creating employee schedule: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

   
    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'shift_id' => 'required|exists:shifts,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $schedule = EmployeeSchedule::findOrFail($id);
            $schedule->update([
                'employee_id' => $request->employee_id,
                'shift_id' => $request->shift_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'modified_by' => Auth::id(),
            ]);

            return ResponseWithSuccessData($lang, $schedule->load('employee', 'shift.details.timetable'), 1);
        } catch (\Exception $e) {
            Log::error('Error updating employee schedule: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $schedule = EmployeeSchedule::findOrFail($id);
            $schedule->update(['deleted_by' => Auth::id()]);
            $schedule->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting employee schedule: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

   
    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $schedule = EmployeeSchedule::onlyTrashed()->findOrFail($id);
            $schedule->restore();

            return ResponseWithSuccessData($lang, $schedule->load('employee', 'shift.details.timetable'), 1);
        } catch (\Exception $e) {
            Log::error('Error restoring employee schedule: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
