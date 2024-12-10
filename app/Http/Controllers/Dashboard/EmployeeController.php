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
            'employee_code' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            // 'password' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'phone' => 'required|string',
            'gender' => 'nullable|string',
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
            'nationality_id' => 'nullable|exists:id,nationalities',
            'department_id' => 'nullable|exists:id,departments',
            'position_id' => 'nullable|exists:id,positions',
            'supervisor_id' => 'nullable|exists:id,employees',
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
        $client = User::where('flag', 'client')->with('clientDetails', 'addresses')->findOrFail($id);
        $countries = Country::all();
        return view('dashboard.employee.edit', compact('countries', 'client'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $id,
            // 'password' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'phone' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'is_default' => 'nullable|boolean'
        ]);

        $this->employeeService->updateClient($validatedData, $id, $this->checkToken);
        return redirect()->route('client.index')->with('success', 'Client updated successfully!');
    }
    public function destroy($id)
    {
        $this->employeeService->deleteClient($id, $this->checkToken);
        return redirect()->route('client.index')->with('success', 'Client deleted successfully!');
    }
}
