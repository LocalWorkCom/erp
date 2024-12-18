<?php

namespace App\Http\Controllers\Api;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\ClientAddress;
use App\Models\ClientDetail;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|email|unique:users",
            'country_id' => 'required|exists:countries,id',
            "password" => "required",
            'phone' => 'required|unique:users,phone',
            "date_of_birth" => "nullable|date",
            // "city" => "nullable|string",
            // "state" => "required|string",
            // "postal_code" => "nullable|string",
            // "address" => "required|string",

        ]);

        if ($validator->fails()) {
            return respondError('Validation Error.', 400, $validator->errors());
        }

        //  Create User
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->flag = 'client';
        $user->phone = $request->phone;
        $user->country_id = $request->country_id;
        $user->password = Hash::make($request->password);
        $user->save();

        event(new UserRegistered($user));

        // Create Client Details
        $clientDetail = new ClientDetail();
        $clientDetail->user_id = $user->id;
        $clientDetail->date_of_birth = $request->date_of_birth;
        $clientDetail->save();

        // Create Client Address
        // $clientAddress = new ClientAddress();
        // $clientAddress->user_id = $user->id;
        // $clientAddress->address = $request->address;
        // $clientAddress->city = $request->city;
        // $clientAddress->state = $request->state;
        // $clientAddress->postal_code = $request->postal_code ?? null;
        // $clientAddress->save();



        // Response
        return RespondWithSuccessRequest($lang, 23);
    }
    public function Login(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale($lang); // Set the locale based on the header

            $messages = [
                'email_or_phone.required' => 'البريد الإلكتروني أو رقم الهاتف مطلوب.',
                'password.required' => 'كلمة المرور مطلوبة.',
                'email_or_phone.exists' => 'البريد الإلكتروني أو رقم الهاتف غير موجود.',
            ];

            // Validate the request
            $validator = Validator::make($request->all(), [
                "email_or_phone" => "required",
                "password" => "required"
            ], $messages);

            if ($validator->fails()) {
                return respondError('Validation Error.', 400, $validator->errors());
            }

            // Determine whether input is email or phone
            $credentials = [];

            if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
                $credentials['email'] = $request->email_or_phone;
            } else {
                $credentials['phone'] = $request->email_or_phone;
            }

            $credentials['password'] = $request->password;

            // Attempt to authenticate the user
            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                $token = $user->createToken("myToken")->accessToken;

                $data = [
                    "access_token" => $token,
                    'data' => $user
                ];

                return ResponseWithSuccessData($lang, $data, 12);
            } else {
                return respondError('Password Error', 403, [
                    'credential' => ['كلمة المرور لا تتطابق مع سجلاتنا']
                ]);
            }
        } catch (\Exception $e) {
            return respondError('An error occurred.', 500, ['error' => $e->getMessage()]);
        }
    }

    public function reset_password(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $messages = [
            "phone.required" => "رقم الهاتف مطلوب.",
            "phone.exists" => "رقم الهاتف غير مسجل.",
            // "otp.required" => "رمز التحقق مطلوب.",
            "password.required" => "كلمة المرور الجديدة مطلوبة.",
            "password_confirm.required" => "تأكيد كلمة المرور مطلوب.",
            "password_confirm.same" => "تأكيد كلمة المرور يجب أن يطابق كلمة المرور الجديدة.",
        ];

        $validator = Validator::make($request->all(), [
            "phone" => "required|exists:users,phone",
            // "otp" => "required",
            "password" => "required",
            "password_confirm" => "required|same:password",
        ], $messages);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Verify OTP
        // if (!$this->verifyPhone($request->phone, $request->otp)) {
        //     return respondError("Invalid or expired OTP.", 400, [
        //         'otp' => ['رمز التحقق غير صالح أو منتهي الصلاحية.']
        //     ]);
        // }

        $user = User::where('phone', $request->phone)->first();

        // Check if the new password is the same as the old one
        if (Hash::check($request->password, $user->password)) {
            return RespondWithBadRequest($lang,  3);
        }

        // Reset the password
        $user->password = Hash::make($request->password);
        $user->save();

        // Generate a new token
        $token = $user->createToken("MyApp")->accessToken;

        $userData = $user->only(['id', 'name', 'email', 'phone']);
        $success = [
            "token" => $token,
            "user" => $userData,
        ];

        return ResponseWithSuccessData($lang, $success, 15);
    }


    // private function verifyPhone($phone, $otpInput)
    // {
    //     $otpRecord = Otp::where('phone', $phone)
    //         ->where('otp', $otpInput)
    //         ->first();

    //     // Check if OTP exists and is not expired
    //     if ($otpRecord && Carbon::now()->lt(Carbon::parse($otpRecord->expires_at))) {
    //         // OTP is valid, delete it after verification
    //         $otpRecord->delete();

    //         return true;
    //     }

    //     return false; // OTP is invalid or expired
    // }

    // public function generateAndSendOtp($phone)
    // {
    //     $otp = rand(100000, 999999); // Generate a 6-digit OTP

    //     // Save OTP in the database with an expiration time (e.g., 5 minutes)
    //     Otp::updateOrCreate(
    //         ['phone' => $phone],
    //         [
    //             'otp' => $otp,
    //             'expires_at' => now()->addMinutes(5),
    //         ]
    //     );

    //     // Send OTP to the user via SMS or other methods
    //     // Example: Log OTP for demonstration purposes
    //     Log::info("OTP for phone $phone: $otp");

    //     return true; // Return success
    // }


    public function Logout(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);
        auth()->user()->token()->revoke();
        return ResponseWithSuccessData($lang, null, 16);
    }
}
