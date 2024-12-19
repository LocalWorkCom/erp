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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Check if the user exists and is flagged as an admin
        if (!$user || $user->flag != 'admin') {
            return back()->withErrors([
                'email' => __('auth.only_admin'),  // Use lang helper to get the message
            ])->onlyInput('email');
        }

        // Verify the password
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => __('auth.invalid_credentials'),  // Use lang helper for invalid credentials message
            ])->onlyInput('email');
        }

        // Log the user in using Laravel's Auth system
        Auth::login($user);

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect to the dashboard
        return redirect()->intended('dashboard');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/dashboard/login');
    }
}
