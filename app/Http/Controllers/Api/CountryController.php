<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\User;
use App\Services\CountryService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    protected $countryService;
    protected $checkToken;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
        $this->checkToken = false;
    }

    public function index(Request $request)
    {
        $lang = $request->header('lang', 'ar');

        $response = $this->countryService->index($request, $this->checkToken);

        $responseData = $response->original;

        $countries = $responseData['data'];
        $countries = $countries->map(function ($country) use ($lang) {
            return [
                'id' => $country->id,
                'name' => $lang == 'en' ? $country->name_en : $country->name_ar,
                'phone_code' => $country->phone_code,
                'currency' => $lang == 'en' ? $country->currency_en : $country->currency_ar,
            ];
        });

        return ResponseWithSuccessData($lang, $countries, 1);
    }
    public function getCountriesRegister(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');

            $response = $this->countryService->index($request, $this->checkToken);

            $responseData = $response->original;

            $countries = $responseData['data'];
            $countries = $countries->map(function ($country) use ($lang) {
                return [
                    'id' => $country->id ,
                    'image' => $country->flag ?? null,
                    'phone_code' => $country->phone_code,
                    'length' =>  $country->length ?? 10,
                ];
            });

            return ResponseWithSuccessData($lang, $countries, 1);

        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }


    // public function store(Request $request)
    // {
    //     try {
    //         $lang = $request->header('lang', 'ar');
    //         App::setLocale($lang);
    //         if (!CheckToken()) {
    //             return RespondWithBadRequest($lang, 5);
    //         }
    //         $validator = Validator::make($request->all(), [
    //             "name_ar" => "required",
    //             "name_en" => "required",
    //             'currency_ar' => 'required',
    //             'currency_en' => 'required',
    //             'currency_code' => 'required',
    //             'code' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             return RespondWithBadRequestWithData($validator->errors());
    //         }

    //         $size = new Country();
    //         $size->name_ar = $request->name_ar;
    //         $size->name_en = $request->name_en;
    //         $size->currency_ar = $request->currency_ar;
    //         $size->currency_en = $request->currency_en;
    //         $size->code = $request->code;
    //         $size->currency_code = $request->currency_code;
    //         $size->created_by = auth()->id();
    //         $size->save();

    //         return ResponseWithSuccessData($lang, $size, 1);
    //     } catch (\Exception $e) {
    //         return RespondWithBadRequestData($lang, 2);
    //     }
    // }

    // public function update(Request $request)
    // {
    //     try {
    //         $lang = $request->header('lang', 'ar');
    //         if (!CheckToken()) {
    //             return RespondWithBadRequest($lang, 5);
    //         }
    //         App::setLocale($lang);

    //         $validator = Validator::make($request->all(), [
    //             "name_ar" => "required",
    //             "name_en" => "required",
    //             'currency_ar' => 'required',
    //             'currency_en' => 'required',
    //             'currency_code' => 'required',
    //             'code' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             return RespondWithBadRequestWithData($validator->errors());

    //         }

    //         $size = Country::findOrFail($request->input('id'));
    //         $size->name_ar = $request->name_ar;
    //         $size->name_en = $request->name_en;
    //         $size->currency_ar = $request->currency_ar;
    //         $size->currency_en = $request->currency_en;
    //         $size->code = $request->code;
    //         $size->currency_code = $request->currency_code;
    //         $size->modified_by = auth()->id();
    //         $size->save();

    //         return ResponseWithSuccessData($lang, $size, 1);
    //     } catch (\Exception $e) {
    //         return RespondWithBadRequestData($lang, 2);
    //     }
    // }

    // public function destroy(Request $request)
    // {
    //     try {
    //         $lang = $request->header('lang', 'ar');
    //         if (!CheckToken()) {
    //             return RespondWithBadRequest($lang, 5);
    //         }
    //         $size = Country::findOrFail($request->input('id'));
    //         $is_allow = Branch::where('country_id', $request->input('id'))->first();
    //         $is_allow2 = User::where('country_id', $request->input('id'))->first();

    //         if ($is_allow || $is_allow2) {
    //             return RespondWithBadRequestData($lang, 5);
    //         } else {
    //             $size->deleted_by = auth()->id();
    //             $size->deleted_at = Carbon::now();
    //             $size->save();

    //             return ResponseWithSuccessData($lang, $size, 1);
    //         }
    //     } catch (\Exception $e) {
    //         return RespondWithBadRequestData($lang, 2);
    //     }
    // }
}
