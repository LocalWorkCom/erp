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
            "password" => "required"
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->flag = 0 ;
        $user->phone = $request->phone;
        $user->country_id=$request->country_id;
        $user->password = Hash::make($request->password);
        $user->save();

        // User::create([
        //     "name" => $request->name,
        //     "email" => $request->email,
        //     'flag' => 0,
        //     'phone'=>$request->phone,
        //     'country_id' => $request->country_id,
        //     "password" => Hash::make($request->password)
        // ]);

        // Response
        return response()->json([
            "status" => true,
            "message" => "User created successfully"
        ]);
    }
    public function Login(Request $request) {
        try {
            $lang = $request->header('lang', 'en');
            App::setLocale($lang);  // Set the locale based on the header

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

            // Attempt to authenticate
            if (Auth::attempt(credentials: [
                "email" => $request->email,
                "password" => $request->password
            ])) {
                $user = Auth::user();


                // Check the user's flag
                if ($user->flag == 0) {

                    $token = $user->createToken("myToken")->accessToken;

                    return response()->json([
                        "status" => true,
                        "message" => __("Login successful"),
                        "access_token" => $token,
                        'data'=>$user
                    ]);
                } else {
                    Auth::logout();
                    return response()->json([
                        "status" => false,
                        "message" => $lang == 'ar'
                            ? "لا يمكنك دخول الموقع"
                            : "Sorry, you cannot log in"
                    ]);
                }
            }

            return response()->json([
                "status" => false,
                "message" => __("Invalid credentials")
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => __("Failed to generate token."),
                "error" => $e->getMessage()  // Return the error message for debugging
            ]);
        }
    }



    public function Logout(Request $request) {
        auth()->user()->token()->revoke();

        return response()->json([
            "status" => true,
            "message" => "User logged out"
        ]);
    }
    public function profile() {
        $userdata = Auth::user();

        return response()->json([
            "status" => true,
            "message" => "Profile data",
            "data" => $userdata
        ]);
    }
}
