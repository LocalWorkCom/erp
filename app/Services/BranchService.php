<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Dish;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchService
{
    private $lang;
    public function __construct()
    {
        $this->lang = app()->getLocale();
    }
    public function index(Request $request)
    {
        try {
            $withTrashed = $request->query('withTrashed', false);

            $branches = $withTrashed
                ? Branch::withTrashed()->with(['country', 'creator', 'deleter'])->get()
                : Branch::with(['country', 'creator', 'deleter','floors'])->get();

            return ResponseWithSuccessData($this->lang, $branches, 1);
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
//        dd($request->all());
        // Validation
        $validator = Validator::make($request->all(), [
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'required|string|max:255',
            'address_en' => 'nullable|string',
            'address_ar' => 'nullable|string',
            'latitute' => 'nullable|string', // Matches the database
            'longitute' => 'nullable|string', // Matches the database
            'country_id' => 'required|integer|exists:countries,id',
            'employee_id' => 'integer|exists:employees,id',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'manager_name' => 'nullable|string|max:255',
            'opening_hour' => 'nullable',
            'closing_hour' => 'nullable',
            'has_kids_area' => 'required|boolean',
            'is_delivery' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        //try {
            //return $get_dishes = Dish::all();
            $user_id =  Auth::guard('admin')->user()->id;
            $manager_name = $this->employeeDetails($request->employee_id, 'first_name');
            $branch = Branch::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'address_en' => $request->address_en,
                'address_ar' => $request->address_ar,
                'latitute' => $request->latitute, // Matches the database field
                'longitute' => $request->longitute, // Matches the database field
                'country_id' => $request->country_id,
                'phone' => $request->phone,
                'email' => $request->email,
                'employee_id' => $request->employee_id,
                'manager_name' => $manager_name,
                'opening_hour' => $request->opening_hour,
                'closing_hour' => $request->closing_hour,
                'has_kids_area' => $request->has_kids_area,
                'is_delivery' => $request->is_delivery,
                'created_by' => $user_id,
            ]);

            AddBranchMenu($branch->id);
            return ResponseWithSuccessData($this->lang, $branch, 1);
        // } catch (\Exception $e) {
        //     Log::error('Error creating branch: ' . $e->getMessage());
        //     return RespondWithBadRequestData($this->lang, 2);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $branch = Branch::with(['country', 'creator', 'deleter'])->findOrFail($id);
            return ResponseWithSuccessData($this->lang, $branch, 1);
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
        App::setLocale($this->lang);

        // Validation
        $validator = Validator::make($request->all(), [
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'required|string|max:255',
            'address_en' => 'nullable|string',
            'address_ar' => 'nullable|string',
            'latitute' => 'nullable|string', // Matches the database
            'longitute' => 'nullable|string', // Matches the database
            'country_id' => 'required|integer|exists:countries,id',
            'employee_id' => 'integer|exists:employees,id', 
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'manager_name' => 'nullable|string|max:255',
            'opening_hour' => 'nullable',
            'closing_hour' => 'nullable',
            'has_kids_area' => 'required|boolean',
            'is_delivery' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        try {
            $user_id =  Auth::guard('admin')->user()->id;
            $manager_name = $this->employeeDetails($request->employee_id, 'first_name');
            $branch = Branch::findOrFail($id);
            $branch->update([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'address_en' => $request->address_en,
                'address_ar' => $request->address_ar,
                'latitute' => $request->latitute, // Matches the database field
                'longitute' => $request->longitute, // Matches the database field
                'country_id' => $request->country_id,
                'phone' => $request->phone,
                'email' => $request->email,
                'employee_id' => $request->employee_id,
                'manager_name' => $manager_name,                
                'opening_hour' => $request->opening_hour,
                'closing_hour' => $request->closing_hour,
                'has_kids_area' => $request->has_kids_area,
                'is_delivery' => $request->is_delivery,
                'modified_by' => $user_id,
            ]);
            return ResponseWithSuccessData($this->lang, $branch, 1);
        } catch (\Exception $e) {
            Log::error('Error updating branch: ' . $e->getMessage());
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    /**
     * Soft delete the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $branch = Branch::findOrFail($id);
            $branch->update(['deleted_by' => auth()->id()]);
            $branch->delete();
            return ResponseWithSuccessData($this->lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting branch: ' . $e->getMessage());
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    /**
     * Restore a soft-deleted branch.
     */
    public function restore(Request $request, $id)
    {
        try {
            $branch = Branch::withTrashed()->findOrFail($id);
            $branch->restore();
            return ResponseWithSuccessData($this->lang, $branch, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring branch: ' . $e->getMessage());
            return RespondWithBadRequestData($this->lang, 2);
        }
    }

    public function employeeDetails($id, $field)
    {
        $employee_details = Employee::where('id', $id)->first();
        if($employee_details){
            return $field = $employee_details->$field;
        }else{
            return null;
        }
    }
}
