<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the phone and country code
        $credentials = $request->validate([
            'phone' => 'required|string',
            'phone_code' => 'required|string',
            'password' => 'required|string',
        ]);

        // Combine the phone number and phone code to create the full phone number
        $fullPhoneNumber = $credentials['phone_code'] . $credentials['phone'];

        // Check if the user exists with the full phone number and check if the user is a client
        $user = User::where('phone', $credentials['phone'])
            ->where('country_code', $credentials['phone_code'])
            ->first();

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
        return response()->json([
            'success' => true,
            'redirect_url' => route('home') // Redirect to the home/dashboard page
        ]);
    }
}
