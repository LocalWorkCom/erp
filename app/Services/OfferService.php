<?php

namespace App\Services;

use App\Http\Resources\OfferResource;
use App\Models\Offer;
use App\Models\OfferDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OfferService
{
    private $lang;

    public function __construct(Request $request)
    {
        $this->lang = $request->header('lang', 'ar');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::with('details')->where('is_active',1)->get();
        return ResponseWithSuccessData($this->lang, OfferResource::collection($offers), 1);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request, string $id = null)
    {
//        dd($request->all());
        $data = $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image_ar' => 'nullable|max:2048',
            'image_en' => 'nullable|max:2048',
            'is_active' => 'required|in:0,1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        if ($request->hasFile('image_ar')) {
//            dd(true);
            $file = $request->file('image_ar');
            $newFileName = 'image_ar_' . rand(1, 999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/offers/ar'), $newFileName);
            $data['image_ar'] = 'images/offers/ar/' . $newFileName;
        }

        if ($request->hasFile('image_en')) {
            $file = $request->file('image_en');
            $newFileName = 'image_en_' . rand(1, 999999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/offers/en'), $newFileName);
            $data['image_en'] = 'images/offers/en/' . $newFileName;
        }
        $id == null ?$data['created_by'] =Auth::guard('api')->user()->id??1
            : $data['modified_by'] =Auth::guard('api')->user()->id??1;

        $offer = Offer::updateOrCreate(['id' => $id], $data);

        return ResponseWithSuccessData($this->lang, OfferResource::make($offer), 1);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Offer::find($id);

        if (!$data) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        return ResponseWithSuccessData($this->lang, OfferResource::make($data), 1);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Offer::find($id);

        if (!$data) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        $data->deleted_by = Auth::guard('api')->user()->id ?? 1;
        $data->save();
        $data->delete();

        return ResponseWithSuccessData($this->lang, OfferResource::make($data), 1);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $data = Offer::withTrashed()->find($id);

        if (!$data) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        $data->restore();
        return ResponseWithSuccessData($this->lang, OfferResource::make($data), 1);
    }

    public function listDetail($offerId)
    {
        $offers = Offer::with(['offerDetails.detail' => function ($query) {
            $query->select('id', 'name_ar');
        }])->findOrFail($offerId);

        return ResponseWithSuccessData($this->lang, $offers, 1);
    }
    public function saveOfferDetails(Request $request, $offerId)
    {
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
        return RespondWithSuccessRequest($this->lang, 1);
    }
}
