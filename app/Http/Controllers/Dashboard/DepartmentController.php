<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departmentService;
    protected $checkToken;


    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
        $this->checkToken = false;
    }

    public function index()
    {
        $departments = $this->departmentService->getAllDepartments($this->checkToken);
        return view('dashboard.department.index', compact( 'departments'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $this->departmentService->createDepartment($validatedData, $this->checkToken);
        return redirect()->route('departments.list')->with('success', 'Department created successfully!');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name_ar' => 'nullable|string',
            'name_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $this->departmentService->updateDepartment($validatedData, $id, $this->checkToken);
        return redirect()->route('departments.list')->with('success', 'Department updated successfully!');
    }
    public function destroy($id)
    {
        $this->departmentService->deleteDepartment($id, $this->checkToken);
        return redirect()->route('departments.list')->with('success', 'Department deleted successfully!');
    }
}
