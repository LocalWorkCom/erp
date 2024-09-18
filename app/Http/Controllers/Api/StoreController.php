<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use App\Models\Store;
use App\Models\StoreCategory;

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
                ? Store::withTrashed()->with(['branch', 'creator', 'deleter', 'categories'])->get()
                : Store::with(['branch', 'creator', 'deleter', 'categories'])->get();

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
            $store = Store::withTrashed()->with(['branch', 'creator', 'deleter', 'categories'])->findOrFail($id);
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
    
            // Validate the request
            $request->validate([
                'branch_id' => 'required|integer|exists:branches,id',
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'required|string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'category_ids' => 'required|array', // Validate category IDs
                'category_ids.*' => 'integer|exists:categories,id', // Ensure each category ID is valid
            ]);
    
            // Create the store
            $store = Store::create([
                'branch_id' => $request->branch_id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'is_freeze' => $request->is_freeze ?? 0,
                'created_by' => auth()->id(),
            ]);
    
            // Insert categories into store_category table
            foreach ($request->category_ids as $categoryId) {
                StoreCategory::create([
                    'store_id' => $store->id,
                    'category_id' => $categoryId,
                ]);
            }
    
            return ResponseWithSuccessData($lang, $store, 1);
        } catch (\Exception $e) {
            Log::error('Error creating store: ' . $e->getMessage());
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
    
            // Validate the request
            $request->validate([
                'branch_id' => 'required|integer|exists:branches,id',
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'required|string|max:255',
                'description_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'is_freeze' => 'nullable|boolean',  
                'category_ids' => 'required|array', // Validate category IDs
                'category_ids.*' => 'integer|exists:categories,id', // Ensure each category ID is valid
            ]);
    
            // Find the store
            $store = Store::findOrFail($id);
    
            // Update the store
            $store->update([
                'branch_id' => $request->branch_id,
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'is_freeze' => $request->is_freeze ?? 0,  
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'modified_by' => auth()->id(),
            ]);
    
            // Delete old category relationships
            StoreCategory::where('store_id', $store->id)->delete();
    
            // Insert updated categories into store_category table
            foreach ($request->category_ids as $categoryId) {
                StoreCategory::create([
                    'store_id' => $store->id,
                    'category_id' => $categoryId,
                ]);
            }
    
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
