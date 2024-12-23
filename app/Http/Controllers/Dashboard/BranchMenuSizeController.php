<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Services\BranchMenuSizeService;
use Illuminate\Http\Request;

class BranchMenuSizeController extends Controller
{
    protected $branchMenuSizeService;

    public function __construct(BranchMenuSizeService $branchMenuSizeService)
    {
        $this->branchMenuSizeService = $branchMenuSizeService;
    }

    public function index(Request $request)
    {
        $response = $this->branchMenuSizeService->index($request);
        $responseData = $response->original;
        $branch_menu_sizes = $responseData['data'];
        $branches = Branch::all();
        return view('dashboard.branch.branch_menu_size.list', compact('branch_menu_sizes', 'branches'));
    }

    public function show($id)
    {
        $response = $this->branchMenuSizeService->show($id);
        $responseData = $response->original;
        return $branch_menu = $responseData['data'];
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $response = $this->branchMenuSizeService->update($request, $id);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->route('branch.menu.sizes.list')->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('branch.menu.sizes.list')->with('message',$message);
    }

    public function change_status(Request $request, $id)
    {
        $response = $this->branchMenuSizeService->change_status($id);
        $responseData = $response->original;
        return $branch_menu = $responseData['data'];
    }

    public function show_branch($branch_id)
    {
        $response = $this->branchMenuSizeService->branch($branch_id);
        $responseData = $response->original;
        $branch_menu_sizes = $responseData['data'];
        $branches = Branch::all();
        return view('dashboard.branch.branch_menu_size.list', compact('branch_menu_sizes', 'branches'));
    }
}
