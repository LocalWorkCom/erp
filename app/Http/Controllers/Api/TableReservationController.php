<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\TableReservation;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TableReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $table_reservations = TableReservation::with('tables')->get();
            return ResponseWithSuccessData($lang, $table_reservations, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function add(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $new_reservation_date = "";
            $new_reservation_time = "";
            $validateData = Validator::make($request->all(), [
                'table_id' => 'required|integer|exists:tables,id',
                'client_id' => 'required|integer|exists:users,id',
                'date' => 'required|date|after:yesterday',
                'time_from' => 'required|date_format:H:i',
                'time_to' => 'required|date_format:H:i'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $setting_details = Setting::find(1);
            if (!$setting_details) {
                return  RespondWithBadRequestNotExist();
            }

            if($setting_details->reservation_time_type == 2){
                $new_reservation_date = $request->time_date + $setting_details->reservation_time;
            }else{
                $new_reservation_time = $request->time_from + $setting_details->reservation_time;
            }


            $check_tabel_reservation = TableReservation::where('table_id', $request->table_id)->first();
            if ($check_tabel_reservation) {
                if($check_tabel_reservation->date == $request->date && $check_tabel_reservation->status != 3)
                return RespondWithBadRequestNotAvailable($lang, 9);
            }

            $user_id = Auth::guard('api')->user()->id;
            $table_reservation = new TableReservation();
            $table_reservation->table_id = $request->table_id;
            $table_reservation->client_id = $request->client_id;
            $table_reservation->date = $request->date;
            $table_reservation->time_from = $request->time_from;
            $table_reservation->time_to = $request->time_to;
            $table_reservation->confirmed = 1;
            $table_reservation->status = 1;
            $table_reservation->created_by = $user_id;
            $table_reservation->save();

            return ResponseWithSuccessData($lang, $table_reservation, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function edit(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'id' => 'required|exists:table_reservations,id',
                'table_id' => 'required|integer|exists:tables,id',
                'client_id' => 'required|integer|exists:users,id',
                'date' => 'required|date|after:yesterday',
                'time_from' => 'required|date_format:H:i',
                'time_to' => 'required|date_format:H:i'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $check_tabel_reservation = TableReservation::where('table_id', $request->table_id)->first();
            if ($check_tabel_reservation) {
                //not empty
                if($check_tabel_reservation->date == $request->date && $check_tabel_reservation->status != 1){
                    return RespondWithBadRequestNotAvailable($lang, 9);
                }

                //not client
                if($check_tabel_reservation->client_id != $request->client_id){
                    return RespondWithBadRequestNotAvailable($lang, 9);
                }

                //not penddeing
                if($check_tabel_reservation->confirmed != 1){
                    return  RespondWithBadRequestNotHavePermeation($lang, 9);
                }
            }

            $user_id = Auth::guard('api')->user()->id;
            $table_reservation = TableReservation::find($request->id);
            $table_reservation->table_id = $request->table_id;
            $table_reservation->client_id = $request->client_id;
            $table_reservation->date = $request->date;
            $table_reservation->time_from = $request->time_from;
            $table_reservation->time_to = $request->time_to;
            $table_reservation->modified_by = $user_id;
            $table_reservation->save();

            return ResponseWithSuccessData($lang, $table_reservation, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $user_id = Auth::guard('api')->user()->id;

            $table_reservation = TableReservation::find($request->id);
            if (!$table_reservation) {
                return  RespondWithBadRequestNotExist();
            }

            if ($table_reservation) {
                //not empty
                if($table_reservation->status != 1){
                    return RespondWithBadRequestNotAvailable($lang, 9);
                }

                //not penddeing
                if($table_reservation->confirmed != 1){
                    return  RespondWithBadRequestNotHavePermeation($lang, 9);
                }
            }

            $table_reservation->deleted_by = $user_id;
            $table_reservation->save();

            $table_reservation->delete();

            return RespondWithSuccessRequest($lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function change_status(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'id' => 'required|exists:table_reservations,id',
                'confirmed' => 'required|integer',
                'confirmed_date' => 'required|date|after:yesterday',
                'confirmed_time' => 'required|date_format:H:i'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $table_reservations = TableReservation::find($request->id);

            if (!$table_reservations) {
                return  RespondWithBadRequestNotExist();
            }

            // if($table_reservations->date < $request->confirmed_date){
            //     return  RespondWithBadRequestNotDate();
            // }

            $table_reservations->confirmed = $request->confirmed;
            $table_reservations->confirmed_date = $request->confirmed_date;
            $table_reservations->confirmed_time = $request->confirmed_time;
            $table_reservations->confirmed_by = $user_id;
            $table_reservations->modified_by = $user_id;
            $table_reservations->save();

            return ResponseWithSuccessData($lang, $table_reservations, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}