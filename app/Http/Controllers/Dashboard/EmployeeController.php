<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
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
        return view('dashboard.clients.create', compact('countries'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            // 'password' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'phone' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'required|boolean',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'nullable|string',
            'is_default' => 'nullable|boolean'
        ]);

        $this->employeeService->createClient($validatedData, $this->checkToken);
        return redirect()->route('client.index')->with('success', 'Client created successfully!');
    }

    public function edit($id)
    {
        $client = User::where('flag', 'client')->with('clientDetails', 'addresses')->findOrFail($id);
        $countries = Country::all();
        return view('dashboard.clients.edit', compact('countries', 'client'));
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
