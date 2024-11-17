<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BioTimeService;
use Illuminate\Http\Request;

class BioTimeController extends Controller
{
    protected $bioTimeService;

    public function __construct(BioTimeService $bioTimeService)
    {
        $this->bioTimeService = $bioTimeService;
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $token = $this->bioTimeService->getJwtAuthToken($request->username, $request->password);

        if ($token) {
            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Authentication failed'], 401);
    }
}
