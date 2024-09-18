<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Shelf;

class ShelfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $withTrashed = $request->query('withTrashed', false); 

            $shelves = $withTrashed
                ? Shelf::withTrashed()->with(['division', 'creator', 'deleter'])->get()
                : Shelf::with(['division', 'creator', 'deleter'])->get();

            return ResponseWithSuccessData($lang, $shelves, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching shelves: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $shelf = Shelf::withTrashed()->with(['division', 'creator', 'deleter'])->findOrFail($id);
            return ResponseWithSuccessData($lang, $shelf, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching shelf: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');

            $request->validate([
                'division_id' => 'required|integer|exists:divisions,id',
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'required|string|max:255',
            ]);

            $lastId = GetLastID('shelves');
            $code = GenerateCode('shelves', $lastId); 

            $shelf = Shelf::create([
                'division_id' => $request->division_id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'code' => $code, 
                'created_by' => auth()->id(), 
            ]);

            return ResponseWithSuccessData($lang, $shelf, 1);
        } catch (\Exception $e) {
            Log::error('Error creating shelf: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

           
            $request->validate([
                'division_id' => 'required|integer|exists:divisions,id',
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'required|string|max:255',
            ]);

           
            $shelf = Shelf::findOrFail($id);

            $shelf->update([
                'division_id' => $request->division_id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'modified_by' => auth()->id(), 
            ]);

            return ResponseWithSuccessData($lang, $shelf, 1);
        } catch (\Exception $e) {
            Log::error('Error updating shelf: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Soft delete the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $shelf = Shelf::findOrFail($id);
            $shelf->update(['deleted_by' => auth()->id()]); 
            $shelf->delete(); 

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting shelf: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Restore a soft-deleted shelf.
     */
    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $shelf = Shelf::withTrashed()->findOrFail($id);
            $shelf->restore();

            return ResponseWithSuccessData($lang, $shelf, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring shelf: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
