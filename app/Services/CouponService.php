<?php


namespace App\Services;

use App\Models\Unit;
use App\Models\Floor;
use App\Models\Coupon;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CouponService
{


    public function index(Request $request, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        // $sizes = Size::all();
        $coupons = Coupon::with('branches')->get();


        // if (!$checkToken) {
        //     $coupons = $coupons->makeVisible(['name_en', 'name_ar']);
        // }
        return ResponseWithSuccessData($lang, $coupons, 1);
    }

    public function show(Request $request, $id, $lang)
    {
        try {
            $coupon = Coupon::with('branches')->findOrFail($id);

            return ResponseWithSuccessData($lang, $coupon, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching coupon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request, $lang)
    {

        try {
            // Define the validation rules
            $validator = Validator::make($request->all(), [
                'code' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        $trimmedValue = trim($value);
                        // Check only for active (non-deleted) coupon codes
                        $exists = DB::table('coupons')
                            ->where('code', $trimmedValue)
                            ->whereNull('deleted_at')
                            ->exists();

                        if ($exists) {
                            // dd(0)
                            $fail(__('coupon.duplicate_code'));
                        }
                    },
                ],
                'type' => 'required|in:percentage,fixed',
                'value' => 'required|numeric|min:0',
                'minimum_spend' => 'nullable|numeric|min:0',
                'usage_limit' => 'nullable|integer|min:1',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_active' => 'required|boolean',
                'branches' => 'nullable|array',
                'branches.*' => 'integer|exists:branches,id',
            ], [
                'code.required' => __('coupon.code_required'), // Use custom message for 'required'
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                if ($validator->errors()->has('code')) {
                    // Get the first error for 'code'
                    $error = $validator->errors()->first('code');
                    // dd($error);
                    // Check if the error is for duplication
                    if ($error === __('coupon.duplicate_code')) {
                        // dd('dd');
                        return CustomRespondWithBadRequest(__('coupon.duplicate_code'));
                    }
                    // dd('00');
                    // Otherwise, handle generic code error
                    return CustomRespondWithBadRequest(__('coupon.code_required'));
                }

                // Handle other validation errors
                return RespondWithBadRequestData($lang, $validator->errors());
            }



            // Validation passed, proceed to create the coupon
            $validatedData = $validator->validated();

            // No need to check again for code uniqueness here, as it is handled in the validator

            $coupon = Coupon::create([
                'code' => $validatedData['code'],
                'type' => $validatedData['type'],
                'value' => $validatedData['value'],
                'minimum_spend' => $validatedData['minimum_spend'],
                'usage_limit' => $validatedData['usage_limit'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'is_active' => $validatedData['is_active'],
                'created_by' => Auth::guard('admin')->user()->id,
                'count_usage' => 0,
            ]);

            if (!empty($validatedData['branches'])) {
                $coupon->branches()->attach($validatedData['branches']);
            }
            // dd($lang);
            return ResponseWithSuccessData($lang, $coupon, 1);
        } catch (\Exception $e) {
            Log::error('Error creating coupon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function update(Request $request, $id, $lang)
    {
        try {
            $coupon = Coupon::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'code' => [
                    'required',
                    'string',
                    Rule::unique('coupons', 'code')
                        ->ignore($id) // Ignore the current record
                        ->where(function ($query) {
                            return $query->whereNull('deleted_at'); // Ignore soft-deleted records
                        }),
                ],
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

            if ($validator->fails()) {
                // Check for unique code error specifically
                if ($validator->errors()->has('code')) {
                    return CustomRespondWithBadRequest('Duplicate code is submitted.');
                }

                // Return other validation errors
                return RespondWithBadRequestData($lang, $validator->errors());
            }

            // Validation passed, update the coupon
            $validatedData = $validator->validated();

            $coupon->update([
                'code' => $validatedData['code'],
                'type' => $validatedData['type'],
                'value' => $validatedData['value'],
                'minimum_spend' => $validatedData['minimum_spend'],
                'usage_limit' => $validatedData['usage_limit'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'is_active' => $validatedData['is_active'],
                'modified_by' => Auth::guard('admin')->user()->id,
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


    public function destroy(Request $request, $id, $lang)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting coupon: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id, $lang)
    {
        try {
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
    public function isCouponValid(Request $request, $id)
    {
        try {
            $branchId = $request->input('branch_id');

            $coupon = Coupon::with('branches')->findOrFail($id); // Load the coupon with its branches

            // Check if the coupon has expired or is fully used
            if (!$coupon->is_active || ($coupon->usage_limit && $coupon->count_usage >= $coupon->usage_limit)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Coupon is no longer valid.',
                ], 400);
            }

            if ($branchId) {
                $validBranches = $coupon->branches->pluck('id')->toArray();

                if (!in_array($branchId, $validBranches)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Coupon is not valid for this branch.',
                    ], 400);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Coupon is valid.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error checking coupon validity: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error checking coupon validity.',
            ], 500);
        }
    }
}
