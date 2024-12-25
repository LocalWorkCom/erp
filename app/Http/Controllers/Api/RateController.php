<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RateResource;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
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
        $rates = Rate::where('active',1)->get();
        return ResponseWithSuccessData($this->lang, RateResource::collection($rates), 1);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request, string $id = null)
    {
        $data = $request->validate([
            'value' => 'required|numeric|in:1,2,3,4,5',
            'note' => 'nullable|string',
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
        $data = Rate::where('active',1)->find($id);

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
