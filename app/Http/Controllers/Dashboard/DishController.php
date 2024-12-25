<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Services\DishService;
use App\Services\DishCategoryService;
use App\Services\AddonCategoryService;
use App\Services\AddonService;
use App\Services\CuisineService;
use App\Services\RecipeService;
use App\Models\Dish;
use App\Models\Branch;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DishController extends Controller
{
    protected $dishService;
    protected $dishCategoryService;
    protected $addonCategoryService;
    protected $addonService;
    protected $cuisineService;
    protected $recipeService;

    public function __construct(
        DishService $dishService,
        DishCategoryService $dishCategoryService,
        AddonCategoryService $addonCategoryService,
        AddonService $addonService,
        CuisineService $cuisineService,
        RecipeService $recipeService


    ) {
        $this->dishService = $dishService;
        $this->dishCategoryService = $dishCategoryService;
        $this->addonCategoryService = $addonCategoryService;
        $this->addonService = $addonService;
        $this->cuisineService = $cuisineService;
        $this->recipeService = $recipeService;

    }


    public function index()
    {
        $dishes = $this->dishService->index();
        return view('dashboard.dish.index', compact('dishes'));
    }

    public function show($id)
    {
        try {
            $dish = $this->dishService->show($id);
    
            Log::info('Dish Data Fetched Successfully', ['dish' => $dish]);
    
            return view('dashboard.dish.show', compact('dish'));
        } catch (\Exception $e) {
            Log::error('Error Fetching Dish Data', ['error' => $e->getMessage()]);
            return redirect()->route('dashboard.dishes.index')->with('error', __('dishes.DishNotFound'));
        }
    }
    

    public function create()
    {
        $categories = $this->dishCategoryService->index(); 
        $addons = $this->addonService->index(); 
        $addonCategories = $this->addonCategoryService->index(); 
        $cuisines = $this->cuisineService->index(); 
        $recipes = $this->recipeService->index(); 
        $branches = Branch::all(); 

        return view('dashboard.dish.create', compact('categories', 'addons', 'addonCategories', 'cuisines', 'recipes','branches'));
    }
    
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['created_by'] = auth()->id(); 
    
            $dish = $this->dishService->store($data, $request->file('image'));
            Log::info('Dish created successfully', ['dish_id' => $dish->id]);
    
            $branches = $request->input('branches', []);
            Log::info('Selected branches', ['branches' => $branches]);
    
            if (in_array('all', $branches)) {
                $allBranchIds = Branch::pluck('id')->toArray();
                Log::info('All branch IDs', ['all_branch_ids' => $allBranchIds]);
    
                AddBranchesMenu($allBranchIds, $dish->id);
            } else {
                Log::info('Specific branches for the dish', [
                    'dish_id' => $dish->id,
                    'branch_ids' => $branches,
                ]);
    
                AddBranchesMenu($branches, $dish->id);
            }
    
            return redirect()->route('dashboard.dishes.index')->with('success', __('dishes.DishCreated'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Dish creation failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('dishes.DishCreationFailed'));
        }
    }
    
    
    
    public function edit($id)
    {
        $dish = Dish::with(['dishAddonsDetails.category', 'dishAddonsDetails.addons'])->findOrFail($id);
        $categories = $this->dishCategoryService->index();
        $cuisines = $this->cuisineService->index();
        $recipes = $this->recipeService->index();
        $allAddons = $this->addonService->index(); 
        $addonCategories = $this->addonCategoryService->index();
        $addons = $dish->addons ?? collect(); 
    
        return view('dashboard.dish.edit', compact('dish', 'categories', 'cuisines', 'recipes', 'allAddons', 'addonCategories', 'addons'));
    }
    
    
    
    
    public function update(Request $request, $id)
    {
        try {
            $this->dishService->update($request, $id);
            return redirect()->route('dashboard.dishes.index')->with('success', __('dishes.DishUpdated'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Dish update failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('dishes.DishUpdateFailed'));
        }
    }
    
    
    public function destroy($id)
    {
        $this->dishService->delete($id);
        return redirect()->route('dashboard.dishes.index')->with('success', 'Dish deleted successfully.');
    }

    public function restore($id)
    {
        $this->dishService->restore($id);
        return redirect()->route('dashboard.dish.index')->with('success', 'Dish restored successfully.');
    }
}
