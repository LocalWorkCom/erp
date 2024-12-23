<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Events\UserRegistered;
use App\Models\ClientDetail;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        $lang = $request->header('lang', 'ar'); // Default to Arabic if no 'lang' header is provided
        App::setLocale($lang);

        // Validation rules
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "email" => "required|email|unique:users",
            'country_code' => 'required|string',
            "password" => "required|min:6",
            'phone' => [
                'required',
                'string',
                'regex:/^[0-9]+$/', // Ensures only numbers are allowed
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('country_code', $request->country_code);
                }),
            ],
            "date_of_birth" => "nullable|date",
        ], [
            // Custom messages for validation errors (localized)
            'name.required' => __('validation.required', ['attribute' => __('auth.nameweb')]),
            'email.required' => __('validation.required', ['attribute' => __('auth.emailweb')]),
            'email.unique' => __('validation.unique', ['attribute' => __('auth.emailweb')]),
            'country_code.required' => __('validation.required', ['attribute' => __('auth.country_code')]),
            'password.required' => __('validation.required', ['attribute' => __('auth.password')]),
            'password.min' => __('validation.min.string', ['attribute' => __('auth.password'), 'min' => 6]),
            'phone.required' => __('validation.required', ['attribute' => __('auth.phoneplace')]),
            'phone.regex' => __('validation.regex', ['attribute' => __('auth.phoneplace')]),
            'phone.unique' => __('validation.unique', ['attribute' => __('auth.phoneplace')]),
            'date_of_birth.date' => __('validation.date', ['attribute' => __('auth.date')]),
        ]);

        // If validation fails, return a localized error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if the country code is valid
        $country = Country::where('phone_code', $request->country_code)->first();

        if (!$country) {
            return response()->json([
                'status' => 'error',
                'errors' => ['country_code' => [__('validation.phone_code', ['attribute' => __('auth.phone_code')])]], // Localized message
            ], 422);
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

        Auth::guard('client')->login($user);
        Auth::setUser($user);

        $request->session()->regenerate();

        return response()->json([
            'status' => 'success',
            'message' => __('Registration successful!'),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email_or_phone' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('phone', $credentials['email_or_phone'])->first();

        if (!$user || $user->flag != 'client') {
            return back()->withErrors([
                'email_or_phone' => __('auth.only_admin'),
            ])->onlyInput('email_or_phone');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email_or_phone' => __('auth.invalid_credentials'),
            ])->onlyInput('email_or_phone');
        }

        Auth::guard('client')->login($user);
        Auth::setUser($user);

        $request->session()->regenerate();

        return redirect()->route('home');
    }
    public function logout(Request $request)
    {
        // Logout the client guard
        Auth::guard('client')->logout();

        // Invalidate the session to clear all data
        $request->session()->invalidate();

        // Regenerate the CSRF token for security
        $request->session()->regenerateToken();

        // Redirect to the login page or another appropriate route
        return redirect()->route('home');
    }

    public function checkPhone(Request $request)
    {
        $request->validate([
            'phoneforget' => 'required|regex:/^01[0-9]{9}$/', // Example validation for Egyptian phone numbers
        ]);

        // Simulate checking phone number
        $phoneExists = User::where('phone', $request->phoneforget)->exists();

        if ($phoneExists) {
            return response()->json(['status' => 'success', 'phone' => $request->phoneforget]);
        }

        return response()->json([
            'errors' => [
                'phoneforget' => [__('auth.phone_not_found')]
            ],
            'phone' => $request->phoneforget
        ], 422);
    }
    public function resetPassword(Request $request)
    {
       // dd($request->all());
        // Validate input
        $request->validate([
            'phone' => 'required', // Validate phone number
            'password' => 'required|min:6|confirmed', // Password confirmation
        ]);

        // Find user by phone number
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => __('auth.phone_not_found'),
            ], 404);
        }

        // Update the user's password
        $user->update([
            'password' => bcrypt($request->password),
        ]);
        Auth::guard('client')->login($user);
        Auth::setUser($user);

        $request->session()->regenerate();
        return response()->json([
            'status' => 'success',
            'message' => __('auth.password_reset_success'),
        ]);
    }
}
