<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RecipeService;
use Illuminate\Support\Facades\Log;

class RecipeController extends Controller
{
    protected $recipeService;

    public function __construct(RecipeService $recipeService)
    {
        $this->recipeService = $recipeService;
    }

    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $withTrashed = $request->query('withTrashed', false);

            $recipes = $this->recipeService->index($withTrashed);

            return ResponseWithSuccessData($lang, $recipes, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching recipes: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');

            $recipe = $this->recipeService->show($id);

            return ResponseWithSuccessData($lang, $recipe, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $data = $request->all();

            $this->recipeService->store($data, $request->file('images'));

            return ResponseWithSuccessData($lang, 'Recipe created successfully.', 1);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return RespondWithBadRequestWithData($e->errors());
        } catch (\Exception $e) {
            Log::error('Error creating recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $data = $request->all();

            $this->recipeService->update($id, $data, $request->file('images'));

            return ResponseWithSuccessData($lang, 'Recipe updated successfully.', 1);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return RespondWithBadRequestWithData($e->errors());
        } catch (\Exception $e) {
            Log::error('Error updating recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');

            $this->recipeService->delete($id);

            return ResponseWithSuccessData($lang, 'Recipe deleted successfully.', 1);
        } catch (\Exception $e) {
            Log::error('Error deleting recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');

            $this->recipeService->restore($id);

            return ResponseWithSuccessData($lang, 'Recipe restored successfully.', 1);
        } catch (\Exception $e) {
            Log::error('Error restoring recipe: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
