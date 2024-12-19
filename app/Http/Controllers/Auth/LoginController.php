<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('dashboard.auth.login'); // Create a Blade view for login
    }

    public function login(Request $request)
    {
        // Check if it's a web login (by phone + country code) or dashboard login (by email)
        if ($request->is('dashboard/*')) {
            // For dashboard login, only email and password are required
            $credentials = $request->validate([
                'email' => 'required|email',  // Email is required for dashboard login
                'password' => 'required|string',  // Password is required
            ]);

            // Find user by email
            $user = User::where('email', $credentials['email'])->first();
        } else {
            // For website login, both phone and country_code are required
            $credentials = $request->validate([
                'phone' => 'required|string', // Phone is required for website login
                'country_code' => 'required|string', // Country code is required for phone login
                'password' => 'required|string',  // Password is required
            ]);

            // Find user by phone and country code
            $user = User::where('phone', $credentials['phone'])
                        ->where('country_code', $credentials['country_code'])
                        ->first();
        }

        // Check if the user exists
        if (!$user) {
            return back()->withErrors([
                'login' => __('auth.user_not_found'),  // Customize error message if user is not found
            ])->onlyInput('email', 'phone');
        }

        // Check if the password is correct
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'login' => __('auth.invalid_credentials'),  // Invalid credentials message
            ])->onlyInput('email', 'phone');
        }

        // Check the user's flag (admin or client)
        if ($user->flag == 'admin') {
            // If the user is an admin, log them in and redirect to the admin dashboard
            Auth::login($user);
            $request->session()->regenerate();  // Regenerate the session to prevent session fixation attacks
            return redirect()->route('dashboard.home');  // Redirect to the admin dashboard
        }

        // Check if the user is a client
        if ($user->flag == 'client') {
            // If the user is a client, log them in and redirect to the client dashboard
            Auth::login($user);
            $request->session()->regenerate();  // Regenerate the session
            return redirect()->route('home');  // Redirect to the client dashboard
        }

        // If the user has an unknown flag, return an error
        return back()->withErrors([
            'login' => __('auth.unknown_flag'),  // Customize this error message if needed
        ])->onlyInput('email', 'phone');
    }





    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/dashboard/login');
    }
}
