<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Dish;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

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
                : Branch::with(['country', 'creator', 'deleter', 'floors'])->get();

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
        $country = Country::findOrFail($request->country_id);
        // Validation
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'address_en' => 'required|string',
            'address_ar' => 'required|string',
            //'country_id' => 'required|integer|exists:countries,id',
            'employee_id' => 'unique:employees,id|integer|exists:employees,id',
            'latitute' => 'required|numeric|between:-90,90',
            'longitute' => 'required|numeric|between:-180,180',
            'country_id' => 'required|exists:countries,id',
            'phone' => 'required|string|max:'.$country->length.'|min:'.$country->length.'|regex:/[0-9]{'.$country->length.'}/',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            //'manager_name' => 'required|string|max:255',
            'opening_hour' => 'required',
            'closing_hour' => 'required',
            'has_kids_area' => 'required|boolean',
            'is_delivery' => 'required|boolean',
            'is_default' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        //try {
        //return $get_dishes = Dish::all();
        $user_id =  Auth::guard('admin')->user()->id;
        $manager_name = $this->employeeDetails($request->employee_id);
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
            'manager_name' => $manager_name->first_name,
            'opening_hour' => $request->opening_hour,
            'closing_hour' => $request->closing_hour,
            'has_kids_area' => $request->has_kids_area,
            'is_delivery' => $request->is_delivery,
            'is_default' => $request->is_default,
            'created_by' => $user_id,
        ]);

        $branche_ids = [$branch->id];
        AddBranchesMenu($branche_ids, $dish_id = 0);

        $employee_data = $this->employeeDetails($request->employee_id);
        if ($employee_data->user_id != null) {
            $branchmanagerRole = Role::firstOrCreate(['name' => 'Branch Manager', 'guard_name' => 'admin']);
            if ($branchmanagerRole) {
                $user = User::find($employee_data->user_id);
                $user->assignRole($branchmanagerRole);
            }
        } else {
            $user = new User();
            $user->email = $employee_data->email;
            $user->name = $employee_data->first_name . ' ' . $employee_data->last_name;
            $user->password = Hash::make('123456'); //ask for how to send pass to manager and give him update pass
            $user->phone = $employee_data->phone_number;
            $user->flag = 'admin';
            $user->save();
            $branchmanagerRole = Role::firstOrCreate(['name' => 'Branch Manager', 'guard_name' => 'admin']);
            if ($user) {
                $employee_user = Employee::find($employee_data->id);
                $employee_user->user_id = $user->id;
                $employee_user->save();
                $user->assignRole($branchmanagerRole);
            }
        }
        if ($request->is_default == 1) {
            $check_branch_default = Branch::where('is_default', 1)->where('id', '!=', $branch->id)->first();
            if ($check_branch_default) {
                $check_branch_default->is_default = 0;
                $check_branch_default->save();
            }
        }

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
        $branch = Branch::findOrFail($id);
        $country = Country::findOrFail($request->country_id);
        // Validation
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'address_en' => 'required|string',
            'address_ar' => 'required|string',
            'latitute' => 'required|numeric|between:-90,90',
            'longitute' => 'required|numeric|between:-180,180',
            'country_id' => 'required|exists:countries,id',
            'employee_id' => 'required|integer|unique:employees,id,'.$branch->employee_id,
            'phone' => 'required|string|max:'.$country->length.'|min:'.$country->length.'|regex:/[0-9]{'.$country->length.'}/',
            'email' => 'nullable|string|email|max:255',
            'opening_hour' => 'required',
            'closing_hour' => 'required',
            'has_kids_area' => 'required|boolean',
            'is_delivery' => 'required|boolean',
            'is_default' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        try {
            $user_id =  Auth::guard('admin')->user()->id;
            $manager_name = $this->employeeDetails($request->employee_id);
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
                'manager_name' => $manager_name->first_name,
                'opening_hour' => $request->opening_hour,
                'closing_hour' => $request->closing_hour,
                'has_kids_area' => $request->has_kids_area,
                'is_delivery' => $request->is_delivery,
                'is_default' => $request->is_default,
                'modified_by' => $user_id,
            ]);

            if ($request->is_default == 1) {
                $check_branch_default = Branch::where('is_default', 1)->where('id', '!=', $id)->first();
                if ($check_branch_default) {
                    $check_branch_default->is_default = 0;
                    $check_branch_default->save();
                }
            }
            $employee_data = $this->employeeDetails($request->employee_id);
            if ($employee_data->user_id != null) {
                $branchmanagerRole = Role::firstOrCreate(['name' => 'Branch Manager', 'guard_name' => 'admin']);
                if ($branchmanagerRole) {
                    $user = User::find($employee_data->user_id);
                    $user->assignRole($branchmanagerRole);
                }
            } else {
                $user = new User();
                $user->email = $employee_data->email;
                $user->name = $employee_data->first_name . ' ' . $employee_data->last_name;
                $user->password = Hash::make('123456'); //ask for how to send pass to manager and give him update pass
                $user->phone = $employee_data->phone_number;
                $user->flag = 'admin';
                $user->save();
                $branchmanagerRole = Role::firstOrCreate(['name' => 'Branch Manager', 'guard_name' => 'admin']);
                if ($user) {
                    $employee_user = Employee::find($employee_data->id);
                    $employee_user->user_id = $user->id;
                    $employee_user->save();
                    $user->assignRole($branchmanagerRole);
                }
            }
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

    public function employeeDetails($id)
    {
        $employee_details = Employee::where('id', $id)->first();
        if ($employee_details) {
            return $field = $employee_details;
        } else {
            return null;
        }
    }
}
