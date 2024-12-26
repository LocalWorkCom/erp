<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Nationality;
use App\Models\Position;
use App\Models\User;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    protected $employeeService;
    protected $checkToken;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
        $this->checkToken = false;
    }

    public function index()
    {
        $employees = $this->employeeService->getAllEmployees($this->checkToken);
        return view('dashboard.employee.index', compact('employees'));
    }
    public function show($id)
    {
        $employee = $this->employeeService->getEmployee($id);
        return view('dashboard.employee.show', compact('employee'));
    }

    public function create()
    {
        $countries = Country::all();
        $nationalities = Nationality::all();
        $departments = Department::all();
        $positions = Position::all();
        $supervisors = Employee::all();
        return view(
            'dashboard.employee.create',
            compact('countries', 'nationalities', 'departments', 'positions', 'supervisors')
        );
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_code' => 'required|string|unique:employees',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:employees',
            // 'password' => 'nullable|string',
            'phone' => 'required|string',
            'gender' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'national_id' => 'nullable|string|unique:employees',
            'passport_number' => 'nullable|string',
            'marital_status' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_relationship' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            'address_en' => 'nullable|string',
            'address_ar' => 'nullable|string',
            'nationality_id' => 'nullable|exists:nationalities,id',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'supervisor_id' => 'nullable|exists:employees,id',
            'hire_date' => 'nullable|date',
            'salary' => 'nullable|string',
            'assurance_salary' => 'nullable|string',
            'assurance_number' => 'nullable|string',
            'bank_account' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'is_biometric' => 'nullable|boolean',
            'biometric_id' => 'nullable|string',
        ]);

        $this->employeeService->createEmployee($validatedData, $this->checkToken);
        return redirect()->route('employees.list')->with('success', 'Employee created successfully!');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $countries = Country::all();
        $nationalities = Nationality::all();
        $departments = Department::all();
        $positions = Position::all();
        $supervisors = Employee::all();
        return view(
            'dashboard.employee.edit',
            compact('employee', 'countries', 'nationalities', 'departments', 'positions', 'supervisors')
        );
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $validatedData = $request->validate([
            'employee_code' => 'nullable|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'email' => [
                'nullable',
                'email',
                Rule::unique('employees')->ignore($employee),
            ],
            // 'password' => 'nullable|string',
            'phone' => 'required|string',
            'gender' => 'nullable',
            'birth_date' => 'nullable|date',
            'national_id' => 'nullable|string',
            'passport_number' => 'nullable|string',
            'marital_status' => 'nullable|string',
            'blood_group' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_relationship' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
            'address_en' => 'nullable|string',
            'address_ar' => 'nullable|string',
            'nationality_id' => 'nullable|exists:nationalities,id',
            'department_id' => 'nullable|exists:departments,id',
            'position_id' => 'nullable|exists:positions,id',
            'supervisor_id' => 'nullable|exists:employees,id',
            'hire_date' => 'nullable|date',
            'salary' => 'nullable|string',
            'assurance_salary' => 'nullable|string',
            'assurance_number' => 'nullable|string',
            'bank_account' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_biometric' => 'nullable|boolean',
            'biometric_id' => 'nullable|string',
        ]);

        $this->employeeService->updateEmployee($validatedData, $id, $this->checkToken);
        return redirect()->route('employees.list')->with('success', 'Employee updated successfully!');
    }
    public function destroy($id)
    {
        $this->employeeService->deleteEmployee($id, $this->checkToken);
        return redirect()->route('employees.list')->with('success', 'Employee deleted successfully!');
    }
}
