<?php

namespace App\Http\Controllers\Api;

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
            'country_id' => 'required',
            "password" => "required",
            'phone' => 'required',
            "city" => "nullable|string",
            "state" => "nullable|string",
            "postal_code" => "nullable|string",
            "date_of_birth" => "nullable|date",
            "address" => "nullable|string",

        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        //  Create User
        $user = new User();
        $user->name = $request->first_name . ' ' . $request->last_name;
        $user->email = $request->email;
        $user->flag = 1;
        $user->phone = $request->phone;
        $user->country_id = $request->country_id;
        $user->password = Hash::make($request->password);
        $user->save();


        // Create Client Details
        $clientDetail = new ClientDetail();
        $clientDetail->user_id = $user->id;
        $clientDetail->first_name = $request->first_name;
        $clientDetail->last_name = $request->last_name;
        $clientDetail->email = $request->email;
        $clientDetail->password = $request->password;
        $clientDetail->phone_number = $request->phone;
        $clientDetail->date_of_birth = $request->date_of_birth;
        $clientDetail->save();

        // Create Client Address
        $clientAddress = new ClientAddress();
        $clientAddress->client_details_id = $clientDetail->id;
        $clientAddress->address = $request->address;
        $clientAddress->city = $request->city;
        $clientAddress->state = $request->state;
        $clientAddress->postal_code = $request->postal_code ?? null;
        $clientAddress->save();



        // Response
        return response()->json([
            "status" => true,
            "message" => $lang == 'ar'
                ? 'تم التسجيل بنجاح'
                : "User created successfully"
        ]);
    }
    public function Login(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale(locale: $lang);  // Set the locale based on the header

            // Validate email and password fields
            $validator = Validator::make($request->all(), [
                "email" => "required|email",
                "password" => "required"
            ]);

            if ($validator->fails()) {
                return RespondWithBadRequestWithData($validator->errors());
            }

            // Attempt to authenticate the user
            if (Auth::attempt([
                "email" => $request->email,
                "password" => $request->password
            ])) {
                $user = Auth::user();

                // Check if the user is a client
                if ($user->flag == 1) {
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

        // Check if the user has the correct flag

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
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);
        auth()->user()->token()->revoke();
        return ResponseWithSuccessData($lang, null, 4);
    }
    public function profile(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $user = Auth::user();

        $clientDetails = $user->clientDetails()->with('addresses')->first();

        // Check if the client details exist
        if (!$clientDetails) {
            return response()->json([
                "status" => false,
                "message" => $lang == 'ar'
                    ? 'لم يتم العثور على تفاصيل العميل'
                    : "Client details not found"
            ], 404);
        }

        // Return the client details along with related addresses
        return response()->json([
            "status" => true,
            "message" => $lang == 'ar'
                ? 'تم عرض تفاصيل العميل بنجاح'
                : "Client details retrieved successfully",
            "data" => $clientDetails
        ]);
    }
}
