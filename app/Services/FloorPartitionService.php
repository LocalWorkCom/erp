<?php


namespace App\Services;
use App\Models\Floor;
use App\Models\FloorPartition;
use App\Models\Unit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FloorPartitionService
{
    private $lang;
    public function __construct()
    {
        $this->lang = app()->getLocale();
        app()->setLocale($this->lang);
    }

    public function index(Request $request)
    {
        try {
            $floor_partitions = FloorPartition::with('tables')->get();
            return ResponseWithSuccessData($this->lang, $floor_partitions, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function add(Request $request)
    {
        try {
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

            $user_id = 13;
            $floor_partition = new FloorPartition();
            $floor_partition->floor_id = $request->floor_id;
            $floor_partition->name_ar = $request->name_ar;
            $floor_partition->name_en = $request->name_en;
            $floor_partition->type = $request->type;
            $floor_partition->smoking = $request->smoking;
            $floor_partition->capacity = $request->capacity;
            $floor_partition->created_by = $user_id;
            $floor_partition->save();

            return ResponseWithSuccessData($this->lang, $floor_partition, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function edit(Request $request,$id)
    {
        try {
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

            $user_id = 13;
            $floor_partition = FloorPartition::findOrFail($id);
            $floor_partition->floor_id = $request->floor_id;
            $floor_partition->name_ar = $request->name_ar;
            $floor_partition->name_en = $request->name_en;
            $floor_partition->type = $request->type;
            $floor_partition->smoking = $request->smoking;
            $floor_partition->capacity = $request->capacity;
            $floor_partition->modified_by = $user_id;
            $floor_partition->save();

            return ResponseWithSuccessData($this->lang, $floor_partition, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $user_id = 13;

            $floor_partition = FloorPartition::find($id);
            if (!$floor_partition) {
                return  RespondWithBadRequestNotExist();
            }

            $floor_partition->deleted_by = $user_id;
            $floor_partition->save();

            $floor_partition->delete();

            return RespondWithSuccessRequest($this->lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }
}
