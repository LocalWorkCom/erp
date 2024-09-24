<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $coupons = Coupon::all();

            return ResponseWithSuccessData($lang, $coupons, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching coupons: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $coupon = Coupon::findOrFail($id);

            return ResponseWithSuccessData($lang, $coupon, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching coupon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            
            dd($request->all());
    
            $validatedData = $request->validate([
                'code' => 'required|string|unique:coupons,code',
                'type' => 'required|in:percentage,fixed',
                'value' => 'required|numeric|min:0',
                'minimum_spend' => 'nullable|numeric|min:0',
                'usage_limit' => 'nullable|integer|min:1',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_active' => 'required|boolean',
            ]);
    
            dd($validatedData);
    
            $coupon = Coupon::create([
                'code' => $validatedData['code'],
                'type' => $validatedData['type'],
                'value' => $validatedData['value'],
                'minimum_spend' => $validatedData['minimum_spend'],
                'usage_limit' => $validatedData['usage_limit'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'is_active' => $validatedData['is_active'],
                'created_by' => auth()->id(),
            ]);
    
            return ResponseWithSuccessData($lang, $coupon, 1);
        } catch (\Exception $e) {
            Log::error('Error creating coupon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
    
    

    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $request->validate([
                'code' => 'required|string|unique:coupons,code,' . $id,
                'type' => 'required|in:percentage,fixed',
                'value' => 'required|numeric|min:0',
                'minimum_spend' => 'nullable|numeric|min:0',
                'usage_limit' => 'nullable|integer|min:1',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_active' => 'required|boolean',
            ]);

            $coupon = Coupon::findOrFail($id);

            $coupon->update([
                'code' => $request->code,
                'type' => $request->type,
                'value' => $request->value,
                'minimum_spend' => $request->minimum_spend,
                'usage_limit' => $request->usage_limit,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => $request->is_active,
                'modified_by' => auth()->id(),
            ]);

            return ResponseWithSuccessData($lang, $coupon, 1);
        } catch (\Exception $e) {
            Log::error('Error updating coupon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting coupon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $coupon = Coupon::withTrashed()->findOrFail($id);
            $coupon->restore();

            return ResponseWithSuccessData($lang, $coupon, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring coupon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
