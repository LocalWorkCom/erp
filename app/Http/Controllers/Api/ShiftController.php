<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\ShiftDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
  
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $shifts = Shift::with('details.timetable')->get();
            return ResponseWithSuccessData($lang, $shifts, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching shifts: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $shift = Shift::with('details.timetable')->findOrFail($id);
            return ResponseWithSuccessData($lang, $shift, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching shift: ' . $e->getMessage());
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
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'details' => 'required|array',
                'details.*.day_index' => 'required|integer|min:0|max:6',
                'details.*.timetable_id' => 'required|exists:timetables,id',
            ]);

            $shift = Shift::create([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'created_by' => Auth::id(),
            ]);

            foreach ($request->details as $detail) {
                ShiftDetail::create([
                    'shift_id' => $shift->id,
                    'day_index' => $detail['day_index'],
                    'timetable_id' => $detail['timetable_id'],
                    'created_by' => Auth::id(),
                ]);
            }

            return ResponseWithSuccessData($lang, $shift->load('details.timetable'), 1);
        } catch (\Exception $e) {
            Log::error('Error creating shift: ' . $e->getMessage());
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
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'details' => 'required|array',
                'details.*.day_index' => 'required|integer|min:0|max:6',
                'details.*.timetable_id' => 'required|exists:timetables,id',
            ]);

            $shift = Shift::findOrFail($id);
            $shift->update([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'modified_by' => Auth::id(),
            ]);

            $shift->details()->delete();
            foreach ($request->details as $detail) {
                ShiftDetail::create([
                    'shift_id' => $shift->id,
                    'day_index' => $detail['day_index'],
                    'timetable_id' => $detail['timetable_id'],
                    'created_by' => Auth::id(),
                ]);
            }

            return ResponseWithSuccessData($lang, $shift->load('details.timetable'), 1);
        } catch (\Exception $e) {
            Log::error('Error updating shift: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $shift = Shift::findOrFail($id);
            $shift->update(['deleted_by' => Auth::id()]);
            $shift->delete();

            return ResponseWithSuccessData($lang, null, 'Shift deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting shift: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

 
    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $shift = Shift::onlyTrashed()->findOrFail($id);
            $shift->restore();

            return ResponseWithSuccessData($lang, $shift->load('details.timetable'), 'Shift restored successfully.');
        } catch (\Exception $e) {
            Log::error('Error restoring shift: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
