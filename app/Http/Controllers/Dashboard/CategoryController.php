<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    protected $categoryService;
    protected $checkToken;  // Set to true or false based on your need


    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->checkToken = false;
    }

    public function index(Request $request)
    {
//        dd(app()->getLocale());
        $response = $this->categoryService->index($request, $this->checkToken);

        $responseData = $response->original;

        $categories = $responseData['data'];

        return view('dashboard.category.list', compact('categories'));
    }

    public function create()
    {
        $categories = Category::where('active', 1)->get();
        return view('dashboard.category.add', compact('categories'));
    }
    public function store(Request $request)
    {
        $response = $this->categoryService->store($request, $this->checkToken);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect('categories')->with('message',$message);
    }

    public function show($id)
    {
        $category = Category::with('parent')->findOrFail($id);
//        dd($category);
        return view('dashboard.category.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('active', 1)->get(); // Fetch only active categories
        return view('dashboard.category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
//        dd($request->all());
        $response = $this->categoryService->update($request, $id, $this->checkToken);
//        dd($response);
        $responseData = $response->original;
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message= $responseData['message'];
        return redirect('categories')->with('message',$message);
    }
    public function delete(Request $request, $id)
    {
        $response = $this->categoryService->delete($request, $id, $this->checkToken);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect('categories')->with('message',$message);
    }

}
