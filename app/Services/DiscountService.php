<?php


namespace App\Services;

use App\Models\Discount;
use App\Models\DishDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DiscountService
{
    public function index(Request $request, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        // $sizes = Size::all();
        $discounts = Discount::with(['branches', 'dishes'])->get();


        if (!$checkToken) {
            $discounts = $discounts->makeVisible(['name_en', 'name_ar']);
        }

        return ResponseWithSuccessData($lang, $discounts, 1);
    }

    public function show(Request $request, $id)
    {
        $lang = app()->getLocale();

        try {
            $discount = Discount::with(['branches', 'dishes'])->get();

            return ResponseWithSuccessData($lang, $discount, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching discount: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        $lang = app()->getLocale();

        try {
            // Validation rules
            $validator = Validator::make($request->all(), [
                'name_ar' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        $trimmedValue = trim($value);

                        // Check for active discounts with the same code
                        $activeExists = DB::table('discounts')
                            ->where('name_ar', $trimmedValue)
                            ->where('is_active', 1) // Check only active discounts
                            ->whereNull('deleted_at') // Exclude deleted discounts
                            ->exists();

                        if ($activeExists) {
                            $fail(__('discount.duplicate_active_code'));
                        }
                    },
                ],
                'name_en' => [
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) {
                        $trimmedValue = trim($value);

                        // Check for active discounts with the same code
                        $activeExists = DB::table('discounts')
                            ->where('name_en', $trimmedValue)
                            ->where('is_active', 1) // Check only active discounts
                            ->whereNull('deleted_at') // Exclude deleted discounts
                            ->exists();

                        if ($activeExists) {
                            $fail(__('discount.duplicate_active_code'));
                        }
                    },
                ],
                'type' => 'required|in:percentage,fixed',
                'value' => 'required|numeric|min:0',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_active' => 'required|boolean',
                'branches' => 'nullable|array',
                'branches.*' => 'integer|exists:branches,id',
                'dishes' => 'nullable|array',
                'dishes.*' => 'integer|exists:dishes,id',
            ]);

            // Check for validation failures
            if ($validator->fails()) {
                if ($validator->errors()->has('name_ar')) {
                    $error = $validator->errors()->first('name_ar');
                    if ($error === __('discount.duplicate_active_code')) {
                        return CustomRespondWithBadRequest(__('discount.duplicate_active_code'));
                    }
                    return CustomRespondWithBadRequest(__('discount.code_required'));
                }
                return RespondWithBadRequestData($lang, $validator->errors());
            }

            // Create the discount
            $validatedData = $validator->validated();

            $discount = Discount::create([
                'name_ar' => $validatedData['name_ar'],
                'name_en' => $validatedData['name_en'] ?? null,
                'type' => $validatedData['type'],
                'value' => $validatedData['value'],
                'start_date' => $validatedData['start_date'] ?? null,
                'end_date' => $validatedData['end_date'] ?? null,
                'is_active' => $validatedData['is_active'],
                'created_by' => Auth::guard('admin')->user()->id,
                'count_usage' => 0,
            ]);

            // Attach related branches and dishes
            if (!empty($validatedData['branches'])) {
                $discount->branches()->attach($validatedData['branches']);
            }
            if (!empty($validatedData['dishes'])) {
                $discount->dishes()->attach($validatedData['dishes']);
            }

            return ResponseWithSuccessData($lang, $discount, 1);
        } catch (\Exception $e) {
            Log::error('Error creating discount: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function update(Request $request, $id)
    {
        $lang = app()->getLocale();

        try {
            $discount = Discount::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name_ar' => 'required|string',
                'name_en' => 'nullable|string',
                'type' => 'required|in:percentage,fixed',
                'value' => 'required|numeric|min:0',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_active' => 'required|boolean',
                'branches' => 'nullable|array',
                'branches.*' => 'integer|exists:branches,id',
                'dishes' => 'nullable|array',
                'dishes.*' => 'integer|exists:dishes,id',
            ]);

            if ($validator->fails()) {
                // Return validation errors
                return RespondWithBadRequestData($lang, $validator->errors());
            }

            // Check for active discounts with the same names and type, excluding the current discount
            $existingActiveDiscount = Discount::where(function ($query) use ($request) {
                $query->where('name_ar', $request->name_ar)
                    ->orWhere('name_en', $request->name_en);
            })
                ->where('type', $request->type)
                ->where('is_active', true)
                ->where('id', '!=', $id) // Exclude the current discount
                ->exists();

            if ($existingActiveDiscount) {
                return CustomRespondWithBadRequest(__('discount.duplicate_active_code'));
            }

            // Validation passed, update the discount
            $validatedData = $validator->validated();

            $discount->update([
                'name_ar' => $validatedData['name_ar'],
                'name_en' => $validatedData['name_en'],
                'type' => $validatedData['type'],
                'value' => $validatedData['value'],
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'is_active' => $validatedData['is_active'],
                'modified_by' => Auth::guard('admin')->user()->id,
            ]);

            // Sync related branches and dishes
            if (!empty($validatedData['branches'])) {
                $discount->branches()->sync($validatedData['branches']);
            } else {
                $discount->branches()->detach();
            }

            if (!empty($validatedData['dishes'])) {
                $discount->dishes()->sync($validatedData['dishes']);
            } else {
                $discount->dishes()->detach();
            }

            return ResponseWithSuccessData($lang, $discount, 1);
        } catch (\Exception $e) {
            Log::error('Error updating discount: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }


    public function destroy(Request $request, $id)
    {
        $lang = app()->getLocale();

        try {
            $discount = Discount::findOrFail($id);
            $discount->delete();

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting discount: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        $lang = app()->getLocale();

        try {
            $discount = Discount::withTrashed()->findOrFail($id);
            $discount->restore();

            return ResponseWithSuccessData($lang, $discount, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring discount: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    // product color
    public function listDish($discountId, $checkToken)
    {
        $lang = app()->getLocale();

        $discounts = Discount::with(['discountDishes.dish' => function ($query) {
            $query->select('id', 'name_ar');  // Select only 'id' and 'name_ar' columns from the 'dishes' table
        }])->findOrFail($discountId);
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        return ResponseWithSuccessData($lang, $discounts, 1);
    }

    public function saveDiscountDish(Request $request, $discountId)
    {
        $lang = app()->getLocale();

        // Validate the input
        $validated = $request->validate([
            'discount_dishes.*.dish_id' => 'required|exists:dishes,id',
            'discount_dish_id' => 'nullable|array',
            'discount_dish_id.*' => 'nullable|integer|exists:dish_discount,id',
        ]);

        // Ensure discount_dish_id is always an array, even if not provided
        $discountDishIds = $request->discount_dish_id ?? [];

        // Ensure discount_dishes is always an array, even if not provided
        $discountDishes = $request->discount_dishes ?? [];

        // Fetch current discount dishes
        $existingDiscountDishes = DishDiscount::where('discount_id', $discountId)->get();

        // Collect submitted dish IDs
        $submittedDishIds = collect($discountDishes)->pluck('dish_id')->toArray();

        // Check for duplicates among submitted dishes
        if (count($submittedDishIds) !== count(array_unique($submittedDishIds))) {
            return CustomRespondWithBadRequest(__('discount.Duplicate dishes are submitted.'));
        }

        // Delete dishes that are not in the submitted discount_dish_ids
        foreach ($existingDiscountDishes as $existingDish) {
            if (!in_array($existingDish->id, $discountDishIds)) {
                $existingDish->delete();
            }
        }

        // Save or update dishes
        foreach ($discountDishes as $index => $discountDish) {
            $dishId = (int) $discountDish['dish_id'];
            $discountDishId = $discountDishIds[$index] ?? null;

            // Check if the same dish already exists for this discount
            $existingDish = DishDiscount::where('discount_id', $discountId)
                ->where('dish_id', $dishId)
                ->where('id', '!=', $discountDishId)
                ->exists();

            if ($existingDish) {
                return CustomRespondWithBadRequest(
                    'The dish with ID ' . $dishId . ' already exists for this discount.'
                );
            }

            if ($discountDishId) {
                // Update existing dish
                DishDiscount::updateOrCreate(
                    ['id' => $discountDishId],
                    ['dish_id' => $dishId, 'discount_id' => $discountId]
                );
            } else {
                // Create new dish
                DishDiscount::create([
                    'dish_id' => $dishId,
                    'discount_id' => $discountId,
                    'created_by' => Auth::guard('admin')->id(),
                ]);
            }
        }

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
