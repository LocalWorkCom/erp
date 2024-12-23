<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Country;
use App\Services\BranchMenuAddonService;
use Illuminate\Http\Request;

class BranchMenuAddonController extends Controller
{
    protected $branchMenuAddonService;

    public function __construct(BranchMenuAddonService $branchMenuAddonService)
    {
        $this->branchMenuAddonService = $branchMenuAddonService;
    }

    public function index(Request $request)
    {
        $response = $this->branchMenuAddonService->index($request);
        $responseData = $response->original;
        $branch_menu_addons = $responseData['data'];
        $branches = Branch::all();
        return view('dashboard.branch.branch_menu_addon.list', compact('branch_menu_addons', 'branches'));
    }

    public function show($id)
    {
        $response = $this->branchMenuAddonService->show($id);
        $responseData = $response->original;
        return $branch_menu_addon = $responseData['data'];
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $response = $this->branchMenuAddonService->update($request, $id);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->route('branch.menu.addons.list')->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect()->route('branch.menu.addons.list')->with('message',$message);
    }
    public function change_status(Request $request, $id)
    {
        $response = $this->branchMenuAddonService->change_status($id);
        $responseData = $response->original;
        return $branch_menu_addon = $responseData['data'];
    }

    public function show_branch($branch_id)
    {
        $response = $this->branchMenuAddonService->branch($branch_id);
        $responseData = $response->original;
        $branch_menu_addons = $responseData['data'];
        $branches = Branch::all();
        return view('dashboard.branch.branch_menu_addon.list', compact('branch_menu_addons', 'branches'));
    }
}
