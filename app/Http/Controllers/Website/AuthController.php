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
        //dd($request->all());
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
        // Set locale
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        // Validation rules
        $validator = Validator::make($request->all(), [
            'email_or_phone' => 'required|string',
            'password' => 'required|string',
            'country_code_login' => 'required|string',
            'address' => 'nullable|json', // Validate address as JSON
        ], [
            'email_or_phone.required' => __('validation.required', ['attribute' => __('auth.email_or_phone')]),
            'password.required' => __('validation.required', ['attribute' => __('auth.password')]),
            'country_code_login.required' => __('validation.required', ['attribute' => __('auth.country_code_login')]),
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Determine if input is email or phone
        $userQuery = User::where('country_code', $request->country_code_login);
        if (filter_var($request->email_or_phone, FILTER_VALIDATE_EMAIL)) {
            $userQuery->where('email', $request->email_or_phone);
        } else {
            $userQuery->where('phone', $request->email_or_phone);
        }

        $user = $userQuery->first();

        // Check if user exists and is a client
        if (!$user || $user->flag != 'client') {
            return response()->json([
                'status' => 'error',
                'errors' => ['email_or_phone' => [__('validation.notfound', ['attribute' => __('auth.email_or_phone')])]],
            ], 422);
        }

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'password' => [__('auth.invalid_credentials')]
                ]
            ], 403);
        }
        // Log the user in
        Auth::guard('client')->login($user);
        $request->session()->regenerate();


        $this->saveAddress($request->input('address'));


        return response()->json([
            'status' => 'success',
            'message' => __('auth.login_success')
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
        if (Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => __('auth.password_same_as_previous'),
            ], 422); // Password can't be the same as the previous one
        }
        // Update the user's password
        $user->update([
            'password' => Hash::make($request->password),
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
