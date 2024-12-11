<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Floor;
use App\Services\FloorPartitionService;
use Illuminate\Http\Request;

class FloorPartitionController extends Controller
{
    protected $floorPartitionService;

    public function __construct(FloorPartitionService $floorPartitionService)
    {
        $this->floorPartitionService = $floorPartitionService;
    }

    public function index(Request $request)
    {
        $response = $this->floorPartitionService->index($request);
        $responseData = $response->original;
        $Partitions = $responseData['data'];
        $floors = Floor::all();
        return view('dashboard.floorPartition.list', compact('Partitions', 'floors'));
    }

    public function store(Request $request)
    {
        $response = $this->floorPartitionService->add($request);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect('floor-partitions')->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect('dashboard/floor-partitions')->with('message',$message);
    }

    public function update(Request $request, $id)
    {
        $response = $this->floorPartitionService->edit($request, $id);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect('dashboard/floor-partitions')->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect('dashboard/floor-partitions')->with('message',$message);
    }
    public function delete(Request $request, $id)
    {
        $response = $this->floorPartitionService->delete($request, $id);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect('dashboard/floor-partitions')->with('message',$message);
    }
}
