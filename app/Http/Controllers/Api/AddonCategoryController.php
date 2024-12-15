<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AddonCategoryService;
use Illuminate\Http\Request;

class AddonCategoryController extends Controller
{
    protected $addonCategoryService;

    public function __construct(AddonCategoryService $addonCategoryService)
    {
        $this->addonCategoryService = $addonCategoryService;
    }

    public function index(Request $request)
    {
        $withTrashed = $request->query('withTrashed', false);
        $addonCategories = $this->addonCategoryService->index($withTrashed);
        return response()->json($addonCategories);
    }

    public function show($id)
    {
        $addonCategory = $this->addonCategoryService->show($id);
        return response()->json($addonCategory);
    }

    public function store(Request $request)
    {
        $addonCategory = $this->addonCategoryService->store($request->all());
        return response()->json($addonCategory, 201);
    }

    public function update(Request $request, $id)
    {
        $addonCategory = $this->addonCategoryService->update($id, $request->all());
        return response()->json($addonCategory);
    }

    public function destroy($id)
    {
        $this->addonCategoryService->delete($id);
        return response()->json(['message' => 'Addon category deleted successfully.']);
    }

    public function restore($id)
    {
        $addonCategory = $this->addonCategoryService->restore($id);
        return response()->json($addonCategory);
    }
}
