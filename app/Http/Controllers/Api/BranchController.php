<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log; 
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $withTrashed = $request->query('withTrashed', false); 

            $branches = $withTrashed
                ? Branch::withTrashed()->with(['country', 'creator', 'deleter'])->get()
                : Branch::with(['country', 'creator', 'deleter'])->get();

            return ResponseWithSuccessData($lang, $branches, 1);
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
             $lang = $request->header('lang', 'en'); 
     
             $request->validate([
                 'name_en' => 'nullable|string|max:255',
                 'name_ar' => 'required|string|max:255',
                 'address_en' => 'nullable|string',
                 'address_ar' => 'nullable|string',
                 'latitute' => 'nullable|string',
                 'longitute' => 'nullable|string',
                 'country_id' => 'required|integer|exists:countries,id',
                 'phone' => 'nullable|string|max:20',
                 'email' => 'nullable|string|email|max:255',
                 'manager_name' => 'nullable|string|max:255',
                 'opening_hours' => 'nullable|string|max:255',
             ]);
     
             $branch = Branch::create([
                 'name_en' => $request->name_en,
                 'name_ar' => $request->name_ar,
                 'address_en' => $request->address_en,
                 'address_ar' => $request->address_ar,
                 'latitute' => $request->latitute,
                 'longitute' => $request->longitute,
                 'country_id' => $request->country_id,
                 'phone' => $request->phone,
                 'email' => $request->email,
                 'manager_name' => $request->manager_name,
                 'opening_hours' => $request->opening_hours,
                 'created_by' => auth()->id() ?? 2, 
             ]);
     
            
             return ResponseWithSuccessData($lang, $branch, 1);
         } catch (\Exception $e) {
            
             Log::error('Error creating branch: ' . $e->getMessage());
             
        
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
            $branch = Branch::with(['country', 'creator', 'deleter'])->findOrFail($id); 
            return ResponseWithSuccessData($lang, $branch, 1); 
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

            // Validate the request
            $request->validate([
                'name_en' => 'nullable|string|max:255',
                'name_ar' => 'required|string|max:255',
                'address_en' => 'nullable|string',
                'address_ar' => 'nullable|string',
                'latitute' => 'nullable|string',
                'longitute' => 'nullable|string',
                'country_id' => 'required|integer|exists:countries,id',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|string|max:255',
                'manager_name' => 'nullable|string|max:255',
                'opening_hours' => 'nullable|string|max:255',
            ]);

            $branch = Branch::findOrFail($id);

            $branch->update([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'address_en' => $request->address_en,
                'address_ar' => $request->address_ar,
                'latitute' => $request->latitute,
                'longitute' => $request->longitute,
                'country_id' => $request->country_id,
                'phone' => $request->phone,
                'email' => $request->email,
                'manager_name' => $request->manager_name,
                'opening_hours' => $request->opening_hours,
                'modified_by' => auth()->id() ?? 2, 
            ]);

            return ResponseWithSuccessData($lang, $branch, 1); 
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2); 
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $branch = Branch::findOrFail($id);
            $branch->delete(); // Soft delete the branch
            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Restore a soft-deleted branch.
     */
    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');

            $branch = Branch::withTrashed()->findOrFail($id);

            $branch->restore();

            return ResponseWithSuccessData($lang, $branch, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring branch: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}