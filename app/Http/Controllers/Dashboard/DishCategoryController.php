<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\DishCategoryService;
use Illuminate\Http\Request;

class DishCategoryController extends Controller
{
    protected $dishCategoryService;

    public function __construct(DishCategoryService $dishCategoryService)
    {
        $this->dishCategoryService = $dishCategoryService;
    }

    public function index()
    {
        $categories = $this->dishCategoryService->index();

        return view('dashboard.dish_categories.index', compact('categories'));
    }
    public function show($id)
    {
        try {
            $category = $this->dishCategoryService->show($id);
    
            return view('dashboard.dish_categories.show', compact('category'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard.dish-categories.index')->with('error', 'Failed to load the category details.');
        }
    }
    
    public function create()
    {
        $categories = $this->dishCategoryService->index(); // Fetch parent categories

        return view('dashboard.dish_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = auth()->id();

            $this->dishCategoryService->store($data, $request->file('image'));

            return redirect()->route('dashboard.dish_categories.index')->with('success', 'Dish category created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the dish category.');
        }
    }
    public function edit($id)
    {
        try {
            $category = $this->dishCategoryService->show($id);

            $categories = $this->dishCategoryService->index();

            return view('dashboard.dish_categories.edit', compact('category', 'categories'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard.dish-categories.index')->with('error', 'Failed to load the edit page.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $data['modified_by'] = auth()->id();

            $this->dishCategoryService->update($id, $data, $request->file('image'));

            return redirect()->route('dashboard.dish_categories.index')->with('success', 'Dish category updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the dish category.');
        }
    }

    public function delete($id)
    {
        try {
            $this->dishCategoryService->delete($id);

            return redirect()->route('dashboard.dish-categories.index')->with('success', 'Dish category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.dish-categories.index')->with('error', 'An error occurred while deleting the dish category.');
        }
    }

    public function restore($id)
    {
        try {
            $this->dishCategoryService->restore($id);

            return redirect()->route('dashboard.dish-categories.index')->with('success', 'Dish category restored successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.dish-categories.index')->with('error', 'An error occurred while restoring the dish category.');
        }
    }
}
