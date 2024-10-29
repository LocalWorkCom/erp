<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\FloorPartition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $tables = Table::with('floors')->get();
            return ResponseWithSuccessData($lang, $tables, 1);
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
                return RespondWithBadRequestData($lang, 9);
            }

            $check_floor_partition = FloorPartition::where('id', $request->floor_partition_id)->first();
            if ($check_floor_partition->capacity <= $check_floor_partition->exist_table) {
                return RespondWithBadRequestNotAdd($lang, 9);
            }

            $user_id = Auth::guard('api')->user()->id;
            $table = new Table();
            $table->floor_id = $request->floor_id;
            $table->floor_partition_id = $request->floor_partition_id;
            $table->name_ar = $request->name_ar;
            $table->name_ar = $request->name_ar;
            $table->table_number = $request->table_number;
            $table->type = $request->type;
            $table->smoking = $request->smoking;
            $table->capacity = $request->capacity;
            $table->status = $request->status;
            $table->created_by = $user_id;
            $table->save();

            return ResponseWithSuccessData($lang, $table, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function edit(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'id' => 'required|exists:tables,id',
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
                return RespondWithBadRequestData($lang, 9);
            }

            $user_id = Auth::guard('api')->user()->id;
            $table = Table::find($request->id);
            $table->floor_id = $request->floor_id;
            $table->floor_partition_id = $request->floor_partition_id;
            $table->name_ar = $request->name_ar;
            $table->name_ar = $request->name_ar;
            $table->table_number = $request->table_number;
            $table->type = $request->type;
            $table->smoking = $request->smoking;
            $table->capacity = $request->capacity;
            $table->status = $request->status;
            $table->modified_by = $user_id;
            $table->save();

            return ResponseWithSuccessData($lang, $table, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $user_id = Auth::guard('api')->user()->id;

            $table = Table::find($request->id);
            if (!$table) {
                return  RespondWithBadRequestNotExist();
            }

            $table->deleted_by = $user_id;
            $table->save();

            $table->delete();

            return RespondWithSuccessRequest($lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
