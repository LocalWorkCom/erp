<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AddonService;

class AddonController extends Controller
{
    protected $addonService;

    public function __construct(AddonService $addonService)
    {
        $this->addonService = $addonService;
    }

    public function index()
    {
        $addons = $this->addonService->index();
        return view('dashboard.addons.index', compact('addons'));
    }

    public function show($id)
    {
        try {
            $addon = $this->addonService->show($id);
            return view('dashboard.addons.show', compact('addon'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard.addons.index')->with('error', 'Failed to load addon details.');
        }
    }

    public function create()
    {
        $products = $this->addonService->getAllProducts();
        return view('dashboard.addons.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            // 'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
            'ingredients' => 'required|array',
            'ingredients.*.product_id' => 'required|integer|exists:products,id',
            'ingredients.*.quantity' => 'required|numeric|min:0',
            'ingredients.*.loss_percent' => 'nullable|numeric|min:0|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,png,jpeg|max:5000',
        ]);

        $this->addonService->store($data, $request->file('images'));
        return redirect()->route('dashboard.addons.index')->with('success', 'Addon created successfully.');
    }

    public function edit($id)
    {
        $addon = $this->addonService->show($id);
        $products = $this->addonService->getAllProducts();
        return view('dashboard.addons.edit', compact('addon', 'products'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            // 'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
            'ingredients' => 'required|array',
            'ingredients.*.product_id' => 'required|integer|exists:products,id',
            'ingredients.*.quantity' => 'required|numeric|min:0',
            'ingredients.*.loss_percent' => 'nullable|numeric|min:0|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,png,jpeg|max:5000',
        ]);

        $this->addonService->update($id, $data, $request->file('images'));
        return redirect()->route('dashboard.addons.index')->with('success', 'Addon updated successfully.');
    }

    public function destroy($id)
    {
        $this->addonService->delete($id);
        return redirect()->route('dashboard.addons.index')->with('success', 'Addon deleted successfully.');
    }

    public function restore($id)
    {
        $this->addonService->restore($id);
        return redirect()->route('dashboard.addons.index')->with('success', 'Addon restored successfully.');
    }
}
