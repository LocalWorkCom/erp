<?php

use Carbon\Carbon;
use App\Models\ApICode;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ActionBackLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

function RespondWithSuccessRequest($lang, $code)
{

    //bad or invalid request missing some params
    $response = new stdClass();
    $APICode = ApICode::where('code', $code)->first();
    $response_array = array(
        'success' => true,
        'apiTitle' => $lang == 'ar' ? $APICode->api_code_title_ar : $APICode->api_code_title_en,
        'apiMsg' => $lang == 'ar' ? $APICode->api_code_message_ar : $APICode->api_code_message_en,
        'apiCode' => $APICode->code

    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}

function RespondWithBadRequest($lang, $code)
{
    $APICode = ApICode::where('code', $code)->first();
    $response_array = array(
        'success' => false,
        'apiTitle' => $lang == 'ar' ? $APICode->api_code_title_ar : $APICode->api_code_title_en,
        'apiMsg' => $lang == 'ar' ? $APICode->api_code_message_ar : $APICode->api_code_message_en,
        'apiCode' => $APICode->code
    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}
function RespondWithBadRequestWithData($data)
{
    $response_array = array(
        'success' => false,
        'apiTitle' => trans('validation.validator_title'),
        'apiMsg' => trans('validation.validator_msg'),
        'apiCode' => -1,
        'data' => $data
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
function GetLastID($table)
{
    $nextId  = DB::table($table)->max('id');
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
    $APICode = ApICode::where('code', $code)->first();
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
function UploadFile($path, $image, $model, $request)
{
    $thumbnail = $request;
    $destinationPath = public_path($path); // Ensure this is the public directory path
    $filename = $model->id . time() . '.' . $thumbnail->getClientOriginalExtension();

    // Move the file to the destination directory
    $thumbnail->move($destinationPath, $filename);

    // Generate the asset path and remove the leading slash if exists
    $filePath = asset($path) . '/' . $filename;
    $filePath = ltrim($filePath, '/'); // Remove the first slash if present

    // Save the file path to the model
    $model->$image = $filePath;

    // Save the model with the updated image path
    $model->save();
}

function GenerateCode($table, $table_id = 0)
{

    if ($table_id) {

        $table = DB::table($table)->where('id', $table_id)->first();
        $table_code = $table->code;
        $numberString = $table_code;

        $number = (int) $numberString;

        $number++;
        $code = sprintf('%04d', $number); // '0001'
        // $code += 1;
    } else {
        $code = '0000';
    }
    return $code;
}
function CheckToken()
{
    $User = auth('api')->user();

    if (!$User) {
        return false;
    }
    return true;
}
if (!function_exists('DeleteFile')) {
    function DeleteFile($path, $filename)
    {
        $filePath = public_path($path . '/' . $filename);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }
}
function RespondWithBadRequestNoChange()
{
    $response_array = array(
        'success' => true,
        'apiTitle' => trans('validation.NoChange'),
        'apiMsg' => trans('validation.NoChangeMessage'),
        'apiCode' => -1,
        'data'   => []
    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}

function RespondWithBadRequestNotExist()
{
    $response_array = array(
        'success' => false,  // Set success to false to indicate an error
        'apiTitle' => trans('validation.NotExist'),
        'apiMsg' => trans('validation.NotExistMessage'),
        'apiCode' => -1,
        'data'   => []
    );
    
    // Change the response code to 404 for "Not Found"
    $response_code = 404;  
    
    return Response::json($response_array, $response_code);
}

function RespondWithBadRequestDataExist()
{
    $response_array = array(
        'success' => false,  // Set success to false to indicate an error
        'apiTitle' => trans('validation.DataExist'),
        'apiMsg' => trans('validation.DataExistMessage'),
        'apiCode' => -1,
        'data'   => []
    );
    
    // Change the response code to 404 for "Not Found"
    $response_code = 404;  
    
    return Response::json($response_array, $response_code);
}
