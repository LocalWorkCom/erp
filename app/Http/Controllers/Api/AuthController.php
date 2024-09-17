<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        // data validation
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            'country_id' => 'required',
            "password" => "required"
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->flag = 0;
        $user->phone = $request->phone;
        $user->country_id = $request->country_id;
        $user->password = Hash::make($request->password);
        $user->save();

        // Response
        return response()->json([
            "status" => true,
            "message" => "User created successfully"
        ]);
    }
    public function Login(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            App::setLocale($lang);  // Set the locale based on the header

            // Validate email and password fields
            $validator = Validator::make($request->all(), [
                "email" => "required|email",
                "password" => "required"
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validator->errors()->first()
                ]);
            }

            // Attempt to authenticate the user
            if (Auth::attempt([
                "email" => $request->email,
                "password" => $request->password
            ])) {
                $user = Auth::user();

                // Check the user's flag (e.g., if account is active)
                if ($user->flag == 0) {

                    $token = $user->createToken("myToken")->accessToken;
                    $data = [
                        "access_token" => $token,
                        'data' => $user
                    ];

                    return ResponseWithSuccessData($lang, $data, 1);
                } else {
                    Auth::logout();

                    return response()->json([
                        "status" => false,
                        "message" => $lang == 'ar'
                            ? "لا يمكنك دخول الموقع"
                            : "Sorry, you cannot log in"
                    ]);
                }
            } else {
                // Authentication failed (incorrect credentials)
                return response()->json([
                    "status" => false,
                    "message" => $lang == 'ar'
                        ? "البريد الإلكتروني أو كلمة المرور غير صحيحة"
                        : "Email or password is incorrect"
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => __($lang == 'ar'
                    ? 'حدث خطأ يرجى المحاولة مرة أخرى'
                    : "Failed to generate token."),
                "error" => $e->getMessage()
            ]);
        }
    }

    public function reset_password(Request $request)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale($lang);

        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required",
            'password_confirm' => 'required|same:password',

        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors()->first()
            ]);
        }
        $user = User::where('email', $request->email)->first();

        // Check if the user has the correct flag
        if ($user->flag !== 0) {
            return RespondWithBadRequestData($lang, 2);
        }

        if (Hash::check($request->password, $user->password) == true) {
            return RespondWithBadRequest($lang, 3);
        }
        Auth::login($user);
        $user->password = Hash::make($request->password);
        $user->save();
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $userData = $user->only(['id', 'name', 'email', 'phone']);

        $success['user'] = array_merge($userData);
        return ResponseWithSuccessData($lang, $success, 1);
    }


    public function Logout(Request $request)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale($lang);
        auth()->user()->token()->revoke();
        return ResponseWithSuccessData($lang, null, 4);
    }
    public function profile(Request $request)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale($lang);
        $userdata = User::with('country')->where('id', Auth::id())->first();
        return ResponseWithSuccessData($lang, $userdata, 1);
    }
}
