<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Services\BranchMenuService;
use Illuminate\Http\Request;

class BranchMenuController extends Controller
{
    protected $branchMenuService;

    public function __construct(BranchMenuService $branchMenuService)
    {
        $this->branchMenuService = $branchMenuService;
    }

    public function index(Request $request)
    {
        $response = $this->branchMenuService->index($request);
        $responseData = $response->original;
        $branch_menu_categories = $responseData['data'];
        $branches = Branch::all();
        return view('dashboard.branch.branch_menu.list', compact('branch_menu_categories', 'branches'));
    }

    public function show($id)
    {
        $response = $this->branchMenuService->show($id);
        $responseData = $response->original;
        return $branch_menu_category = $responseData['data'];
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $response = $this->branchMenuService->edit($request, $id);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->route('branch.categories.list')->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('branch.categories.list')->with('message',$message);
    }
    public function change_status(Request $request, $id)
    {
        $response = $this->branchMenuService->change_status($id);
        $responseData = $response->original;
        return $branch_menu_category = $responseData['data'];
        // $message= $responseData['message'];
        // return redirect()->route('branch.categories.list')->with('message',$message);
    }

    public function show_branch($branch_id)
    {
        $response = $this->branchMenuService->branch($branch_id);
        $responseData = $response->original;
        $branch_menu_categories = $responseData['data'];
        $branches = Branch::all();
        return view('dashboard.branch.branch_menu.list', compact('branch_menu_categories', 'branches'));
    }
}
