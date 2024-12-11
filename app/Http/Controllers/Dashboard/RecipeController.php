<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\RecipeService;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    protected $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    public function index()
    {
        $recipes = $this->recipeService->index();
        return view('dashboard.recipes.index', compact('recipes'));
    }
    public function show($id)
    {
        try {
            $recipe = $this->recipeService->show($id);
            return view('dashboard.recipes.show', compact('recipe'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard.recipes.index')->with('error', 'Failed to load recipe details.');
        }
    }
    
    public function create()
    {
        return view('dashboard.recipes.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $this->recipeService->store($data, $request->file('images'));

            return redirect()->route('dashboard.recipes.index')->with('success', 'Recipe created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create recipe.');
        }
    }

    public function edit($id)
    {
        try {
            $recipe = $this->recipeService->show($id);
            return view('dashboard.recipes.edit', compact('recipe'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard.recipes.index')->with('error', 'Failed to load recipe.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $this->recipeService->update($id, $data, $request->file('images'));

            return redirect()->route('dashboard.recipes.index')->with('success', 'Recipe updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update recipe.');
        }
    }

    public function delete($id)
    {
        try {
            $this->recipeService->delete($id);
            return redirect()->route('dashboard.recipes.index')->with('success', 'Recipe deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.recipes.index')->with('error', 'Failed to delete recipe.');
        }
    }

    public function restore($id)
    {
        try {
            $this->recipeService->restore($id);
            return redirect()->route('dashboard.recipes.index')->with('success', 'Recipe restored successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.recipes.index')->with('error', 'Failed to restore recipe.');
        }
    }
}
