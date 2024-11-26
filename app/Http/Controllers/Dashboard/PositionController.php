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

    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
    }

    public function index(Request $request)
    {
        $response = $this->positionService->index($request);
        $responseData = $response->original;
        $Positions = $responseData['data'];
        $departments = Department::all();
        return view('dashboard.position.list', compact('Positions', 'departments'));
    }

    public function store(Request $request)
    {
        $response = $this->positionService->add($request);
        $responseData = $response->original;
        $message= $responseData['apiMsg'];
        return redirect('positions')->with('message',$message);
    }

    public function update(Request $request, $id)
    {
        $response = $this->positionService->edit($request, $id);
        $responseData = $response->original;
        $message= $responseData['apiMsg'];
        return redirect('positions')->with('message',$message);
    }
    public function delete(Request $request, $id)
    {
        $response = $this->positionService->delete($request, $id);
        $responseData = $response->original;
        $message= $responseData['apiMsg'];
        return redirect('positions')->with('message',$message);
    }
}
