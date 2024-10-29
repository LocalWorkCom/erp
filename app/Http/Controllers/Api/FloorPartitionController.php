<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FloorPartition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FloorPartitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $floor_partitions = FloorPartition::with('tables')->get();
            return ResponseWithSuccessData($lang, $floor_partitions, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function add(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'floor_id' => 'required|integer|exists:floors,id',
                'name_ar' => 'required',
                'name_en' => 'required',
                'type' => 'required|integer|min:1',
                'smoking' => 'required|integer|min:1',
                'capacity' => 'required|integer|min:1'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $floor_partition = new FloorPartition();
            $floor_partition->floor_id = $request->floor_id;
            $floor_partition->name_ar = $request->name_ar;
            $floor_partition->name_en = $request->name_en;
            $floor_partition->type = $request->type;
            $floor_partition->smoking = $request->smoking;
            $floor_partition->capacity = $request->capacity;
            $floor_partition->created_by = $user_id;
            $floor_partition->save();

            return ResponseWithSuccessData($lang, $floor_partition, 1);
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
                'floor_id' => 'required|integer|exists:floors,id',
                'name_ar' => 'required',
                'name_en' => 'required',
                'type' => 'required|integer|min:1',
                'smoking' => 'required|integer|min:1',
                'capacity' => 'required|integer|min:1'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $floor_partition = FloorPartition::find($request->id);
            $floor_partition->floor_id = $request->floor_id;
            $floor_partition->name_ar = $request->name_ar;
            $floor_partition->name_en = $request->name_en;
            $floor_partition->type = $request->type;
            $floor_partition->smoking = $request->smoking;
            $floor_partition->capacity = $request->capacity;
            $floor_partition->modified_by = $user_id;
            $floor_partition->save();

            return ResponseWithSuccessData($lang, $floor_partition, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $user_id = Auth::guard('api')->user()->id;

            $floor_partition = FloorPartition::find($request->id);
            if (!$floor_partition) {
                return  RespondWithBadRequestNotExist();
            }

            $floor_partition->deleted_by = $user_id;
            $floor_partition->save();

            $floor_partition->delete();

            return RespondWithSuccessRequest($lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
