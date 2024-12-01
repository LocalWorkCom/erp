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

    public function store(Request $request)
    {
//        dd($request->all());
        $response = $this->floorService->add($request);
        $responseData = $response->original;
//        dd($responseData);
        $message= $responseData['Msg'];
        return redirect('floors')->with('message',$message);
    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        $response = $this->floorService->edit($request, $id);
//        dd($response);
        $responseData = $response->original;
        $message= $responseData['Msg'];
        return redirect('floors')->with('message',$message);
    }
    public function delete(Request $request, $id)
    {
        $response = $this->floorService->delete($request, $id);
        $responseData = $response->original;
        $message= $responseData['Msg'];
        return redirect('floors')->with('message',$message);
    }
}
