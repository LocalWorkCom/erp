<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeeOpeningBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EmployeeOpeningBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        //try {
            $lang =  $request->header('lang', 'en');
            $employee_opening_balances = EmployeeOpeningBalance::get();
            return ResponseWithSuccessData($lang, $employee_opening_balances, 1);
        // } catch (\Exception $e) {
        //     return RespondWithBadRequestData($lang, 2);
        // }
    }

    public function open_day_balance(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'employee_id' => 'required|integer|exists:employees,id',
                'employee_schedule_id' => 'required|integer|exists:employee_schedules,id',
                'cashier_machine_id' => 'required|integer|exists:cashier_machines,id',
                'open_cash' => 'required|numeric|min:0',
                'open_visa' => 'required|numeric|min:0',
                'date' => 'required|date|after:yesterday'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $employee_opening_balance = new EmployeeOpeningBalance();
            $employee_opening_balance->employee_id = $request->employee_id;
            $employee_opening_balance->employee_schedule_id = $request->employee_schedule_id;
            $employee_opening_balance->cashier_machine_id = $request->cashier_machine_id;
            $employee_opening_balance->open_cash = $request->open_cash;
            $employee_opening_balance->open_visa = $request->open_visa;
            $employee_opening_balance->date = $request->date;
            $employee_opening_balance->type = 1;
            $employee_opening_balance->created_by = $user_id;
            $employee_opening_balance->save();

            return ResponseWithSuccessData($lang, $employee_opening_balance, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function close_day_balance(Request $request)
    {
        //try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'cashier_machine_id' => 'required|integer|exists:cashier_machines,id',
                'close_cash' => 'required|numeric|min:0',
                'close_visa' => 'required|numeric|min:0',
                'date' => 'required|date|after:yesterday'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }


            $employee_opening_balance = EmployeeOpeningBalance::where('cashier_machine_id', $request->cashier_machine_id)->where('date', $request->date)->where('type', 1)->first();
            if(!$employee_opening_balance){
                return RespondWithBadRequestData($lang, 2);
            }

            return CalculateTotalOrders($employee_opening_balance->cashier_machine_id, $employee_opening_balance->employee_id, $employee_opening_balance->date);

            $user_id = Auth::guard('api')->user()->id;
            $employee_opening_balance->close_cash = $request->close_cash;
            $employee_opening_balance->close_visa = $request->close_visa;
            $employee_opening_balance->type = 2;
            $employee_opening_balance->modified_by = $user_id;
            //$employee_opening_balance->save();

            return ResponseWithSuccessData($lang, $employee_opening_balance, 1);
        // } catch (\Exception $e) {
        //     return RespondWithBadRequestData($lang, 2);
        // }
    }

    

    public function edit(Request $request)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $validateData = Validator::make($request->all(), [
                'id' => 'required|exists:employee_opening_balances,id',
                'name_ar' => 'required',
                'name_en' => 'required'
            ]);

            if ($validateData->fails()) {
                return RespondWithBadRequestWithData($validateData->errors());
            }

            $user_id = Auth::guard('api')->user()->id;
            $employee_opening_balance = EmployeeOpeningBalance::findOrFail($request->id);
            $employee_opening_balance->name_ar = $request->name_ar;
            $employee_opening_balance->name_en = $request->name_en;
            $employee_opening_balance->modified_by = $user_id;
            $employee_opening_balance->save();

            return ResponseWithSuccessData($lang, $employee_opening_balance, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $lang =  $request->header('lang', 'en');
            $user_id = Auth::guard('api')->user()->id;

            $employee_opening_balance = EmployeeOpeningBalance::find($request->id);
            if (!$employee_opening_balance) {
                return  RespondWithBadRequestNotExist();
            }

            if ($employee_opening_balance->id < 4) {
                return  RespondWithBadRequestNotExist();
            }

            $employee_opening_balance->deleted_by = $user_id;
            $employee_opening_balance->save();

            $employee_opening_balance->delete();

            return RespondWithSuccessRequest($lang, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
