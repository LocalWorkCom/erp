<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\ProductColor;
use Illuminate\Http\Request;

class ColorController extends Controller
{

    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $colors = Color::where('deleted_at',null)->get();

            return ResponseWithSuccessData($lang, $colors, 1);
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
            $color = new Color();
            $color->name_ar = $request->name_ar;
            $color->name_en = $request->name_en;
            $color->hexa_code = $request->hexa_code;
            $color->created_by =1;
            $color->save();
            return ResponseWithSuccessData($lang, $color, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $color = Color::findOrFail($request->input('id'));
            return ResponseWithSuccessData($lang, $color, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $color = Color::findOrFail($request->input('id'));
            return ResponseWithSuccessData($lang, $color, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $color = Color::findOrFail($request->input('id'));
            $color->name_ar = $request->name_ar;
            $color->name_en = $request->name_en;
            $color->hexa_code = $request->hexa_code;
            $color->modified_by =1;

            $color->save();

            return ResponseWithSuccessData($lang, $color, 1);
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
            $color = Color::findOrFail($request->input('id'));
            $is_allow = ProductColor::where('color_id',$request->input('id'))->first();
            if($is_allow){
                return RespondWithBadRequestData($lang, 3);
            }else{
                $color->deleted_by =1;
                $color->deleted_at =time();

                return ResponseWithSuccessData($lang, $color, 1);

            }
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}