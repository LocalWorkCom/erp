<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use App\Models\Store;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $withTrashed = $request->query('withTrashed', false); 

            $stores = $withTrashed
                ? Store::withTrashed()->with(['branch', 'creator', 'deleter'])->get()
                : Store::with(['branch', 'creator', 'deleter'])->get();

            return ResponseWithSuccessData($lang, $stores, 1);
        } catch (\Exception $e) {
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
            $store = Store::withTrashed()->with(['branch', 'creator', 'deleter'])->findOrFail($id);
            return ResponseWithSuccessData($lang, $store, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');

            $request->validate([
                'branch_id' => 'required|integer|exists:branches,id',
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'required|string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
            ]);

            $store = Store::create([
                'branch_id' => $request->branch_id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'created_by' => auth()->id() ?? 2,  
            ]);

            return ResponseWithSuccessData($lang, $store, 1);
        } catch (\Exception $e) {
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
                'branch_id' => 'required|integer|exists:branches,id',
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'required|string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
            ]);

            $store = Store::findOrFail($id);

            $store->update([
                'branch_id' => $request->branch_id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'modified_by' => auth()->id() ?? 2,  
            ]);

            return ResponseWithSuccessData($lang, $store, 1);
        } catch (\Exception $e) {
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
            $store = Store::findOrFail($id);
            $store->update(['deleted_by' => auth()->id()]); 
            $store->delete(); 
            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Restore a soft-deleted store.
     */
    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $store = Store::withTrashed()->findOrFail($id);
            $store->restore();

            return ResponseWithSuccessData($lang, $store, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}