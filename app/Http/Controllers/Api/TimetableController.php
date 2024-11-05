<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Timetable;
use Illuminate\Support\Facades\Log;

class TimetableController extends Controller
{
  
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $timetables = Timetable::all();
            return ResponseWithSuccessData($lang, $timetables, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching timetables: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

 
    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');

            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'on_duty_time' => 'required|date_format:H:i',
                'off_duty_time' => 'required|date_format:H:i',
                'start_sign_in' => 'required|date_format:H:i',
                'end_sign_in' => 'required|date_format:H:i',
                'start_sign_out' => 'required|date_format:H:i',
                'end_sign_out' => 'required|date_format:H:i',
                'lateness_grace_period' => 'required|integer|min:0',
                'start_late_time_option' => 'required|in:after_duty_time_grace_period,after_duty_time,from_duty_time',
            ]);

            $timetable = Timetable::create(array_merge($request->all(), [
                'created_by' => auth()->id()
            ]));

            return ResponseWithSuccessData($lang, $timetable, 1);
        } catch (\Exception $e) {
            Log::error('Error creating timetable: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $timetable = Timetable::findOrFail($id);
            return ResponseWithSuccessData($lang, $timetable, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching timetable: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

            $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'on_duty_time' => 'required|date_format:H:i',
                'off_duty_time' => 'required|date_format:H:i',
                'start_sign_in' => 'required|date_format:H:i',
                'end_sign_in' => 'required|date_format:H:i',
                'start_sign_out' => 'required|date_format:H:i',
                'end_sign_out' => 'required|date_format:H:i',
                'lateness_grace_period' => 'required|integer|min:0',
                'start_late_time_option' => 'required|in:after_duty_time_grace_period,after_duty_time,from_duty_time',
            ]);

            $timetable = Timetable::findOrFail($id);
            $timetable->update(array_merge($request->all(), [
                'modified_by' => auth()->id()
            ]));

            return ResponseWithSuccessData($lang, $timetable, 1);
        } catch (\Exception $e) {
            Log::error('Error updating timetable: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $timetable = Timetable::findOrFail($id);
    
            Log::info('Deleting timetable', ['id' => $timetable->id, 'name' => $timetable->name]);
    
            $timetable->update(['deleted_by' => auth()->id()]);
    
            $timetable->delete();
    
            return ResponseWithSuccessData($lang, null, 'Timetable deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting timetable: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
    

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $timetable = Timetable::onlyTrashed()->findOrFail($id);
    
            $timetable->restore();
    
            Log::info('Timetable restored', ['id' => $timetable->id]);
    
            return ResponseWithSuccessData($lang, $timetable, 'Timetable restored successfully.');
        } catch (\Exception $e) {
            Log::error('Error restoring timetable: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
    
}
