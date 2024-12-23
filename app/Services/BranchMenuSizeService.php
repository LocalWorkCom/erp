<?php

namespace App\Services;

use App\Models\BranchMenuSize;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchMenuSizeService
{
    private $lang;
    public function __construct()
    {
        $this->lang = app()->getLocale();
        app()->setLocale($this->lang);
    }

    public function index(Request $request)
    {
        try{ 
            $branch_menu_sizes = BranchMenuSize::with(['branches', 'dishSizes', 'dishes'])->get();
            return ResponseWithSuccessData($this->lang, $branch_menu_sizes, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching branches: ' . $e->getMessage());
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function branch($id)
    {
        try {
            $branch_menu_sizes = BranchMenuSize::where('branch_id', $id)->with(['branches', 'dishSizes', 'dishes'])->get();
            return ResponseWithSuccessData($this->lang, $branch_menu_sizes, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching branches: ' . $e->getMessage());
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $branch_menu_size = BranchMenuSize::with(['branches', 'dishSizes', 'dishes'])->findOrFail($id);
            return ResponseWithSuccessData($this->lang, $branch_menu_size, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching branch: ' . $e->getMessage());
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                'price' => 'required|numeric',
                'is_active' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return RespondWithBadRequestWithData($validator->errors());
            }

            $check_branch_menu_size = BranchMenuSize::find($id);
            if (!$check_branch_menu_size) {
                return  RespondWithBadRequestNotExist();
            }

            $user_id =  Auth::guard('admin')->user()->id;
            $branch_menu_size = BranchMenuSize::findOrFail($id);
            $branch_menu_size->price = $request->price;
            $branch_menu_size->is_active = $request->is_active;
            $branch_menu_size->modified_by = $user_id;
            $branch_menu_size->save();

            return ResponseWithSuccessData($this->lang, $branch_menu_size, 1);
        } catch (\Exception $e) {
            Log::error('Error updating branch menu category: ' . $e->getMessage());
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    /**
     * Soft delete the specified resource from storage.
     */
    public function change_status($id)
    {
        try {
            $user_id =  Auth::guard('admin')->user()->id;
            $active = 1;
            $branch_menu_size = BranchMenuSize::findOrFail($id);
            if($branch_menu_size->is_active == 1){
                $active = 0;
            }
            $branch_menu_size->is_active = $active;
            $branch_menu_size->modified_by = $user_id;
            $branch_menu_size->save();
            return ResponseWithSuccessData($this->lang, $branch_menu_size, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting branch menu category: ' . $e->getMessage());
            return RespondWithBadRequestData($this->lang, 2);
        }
    }
    
}
