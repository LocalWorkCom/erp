<?php

use App\Models\ApiCode;
use Illuminate\Http\Request;
use App\Models\ActionBackLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

function RespondWithSuccessRequest($code)
{

    //bad or invalid request missing some params
    $response = new stdClass();
    $APICode = APICode::where('code', $code)->first();
    $response_array = array(
        'success' => true,
        'apiTitleAr' => $APICode->ApiCodeTitleAr,
        'apiTitleEn' => $APICode->ApiCodeTitleEn,
        'apiMsgAr' => $APICode->ApiCodeMessageAr,
        'apiMsgEn' => $APICode->ApiCodeMessageEn,
        'apiCode' => $APICode->IDApiCode,
        'data' => $response
    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}

function RespondWithBadRequest($code)
{
    $APICode = APICode::where('code', $code)->first();
    $response_array = array(
        'success' => false,
        'ApiTitleAr' => $APICode->ApiCodeTitleAr,
        'ApiTitleEn' => $APICode->ApiCodeTitleEn,
        'ApiMsgAr' => $APICode->ApiCodeMessageAr,
        'ApiMsgEn' => $APICode->ApiCodeMessageEn,
        'ApiCode' => $APICode->IDApiCode
    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}
function GetNextID($table)
{
    $nextId  = DB::table($table)->count() + 1;
    return $nextId;
}
function ActionBackLog($IDUser, $function_name, $controller_name, $action_name, $action_id)
{
    $ActionBackLog = new ActionBackLog();
    $ActionBackLog->IDUser              = $IDUser;
    $ActionBackLog->function_name       = $function_name;
    $ActionBackLog->controller_name   = $controller_name;
    $ActionBackLog->action_name   = $action_name;
    $ActionBackLog->action_id   = $action_id;
    $ActionBackLog->date_time   = date('Y-m-d H:i:s');
    $ActionBackLog->save();
}
function BaseUrl()
{
    $myUrl = "";
    if (isset($_SERVER['HTTPS'])) $myUrl .= "https://";
    else $myUrl .= "http://";
    if ($_SERVER['SERVER_NAME'] == "127.0.0.1") return "http://127.0.0.1:8000";
    return $myUrl . $_SERVER['SERVER_NAME'];
}
function AddDays($date, $daysNumber)
{
    $startDate = Carbon::parse($date);
    $daysNumber = $daysNumber;

    $next_date = $startDate->copy()->addDays($daysNumber);
    return $next_date->toDateString();
}
function formatTime($time)
{
    $to = Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
    $toDay = str_replace(['AM', 'PM'], ['ص', 'م'], $to);
    return $toDay;
}
function convertToArabicNumerals($number)
{
    $westernArabicNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    $easternArabicNumerals = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

    return str_replace($westernArabicNumerals, $easternArabicNumerals, $number);
}
function ApiCode($code)
{
    $APICode = APICode::where('code', $code)->first();
    return $APICode;
}

function ResponseWithSuccessData($lang, $data, $code)
{
    $APICode = ApiCode($code);
    $response_array = array(
        'success' => true,
        'apiTitle' => $lang == 'ar' ? $APICode->api_code_title_ar : $APICode->api_code_title_en,
        'apiMsg' => $lang == 'ar' ? $APICode->api_code_message_ar : $APICode->api_code_message_en,
        'apiCode' => $APICode->code,
        'data'   => $data
    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}