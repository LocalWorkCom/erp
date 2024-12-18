<?php

namespace App\Http\Controllers\Api;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\ClientAddress;
use App\Models\ClientDetail;
use App\Models\User;
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

        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required",
            'password_confirm' => 'required|same:password',

        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }
        $user = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $user->password) == true) {
            return RespondWithBadRequest($lang, 3);
        }
        Auth::login($user);
        $user->password = Hash::make($request->password);
        $user->save();
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $userData = $user->only(['id', 'name', 'email', 'phone']);

        $success['user'] = array_merge($userData);
        return ResponseWithSuccessData($lang, $success, 15);
    }


    public function Logout(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);
        auth()->user()->token()->revoke();
        return ResponseWithSuccessData($lang, null, 16);
    }
}
