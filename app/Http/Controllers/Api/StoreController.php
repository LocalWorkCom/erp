<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use App\Models\Store;
class StoreController extends Controller
{
     
        public function index(Request $request)
        {
            try {
                $lang = $request->header('lang', 'ar'); 
                $stores = Store::with(['branch', 'creator', 'deleter'])->get(); 
                return ResponseWithSuccessData($lang, $stores, 1); 
            } catch (\Exception $e) {
                return RespondWithBadRequestData($lang, 2); 
            }
        }
    
    
        public function show(Request $request, $id)
        {
            try {
                $lang = $request->header('lang', 'en');
                $store = Store::with(['branch', 'creator', 'deleter'])->findOrFail($id); 
                return ResponseWithSuccessData($lang, $store, 1); 
            } catch (\Exception $e) {
                return RespondWithBadRequestData($lang, 2);
            }
        }
    
    
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
                    'created_by' => 2, 
                ]);
    
                return ResponseWithSuccessData($lang, $store, 1); 
            } catch (\Exception $e) {
                return RespondWithBadRequestData($lang, 2); 
            }
        }
    
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
                    'created_by' => 2,
                    'modified_by' => 2, 
                ]);
    
                return ResponseWithSuccessData($lang, $store, 1); 
            } catch (\Exception $e) {
                return RespondWithBadRequestData($lang, 2); 
            }
        }
    
        public function destroy(Request $request, $id)
        {
            try {
                $lang = $request->header('lang', 'en');
                $store = Store::findOrFail($id);
                $store->delete();
                return ResponseWithSuccessData($lang, null, 1);
            } catch (\Exception $e) {
                return RespondWithBadRequestData($lang, 2);
            }
        }
}
