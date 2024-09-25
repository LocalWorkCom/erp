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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

            $new = new pointSystem();
            $new->name  = $request->name;
            $new->key  = $request->key;
            $new->value = $request->value;
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
