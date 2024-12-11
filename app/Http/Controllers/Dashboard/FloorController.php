<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Services\FloorService;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    protected $floorService;

    public function __construct(FloorService $floorService)
    {
        $this->floorService = $floorService;
    }

    public function index(Request $request)
    {
//        dd(app()->getLocale());
        $response = $this->floorService->index($request);

        $responseData = $response->original;

        $Floors = $responseData['data'];
        $branches = Branch::all();
//        dd($branches);
        return view('dashboard.floor.list', compact('Floors', 'branches'));
    }

    public function show($id)
    {
        $response = $this->floorService->show($id);
        $responseData = $response->original;
        return $Floors = $responseData['data'];
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $response = $this->floorService->add($request);
        $responseData = $response->original;
//        dd($responseData);
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->route('floors.list')->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('floors.list')->with('message',$message);
    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        $response = $this->floorService->edit($request, $id);
//        dd($response);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->route('floors.list')->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('floors.list')->with('message',$message);
    }
    public function delete(Request $request, $id)
    {
        $response = $this->floorService->delete($request, $id);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect()->route('floors.list')->with('message',$message);
    }
}
