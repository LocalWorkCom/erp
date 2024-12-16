<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\CuisineService;
use Illuminate\Http\Request;

class CuisineController extends Controller
{
    protected $cuisineService;

    public function __construct(CuisineService $cuisineService)
    {
        $this->cuisineService = $cuisineService;
    }

    public function index()
    {
        $cuisines = $this->cuisineService->index();
        return view('dashboard.cuisines.index', compact('cuisines'));
    }

    public function create()
    {
        return view('dashboard.cuisines.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
        ]);

        $this->cuisineService->store($data, $request->file('image'));

        return redirect()->route('dashboard.cuisines.index')->with('success', 'Cuisine created successfully.');
    }

    public function edit($id)
    {
        $cuisine = $this->cuisineService->show($id);
        return view('dashboard.cuisines.edit', compact('cuisine'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:5000',
        ]);

        $this->cuisineService->update($id, $data, $request->file('image'));

        return redirect()->route('dashboard.cuisines.index')->with('success', 'Cuisine updated successfully.');
    }

    public function destroy($id)
    {
        $this->cuisineService->delete($id);
        return redirect()->route('dashboard.cuisines.index')->with('success', 'Cuisine deleted successfully.');
    }

    public function restore($id)
    {
        $this->cuisineService->restore($id);
        return redirect()->route('dashboard.cuisines.index')->with('success', 'Cuisine restored successfully.');
    }
}
