<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BioTimeService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.biotime.base_url'); 
    }

    
    public function getJwtAuthToken($username, $password)
    {
        $url = $this->baseUrl . '/jwt-api-token-auth/';

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                'username' => $username,
                'password' => $password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['token'];
            } else {
                Log::error("BioTime Auth Error: " . $response->body());
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Error fetching BioTime JWT Token: ' . $e->getMessage());
            return null;
        }
    }
}
