<?php

namespace App\Http\Controllers\Api;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\ClientAddress;
use App\Models\ClientDetail;
use App\Models\Country;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|email|unique:users",
            'country_code' => 'required|string',
            "password" => "required|min:6",
            'phone' => [
                'required',
                'string',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('country_code', $request->country_code);
                }),
            ],
            "date_of_birth" => "nullable|date",

        ]);

        if ($validator->fails()) {
            return respondError('Validation Error.', 400, $validator->errors());
        }

        $country = Country::where('phone_code', $request->country_code)->first();

        if (!$country) {
            return respondError('Invalid country code.', 400, [
                'credential' => [__('validation.countryCodeExists')]
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->flag = 'client';
        $user->phone = $request->phone;
        $user->country_id = $country->id;
        $user->country_code = $request->country_code;
        $user->password = Hash::make($request->password);
        $user->save();

        event(new UserRegistered($user));

        $clientDetail = new ClientDetail();
        $clientDetail->user_id = $user->id;
        $clientDetail->date_of_birth = $request->date_of_birth;
        $clientDetail->save();

        return RespondWithSuccessRequest($lang, 23);
    }
    public function Login(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale($lang);

            $messages = [
                'email_or_phone.required' => __('validation.email_or_phone.required'),
                'password.required' => __('validation.password.required'),
                'country_code.required_if' => __('validation.country_code.required_if'),
            ];

            $validator = Validator::make($request->all(), [
                "email_or_phone" => "required",
                "password" => "required",
                "country_code" => "required_if:email_or_phone," . ($this->isPhone($request->email_or_phone) ? $request->email_or_phone : ''),
            ], $messages);

            if ($validator->fails()) {
                return respondError('Validation Error.', 400, $validator->errors());
            }

            $isEmail = filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL);
            $user = $isEmail
                ? User::where('email', $request->email_or_phone)->first()
                : User::where('phone', $request->email_or_phone)
                ->where('country_code', $request->country_code)
                ->first();

            if (!$user) {
                $errorMessage = $isEmail
                    ? __('validation.emailDoesntExist')
                    : __('validation.phoneDoesntExist');

                return respondError('User Not Found.', 404, [
                    'email_or_phone' => [$errorMessage]
                ]);
            }

            $credentials = $isEmail
                ? ['email' => $request->email_or_phone, 'password' => $request->password]
                : ['phone' => $request->email_or_phone, 'password' => $request->password, 'country_code' => $request->country_code];

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                $token = $user->createToken("myToken")->accessToken;

                $data = [
                    "access_token" => $token,
                    'user' => $user
                ];

                return ResponseWithSuccessData($lang, $data, 12);
            } else {
                return respondError('Password Error', 403, [
                    'credential' => [__('validation.passwordMatch')]
                ]);
            }
        } catch (\Exception $e) {
            return respondError('An error occurred.', 500, ['error' => $e->getMessage()]);
        }
    }

    public function verifyPhone(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $messages = [
            "phone.required" => __('validation.email_or_phone.required'),
            "country_code.required" => __('validation.country_code.required'),
            "phone.exists" => __('validation.phoneDoesntExist'),
        ];

        $validator = Validator::make($request->all(), [
            "phone" => "required",
            "country_code" => "required",
        ], $messages);

        if ($validator->fails()) {
            return respondError('Validation Error.', 400, $validator->errors());
        }


        $userExists = User::where('phone', $request->phone)
            ->where('country_code', $request->country_code)
            ->exists();

        if (!$userExists) {
            return respondError(
                'Validation Error.',
                400,
                ['phone' => __('validation.phoneDoesntExist')]
            );
        }

        $data = [
            'phone' => $request->phone,
            'country_code' => $request->country_code,
        ];
        return ResponseWithSuccessData($lang, $data, 35);
    }

    public function resetPassword(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $messages = [
            "phone.required" => __('validation.email_or_phone.required'),
            "country_code.required" => __('validation.country_code.required'),
            "phone.exists" => __('validation.phoneDoesntExist'),
            "password.required" => __('validation.newPasswordRequired'),
            "password_confirm.required" => __('validation.confirmPassword'),
            "password_confirm.same" => __('validation.confirmPasswordSame'),
        ];

        $validator = Validator::make($request->all(), [
            "phone" => "required",
            "country_code" => "required",
            "password" => "required",
            "password_confirm" => "required|same:password",
        ], $messages);

        if ($validator->fails()) {
            return respondError('Validation Error.', 400, $validator->errors());
        }

        $user = User::where('phone', $request->phone)
            ->where('country_code', $request->country_code)
            ->first();

        if (!$user) {
            return respondError(
                'Validation Error.',
                400,
                ['phone' => __('validation.phoneDoesntExist')]
            );
        }

        // Check if the new password is the same as the old one
        if (Hash::check($request->password, $user->password)) {
            return respondError('Password Error', 403, [
                'password' => __('validation.newOldPassword')
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $token = $user->createToken("MyApp")->accessToken;

        $userData = $user->only(['id', 'name', 'email', 'country_code', 'phone']);
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

    private function isPhone($input)
    {
        return preg_match('/^\+?[0-9]+$/', $input) && !filter_var($input, FILTER_VALIDATE_EMAIL);
    }
}
