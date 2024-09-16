<?php

use App\Models\ApiCode;
use Illuminate\Http\Request;
use App\Models\ActionBackLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

function RespondWithSuccessRequest($lang, $code)
{

    //bad or invalid request missing some params
    $response = new stdClass();
    $APICode = APICode::where('code', $code)->first();
    $response_array = array(
        'success' => true,
        'apiTitle' => $lang == 'ar' ? $APICode->api_code_title_ar : $APICode->api_code_title_en,
        'apiMsg' => $lang == 'ar' ? $APICode->api_code_message_ar : $APICode->api_code_message_en,
        'apiCode' => $APICode->IDApiCode

    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}

function RespondWithBadRequest($lang, $code)
{
    return $APICode = APICode::where('code', $code)->first();
    $response_array = array(
        'success' => false,
        'apiTitle' => $lang == 'ar' ? $APICode->api_code_title_ar : $APICode->api_code_title_en,
        'apiMsg' => $lang == 'ar' ? $APICode->api_code_message_ar : $APICode->api_code_message_en,
        'apiCode' => $APICode->IDApiCode
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
    $APICode = ApiCode(code: $code);
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

function RespondWithBadRequestData($lang, $code)
{
    $APICode = ApiCode($code);
    $response_array = array(
        'success' => true,
        'apiTitle' => $lang == 'ar' ? $APICode->api_code_title_ar : $APICode->api_code_title_en,
        'apiMsg' => $lang == 'ar' ? $APICode->api_code_message_ar : $APICode->api_code_message_en,
        'apiCode' => $APICode->code,
        'data'   => []
    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}

function translateDataColumns($data, $lang, $translateColumns)
{
    $translatedData = $data;

    foreach ($translateColumns as $column) {
        // Determine the translated column name based on language
        $translatedColumn = $column . ($lang === 'ar' ? '_ar' : '_en');

        // Check if the translated column exists in the data
        if (array_key_exists($translatedColumn, $data)) {
            // Replace the original column with the translated one
            $translatedData[$column] = $data[$translatedColumn];
        } else {
            // Optionally handle missing translated columns (e.g., use a default value)
            $translatedData[$column] = null;
        }
    }

    return $translatedData;
}
function removeColumns($data, $columnsToRemove)
{
    return array_diff_key($data, array_flip($columnsToRemove));
}
function UploadFile($path, $image, $realname, $model, $request)
{

    $thumbnail = $request;
    $destinationPath = $path;
    $filerealname = $thumbnail->getClientOriginalName();
    $filename = $model->id . time() . '.' . $thumbnail->getClientOriginalExtension();
    // $destinationPath = asset($path) . '/' . $filename;
    $thumbnail->move($destinationPath, $filename);
    // $thumbnail->resize(1080, 1080);
    //  $thumbnail = Image::make(public_path() . '/'.$path.'/' . $filename);
    //Storage::move('public')->put($destinationPath, file_get_contents($thumbnail));

    $model->$image = asset($path) . '/' . $filename;
    $model->$realname = asset($path) . '/' . $filerealname;

    $model->save();

}