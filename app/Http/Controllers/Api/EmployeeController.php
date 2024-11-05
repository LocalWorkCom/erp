<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
            $employees = Employee::with(['department', 'position', 'supervisor'])->get();
            return ResponseWithSuccessData($lang, $employees, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching employees: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $employee = Employee::with(['department', 'position', 'supervisor'])->findOrFail($id);
            return ResponseWithSuccessData($lang, $employee, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching employee: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'en');
    
            $request->validate([
                'employee_code' => 'required|string|max:10|unique:employees',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:employees',
                'phone_number' => 'required|string|max:15|regex:/^\+?[0-9]*$/',
                'gender' => 'required|in:male,female,other',
                'birth_date' => 'required|date|before:today',
                'national_id' => 'nullable|string|max:20|unique:employees',
                'passport_number' => 'nullable|string|max:20|unique:employees',
                'marital_status' => 'nullable|in:single,married,divorced,widowed',
                'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                'emergency_contact_name' => 'nullable|string|max:255',
                'emergency_contact_relationship' => 'nullable|string|max:100',
                'emergency_contact_phone' => 'nullable|string|max:15|regex:/^\+?[0-9]*$/',
                'address' => 'nullable|string|max:500',
                'nationality' => 'nullable|string|max:100',
                'department_id' => 'required|exists:departments,id',
                'position_id' => 'required|exists:positions,id',
                'supervisor_id' => 'nullable|exists:employees,id',
                'user_id' => 'required|exists:users,id',
                'hire_date' => 'required|date',
                'salary' => 'required|numeric|min:0',
                'employment_type' => 'required|in:full_time,part_time,contract,intern',
                'status' => 'required|in:active,inactive,terminated,resigned',
                'notes' => 'nullable|string',
                'is_biometric' => 'required|boolean',
                'biometric_id' => 'nullable|integer|unique:employees',
            ]);
    
            $employeeData = $request->all();
            $employeeData['created_by'] = auth()->id();
    
            $employee = Employee::create($employeeData);
            return ResponseWithSuccessData($lang, $employee, 1);
        } catch (\Exception $e) {
            Log::error('Error creating employee: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
    
            $request->validate([
                'employee_code' => 'sometimes|string|max:10|unique:employees,employee_code,' . $id,
                'first_name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:employees,email,' . $id,
                'phone_number' => 'sometimes|string|max:15|regex:/^\+?[0-9]*$/',
                'gender' => 'sometimes|in:male,female,other',
                'birth_date' => 'sometimes|date|before:today',
                'national_id' => 'nullable|string|max:20|unique:employees,national_id,' . $id,
                'passport_number' => 'nullable|string|max:20|unique:employees,passport_number,' . $id,
                'marital_status' => 'nullable|in:single,married,divorced,widowed',
                'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
                'emergency_contact_name' => 'nullable|string|max:255',
                'emergency_contact_relationship' => 'nullable|string|max:100',
                'emergency_contact_phone' => 'nullable|string|max:15|regex:/^\+?[0-9]*$/',
                'address' => 'nullable|string|max:500',
                'nationality' => 'nullable|string|max:100',
                'department_id' => 'sometimes|exists:departments,id',
                'position_id' => 'sometimes|exists:positions,id',
                'supervisor_id' => 'nullable|exists:employees,id',
                'user_id' => 'sometimes|exists:users,id',
                'hire_date' => 'sometimes|date',
                'salary' => 'sometimes|numeric|min:0',
                'employment_type' => 'sometimes|in:full_time,part_time,contract,intern',
                'status' => 'sometimes|in:active,inactive,terminated,resigned',
                'notes' => 'nullable|string',
                'is_biometric' => 'sometimes|boolean',
                'biometric_id' => 'nullable|integer|unique:employees,biometric_id,' . $id,
            ]);
    
            $employee = Employee::findOrFail($id);
            $employeeData = $request->all();
            $employeeData['modified_by'] = auth()->id();
    
            $employee->update($employeeData);
            return ResponseWithSuccessData($lang, $employee, 1);
        } catch (\Exception $e) {
            Log::error('Error updating employee: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
    

    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $employee = Employee::findOrFail($id);
            $employee->update(['deleted_by' => auth()->id()]);
            $employee->delete();

            return ResponseWithSuccessData($lang, null, 'Employee deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting employee: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'en');
            $employee = Employee::onlyTrashed()->findOrFail($id);
            $employee->restore();

            return ResponseWithSuccessData($lang, $employee, 'Employee restored successfully.');
        } catch (\Exception $e) {
            Log::error('Error restoring employee: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
