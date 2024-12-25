<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Product;
use App\Models\ProductLimit;
use App\Models\ProductImage;
use App\Models\ProductTransaction;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductUnit;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CountryService
{

    public function index(Request $request, $checkToken)
    {

        $lang = $request->header('lang', 'ar');
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $counties = Country::whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

        if (!$checkToken) {
            $counties = $counties->makeVisible(['name_en', 'name_ar', 'image', 'description_ar', 'description_en']);
        }

        return ResponseWithSuccessData($lang, $counties, 1);
    }
    public function store(Request $request, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $validator = Validator::make($request->all(), [
            "name_ar" => "required",
            "name_en" => "required",
            'currency_ar' => 'required',
            'currency_en' => 'required',
            'currency_code' => 'required',
            'code' => 'required',
            'phone_code' => 'required',
            'length' => 'required',
            'flag' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);
        // if($request->type == 1 && $validator->fails()){
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }else
        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        $lang = $request->header('lang', 'ar');

        $counties = new Country();
        $counties->name_ar = $request->name_ar;
        $counties->name_en = $request->name_en;
        $counties->currency_ar = $request->currency_ar;
        $counties->currency_en = $request->currency_en;
        $counties->code = $request->code;
        $counties->currency_code = $request->currency_code;
        $counties->phone_code = $request->phone_code;
        $counties->length = $request->length;
        $counties->created_by = auth()->id() ?? 1;
        $counties->save();
        if ($request->hasFile('flag')) {
            $image = $request->file('flag');
            UploadFile('images/countries', 'flag', $counties, $image);
        }
        return RespondWithSuccessRequest($lang, 1);
    }
    public function update(Request $request, $id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        // Validate the input
        $validator = Validator::make($request->all(), [
            "name_ar" => "required",
            "name_en" => "required",
            'currency_ar' => 'required',
            'currency_en' => 'required',
            'currency_code' => 'required',
            'code' => 'required',
            'phone_code' => 'required',
            'length' => 'required',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Retrieve the category by ID, or throw an exception if not found
        $country = Country::find($id);
        if (!$country) {
            return  RespondWithBadRequestData($lang, 8);
        }
        $modify_by = Auth::guard('admin')->user()->id;
        $country->name_ar = $request->name_ar;
        $country->name_en = $request->name_en;
        $country->currency_ar = $request->currency_ar;
        $country->currency_en = $request->currency_en;
        $country->code = $request->code;
        $country->currency_code = $request->currency_code;
        $country->phone_code = $request->phone_code;
        $country->length = $request->length;
        $country->modified_by = $modify_by;
        // Update the category in the database
        $country->save();
        if ($request->hasFile('flag')) {
            $image = $request->file('flag');
            UploadFile('images/countries', 'flag', $country, $image);
        }
        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
    public function destroy(Request $request, $id, $checkToken)
    {

        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        // Find the country
        $country = Country::find($id);
        if (!$country) {
            return RespondWithBadRequestData($lang, 8);
        }

        // Check if the country has related users
        if ($country->users()->count() > 0) {
            return RespondWithBadRequest($lang, 6);
        }
        // Delete the country
        $country->delete();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
