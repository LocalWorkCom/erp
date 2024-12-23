<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Branch;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $coupons = Coupon::with('branches')->get();

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
            $coupon = Coupon::with('branches')->findOrFail($id);

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

            $validatedData = $request->validate([
                'code' => 'required|string|unique:coupons,code',
                'type' => 'required|in:percentage,fixed',
                'value' => 'required|numeric|min:0',
                'minimum_spend' => 'nullable|numeric|min:0',
                'usage_limit' => 'nullable|integer|min:1',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_active' => 'required|boolean',
                'branches' => 'nullable|array',
                'branches.*' => 'integer|exists:branches,id',
            ]);

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
                'count_usage' => 0,
            ]);

            if (!empty($validatedData['branches'])) {
                $coupon->branches()->attach($validatedData['branches']);
            }

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
            $validatedData = $request->validate([
                'code' => 'required|string|unique:coupons,code,' . $id,
                'type' => 'required|in:percentage,fixed',
                'value' => 'required|numeric|min:0',
                'minimum_spend' => 'nullable|numeric|min:0',
                'usage_limit' => 'nullable|integer|min:1',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_active' => 'required|boolean',
                'branches' => 'nullable|array',
                'branches.*' => 'integer|exists:branches,id',
            ]);

            $coupon = Coupon::findOrFail($id);

            $coupon->update([
                'code' => $validatedData['code'],
                'type' => $validatedData['type'],
                'value' => $validatedData['value'],
                'minimum_spend' => $validatedData['minimum_spend'],
                'usage_limit' => $validatedData['usage_limit'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'is_active' => $validatedData['is_active'],
                'modified_by' => auth()->id(),
            ]);

            if (!empty($validatedData['branches'])) {
                $coupon->branches()->sync($validatedData['branches']);
            } else {
                $coupon->branches()->detach();
            }

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

    /**
     * Increment usage of the coupon.
     */
    public function incrementUsage($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);

            // Check if coupon has a usage limit and if it's reached
            if ($coupon->usage_limit && $coupon->count_usage >= $coupon->usage_limit) {
                return response()->json([
                    'success' => false,
                    'message' => 'Coupon usage limit reached.',
                ], 400);
            }

            // Increment the count_usage
            $coupon->increment('count_usage');

            return response()->json([
                'success' => true,
                'message' => 'Coupon usage incremented successfully.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error incrementing coupon usage: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error incrementing coupon usage.',
            ], 500);
        }
    }

    /**
     * Check if the coupon is still valid based on usage and date.
     */
    public function isCouponValid(Request $request)
    {
        $code = $request->code;
        $amount = $request->amount;
        try {
            $lang = $request->header('lang', 'en');
            // $branchId = $request->input('branch_id');  

            $coupon = GetCouponId($code);
            if ($coupon) {
                $valid = CheckCouponValid($coupon->id, $amount);
                if ($valid) {

                    $amount_after_coupon =  applyCoupon($amount, $coupon);
                    return response()->json([
                        'success' => true,
                        'message' => 'Coupon is valid.',
                        'data' => $amount_after_coupon
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Coupon is no longer valid.',
                    ], 200);
                }
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Coupon is valid.',
                ]);
            }

          

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking coupon validity.',
            ], 500);
        }
    }
}
