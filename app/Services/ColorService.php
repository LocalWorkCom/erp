<?php

namespace App\Services;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ColorService
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        $colors = Color::all();

        if (!$checkToken) {
            // Include 'hexa_code' in the visible fields
            $colors = $colors->makeVisible(['name_en', 'name_ar', 'hexa_code']);
        }

        return ResponseWithSuccessData($lang, $colors, 1);
    }

    public function store(Request $request, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        // Validate the input including 'hexa_code'
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'string',
            'hexa_code' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/']

        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        $name_ar = $request->name_ar;
        $name_en = $request->name_en;
        $hexa_code = $request->hexa_code;

        if (CheckExistColumnValue('colors', 'name_ar', $name_ar) || CheckExistColumnValue('colors', 'name_en', $name_en)) {
            return RespondWithBadRequest($lang, 9);
        }

        $created_by =  Auth::guard('admin')->user()->id;

        // Create the new color
        $color = new Color();
        $color->name_ar = $name_ar;
        $color->name_en = $name_en;
        $color->hexa_code = $hexa_code; // Store the hex code
        $color->created_by = $created_by;
        $color->save();

        return RespondWithSuccessRequest($lang, 1);
    }

    public function update(Request $request, $id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        // Validate the input including 'hexa_code'
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'string',
            'hexa_code' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/']
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Retrieve the color by ID, or throw an exception if not found
        $color = Color::find($id);
        if (!$color) {
            return  RespondWithBadRequestData($lang, 8);
        }

        if (
            $color->name_ar == $request->name_ar && $color->name_en == $request->name_en && $color->hexa_code == $request->hexa_code
        ) {
            return  RespondWithBadRequestData($lang, 10);
        }

        if (CheckExistColumnValue('colors', 'name_ar', $request->name_ar) && CheckExistColumnValue('colors', 'name_en', $request->name_en) && CheckExistColumnValue('colors', 'hexa_code', $request->hexa_code)) {
            return RespondWithBadRequest($lang, 9);
        }

        $modified_by =  Auth::guard('admin')->user()->id;

        // Assign the updated values to the color model
        $color->name_ar = $request->name_ar;
        $color->name_en = $request->name_en;
        $color->hexa_code = $request->hexa_code; // Update hex code
        $color->modified_by = $modified_by;

        // Update the color in the database
        $color->save();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }

    public function delete(Request $request, $id, $checkToken)
    {
        $lang = app()->getLocale();

        // Check token
        if ($checkToken && !CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        // Find the color by ID, or throw a 404 if not found
        $color = Color::find($id);
        if (!$color) {
            return RespondWithBadRequestData($lang, 8);
        }

        // Check if the color is associated with any products
        $activeProductColors = $color->productColors()->count();
        if ($activeProductColors > 0) {
            return CustomRespondWithBadRequest(__('color.The color has relations'));
        }

        // Delete the color
        $color->delete();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
