<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Employee;
use App\Services\BranchService;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    protected $branchService;

    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    public function index(Request $request)
    {
//        dd(app()->getLocale());
        $response = $this->branchService->index($request);

        $responseData = $response->original;

        $branches = $responseData['data'];
//        dd($branches);
        return view('dashboard.branch.list', compact('branches'));
    }

    public function create()
    {
        $countries = Country::all();
        $employees = Employee::all();
        return view('dashboard.branch.add', compact('countries', 'employees'));
    }
    public function store(Request $request)
    {
//        dd($request->all());
        $response = $this->branchService->store($request);
        $responseData = $response->original;
//        dd($responseData);
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('branches.list')->with('message',$message);
    }

    public function show($id)
    {
        $response = $this->branchService->show($id);

        $responseData = $response->original;

        $branch = $responseData['data'];
//        dd($branch->country->name_ar);

        return view('dashboard.branch.show', compact('branch'));
    }

    public function edit($id)
    {
        $branch = Branch::findOrFail($id);
        $countries = Country::all();
        $employees = Employee::all();
        return view('dashboard.branch.edit', compact('branch', 'countries', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->branchService->update($request, $id);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('branches.list')->with('message',$message);
    }
 
    public function delete(Request $request, $id)
    {
        $response = $this->branchService->destroy($request, $id);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect()->route('branches.list')->with('message',$message);
    }
}
