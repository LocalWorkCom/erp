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
        $credentials = $request->validate([
            'email_or_phone' => 'required',
            'password' => 'required',
        ]);

        // Find the user by email
        $user = User::where('phone', $credentials['email_or_phone'])->first();

        // Check if the user exists and ensure the user is not an admin
        if (!$user || $user->flag == 'phone') {
            return back()->withErrors([
                'email_or_phone' => __('auth.only_client'),  // Add language key for client-only access
            ])->onlyInput('email_or_phone');
        }

        // Verify the password
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email_or_phone' => __('auth.invalid_credentials'),
            ])->onlyInput('email_or_phone');
        }

        // Log the client in using the default web guard (or a specific client guard if configured)
        Auth::guard('web')->login($user);

        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect to the client dashboard or home page
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
