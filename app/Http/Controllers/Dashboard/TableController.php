<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Floor;
use App\Models\FloorPartition;
use App\Services\TableService;
use Illuminate\Http\Request;

class TableController extends Controller
{
    protected $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    public function index(Request $request)
    {
//        dd(app()->getLocale());
        $response = $this->tableService->index($request);

        $responseData = $response->original;

        $Tables = $responseData['data'];
        $floors = Floor::all();
        $floorPartitions = FloorPartition::all();
//        dd($floors);
        return view('dashboard.table.list', compact('Tables', 'floors','floorPartitions'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $response = $this->tableService->add($request);
        $responseData = $response->original;
//        dd($responseData);
        $message= $responseData['apiMsg'];
        return redirect('tables')->with('message',$message);
    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        $response = $this->tableService->edit($request, $id);
//        dd($response);
        $responseData = $response->original;
        $message= $responseData['apiMsg'];
        return redirect('tables')->with('message',$message);
    }
    public function delete(Request $request, $id)
    {
        $response = $this->tableService->delete($request, $id);
        $responseData = $response->original;
        $message= $responseData['apiMsg'];
        return redirect('tables')->with('message',$message);
    }
}
