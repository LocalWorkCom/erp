<?php
namespace App\Http\Controllers\Dashboard;

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

    public function index()
    {
        $addonCategories = $this->addonCategoryService->index();
        return view('dashboard.addon_categories.index', compact('addonCategories'));
    }

    public function show($id)
    {
        $addonCategory = $this->addonCategoryService->show($id);
        return view('dashboard.addon_categories.show', compact('addonCategory'));
    }

    public function create()
    {
        return view('dashboard.addon_categories.create');
    }

    public function store(Request $request)
    {
        $this->addonCategoryService->store($request->all());
        return redirect()->route('dashboard.addon_categories.index')->with('success', 'Addon category created successfully.');
    }

    public function edit($id)
    {
        $addonCategory = $this->addonCategoryService->show($id);
        return view('dashboard.addon_categories.edit', compact('addonCategory'));
    }

    public function update(Request $request, $id)
    {
        $this->addonCategoryService->update($id, $request->all());
        return redirect()->route('dashboard.addon_categories.index')->with('success', 'Addon category updated successfully.');
    }

    public function destroy($id)
    {
        $this->addonCategoryService->delete($id);
        return redirect()->route('dashboard.addon_categories.index')->with('success', 'Addon category deleted successfully.');
    }

    public function restore($id)
    {
        $this->addonCategoryService->restore($id);
        return redirect()->route('dashboard.addon_categories.index')->with('success', 'Addon category restored successfully.');
    }
}
