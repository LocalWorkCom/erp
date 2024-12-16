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
            "first_name" => "required|string",
            "last_name" => "required|string",
            "email" => "required|email|unique:users",
            'country_id' => 'required|exists:countries,id',
            "password" => "required",
            'phone' => 'required|unique:users,phone',
            "city" => "required|string",
            "state" => "required|string",
            "postal_code" => "nullable|string",
            "date_of_birth" => "nullable|date",
            "address" => "required|string",

        ]);

        if ($validator->fails()) {
            return respondError('Validation Error.', $validator->errors(), 400);

            // return RespondWithBadRequestWithData($validator->errors());
        }

        //  Create User
        $user = new User();
        $user->name = $request->first_name . ' ' . $request->last_name;
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
        $clientDetail->first_name = $request->first_name;
        $clientDetail->last_name = $request->last_name;
        $clientDetail->date_of_birth = $request->date_of_birth;
        $clientDetail->save();

        // Create Client Address
        $clientAddress = new ClientAddress();
        $clientAddress->user_id = $user->id;
        $clientAddress->address = $request->address;
        $clientAddress->city = $request->city;
        $clientAddress->state = $request->state;
        $clientAddress->postal_code = $request->postal_code ?? null;
        $clientAddress->save();



        // Response
        return RespondWithSuccessRequest($lang, 23);
    }
    public function Login(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale(locale: $lang);  // Set the locale based on the header
            $messages = [
                'email.required' => 'البريد الالكتروني مطلوب.',
                'email.exists' => 'بيانات الاعتماد غير صحيحة.',
                'password.required' => 'كلمة المرور مطلوبة.',
            ];
        
            // Validate the request
            $validator = Validator::make($request->all(), [
                "email" => "required|email|exists:users,email",
                "password" => "required"
            ], $messages);

            if ($validator->fails()) {
                return respondError('Validation Error.', $validator->errors(), 400);

                // return RespondWithBadRequestWithData($validator->errors());
            }

            // Attempt to authenticate the user
            if (Auth::attempt([
                "email" => $request->email,
                "password" => $request->password
            ])) {

                $user = Auth::user();

                $token = $user->createToken("myToken")->accessToken;

                $data = [
                    "access_token" => $token,
                    'data' => $user
                ];

                return ResponseWithSuccessData($lang, $data, 12);
            } else {
                return respondError('Password Error', [
                    'crediential' => ['كلمة المرور لا تتطابق مع سجلاتنا']
                ], 403);
                // return RespondWithBadRequest($lang, 13);
            }
        } catch (\Exception $e) {
            return RespondWithBadRequest($lang, 14);
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
