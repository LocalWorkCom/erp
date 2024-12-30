<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaticPageResource;
use App\Models\Branch;
use App\Models\BranchMenu;
use App\Models\BranchMenuAddon;
use App\Models\BranchMenuCategory;
use App\Models\BranchMenuSize;
use App\Models\Discount;
use App\Models\DishDiscount;
use App\Models\Order;
use App\Models\PrivacyPolicy;
use App\Models\Recipe;
use App\Models\ReturnPolicy;
use App\Models\Slider;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getDishDetail(Request $request)
    {
        $IDBranch = getDefaultBranch();

        // Fetch the dish details for the branch
        $BranchMenu = BranchMenu::where('dish_id', $request->id)
            ->where('branch_id', $IDBranch)
            ->first();

        // Check if the dish exists
        if (!$BranchMenu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dish not found in this branch.'
            ], 404);
        }
        $Branch = Branch::find($IDBranch);

        // Fetch the sizes and addons for the dish
        $BranchMenuSize = BranchMenuSize::where('dish_id', $request->id)
            ->where('branch_id', $IDBranch)
            ->get();

        $BranchMenuAddon = BranchMenuAddon::where('dish_id', $request->id)
            ->where('branch_id', $IDBranch)
            ->get();

        // Structure the response data
        $response = [
            'status' => 'success',
            'branch' => [
                'currency_symbol' => $Branch->country->currency_symbol
            ],
            'dish' => [
                'id' => $BranchMenu->dish_id,
                'name' => $BranchMenu->dish->name_ar,
                'description' => $BranchMenu->dish->description,
                'price' => $BranchMenu->dish->has_size ? 0 : $BranchMenu->price,
                'image' => $BranchMenu->dish->image ?? null,

                'mostOrdered' => checkDishExistMostOrderd($BranchMenu->dish_id)

            ],
            'sizes' => $BranchMenuSize->map(function ($size) {
                return [
                    'id' => $size->id,
                    'name' => $size->dishSizes->name_site,
                    'price' => $size->price,
                    'default_size' => $size->dishSizes->default_size
                ];
            }),
            'addons' => $BranchMenuAddon->map(function ($addon) {

                return [
                    'id' => $addon->id,
                    'name' => $addon->dishAddons->addons->name_site,
                    'price' => $addon->price,
                    'min' => $addon->dishAddons->addons->min_addons,
                    'max' =>  $addon->dishAddons->addons->max_addons
                ];
            })
        ];

        // Return JSON response
        return response()->json($response, 200);
    }
    public function Cart()
    {
        // $branches = Branch::all();

        return view('website.cart');
    }
    public function Checkout(Request $request)
    {
        // $branches = Branch::all();
        return view('website.checkout');
    }
    public function isCouponValid(Request $request)
    {
        $code = $request->code;
        $amount = $request->amount;
        try {
            $lang = $request->header('lang', 'en');
            // $branchId = $request->input('branch_id');  

            $coupon = GetCouponId($code);
            if ($coupon) {
                $valid = CheckCouponValid($coupon->id, $amount);
                if ($valid) {

                    $amount_after_coupon =  applyCoupon($amount, $coupon);
                    return response()->json([
                        'success' => true,
                        'message' => 'Coupon is valid.',
                        'data' => $amount_after_coupon
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Coupon is no longer valid.',
                    ], 200);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Coupon is not valid.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking coupon validity.',
            ], 500);
        }
    }
    public function trackOrder($orderId)
    {
        $order = Order::with(['client', 'branch', 'address', 'tracking', 'orderDetails', 'orderProducts', 'orderTransactions', 'coupon'])
            ->findOrFail($orderId);

        return view('website.track-order', compact('order'));
    }
}
