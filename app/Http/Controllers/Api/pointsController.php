<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pointSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class pointsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //point_systems -- show all point system
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale($lang);

            $new = pointSystem::get();

            return ResponseWithSuccessData($lang, $new, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //point_systems--add new system
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale($lang);

            $validator = Validator::make($request->all(), [
                "name" => "required",
                "key" => "required",
                'value' => 'required',
            ]);

            if ($validator->fails()) {
                return RespondWithBadRequestWithData($validator->errors());
            }

            $new = new pointSystem();
            $new->name  = $request->name;
            $new->key  = $request->key;
            $new->value = $request->value;
            $new->active = 0;
            $new->created_by = auth()->id();
            $new->save();

            return ResponseWithSuccessData($lang, $new, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
          //point_systems -- show all point system
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale($lang);

            $new = pointSystem::findOrFail($id);

            return ResponseWithSuccessData($lang, $new, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }//
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
         //point_systems -- show all point system
         try {
            $lang = $request->header('lang', 'ar');
            App::setLocale($lang);

            $new = pointSystem::findOrFail($id);

            return ResponseWithSuccessData($lang, $new, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }// //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //point_systems
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale($lang);

            $validator = Validator::make($request->all(), [
                "name" => "required",
                "key" => "required",
                'value' => 'required',
            ]);

            if ($validator->fails()) {
                return RespondWithBadRequestWithData($validator->errors());
            }

            $new = pointSystem::findOrFail($id);
            $new->name  = $request->name;
            $new->key  = $request->key;
            $new->value = $request->value;
            $new->active = $request->active;

            $new->modified_by = auth()->id();
            $new->save();

            return ResponseWithSuccessData($lang, $new, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
