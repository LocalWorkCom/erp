<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $floors = Floor::with('tables')->get();
            return ResponseWithSuccessData($lang, $floors, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function add(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'name_ar' => 'required',
                'name_en' => 'required',
                'type' => 'required|integer|min:1',
                'smoking' => 'required|integer|min:1'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $floor = new Floor();
            $floor->name_ar = $request->name_ar;
            $floor->name_en = $request->name_en;
            $floor->type = $request->type;
            $floor->smoking = $request->smoking;
            $floor->created_by = $user_id;
            $floor->save();

            return ResponseWithSuccessData($lang, $floor, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function edit(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'id' => 'required|exists:floors,id',
                'name_ar' => 'required',
                'name_en' => 'required',
                'type' => 'required|integer|min:1',
                'smoking' => 'required|integer|min:1'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $floor = Floor::findOrFail($request->id);
            $floor->name_ar = $request->name_ar;
            $floor->name_en = $request->name_en;
            $floor->type = $request->type;
            $floor->smoking = $request->smoking;
            $floor->modified_by = $user_id;
            $floor->save();

            return ResponseWithSuccessData($lang, $floor, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $user_id = Auth::guard('api')->user()->id;

            $floor = Floor::findOrFail($request->id);
            if (!$floor) {
                return  RespondWithBadRequestNotExist();
            }

            $floor->deleted_by = $user_id;
            $floor->save();

            $floor->delete();

            return RespondWithSuccessRequest($lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
