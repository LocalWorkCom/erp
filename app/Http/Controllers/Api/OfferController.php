<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    private $lang;

    public function __construct(Request $request)
    {
        $this->lang = $request->header('lang', 'ar');
        if (!CheckToken()) {
            return RespondWithBadRequest($this->lang, 5);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::with('details')->get();
        return ResponseWithSuccessData($this->lang, OfferResource::collection($offers), 1);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request, string $id = null)
    {
        $data = $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image_ar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_en' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'required|in:0,1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        if ($request->hasFile('image_ar')) {
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
}
