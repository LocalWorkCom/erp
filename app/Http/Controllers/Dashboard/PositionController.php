<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Floor;
use App\Services\PositionService;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    protected $positionService;
    protected $checkToken;


    public function __construct(PositionService $positionService)
    {
        $this->positionService = $positionService;
        $this->checkToken = false;
    }

    public function index()
    {
        $positions = $this->positionService->getAllPositions($this->checkToken);
        $departments = Department::get();
        return view('dashboard.position.index', compact('positions', 'departments'));
    }

    public function store(Request $request)
    {
<<<<<<< HEAD
        $response = $this->positionService->add($request);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect('positions')->withErrors($validationErrors)->withInput();
        }
        $message = $responseData['message'];
        return redirect('positions')->with('message', $message);
=======
        $validatedData = $request->validate([
            'department_id' => 'required|integer|exists:departments,id',
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $this->positionService->createPosition($validatedData, $this->checkToken);
        return redirect()->route('positions.index')->with('success', 'Position created successfully!');
>>>>>>> 699fe20f9b11eae99024815d6861e2f3a42cddb8
    }

    public function update(Request $request, $id)
    {
<<<<<<< HEAD
        $response = $this->positionService->edit($request, $id);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect('positions')->withErrors($validationErrors)->withInput();
        }
        $message = $responseData['message'];
        return redirect('positions')->with('message', $message);
=======
        $validatedData = $request->validate([
            'department_id' => 'nullable|integer|exists:departments,id',
            'name_ar' => 'nullable|string',
            'name_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
        ]);

        $this->positionService->updatePosition($validatedData, $id, $this->checkToken);
        return redirect()->route('positions.index')->with('success', 'Position updated successfully!');
>>>>>>> 699fe20f9b11eae99024815d6861e2f3a42cddb8
    }
    public function destroy($id)
    {
<<<<<<< HEAD
        $response = $this->positionService->delete($request, $id);
        $responseData = $response->original;
        $message = $responseData['message'];
        return redirect('positions')->with('message', $message);
=======
        $this->positionService->deletePosition($id, $this->checkToken);
        return redirect()->route('positions.index')->with('success', 'Position deleted successfully!');
>>>>>>> 699fe20f9b11eae99024815d6861e2f3a42cddb8
    }
}
