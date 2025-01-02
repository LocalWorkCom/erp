<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Dish;
use App\Services\DiscountService;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    protected $discountService;
    protected $checkToken;
    protected $lang;


    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
        $this->checkToken = false;
        $this->lang =  app()->getLocale();
    }

    public function index(Request $request)
    {
        $response  = $this->discountService->index($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $discounts = Discount::hydrate($responseData['data']);

        return view('dashboard.discount.list', compact('discounts'));
    }

    public function create(Request $request)
    {
        return view('dashboard.discount.add');
    }

    public function store(Request $request)
    {
        $response = $this->discountService->store($request, $this->checkToken);
        $responseData = $response->original;

        // Check if the response has a 'status' key
        if (isset($responseData['status']) && !$responseData['status']) {
            // Check if 'data' key exists and handle validation errors
            if (isset($responseData['data']) && is_array($responseData['data'])) {
                $validationErrors = $responseData['data'];
                return redirect()->back()->withErrors($validationErrors)->withInput();
            }

            // If 'data' key is not present, handle with the 'message' key
            if (isset($responseData['message'])) {
                return redirect()->back()->withErrors($responseData['message'])->withInput();
            }

            // Fallback for unexpected error formats
            return redirect()->back()->withErrors(__('Unexpected error occurred'))->withInput();
        }

        // Success case
        $message = $responseData['message'] ?? __('Operation successful');
        return redirect('dashboard/discounts')->with('message', $message);
    }


    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        return view('dashboard.discount.edit', compact('discount', 'id'));
    }

    public function show($id)
    {
        $discount = Discount::findOrFail($id);
        return view('dashboard.discount.show', compact('discount', 'id'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->discountService->update($request, $id);
        $responseData = $response->original;
        if (isset($responseData['status']) && !$responseData['status']) {
            // If 'data' key exists, handle validation errors
            if (isset($responseData['data'])) {
                $validationErrors = $responseData['data'];
                return redirect()->back()->withErrors($validationErrors)->withInput();
            } else {
                // dd(0);
                return redirect()->back()->withErrors($responseData['message'])->withInput();
            }
        }
        $message = $responseData['message'];
        return redirect('dashboard/discounts')->with('message', $message);
    }

    public function delete(Request $request, $id)
    {
        $response = $this->discountService->destroy($request, $id);
        $responseData = $response->original;
        $message = $responseData['message'];
        return redirect('dashboard/discounts')->with('message', $message);
    }

    public function dish(Request $request, $discountId)
    {
        $response = $this->discountService->listDish($request, $this->checkToken);
        $responseData = json_decode($response->getContent(), true);
        $discount = Discount::with('discount_dishes')->findOrFail($discountId); // Load discount with dishes
        $dishes = Dish::where('is_active', 1)->whereNull('deleted_at')->get();
        foreach ($discount->dishes as $dish) {
            if ($dish->pivot) {
                $dishId = $dish->pivot->dish_id ?? null;
            }
        }

        return view('dashboard.discount.dish.list', compact('discount', 'dishes'));
    }

    public function saveDishes(Request $request, $discountId)
    {
        // Call the service method to save the units
        $response = $this->discountService->saveDiscountDish($request, $discountId);

        // Ensure the response is in the expected format
        $responseData = $response->original ?? [];

        // Check if the response has a 'status' key
        if (isset($responseData['status']) && !$responseData['status']) {
            // If 'data' key exists, handle validation errors
            if (isset($responseData['data'])) {
                $validationErrors = $responseData['data'];
                return redirect()->back()->withErrors($validationErrors)->withInput();
            } else {
                // dd(0);
                return redirect()->back()->withErrors($responseData['message'])->withInput();
            }

            // If no 'data' key is present, handle it gracefully
        }

        // Success message
        $message = $responseData['message'] ?? __('Operation completed successfully.');

        // Redirect with success message
        return redirect()->route('discounts.list', ['id' => $discountId])->with('message', $message);
    }
}
