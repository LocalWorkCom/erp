<?php


namespace App\Services;
use App\Models\Unit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UnitService
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request, $checkToken)
    {
        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        App::setLocale($lang);

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $units = Unit::all();
        
        if (!$checkToken) {
            $units = $units->makeVisible(['name_en', 'name_ar']);
        }
        return ResponseWithSuccessData($lang, $units, 1);
    }
    public function store(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'string',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }


        $name_ar = $request->name_ar;
        $name_en = $request->name_en;

        if (CheckExistColumnValue('units', 'name_ar', $name_ar) || CheckExistColumnValue('units', 'name_ar', $name_ar)) {
            return RespondWithBadRequest($lang, 9);
        }
        $created_by = Auth::guard('api')->user()->id;


        $unit = new Unit();
        $unit->name_ar = $name_ar;
        $unit->name_en =  $name_en;
        $unit->created_by =  $created_by;
        $unit->save();

        return RespondWithSuccessRequest($lang, 1);
    }
    public function update(Request $request, $id)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        App::setLocale($lang);
        // Validate the input
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'string',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Retrieve the unit by ID, or throw an exception if not found
        $unit = Unit::find($id);
        if (!$unit) {
            return  RespondWithBadRequestData($lang, 8);
        }
        if (
            $unit->name_ar == $request->name_ar && $unit->name_en == $request->name_en
        ) {
            return  RespondWithBadRequestData($lang, 10);
        }

        if (CheckExistColumnValue('units', 'name_ar', $request->name_ar) || CheckExistColumnValue('units', 'name_en', $request->name_en)) {
            return RespondWithBadRequest($lang, 9);
        }
        $modify_by = Auth::guard('api')->user()->id;

        // Assign the updated values to the unit model
        $unit->name_ar = $request->name_ar;
        $unit->name_en = $request->name_en;
        $unit->modify_by = $request->modify_by;

        // Update the unit in the database
        $unit->save();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
    public function delete(Request $request, $id)
    {
        // Fetch the language header for response
        $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Find the unit by ID, or throw a 404 if not found
        $unit = Unit::find($id);
        if (!$unit) {
            return  RespondWithBadRequestData($lang, 8);
        }
        // Delete the unit
        $unit->delete();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
