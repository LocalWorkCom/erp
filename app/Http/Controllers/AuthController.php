<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:users,phone',
            'country_code' => 'required|string|max:5',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'date_of_birth' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the user (client)
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'country_code' => $request->country_code,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_of_birth' => $request->date_of_birth,
            'type' => 'client', // Assuming 'type' column exists to differentiate between user types
        ]);

        // Log the user in (optional)
        auth()->login($user);

        // Redirect to the client dashboard or homepage
        return redirect()->route('client.dashboard')->with('success', __('Registration successful!'));
    }
    public function login(Request $request)
    {
        $rules = [
            'phone' => 'required|string',
            'phone_code' => 'required|string',
            'password' => 'required|string',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            // Handle validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Proceed if validation passes
        $credentials = $validator->validated();

        // Debugging information (optional)

        // Check if the user exists with the full phone number and check if the user is a client
        $user = User::where('phone', $credentials['phone'])
        ->where('country_code', $credentials['phone_code'])
        ->first();
        dd($user,$credentials['phone_code'] ,)
        // Check if user exists and if user flag is 'client'
        if (!$user || $user->flag != 'client') {

            return response()->json([
                'errors' => [
                    'phone' => [__('auth.only_client')] // Custom message for client login only
                ]
            ], 422);
        }

        // Verify the password
        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'errors' => [
                    'password' => [__('auth.invalid_credentials')] // Message for invalid credentials
                ]
            ], 422);
        }

        // Log the user in using Laravel's Auth system
        Auth::login($user);

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Respond with a success message and redirect URL
        return redirect()->route('home');
    }
    public function logout()
    {
        // Log the user out
        Auth::logout();

        // Redirect to the homepage or login page
        return redirect()->route('website.home')->with('success', __('You have been logged out successfully.'));
    }
}
