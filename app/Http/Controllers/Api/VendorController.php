<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    /**
     * Display a listing of the vendors.
     * Optionally include soft deleted records based on the request.
     */
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en'); 
            $withTrashed = $request->query('withTrashed', false); 

            if ($withTrashed) {
                $vendors = Vendor::withTrashed()->with('country')->get();
            } else {
                $vendors = Vendor::with('country')->get(); 
            }

            $vendors = $vendors->map(function ($vendor) use ($lang) {
                return [
                    'id' => $vendor->id,
                    'name' => $lang === 'ar' ? $vendor->name_ar : $vendor->name_en,
                    'contact_person' => $vendor->contact_person,
                    'phone' => $vendor->phone,
                    'email' => $vendor->email,
                    'address' => $lang === 'ar' ? $vendor->address_ar : $vendor->address_en,
                    'country' => $vendor->country->name_ar, 
                    'deleted_at' => $vendor->deleted_at,
                ];
            });

            return ResponseWithSuccessData($lang, $vendors, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching vendors: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Store a newly created vendor in storage.
     */
    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en'); 

         
            $request->validate([
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'required|string|max:255',
                'contact_person' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address_en' => 'nullable|string',
                'address_ar' => 'nullable|string',
                'country_id' => 'required|integer|exists:countries,id',
            ]);

          
            $vendor = Vendor::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'contact_person' => $request->contact_person,
                'phone' => $request->phone,
                'email' => $request->email,
                'address_en' => $request->address_en,
                'address_ar' => $request->address_ar,
                'country_id' => $request->country_id,
                'created_by' => auth()->id() ?? 2, 
            ]);

            return ResponseWithSuccessData($lang, $vendor, 1);
        } catch (\Exception $e) {
            Log::error('Error creating vendor: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Display the specified vendor.
     */
    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $vendor = Vendor::withTrashed()->with('country')->findOrFail($id); 

            // Translate based on language
            $vendorData = [
                'id' => $vendor->id,
                'name' => $lang === 'ar' ? $vendor->name_ar : $vendor->name_en,
                'contact_person' => $vendor->contact_person,
                'phone' => $vendor->phone,
                'email' => $vendor->email,
                'address' => $lang === 'ar' ? $vendor->address_ar : $vendor->address_en,
                'country' => $vendor->country->name_ar, 
                'deleted_at' => $vendor->deleted_at,
            ];

            return ResponseWithSuccessData($lang, $vendorData, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching vendor: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Update the specified vendor in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

            $request->validate([
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'required|string|max:255',
                'contact_person' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address_en' => 'nullable|string',
                'address_ar' => 'nullable|string',
                'country_id' => 'required|integer|exists:countries,id',
            ]);

            $vendor = Vendor::withTrashed()->findOrFail($id);

            $vendor->update([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'contact_person' => $request->contact_person,
                'phone' => $request->phone,
                'email' => $request->email,
                'address_en' => $request->address_en,
                'address_ar' => $request->address_ar,
                'country_id' => $request->country_id,
                'modified_by' => auth()->id() ?? 2, 
            ]);

            return ResponseWithSuccessData($lang, $vendor, 1);
        } catch (\Exception $e) {
            Log::error('Error updating vendor: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Soft delete the specified vendor from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

            $vendor = Vendor::findOrFail($id);
            $vendor->update(['deleted_by' => auth()->id() ?? 2]); 
            $vendor->delete(); 

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting vendor: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Restore a soft deleted vendor.
     */
    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

            $vendor = Vendor::withTrashed()->findOrFail($id);
            $vendor->restore(); 

            return ResponseWithSuccessData($lang, $vendor, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring vendor: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}