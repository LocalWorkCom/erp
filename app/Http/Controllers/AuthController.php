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
}
