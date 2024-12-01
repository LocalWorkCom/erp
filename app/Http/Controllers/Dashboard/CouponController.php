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
        $response  = $this->couponService->index($request);
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
        $response = $this->couponService->store($request, $this->checkToken);
        $responseData = $response->original;
        $message= $responseData['Msg'];
        return redirect('coupons')->with('message',$message);
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('dashboard.coupon.edit', compact('coupon'));
    }

    public function show($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('dashboard.coupon.show', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->couponService->update($request, $id);
        $responseData = $response->original;
        $message= $responseData['Msg'];
        return redirect('coupons')->with('message',$message);
    }

    public function delete(Request $request, $id)
    {
        $response = $this->couponService->destroy($request, $id);
        $responseData = $response->original;
        $message= $responseData['Msg'];
        return redirect('coupons')->with('message',$message);
    }
}
