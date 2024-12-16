<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\RecipeService;
use Illuminate\Support\Facades\Log;

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
        try {
            $products = $this->recipeService->getAllProducts();
            return view('dashboard.recipes.create', compact('products'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard.recipes.index')->with('error', 'Failed to load the create recipe page.');
        }
    }
    
    

    public function store(Request $request)
    {
        try {
            Log::info('Storing a new recipe', ['data' => $request->all()]);
    
            $data = $request->all();
            $this->recipeService->store($data, $request->file('images'));
    
            return redirect()->route('dashboard.recipes.index')->with('success', 'Recipe created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed while creating recipe', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Failed to create recipe', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to create recipe. Please try again later.');
        }
    }
    public function edit($id)
    {
        try {
            \Log::info('Fetching recipe for editing', ['recipe_id' => $id]);
    
            $recipe = $this->recipeService->show($id);
            $products = $this->recipeService->getAllProducts();
    
            return view('dashboard.recipes.edit', compact('recipe', 'products'));
        } catch (\Exception $e) {
            \Log::error('Failed to load recipe for editing', ['recipe_id' => $id, 'message' => $e->getMessage()]);
            return redirect()->route('dashboard.recipes.index')->with('error', 'Failed to load recipe.');
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            \Log::info('Updating recipe', ['recipe_id' => $id, 'data' => $request->all()]);
    
            $data = $request->all();
            $this->recipeService->update($id, $data, $request->file('images'));
    
            return redirect()->route('dashboard.recipes.index')->with('success', 'Recipe updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to update recipe', ['recipe_id' => $id, 'message' => $e->getMessage()]);
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
