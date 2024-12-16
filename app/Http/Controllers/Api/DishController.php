<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DishService;
use Illuminate\Http\Request;

class DishController extends Controller
{
    protected $dishService;

    public function __construct(DishService $dishService)
    {
        $this->dishService = $dishService;
    }

    public function index(Request $request)
    {
        $withTrashed = $request->query('withTrashed', false);
        $dishes = $this->dishService->index($withTrashed);

        return response()->json($dishes);
    }

    public function show($id)
    {
        $dish = $this->dishService->show($id);
        return response()->json($dish);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'cuisine_id' => 'required|integer|exists:cuisines,id',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:5000',
            'is_active' => 'required|boolean',
            'has_sizes' => 'required|boolean',
        ]);

        $dish = $this->dishService->store($data);
        return response()->json($dish, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'cuisine_id' => 'required|integer|exists:cuisines,id',
            'price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:5000',
            'is_active' => 'required|boolean',
            'has_sizes' => 'required|boolean',
        ]);

        $dish = $this->dishService->update($id, $data);
        return response()->json($dish);
    }

    public function destroy($id)
    {
        $this->dishService->delete($id);
        return response()->json(['message' => 'Dish deleted successfully.']);
    }

    public function restore($id)
    {
        $dish = $this->dishService->restore($id);
        return response()->json($dish);
    }
}
