<?php

namespace App\Services;

use App\Http\Resources\OfferDetailResource;
use App\Models\Dish;
use App\Models\DishAddon;
use App\Models\OfferDetail;
use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OfferDetailService
{
    private $lang;

    public function __construct(Request $request)
    {
        $this->lang = $request->header('lang', 'ar');

    }

    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $details = OfferDetail::where('offer_id',$id)
            ->with(['dish', 'addon', 'product'])
            ->get();
//        dd($details);
        return ResponseWithSuccessData($this->lang, OfferDetailResource::collection($details), 1);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request, string $id = null)
    {
        $data = $request->validate([
            'offer_id' => 'required|numeric|exists:offers,id',
            'offer_type' => 'required|string|in:dishes,products,addons',
            'type_id' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    $offerType = $request->input('offer_type');
                    switch ($offerType) {
                        case 'products':
                            if (!Product::where('id', $value)->exists()) {
                                $this->lang == 'ar'? $fail('كود المنتج غير موجود')
                                    : $fail('The selected type_id is invalid for products.');
                            }
                            break;

                        case 'dishes':
                            if (!Dish::where('id', $value)->exists()) {
                                $this->lang == 'ar'? $fail('كود الطبق غير موجود')
                                    : $fail('The selected type_id is invalid for dishes.');
                            }
                            break;

                        case 'addons':
                            if (!Recipe::where('type',2)->where('id', $value)->exists()) {
                                $this->lang == 'ar'? $fail('كود الإضافة غير موجود')
                                    : $fail('The selected type_id is invalid for addons.');
                            }
                            break;

                        default:
                            $fail('Invalid offer type provided.');
                    }
                },
            ],
            'count' => 'required|numeric|min:1',
        ]);
        $id == null ?$data['created_by'] =Auth::guard('api')->user()->id??1
            : $data['modified_by'] =Auth::guard('api')->user()->id??1;

        $offer = OfferDetail::updateOrCreate(['id' => $id], $data);

        return ResponseWithSuccessData($this->lang, OfferDetailResource::make($offer), 1);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = OfferDetail::find($id);

        if (!$data) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        return ResponseWithSuccessData($this->lang, OfferDetailResource::make($data), 1);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = OfferDetail::find($id);

        if (!$data) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        $data->deleted_by = Auth::guard('api')->user()->id ?? 1;
        $data->save();
        $data->delete();

        return ResponseWithSuccessData($this->lang, OfferDetailResource::make($data), 1);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $data = OfferDetail::withTrashed()->find($id);

        if (!$data) {
            return RespondWithBadRequestData($this->lang, 2);
        }
        $data->restore();
        return ResponseWithSuccessData($this->lang, OfferDetailResource::make($data), 1);
    }
}
