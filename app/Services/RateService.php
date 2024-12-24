<?php

namespace App\Services;

use App\Http\Resources\OfferResource;
use App\Http\Resources\RateResource;
use App\Models\Branch;
use App\Models\Offer;
use App\Models\OfferDetail;
use App\Models\Rate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RateService
{
    private $lang;

    public function __construct()
    {
        $this->lang = app()->getLocale();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rates = Rate::get();
        return ResponseWithSuccessData($this->lang, RateResource::collection($rates), 1);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request, string $id = null)
    {
        $data = $request->validate([
            'value' => 'required|numeric|in:1,2,3,4,5',
            'note' => 'required|string',
            'active' => 'required|in:0,1',
        ]);
        $id == null ?$data['created_by'] =Auth::guard('api')->user()->id ?? 1
            : $data['modified_by'] =Auth::guard('api')->user()->id ?? 1;

        $rate = Rate::updateOrCreate(['id' => $id], $data);

        return ResponseWithSuccessData($this->lang, RateResource::make($rate), 1);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Rate::find($id);

        if (!$data) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        return ResponseWithSuccessData($this->lang, RateResource::make($data), 1);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Rate::find($id);

        if (!$data) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        $data->deleted_by = Auth::guard('api')->user()->id ?? 1;
        $data->save();
        $data->delete();

        return ResponseWithSuccessData($this->lang, RateResource::make($data), 1);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $data = Rate::withTrashed()->find($id);

        if (!$data) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        $data->restore();
        return ResponseWithSuccessData($this->lang, RateResource::make($data), 1);
    }
}
