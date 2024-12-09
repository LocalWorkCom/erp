<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Floor;
use App\Services\PositionService;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    protected $positionService;
    protected $checkToken;


    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
        $this->checkToken = false;
    }

    public function index()
    {
        $positions = $this->positionService->getAllPositions($this->checkToken);
        return view('dashboard.position.list', compact('positions'));
    }
    public function show($id)
    {
        $client = $this->positionService->getPosition($id);
        return view('dashboard.clients.show', compact('client'));
    }

    public function store(Request $request)
    {
        $response = $this->positionService->add($request);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect('positions')->withErrors($validationErrors)->withInput();
        }
        $message = $responseData['message'];
        return redirect('positions')->with('message', $message);
    }

    public function update(Request $request, $id)
    {
        $response = $this->positionService->edit($request, $id);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect('positions')->withErrors($validationErrors)->withInput();
        }
        $message = $responseData['message'];
        return redirect('positions')->with('message', $message);
    }
    public function delete(Request $request, $id)
    {
        $response = $this->positionService->delete($request, $id);
        $responseData = $response->original;
        $message = $responseData['message'];
        return redirect('positions')->with('message', $message);
    }
}
