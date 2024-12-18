<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Discount;
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
        $this->lang =  app()->getLocale();
        $this->checkToken = false;
    }

    public function index(Request $request)
    {
        $response  = $this->discountService->index($request,$this->checkToken);
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
            // If 'data' key exists, handle validation errors
            if (isset($responseData['data'])) {
                $validationErrors = $responseData['data'];
                return redirect()->back()->withErrors($validationErrors)->withInput();
            } else {
                return redirect()->back()->withErrors($responseData['message'])->withInput();
            }

            // If no 'data' key is present, handle it gracefully
        }
        $message= $responseData['message'];
        return redirect('dashboard/discounts')->with('message',$message);
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
        $message= $responseData['message'];
        return redirect('dashboard/discounts')->with('message',$message);
    }

    public function delete(Request $request, $id)
    {
        $response = $this->discountService->destroy($request, $id);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect('dashboard/discounts')->with('message',$message);
    }
}
