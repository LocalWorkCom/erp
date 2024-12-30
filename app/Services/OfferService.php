<?php

namespace App\Services;

use App\Http\Resources\OfferResource;
use App\Models\Branch;
use App\Models\Offer;
use App\Models\OfferDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OfferService
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lang = app()->getLocale();
        $offers = Offer::with('details')->get();
        return ResponseWithSuccessData($lang, OfferResource::collection($offers), 1);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request, $id = null)
    {
        $lang = app()->getLocale();

        $messages = [];

        if (app()->getLocale() == 'ar') {
            $messages = [
                'branches.required_if' => 'حقل الفروع مطلوب عند تحديد "اختر" في اختيار الفرع.',
                'branches.*.exists' => 'الفرع المحدد غير موجود.',
                'end_date.after_or_equal' => 'يجب أن يكون تاريخ الانتهاء بعد أو يساوي تاريخ البدء.',
            ];
        } else {
            $messages = [
                'branches.required_if' => 'The branches field is required when the branch selection is specific.',
                'branches.*.exists' => 'The selected branch does not exist.',
                'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            ];
        }
        $data = $request->validate([
            'branch_selection' => 'required|in:all,specific',
            'branches' => 'required_if:branch_selection,specific|array',
            'branches.*' => 'exists:branches,id',
            'name_ar' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request, $id) {
                    $exists = Offer::where('name_ar', $value)
                        ->where('is_active', 1)
                        ->where('start_date', '<=', $request->end_date)
                        ->where('end_date', '>=', $request->start_date)
                        ->when($id, function ($query) use ($id) {
                            $query->where('id', '!=', $id); // Exclude current record in case of update
                        })
                        ->exists();

                    if ($exists) {
                        $fail(__('validation.unique_within_duration', ['attribute' => __('validation.attributes.name_ar')]));
                    }
                },
            ],
            'name_en' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request, $id) {
                    $exists = Offer::where('name_en', $value)
                        ->where('is_active', 1)
                        ->where('start_date', '<=', $request->end_date)
                        ->where('end_date', '>=', $request->start_date)
                        ->when($id, function ($query) use ($id) {
                            $query->where('id', '!=', $id); // Exclude current record in case of update
                        })
                        ->exists();

                    if ($exists) {
                        $fail(__('validation.unique_within_duration', ['attribute' => __('validation.attributes.name_en')]));
                    }
                },
            ],
            'discount_type' => 'required|string|in:fixed,percentage',
            'discount_value' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percentage' && $value > 100) {
                        $fail(__('validation.discount_exceeds_100'));
                    }
                },
            ],
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'image_ar' => 'nullable|max:2048',
            'image_en' => 'nullable|max:2048',
            'is_active' => [
                'required',
                'in:0,1',
                function ($attribute, $value, $fail) use ($request, $id) {
                    if ($value == 1) { // Only check if activating the offer
                        $exists = Offer::where(function ($query) use ($request, $id) {
                            $query->where('name_ar', $request->name_ar)
                                ->orWhere('name_en', $request->name_en);
                        })
                            ->where('is_active', 1)
                            ->when($id, function ($query) use ($id) {
                                $query->where('id', '!=', $id); // Exclude current record in case of update
                            })
                            ->exists();

                        if ($exists) {
                            $fail(__('validation.active_offer_conflict'));
                        }
                    }
                },
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], $messages);

        // Handle Arabic image upload
        if ($request->hasFile('image_ar')) {
            $file = $request->file('image_ar');
            $newFileName = 'image_ar_' . rand(1, 999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/offers/ar'), $newFileName);
            $data['image_ar'] = url('images/offers/ar/' . $newFileName);
        }

        // Handle English image upload
        if ($request->hasFile('image_en')) {
            $file = $request->file('image_en');
            $newFileName = 'image_en_' . rand(1, 999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/offers/en'), $newFileName);

            // Generate the full URL for the image
            $data['image_en'] = url('images/offers/en/' . $newFileName);
        }

        // Determine created_by or modified_by
        $id === null
            ? $data['created_by'] = Auth::guard('api')->user()->id ?? 1
            : $data['modified_by'] = Auth::guard('api')->user()->id ?? 1;

        // Handle branch logic
        if ($request->branch_selection === 'all') {
            // Save branch_id as -1 for all branches
            $data['branch_id'] = '-1';
        } else {
            // Save branch IDs as a comma-separated string
            $data['branch_id'] = implode(',', $request->branches);
        }

        // Save the offer
        $offer = Offer::updateOrCreate(['id' => $id], $data);

        return ResponseWithSuccessData($lang, OfferResource::make($offer), 1);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lang = app()->getLocale();

        $offer = Offer::find($id);

        if (!$offer) {
            return RespondWithBadRequestData($lang, 2);
        }

        // Retrieve branches from the `branches` table using the comma-separated `branch_id`
        $branchIds = explode(',', $offer->branch_id); // Assuming branch_id is stored as a comma-separated string
        $branches = Branch::whereIn('id', $branchIds)->get();

        return ResponseWithSuccessData($lang, [
            'offer' => $offer,
            'branches' => $branches
        ], 1);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lang = app()->getLocale();

        $data = Offer::find($id);

        if (!$data) {
            return RespondWithBadRequestData($lang, 2);
        }
        $data->deleted_by = Auth::guard('api')->user()->id ?? 1;
        $data->save();
        $data->delete();

        return ResponseWithSuccessData($lang, OfferResource::make($data), 1);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $lang = app()->getLocale();

        $data = Offer::withTrashed()->find($id);

        if (!$data) {
            return RespondWithBadRequestData($lang, 2);
        }
        $data->restore();
        return ResponseWithSuccessData($lang, OfferResource::make($data), 1);
    }

    public function listDetail($offerId)
    {
        $lang = app()->getLocale();

        $offers = Offer::with(['offerDetails.detail' => function ($query) {
            $query->select('id', 'name_ar');
        }])->findOrFail($offerId);

        return ResponseWithSuccessData($lang, $offers, 1);
    }
    public function saveOfferDetails(Request $request, $offerId)
    {
        $lang = app()->getLocale();

        // Validate the input
        $validated = $request->validate([
            'details.*.detail_id' => 'required|exists:details,id',
            'offer_detail_id' => 'nullable|array',
            'offer_detail_id.*' => 'nullable|integer|exists:offer_details,id',
        ]);

        // Ensure offer_detail_id is always an array, even if not provided
        $offerDetailIds = $request->offer_detail_id ?? [];

        // Ensure details is always an array, even if not provided
        $details = $request->details ?? [];

        // Fetch current offer details
        $offerDetails = OfferDetail::where('offer_id', $offerId)->get();

        // Collect submitted detail IDs
        $submittedDetailIds = collect($details)->pluck('detail_id')->toArray();

        // Check for duplicates among submitted details
        if (count($submittedDetailIds) !== count(array_unique($submittedDetailIds))) {
            return CustomRespondWithBadRequest('Duplicate details are submitted.');
        }

        // Delete details that are not in the submitted offer_detail_ids
        foreach ($offerDetails as $detail) {
            if (!in_array($detail->id, $offerDetailIds)) {
                $detail->delete();
            }
        }

        // Save or update details
        foreach ($details as $index => $detail) {
            $detailId = (int) $detail['detail_id'];  // Ensure detail_id is an integer
            $offerDetailId = isset($offerDetailIds[$index]) ? $offerDetailIds[$index] : null;

            // Check if the same detail already exists for this offer
            $existingDetail = OfferDetail::where('offer_id', $offerId)
                ->where('detail_id', $detailId)
                ->where('id', '!=', $offerDetailId) // Exclude the current detail being updated
                ->exists();

            if ($existingDetail) {
                return CustomRespondWithBadRequest(
                    'The detail with ID ' . $detailId . ' already exists for this offer.'
                );
            }

            if ($offerDetailId) {
                // Update existing detail
                OfferDetail::updateOrCreate(
                    ['id' => $offerDetailId],
                    ['detail_id' => $detailId, 'offer_id' => $offerId]
                );
            } else {
                // Create new detail
                OfferDetail::create([
                    'detail_id' => $detailId,
                    'offer_id' => $offerId,
                    'created_by' => Auth::guard('admin')->user()->id,
                ]);
            }
        }

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
