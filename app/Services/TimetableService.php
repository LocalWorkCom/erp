<?php
namespace App\Services;

use App\Models\EmployeeSchedule;
use App\Models\ShiftDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TimetableService
{
    public static function getTimetableForDate($employeeId, $date)
    {
        try {
            $date = Carbon::parse($date);
            $dayIndex = $date->dayOfWeek;

            $schedule = EmployeeSchedule::where('employee_id', $employeeId)
                ->where('start_date', '<=', $date)
                ->where('end_date', '>=', $date)
                ->first();

            if (!$schedule) {
                return ['status' => false, 'message' => 'No schedule found for the given date.'];
            }

            $shiftDetail = ShiftDetail::where('shift_id', $schedule->shift_id)
                ->where('day_index', $dayIndex)
                ->with('timetable')
                ->first();

            if (!$shiftDetail || !$shiftDetail->timetable) {
                return ['status' => false, 'message' => 'No timetable found for the given day.'];
            }

            return [
                'status' => true,
                'data' => [
                    'timetable' => $shiftDetail->timetable,
                    'cross_day' => $shiftDetail->timetable->cross_day,
                    'on_duty_time' => $shiftDetail->timetable->on_duty_time,
                    'off_duty_time' => $shiftDetail->timetable->off_duty_time,
                    'start_sign_in' => $shiftDetail->timetable->start_sign_in,
                    'end_sign_in' => $shiftDetail->timetable->end_sign_in,
                    'start_sign_out' => $shiftDetail->timetable->start_sign_out,
                    'end_sign_out' => $shiftDetail->timetable->end_sign_out,
                    'lateness_grace_period' => $shiftDetail->timetable->lateness_grace_period,
                    'start_late_time_option' => $shiftDetail->timetable->start_late_time_option,
                ],
            ];
        } catch (\Exception $e) {
            Log::error("Error retrieving timetable for employee $employeeId on date $date: " . $e->getMessage());
            return ['status' => false, 'message' => 'Error retrieving timetable data.'];
        }
    }
}
