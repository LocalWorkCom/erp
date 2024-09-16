<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $sizes = Country::where('deleted_at',null)->get();

            return ResponseWithSuccessData($lang, $sizes, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $size = new Country();
            $size->name_ar = $request->name_ar;
            $size->name_en = $request->name_en;
            $size->currency_ar = $request->currency_ar;
            $size->currency_en = $request->currency_en;
            $size->currency_ar = $request->currency_ar;
            $size->code = $request->code;
            $size->currency_code = $request->currency_code;
            $size->created_by =1;
            $size->save();
            return ResponseWithSuccessData($lang, $size, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $size = Country::findOrFail($request->input('id'));
            $size->name_ar = $request->name_ar;
            $size->name_en = $request->name_en;
            $size->currency_ar = $request->currency_ar;
            $size->currency_en = $request->currency_en;
            $size->currency_ar = $request->currency_ar;
            $size->code = $request->code;
            $size->currency_code = $request->currency_code;
            $size->modified_by =1;
            $size->save();

            return ResponseWithSuccessData($lang, $size, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $size = Country::findOrFail($request->input('id'));
            $is_allow = Branch::where('country_id',$request->input('id'))->first();
            $is_allow2 = User::where('country_id',$request->input('id'))->first();

            if($is_allow || $is_allow2){
                return RespondWithBadRequestData($lang, 3);
            }else{
                $size->deleted_by =1;
                $size->deleted_at =time();

                return ResponseWithSuccessData($lang, $size, 1);

            }
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
