<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try{
            $lang =  $request->header('lang', 'en');
            $tables = Table::with('floors')->get();
            return ResponseWithSuccessData($lang, $tables, 1);
        }catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function add(Request $request)
    {
        try{
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'name_ar'=>'required',
                'name_en'=>'required',
                'type'=>'required|integer|min:1',
                'smoking'=>'required|integer|min:1',
                'floor_id'=>'required|integer|exists:floors,id',
                'table_number'=>'required|integer'
            ]);

            if($validateData->fails()){
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $check_tabel_number = Table::where('table_number', $request->table_number)->first();
            if($check_tabel_number){
                return RespondWithBadRequestDataExist();
            }

            $user_id = Auth::guard('api')->user()->id;
            $table = new Table();
            $table->name_ar = $request->name_ar;
            $table->name_ar = $request->name_ar;
            $table->table_number = $request->table_number;
            $table->type = $request->type;
            $table->smoking = $request->smoking;
            $table->status = $request->status;
            $table->created_by = $user_id;
            $table->floor_id = $request->floor_id;
            $table->save();

            return ResponseWithSuccessData($lang, $table, 1);
        }catch(\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function edit(Request $request)
    {
        try{
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'name_ar'=>'required',
                'name_en'=>'required',
                'type'=>'required|integer|min:1',
                'smoking'=>'required|integer|min:1',
                'floor_id'=>'required|integer|exists:floors,id',
                'table_number'=>'required|integer|min:1'
            ]);

            if($validateData->fails()){
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $check_tabel_number = Table::where('table_number', $request->table_number)->where('id', '!=', $request->id)->first();
            if($check_tabel_number){
                return RespondWithBadRequestDataExist();
            }

            $user_id = Auth::guard('api')->user()->id;
            $table = Table::findOrFail($request->id);
            $table->name_ar = $request->name_ar;
            $table->name_ar = $request->name_ar;
            $table->table_number = $request->table_number;
            $table->type = $request->type;
            $table->smoking = $request->smoking;
            $table->status = $request->status;
            $table->created_by = $user_id;
            $table->floor_id = $request->floor_id;
            $table->save();

            return ResponseWithSuccessData($lang, $table, 1);
        }catch(\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try{
            $lang =  $request->header('lang', 'en');
            $user_id = Auth::guard('api')->user()->id;

            $table = Table::findOrFail($request->id);
            if(!$table){
                return  RespondWithBadRequestNotExist();
            }

            $table->deleted_by = $user_id;
            $table->save();

            $table->delete();
            
            return RespondWithSuccessRequest($lang, 1);
        }catch(\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }


}
