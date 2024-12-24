<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Store;
use App\Models\Unit;
use App\Services\BrandService;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    protected $couponService;
    protected $checkToken;
    protected $lang;


    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
        $this->lang =  app()->getLocale();
    }

    public function index(Request $request)
    {
        $response  = $this->couponService->index($request,$this->lang);
        $responseData = json_decode($response->getContent(), true);
        $coupons = Coupon::hydrate($responseData['data']);

        return view('dashboard.coupon.list', compact('coupons'));
    }

    public function create(Request $request)
    {
        return view('dashboard.coupon.add');
    }

    public function store(Request $request)
    {
        $response = $this->couponService->store($request, $this->lang);
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
        return redirect('dashboard/coupons')->with('message',$message);
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('dashboard.coupon.edit', compact('coupon', 'id'));
    }

    public function show($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('dashboard.coupon.show', compact('coupon', 'id'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->couponService->update($request, $id,$this->lang);
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

            // If no 'data' key is present, handle it gracefully
        }
        // if (!$responseData['status'] && isset($responseData['data'])) {
        //     $validationErrors = $responseData['data'];
        //     return redirect()->back()->withErrors($validationErrors)->withInput();
        // }
        $message= $responseData['message'];
        return redirect('dashboard/coupons')->with('message',$message);
    }

    public function delete(Request $request, $id)
    {
        $response = $this->couponService->destroy($request, $id,$this->lang);
        $responseData = $response->original;
        $message= $responseData['message'];
        return redirect('dashboard/coupons')->with('message',$message);
    }
}
