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
            // Log the incoming data
            Log::info('Storing a new recipe', ['data' => $request->all()]);
    
            // Validate the request
            $validatedData = $request->validate([
                'name_ar' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'type' => 'required|integer|in:1',
                'is_active' => 'required|boolean',
                'ingredients' => 'required|array',
                'ingredients.*.product_id' => 'required|exists:products,id',
                'ingredients.*.quantity' => 'required|numeric|min:0',
                'ingredients.*.loss_percent' => 'nullable|numeric|min:0|max:100',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            // Call the service to store the recipe
            $this->recipeService->store($validatedData, $request->file('images'));
    
            // Redirect to index with success message
            return redirect()->route('dashboard.recipes.index')->with('success', 'Recipe created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::error('Validation failed while creating recipe', ['errors' => $e->errors()]);
    
            // Redirect back with errors and input
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log unexpected exceptions
            Log::error('Failed to create recipe', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
    
            // Redirect back with an error message
            return redirect()->back()->with('error', 'Failed to create recipe. Please try again later.');
        }
    }
    
    public function edit($id)
    {
        try {
            \Log::info('Fetching recipe for editing', ['recipe_id' => $id]);
    
            // Fetch the recipe along with its ingredients and other necessary data
            $recipe = $this->recipeService->show($id);
    
            // Fetch all products for ingredient selection
            $products = $this->recipeService->getAllProducts();
    
            return view('dashboard.recipes.edit', compact('recipe', 'products'));
        } catch (\Exception $e) {
            \Log::error('Failed to load recipe for editing', [
                'recipe_id' => $id,
                'message' => $e->getMessage()
            ]);
    
            return redirect()->route('dashboard.recipes.index')->with('error', 'Failed to load recipe for editing.');
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
