<?php


namespace App\Services;
use App\Models\FloorPartition;
use App\Models\Position;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TableService
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
            $tables = Table::with(['floors','floorPartitions'])->get();
            return ResponseWithSuccessData($this->lang, $tables, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function add(Request $request)
    {
//        dd($request->all());
        try {
            $validateData = Validator::make($request->all(), [
                'floor_id' => 'required|integer|exists:floors,id',
                'floor_partition_id' => 'required|integer|exists:floor_partitions,id',
                'name_ar' => 'required',
                'name_en' => 'required',
                'type' => 'required|integer|min:1',
                'smoking' => 'required|integer|min:1',
                'table_number' => 'required|integer',
                'capacity' => 'required|integer|min:1'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $check_tabel_number = Table::where('table_number', $request->table_number)->first();
            if ($check_tabel_number) {
                return RespondWithBadRequestData($this->lang, 9);
            }

            $check_floor_partition = FloorPartition::where('id', $request->floor_partition_id)->first();
            if ($check_floor_partition->capacity <= $check_floor_partition->exist_table) {
                return RespondWithBadRequestNotAdd($this->lang, 9);
            }

            $user_id =  Auth::guard('admin')->user()->id;
            $table = new Table();
            $table->floor_id = $request->floor_id;
            $table->floor_partition_id = $request->floor_partition_id;
            $table->name_ar = $request->name_ar;
            $table->name_en = $request->name_en;
            $table->table_number = $request->table_number;
            $table->type = $request->type;
            $table->smoking = $request->smoking;
            $table->capacity = $request->capacity;
            $table->status = $request->status;
            $table->created_by = $user_id;
            $table->save();

            return ResponseWithSuccessData($this->lang, $table, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function edit(Request $request,$id)
    {
        try {
            $validateData = Validator::make($request->all(), [
                'floor_partition_id' => 'required|integer|exists:floor_partitions,id',
                'floor_id' => 'required|integer|exists:floors,id',
                'name_ar' => 'required',
                'name_en' => 'required',
                'type' => 'required|integer|min:1',
                'smoking' => 'required|integer|min:1',
                'table_number' => 'required|integer|min:1',
                'capacity' => 'required|integer|min:1'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $check_tabel_number = Table::where('table_number', $request->table_number)->where('id', '!=', $request->id)->first();
            if ($check_tabel_number) {
                return RespondWithBadRequestData($this->lang, 9);
            }

            $user_id =  Auth::guard('admin')->user()->id;
            $table = Table::findOrFail($id);
            $table->floor_id = $request->floor_id;
            $table->floor_partition_id = $request->floor_partition_id;
            $table->name_ar = $request->name_ar;
            $table->name_en = $request->name_en;
            $table->table_number = $request->table_number;
            $table->type = $request->type;
            $table->smoking = $request->smoking;
            $table->capacity = $request->capacity;
            $table->status = $request->status;
            $table->modified_by = $user_id;
            $table->save();

            return ResponseWithSuccessData($this->lang, $table, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $user_id =  Auth::guard('admin')->user()->id;

            $table = Table::find($request->id);
            if (!$table) {
                return  RespondWithBadRequestNotExist();
            }

            $table->deleted_by = $user_id;
            $table->save();

            $table->delete();

            return RespondWithSuccessRequest($this->lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($this->lang, 2);
        }
    }
}
