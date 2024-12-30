<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Events\UserRegistered;
use App\Models\ClientAddress;
use App\Models\ClientDetail;
use App\Models\Country;
use App\Models\User;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class AuthController extends Controller
{
    protected $clientService;
    protected $checkToken;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
        $this->checkToken = false;
    }
    public function register(Request $request)
    {
        $lang = app()->getLocale(); // Get the current language

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
            'email.unique' => __('validation.unique', ['attribute' => __('auth.email')]),
            'country_code.required' => __('validation.required', ['attribute' => __('auth.country_code')]),
            'password.required' => __('validation.required', ['attribute' => __('auth.password')]),
            'password.min' => __('validation.min.string', ['attribute' => __('auth.password'), 'min' => 6]),
            'phone.required' => __('validation.required', ['attribute' => __('auth.phoneplace')]),
            'phone.regex' => __('validation.regex', ['attribute' => __('auth.phoneplace')]),
            'phone.unique' => __('validation.unique', ['attribute' => __('auth.phone')]),
            'date_of_birth.date' => __('validation.date', ['attribute' => __('auth.date')]),
        ]);

        // If validation fails, return a localized error response
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if the country code is valid
        $country = Country::where('phone_code', $request->country_code)->first();

        if (!$country) {
            return response()->json([
                'status' => 'error',
                'errors' => ['country_code' => [__('validation.phone_code', ['attribute' => __('auth.phone_code')])]],
            ], 422);
        }

        // Use a database transaction to ensure data consistency
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->flag = 'client';
            $user->phone = $request->phone;
            $user->country_id = $country->id;
            $user->country_code = $request->country_code;
            $user->birth_date = $request->date_of_birth;
            $user->password = Hash::make($request->password);
            $user->save();

            event(new UserRegistered($user));

            Auth::guard('client')->login($user);
            Auth::setUser($user);

            $request->session()->regenerate();


            return response()->json([
                'status' => 'success',
                'message' => __('Registration successful!'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => __('An error occurred during registration. Please try again later.'),
            ], 500);
        }
    }


    public function login(Request $request)
    {
        // Set the application language
        $lang = app()->getLocale();

        // Validation rules and localized error messages
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
            'country_code_login' => 'required|string',
            'address' => 'nullable|json', // Optional: Validate address as JSON
        ], [
            'email_or_phone.required' => __('validation.required', ['attribute' => __('auth.phone')]),
            'password.required' => __('validation.required', ['attribute' => __('auth.password')]),
            'country_code_login.required' => __('validation.required', ['attribute' => __('auth.country_code_login')]),
            'address.json' => __('validation.json', ['attribute' => __('auth.address')]),
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if the input is email or phone
        $userQuery = User::where('country_code', $request->country_code_login);
        if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
            $userQuery->where('email', $request->email_or_phone);
        } else {
            $userQuery->where('phone', $request->email_or_phone);
        }

        $user = $userQuery->first();

        // Validate user existence and role
        if (!$user || $user->flag != 'client') {
            return response()->json([
                'status' => 'error',
                'errors' => ['email_or_phone' => [__('validation.notfound', ['attribute' => __('auth.phone')])]],
            ], 422);
        }

        // Check the password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => ['password' => [__('auth.invalid_credentials')]],
            ], 403);
        }

        // Log the user in and regenerate the session
        Auth::guard('client')->login($user);
        $request->session()->regenerate();

        // Optional: Save the address if provided (function implementation required)
        // if ($request->filled('address')) {
        //     $this->saveAddress($request->input('address'), $user);
        // }

        // Success response
        return response()->json([
            'status' => 'success',
            'message' => __('auth.login_success'),
        ]);
    }


    public function saveAddress($data)
    {
        $jsonData = $data;
        if (!$jsonData) {
            return response()->json(['status' => 'error', 'message' => 'Address data is missing'], 422);
        }
        $addressData = json_decode($jsonData, true);

        $address = json_decode($addressData);
        $name = $address->namevilla ||
            // Example: Access specific fields
            $villaName = $address->namevilla;


        // Save address if provided
        if ($address) {
            $clientAddress = new ClientAddress();
            $clientAddress->user_id = $user->id;
            $clientAddress->address = $address['address'];
            $clientAddress->city = $address['city'];
            $clientAddress->state = $address['state'];
            $clientAddress->postal_code = $address['postal_code'] ?? null;
            $clientAddress->latitude = $address['latitude'] ?? null;
            $clientAddress->longtitude = $address['longtitude'] ?? null;
            $clientAddress->is_default = $address['is_default'] ?? 0;
            $clientAddress->is_active = 1;
            $clientAddress->save();
        }
    }

    public function logout(Request $request)
    {
        // Logout the client guard
        Auth::guard('client')->logout();

        // Remove session data specific to the client guard
        $request->session()->forget('client');

        // Regenerate the CSRF token for security
        $request->session()->regenerateToken();

        // Redirect to the login page or another appropriate route
        return redirect()->route('home');
    }

    public function checkPhone(Request $request)
    {
        $request->validate([
            'country_code_forget' => 'required|string',  // You can add more rules for the country code if necessary
            'phoneforget' => 'required|regex:/^01[0-9]{9}$/',  // Example validation for Egyptian phone numbers
        ], [
            'country_code_forget.required' => __('validation.required', ['attribute' => __('auth.country_code_forget')]),
            'phoneforget.required' => __('validation.required', ['attribute' => __('auth.phone')]),
        ]);

        // Check if the phone number with the country code exists in the database
        $phoneExists = User::where('phone', $request->phoneforget)
            ->where('country_code', $request->country_code_forget)
            ->exists();
        //               dd($phoneExists);
        if ($phoneExists) {
            return response()->json([
                'status' => 'success',
                'phone' => $request->phoneforget,
                'country_code_forget' => $request->country_code_forget
            ]);
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
        $lang = app()->getLocale();

        $validator = Validator::make($request->all(), [
            'phone' => 'required_if:auth,null|numeric',
            'password' => 'required|min:6|confirmed',

        ], [
            'phone.required_if' => __('validation.required', ['attribute' => __('auth.phone')]),
            'phone.numeric' => __('validation.numeric', ['attribute' => __('auth.phone')]),
            'password.required' => __('validation.required', ['attribute' => __('auth.password')]),
            'password.confirmed' => __('validation.confirmed', ['attribute' => __('auth.password')]),
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return errors with the old input values
            return back()->withErrors($validator)->withInput();
        }

        // Check if the user is authenticated
        if (Auth::guard('client')->check()) {
            $user = Auth::guard('client')->user();
        } else {
            $user = User::where('phone', $request->phone)->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => __('auth.phone_not_found'),
                ], 404);
            }
        }

        // Ensure the new password is not the same as the old one
        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => __('auth.password_same_as_previous'),
            ], 422);
        }

        // Update the password
        $user->update(['password' => Hash::make($request->password)]);

        // Log in the user if they were found via phone
        if (!Auth::guard('client')->check()) {
            Auth::guard('client')->login($user);
            $request->session()->regenerate();
            return response()->json([
                'status' => 'success',
                'message' => __('auth.password_reset_success'),
            ]);
        }

        return redirect()->route('website.profile.view')->with('message', __('auth.profile_updated'));
    }



    public function viewProfile()
    {
        return view('website.auth.profile');
    }
    public function updateProfile(Request $request)
    {
        $lang = app()->getLocale();
        ;

        // Fetch phone length dynamically
        $phone_length = Country::where('phone_code', $request->country_code_profile)->value('length');

        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($phone_length) {
                    if ($phone_length && strlen($value) != $phone_length) {
                        $fail(__('validation.custom.phone.length', ['attribute' => __('auth.phone'), 'length' => $phone_length]));
                    }
                },
            ],
            'email' => 'required|email',
            'birth_date' => 'nullable|date_format:Y-m-d',
        ], [
            'name.required' => __('validation.required', ['attribute' => __('auth.name')]),
            'phone.required' => __('validation.required', ['attribute' => __('auth.phone')]),
            'phone.numeric' => __('validation.custom.phone.numeric', ['attribute' => __('auth.phone')]),
            'email.required' => __('validation.required', ['attribute' => __('auth.email')]),
            'email.email' => __('validation.email', ['attribute' => __('auth.email')]),
            'birth_date.date_format' => __('validation.date_format', ['attribute' => __('auth.birth_date'), 'format' => 'Y-m-d']),
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Return errors with the old input values
            return back()->withErrors($validator)->withInput();
        }

        // Update user profile
        $user = Auth::guard('client')->user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->birth_date = $request->birth_date;
        $user->country_code = $request->country_code_profile;
        $user->country_id = Country::where('phone_code', $request->country_code_profile)->value('id');
        $user->save();

        return redirect()->route('website.profile.view')->with('message', __('auth.profile_updated'));
    }
}
