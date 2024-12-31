<?php

use App\Models\OrderDetail;
use App\Models\pointSystem;
use Carbon\Carbon;
use App\Models\ApICode;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ActionBackLog;
use App\Models\Branch;
use App\Models\ClientDetail;
use App\Models\Coupon;
use App\Models\DeliverySetting;
use App\Models\Discount;
use App\Models\OpeningBalance;
use App\Models\pointTransaction;
use App\Models\PurchaseInvoicesDetails;
use App\Models\Setting;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\CashierMachine;
use App\Models\Country;
use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\DishCategory;
use App\Models\Dish;
use App\Models\DishAddon;
use App\Models\DishSize;
use App\Models\Menu;
use App\Models\AddonCategory;

use App\Models\BranchMenuCategory;
use App\Models\BranchMenu;
use App\Models\BranchMenuAddonCategory;
use App\Models\BranchMenuAddon;
use App\Models\BranchMenuSize;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\Builder; // Import the Builder class
use App\Services\TimetableService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

function RespondWithSuccessRequest($lang, $code)
{


    //bad or invalid request missing some params
    $response = new stdClass();
    $APICode = ApICode::where('code', $code)->first();
    $response_array = array(
        'status' => true,
        // 'apiTitle' => $lang == 'ar' ? $APICode->api_code_title_ar : $APICode->api_code_title_en,
        'message' => $lang == 'ar' ? $APICode->api_code_message_ar : $APICode->api_code_message_en,
        'code' => 200

    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}

function RespondWithBadRequest($lang, $code)
{


    $APICode = ApICode::where('code', $code)->first();
    $response_array = array(
        'status' => false,
        // 'apiTitle' => $lang == 'ar' ? $APICode->api_code_title_ar : $APICode->api_code_title_en,
        'message' => $lang == 'ar' ? $APICode->api_code_message_ar : $APICode->api_code_message_en,
        'code' => 400
    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}
function CustomRespondWithBadRequest($message)
{


    $response_array = array(
        'status' => false,
        // 'apiTitle' => $lang == 'ar' ? $APICode->api_code_title_ar : $APICode->api_code_title_en,
        'message' => $message,
        'code' => 400
    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}
function RespondWithBadRequestWithData($data)
{

    $response_array = array(
        'status' => false,
        // 'apiTitle' => trans('validation.validator_title'),
        'message' => trans('validation.validator_msg'),
        'code' => 401,
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
    if ($_SERVER['SERVER_NAME'] == "erp.test/") return "http://erp.test/";
    return $myUrl . $_SERVER['SERVER_NAME'];
}
// function BaseUrl()
// {
//     $myUrl = "";

//     // Check if the connection is secure (HTTPS)
//     if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
//         $myUrl .= "https://";
//     } else {
//         $myUrl .= "http://";
//     }

//     // Return specific base URL for 'erp.test/'
//     if ($_SERVER['SERVER_NAME'] === "erp.test/") {
//         return "http://erp.test/";
//     }

//     // Default behavior for other server names
//     return $myUrl . $_SERVER['SERVER_NAME'];
// }

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
        'status' => true,
        // 'apiTitle' => $lang == 'ar' ? $APICode->api_code_title_ar : $APICode->api_code_title_en,
        'message' => $lang == 'ar' ? $APICode->api_code_message_ar : $APICode->api_code_message_en,
        'code' => 200,
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
        'status' => true,
        // 'apiTitle' => $lang == 'ar' ? $APICode->api_code_title_ar : $APICode->api_code_title_en,
        'message' => $lang == 'ar' ? $APICode->api_code_message_ar : $APICode->api_code_message_en,
        'code' => 400,
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
    $filePath = url($filePath); // Remove the first slash if present

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
    $lang = 'ar';
    $User = auth('api')->user();
    if (!$User) {
        return false;
    }
    $token = DB::table('oauth_access_tokens')
        ->select('expires_at') // Get the necessary fields
        ->orderBy('created_at', 'desc') // Order by creation date (ascending)
        ->where('user_id', $User->id) // Filter by the user's ID
        ->first();

    if ($token->expires_at < Carbon::now()->toDateTimeString()) {
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
//not used
function RespondWithBadRequestNoChange()
{

    $response_array = array(
        'status' => true,
        // 'apiTitle' => trans('validation.NoChange'),
        'message' => trans('validation.NoChangeMessage'),
        'code' => 401,
        'data'   => []
    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}

function RespondWithBadRequestNoEmpty()
{
    $response_array = array(
        'status' => true,
        // 'apiTitle' => trans('validation.NoChange'),
        'message' => trans('validation.NotAllowMessage'),
        'code' => 401,
        'data'   => []
    );
    $response_code = 200;
    $response = Response::json($response_array, $response_code);
    return $response;
}

//not used
function RespondWithBadRequestNotExist()
{

    $response_array = array(
        'status' => false,  // Set success to false to indicate an error
        // 'apiTitle' => trans('validation.NotExist'),
        'message' => trans('validation.NotExistMessage'),
        'code' => 401,
        'data'   => []
    );

    // Change the response code to 404 for "Not Found"
    $response_code = 200;

    return Response::json($response_array, $response_code);
}

//not have Permeation
function RespondWithBadRequestNotHavePermeation()
{

    $response_array = array(
        'status' => false,  // Set success to false to indicate an error
        // 'apiTitle' => trans('validation.NotHavePermeation'),
        'message' => trans('validation.NotHavePermeationMessage'),
        'code' => 403,
        'data'   => []
    );

    // Change the response code to 404 for "Not Found"
    $response_code = 200;

    return Response::json($response_array, $response_code);
}

//not date
function RespondWithBadRequestNotDate()
{

    $response_array = array(
        'status' => false,  // Set success to false to indicate an error
        // 'apiTitle' => trans('validation.NotDate'),
        'message' => trans('validation.NotDateMessage'),
        'code' => 400,
        'data'   => []
    );

    // Change the response code to 404 for "Not Found"
    $response_code = 200;

    return Response::json($response_array, $response_code);
}

//not add
function RespondWithBadRequestNotAdd()
{

    $response_array = array(
        'status' => false,  // Set success to false to indicate an error
        // 'apiTitle' => trans('validation.NotAddMore'),
        'message' => trans('validation.NotAddMoreMessage'),
        'code' => 400,
        'data'   => []
    );

    // Change the response code to 404 for "Not Found"
    $response_code = 200;

    return Response::json($response_array, $response_code);
}

//not available
function RespondWithBadRequestNotAvailable()
{

    $response_array = array(
        'status' => false,  // Set success to false to indicate an error
        // 'apiTitle' => trans('validation.NotAvailable'),
        'message' => trans('validation.NotAvailableMessage'),
        'code' => 404,
        'data'   => []
    );

    // Change the response code to 404 for "Not Found"
    $response_code = 200;

    return Response::json($response_array, $response_code);
}

//not Closing
function RespondWithBadRequestNotClosing()
{

    $response_array = array(
        'status' => false,  // Set success to false to indicate an error
        // 'apiTitle' => trans('validation.NotAvailable'),
        'message' => trans('validation.NotClosingMessage'),
        'code' => 403,
        'data'   => []
    );

    // Change the response code to 404 for "Not Found"
    $response_code = 200;

    return Response::json($response_array, $response_code);
}

function RespondWithBadRequestNoLeave()
{

    $response_array = array(
        'status' => false,  // Set success to false to indicate an error
        // 'apiTitle' => trans('validation.NoLeave'),
        'message' => trans('validation.NoLeaveMessage'),
        'code' => 400,
        'data'   => []
    );

    // Change the response code to 404 for "Not Found"
    $response_code = 200;

    return Response::json($response_array, $response_code);
}


//not used
function RespondWithBadRequestDataExist()
{

    $response_array = array(
        'status' => false,  // Set success to false to indicate an error
        // 'apiTitle' => trans('validation.DataExist'),
        'message' => trans('validation.DataExistMessage'),
        'code' => 401,
        'data'   => []
    );

    // Change the response code to 404 for "Not Found"
    $response_code = 200;

    return Response::json($response_array, $response_code);
}

function CheckExistColumnValue($table, $column, $value)
{
    return DB::table($table)
        ->where($column, $value)
        ->whereNull('deleted_at') // Ensures only active records are checked
        ->exists();
}


function CheckCouponValid($id, $amount)
{

    $coupon = Coupon::find($id);
    if ($coupon) {
        if (date('Y-m-d', strtotime($coupon->end_date))  <= date('Y-m-d') && $coupon->minimum_spend <= $amount) {
            return true;
        }
    }
    return false;
}

function GetCouponId($code)
{
    $coupon = Coupon::where('code', $code)->first();
    if ($coupon) {
        return $coupon;
    } else {
        return 0;
    }
}
function CountCouponUsage($id)
{
    $coupon = Coupon::find($id);

    if ($coupon) {
        if ($coupon->usage_limit <= $coupon->count_usage) {
            return false;
        }
        $coupon->count_usage = $coupon->count_usage + 1;
        $coupon->save();
    }
    return true;
}

function CheckDiscountValid()
{
    $discount = Discount::where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->first();
    return $discount;
}
function getSetting($column)
{
    $setting = Setting::first();

    if ($setting) {
        return $setting->$column;
    }

    return null;  // or handle this as needed
}
function applyCoupon($total_price, $coupon)
{
    if ($coupon->type == 'fixed') {
        return $total_price - $coupon->value;
    } else {
        return $total_price - ($total_price * ($coupon->value / 100));
    }
    return $total_price;
}
function applyDiscount($total_price, $discount)
{
    if ($discount->type == 'fixed') {
        return $total_price - $discount->value;
    } else {
        return $total_price - ($total_price * ($discount->value / 100));
    }
    return $total_price;
}
function calcDiscount($total_price, $discount)
{
    if ($discount->type == 'fixed') {
        return  $discount->value;
    } else {
        return ($total_price * ($discount->value / 100));
    }
}
// Function to apply tax
function applyTax($total_price, $tax_percentage, $tax_application)
{
    if ($tax_application) {
        return $total_price - ($total_price * ($tax_percentage / 100));
    } else {

        return $total_price + ($total_price * ($tax_percentage / 100));
    }
}
function CalculateTax($tax_percentage, $amount)
{
    $tax = $amount * ($tax_percentage / 100);
    // dd($tax,($tax_percentage / 100), $tax_percentage);
    return $tax;
}

function CheckUserType()
{
    $User = auth('api')->user();
    if ($User) {
        return $User->flag;
    }
    return '';
}
function isValid($branch_id)
{
    return pointSystem::where('branch_id', $branch_id)->exists();
}
function isActive($branch_id)
{
    return pointSystem::where('branch_id', $branch_id)->value('active') == 1;
}
function calculateEarnPoint($total, $branch, $order_id, $user_id)
{

    //get system value earn
    $value_percent = pointSystem::where('branch_id', $branch)->value('value_earn');

    //get num of points of total of order
    $points_num = $total * ($value_percent / 100);

    $transactions = new pointTransaction();
    $transactions->customer_id = $user_id;
    $transactions->order_id = $order_id;
    $transactions->type = 'earn';
    $transactions->points = $points_num;
    $transactions->transaction_date = now();
    $transactions->created_by  = $user_id;
    $transactions->save();

    $point_user = ClientDetail::where('user_id', $user_id)->value('loyalty_points') + $points_num;
    $point = ClientDetail::where('user_id', $user_id)->first();
    $point->loyalty_points = $point_user;
    $point->save();

    return  $points_num;
}

function calculateRedeemPoint($total, $branch_id, $Order_id, $client_id)
{

    //get system value redeem
    $point_redeem = pointSystem::where('branch_id', $branch_id)->value('point_redeem');
    $limit_redeem = pointSystem::where('branch_id', $branch_id)->value('value_redeem');

    $user_points = ClientDetail::where('user_id', $client_id)->value('loyalty_points');

    $points_percent = $user_points * $point_redeem;
    $redeem_total = 0;
    // dd($limit_redeem);
    if ($limit_redeem > $points_percent) {
        // dd(0);
        $redeem_total = $total *  $points_percent;
        $transactions = new pointTransaction();
        $transactions->customer_id = $client_id;
        $transactions->order_id = $Order_id;
        $transactions->type = 'redeem';
        $transactions->points = $user_points;
        $transactions->transaction_date = now();
        $transactions->created_by = $client_id;
        $transactions->save();

        //  $point_user = ClientDetail::where('user_id', $client_id)->value('loyalty_points') - $user_points;
        $client = ClientDetail::where('user_id', $client_id)->first();

        $client->loyalty_points = 0;
        $client->save();
    }

    return $redeem_total;
}

function get_by_md5_id($id, $table)
{
    return DB::table($table)
        ->where(DB::raw('MD5(id)'), $id)
        ->first();
}

function einvoice_settings($key)
{
    $setting = DB::table('einvoice_settings')->where('key', $key)->value('value');

    return $setting ?? null;
}

function helper_update_by_id(array $data, $id, $table)
{
    // Update the specified table with the data, where the ID matches
    return DB::table($table)->where('id', $id)->update($data);
}


function getNearestBranch($userLat, $userLon)
{
    $nearestBranch = Branch::select('*') // Select all columns
    ->selectRaw("(6371 * acos(cos(radians($userLat))
                * cos(radians(latitute))
                * cos(radians(longitute) - radians($userLon))
                + sin(radians($userLat))
                * sin(radians(latitute)))) AS distance")
    ->whereNotNull('latitute')
    ->whereNotNull('longitute')
    ->orderBy('distance', 'asc')
    ->first();
    return $nearestBranch;
}


function scopeNearest($IDBranch, $latitude, $longitude)
{
    return DeliverySetting::where('branch_id', $IDBranch)
        ->select('*', DB::raw("
                (6371 * acos(
                    cos(radians($latitude)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians($longitude)) +
                    sin(radians($latitude)) *
                    sin(radians(latitude))
                )) AS distance
            "))
        ->havingRaw('distance <= radius')
        ->orderBy('distance')->first();
}
function getProductPrice($product_id, $store_id, $unit_id)
{
    $pricing_method = getSetting('pricing_method');
    if ($pricing_method == 'original_price') {
        $price = OpeningBalance::where('product_id', $product_id)->where('unit_id', $unit_id)->where('store_id', $store_id)->first()->price;
    } elseif ($pricing_method == 'avg_price') {
        $price = PurchaseInvoicesDetails::leftJoin('purchase_invoices', 'purchase_invoices.id', '=', 'purchase_invoices_details.purchase_invoices_id')
            ->where('product_id', $product_id)
            ->where('unit_id', $unit_id)
            ->where('store_id', $store_id)
            ->avg('price');
    } else {
        $price = PurchaseInvoicesDetails::leftJoin('purchase_invoices', 'purchase_invoices.id', '=', 'purchase_invoices_details.purchase_invoices_id')
            ->where('product_id', $product_id)
            ->where('unit_id', $unit_id)
            ->where('store_id', $store_id)->orderby('id', 'desc')->first()->price;
    }
    return $price;
}
function CalculateTotalOrders($cashier_machine_id, $employee_id, $date, $payment_method)
{
    $sum_orders = 0;
    $branch_id = 0;
    $cashier_machine_details = CashierMachine::find($cashier_machine_id);
    if ($cashier_machine_details) {
        if ($cashier_machine_details->branches) {
            $branch_id = $cashier_machine_details->branches->id;
        }
    }


    $employee_time =  TimetableService::getTimetableForDate($employee_id, $date);
    if ($branch_id != 0) {
        if ($employee_time['data']['cross_day'] == 0) {
            $orders_totals = Order::where('branch_id', $branch_id)->whereDate('date', $date)->whereTime('created_at', '>=', $employee_time['data']['on_duty_time'])->whereTime('created_at', '<=', $employee_time['data']['off_duty_time'])->get();
        } else {
            $next_day = Carbon::parse($date)->addDays(1);
            $orders_totals_old = Order::where('branch_id', $branch_id)->whereDate('date', $date)->whereTime('created_at', '>=', $employee_time['data']['on_duty_time'])->whereTime('created_at', '>=', $employee_time['data']['off_duty_time'])->get()->toArray();
            $orders_totals_new = Order::where('branch_id', $branch_id)->whereDate('date', $next_day)->whereTime('created_at', '<=', $employee_time['data']['on_duty_time'])->whereTime('created_at', '<=', $employee_time['data']['off_duty_time'])->get()->toArray();
            $orders_totals = array_merge($orders_totals_old, $orders_totals_new);
        }

        if ($orders_totals)
            foreach ($orders_totals as $orders_total) {
                if ($orders_total) {
                    $orders_tot = OrderTransaction::where('order_id', $orders_total['id'])->where('order_type', 'order')->where('payment_status', 'paid')->where('payment_method', $payment_method)->first();
                    if ($orders_tot) {
                        $sum_orders += $orders_tot->paid;
                    }
                }
            }
    }
    return $sum_orders;
}
function addEmployeeToDevice($empCode, $departmentId, $areaIds, $firstName = null, $lastName = null, $hireDate = null, $gender = null, $mobile = null, $email = null)
{
    try {
        $url = 'http://127.0.0.1:8085/personnel/api/employees/';
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0b2tlbl90eXBlIjoiYWNjZXNzIiwiZXhwIjoxNzMxNTgzODk2LCJpYXQiOjE3MzE0OTc0OTYsImp0aSI6Ijk0YzRlYjQzY2I2MzRhMDdhNWIwMzZjOTZmOWM4NDVkIiwidXNlcl9pZCI6MX0.6uMFiXnFHEB_I5baP8qvgWkG_z7BXjPLWaU5QEfuCMg';

        $data = [
            'emp_code' => $empCode,
            'department' => $departmentId,
            'area' => $areaIds,
            'hire_date' => $hireDate ?? now()->toDateString(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'gender' => $gender,
            'mobile' => $mobile,
            'email' => $email,
        ];

        $client = new Client();

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'JWT ' . $token,
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        if ($response->getStatusCode() == 201) {
            return json_decode($response->getBody()->getContents(), true);
        } else {
            return 'Failed to add employee. Status code: ' . $response->getStatusCode();
        }
    } catch (\Exception $e) {
        Log::error('Error adding employee to BioTime device: ' . $e->getMessage());
        return 'Error: ' . $e->getMessage();
    }
}

function CalculateDeficitOrder($open_amount = 0, $close_amount = 0, $real_amount = 0)
{
    $remaining_amount = ($close_amount - $open_amount);
    return ($remaining_amount - $real_amount);
}

function CalculateEmployeeLeave($employee_id, $leave_type, $leave_year_count)
{
    $first_day = date('Y-01-01');
    $last_day = date('Y-12-31');
    return $employee_leave_count = LeaveRequest::where('employee_id', $employee_id)->where('leave_type_id', $leave_type)->where('agreement', 2)->whereBetween('date', [$first_day, $last_day])->sum('leave_count');
}

function CheckExistOrder($client_id)
{
    $Order = Order::where('client_id', $client_id)->where('status', 'open')->fisrt();
    return $Order;
}
function CheckOrderPaid($order_id)
{

    return  OrderTransaction::where('order_id', $order_id)->exists();
}
function GetCurrencyCodes()
{
    $Currencies = Country::select('currency_code', 'id')->get();
    return $Currencies;
}
function GetCountries()
{
    $countries = Country::select('phone_code', 'id', 'flag')->get();
    return $countries;
}

function AddBranchesMenu($branch_ids, $dish_id)
{
    $add_dish_categories = AddDishCategories($branch_ids, $dish_id);
    $add_dishes = AddDishes($branch_ids, $dish_id);
    $add_addon_category = AddAddonCategories($branch_ids, $dish_id);
    $add_addons = AddAddons($branch_ids, $dish_id);
    $add_sizes = AddSizes($branch_ids, $dish_id);
}

function AddDishCategories($branch_ids, $dish_id)
{
    if ($dish_id != 0) {
        $get_dish = Dish::where('id', $dish_id)->first();
        $get_dish_categories = DishCategory::where('id', $get_dish->category_id)->get();
    } else {
        $get_dish_categories = DishCategory::get();
    }

    if ($get_dish_categories) {
        foreach ($get_dish_categories as $get_dish_category) {
            foreach ($branch_ids as $branch_id) {
                $branch_menu_category = BranchMenuCategory::firstOrCreate(
                    ['dish_category_id' => $get_dish_category->id, 'branch_id' => $branch_id],
                    ['is_active' => 1, 'created_by' => auth()->user()->id]
                );
            }
        }
    }
}

function AddDishes($branch_ids, $dish_id)
{
    if ($dish_id != 0) {
        $get_dishes = Dish::where('id', $dish_id)->get();
    } else {
        $get_dishes = Dish::get();
    }
    if ($get_dishes) {
        foreach ($get_dishes as $get_dish) {
            $get_branch_menu_category = BranchMenuCategory::where('dish_category_id', $get_dish->category_id)->first();
            foreach ($branch_ids as $branch_id) {
                $branch_menu_category = BranchMenu::firstOrCreate(
                    ['dish_id' => $get_dish->id, 'branch_id' => $branch_id],
                    [
                        'branch_menu_category_id' => $get_branch_menu_category->id,
                        'price' => $get_dish->price,
                        'is_product' => 0,
                        //'is_product' => $get_dish->price,
                        'is_active' => 1,
                        'created_by' => auth()->user()->id
                    ]
                );
            }
        }
    }
}

function AddAddonCategories($branch_ids, $dish_id)
{
    if ($dish_id != 0) {
        $get_dish = Dish::where('id', $dish_id)->with('dishAddonsDetails')->first();
        $addon_categories = $get_dish->dishAddonsDetails->pluck('addon_category_id');
        $get_addon_categories = AddonCategory::whereIn('id', $addon_categories)->get();
    } else {
        $get_addon_categories = AddonCategory::get();
    }

    if ($get_addon_categories) {
        foreach ($get_addon_categories as $get_addon_category) {
            foreach ($branch_ids as $branch_id) {
                $branch_menu_addon_category = BranchMenuAddonCategory::firstOrCreate(
                    ['branch_id' => $branch_id, 'addon_category_id' => $get_addon_category->id],
                    [
                        'is_active' => 1,
                        'created_by' => auth()->user()->id
                    ]
                );
            }
        }
    }
}

function AddAddons($branch_ids, $dish_id)
{
    if ($dish_id != 0) {
        $get_dish = Dish::where('id', $dish_id)->with('dishAddonsDetails')->first();
        $addons = $get_dish->dishAddonsDetails->pluck('id');
        $get_addons = DishAddon::whereIn('id', $addons)->get();
    } else {
        $get_addons = DishAddon::get();
    }

    if ($get_addons) {
        foreach ($get_addons as $get_addon) {
            //$menu = BranchMenu::where('dish_id', $get_addon->dish_id)->first();
            $branch_menu_addon_category = BranchMenuAddonCategory::where('addon_category_id', $get_addon->addon_category_id)->first();
            foreach ($branch_ids as $branch_id) {
                $branch_menu_category = BranchMenuAddon::firstOrCreate(
                    ['dish_id' => $get_addon->dish_id, 'branch_id' => $branch_id, 'dish_addon_id' => $get_addon->id],
                    [
                        'branch_menu_addon_category_id' => $branch_menu_addon_category->id,
                        'price' => $get_addon->price,
                        'is_active' => 1,
                        'created_by' => auth()->user()->id
                    ]
                );
            }
        }
    }
}

function AddSizes($branch_ids, $dish_id)
{
    if ($dish_id != 0) {
        $get_sizes = DishSize::where('dish_id', $dish_id)->get();
    } else {
        $get_sizes = DishSize::all();
    }

    if ($get_sizes) {
        foreach ($get_sizes as $get_size) {
            //$menu = BranchMenu::where('dish_id', $get_size->dish_id)->first();
            foreach ($branch_ids as $branch_id) {
                $branch_menu_category = BranchMenuSize::firstOrCreate(
                    ['dish_id' => $get_size->dish_id, 'branch_id' => $branch_id, 'dish_size_id' => $get_size->id],
                    [
                        'price' => $get_size->price,
                        'is_active' => 1,
                        'created_by' => auth()->user()->id
                    ]
                );
            }
        }
    }
}


function getDefaultBranch()
{
    $defaultBranch = Branch::where('is_default', 1)->first();
    $defaultBranch->makeHidden(['name_site', 'address_site']);
    if (!$defaultBranch) {
        throw new Exception('No default branch is set.');
    }
    return $defaultBranch ? $defaultBranch->id : null;
}


function respondError($error, $code, $errorMessages = [])
{
    if ($code == 404) {
        $code1 = 404;
    } elseif ($code == 500) {
        $code1 = 500;
    } else {
        $code1 = 200;
    }
    $response = [
        'code' => $code,
        'status' => false,
        'message' => $error,
        'data' => null,
        'errorData' => null
    ];


    if (!empty($errorMessages)) {
        $response['errorData'] = $errorMessages;
    }


    return response()->json($response, $code1);
}
function getMostDishesOrdered($IDBranch, $limit = 5)
{
    return BranchMenu::select('dishes.*')
    ->leftJoin('dishes', 'dishes.id', 'branch_menus.dish_id')
    ->leftJoin('branches', 'branches.id', 'branch_menus.branch_id')
    ->leftJoin('order_details', 'order_details.dish_id', '=', 'dishes.id')
    ->leftJoin('countries', 'countries.id', '=', 'branches.country_id') // Join the countries table
    ->groupBy('dishes.id', 'dishes.name_ar', 'countries.currency_symbol') // Include currency_symbol in GROUP BY
    ->selectRaw('SUM(order_details.quantity) as total_quantity')
    ->selectRaw('countries.currency_symbol as currency_symbol') // Select the currency symbol
    ->where('branch_id', $IDBranch)
    ->orderByDesc('total_quantity')
    ->orderBy('dishes.created_at', 'desc') // Order by newest first
    ->limit($limit)
    ->get();

}
function checkDishExistMostOrderd($IDBranch, $id)
{
    $Dishes =  BranchMenu::select('dishes.*')
        ->leftJoin('dishes', 'dishes.id', 'branch_menus.dish_id')
        ->leftJoin('order_details', 'order_details.dish_id', '=', 'dishes.id')
        ->groupBy('dishes.id', 'dishes.name_ar')
        ->where('branch_id', $IDBranch)
        ->selectRaw('SUM(order_details.quantity) as total_quantity')
        ->orderByDesc('total_quantity')
        ->limit(5)
        ->pluck('id')->toArray();
    if (in_array($id, $Dishes)) {
        return true;
    }
    return false;
}

function checkOfferUsed($id)
{
    return OrderDetail::where('offer_id', $id)->exists();
}

function getAddressFromLatLong($latitude, $longitude)
{
    $apiKey = env('GOOGLE_MAPS_API_KEY');
    $url = "https://maps.googleapis.com/maps/api/geocode/json";

    $response = Http::get($url, [
        'latlng' => "{$latitude},{$longitude}",
        'key' => $apiKey,
    ]);

    if ($response->successful() && isset($response['results'][0])) {
        $result = $response['results'][0];
        return [
            'formatted_address' => $result['formatted_address'] ?? null,
            'city' => collect($result['address_components'])->firstWhere('types', 'locality')['long_name'] ?? null,
            'state' => collect($result['address_components'])->firstWhere('types', 'administrative_area_level_1')['long_name'] ?? null,
            'country' => collect($result['address_components'])->firstWhere('types', 'country')['long_name'] ?? null,
            'postal_code' => collect($result['address_components'])->firstWhere('types', 'postal_code')['long_name'] ?? null,
        ];
    }

    return null;
}
