<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaticPageResource;
use App\Models\Branch;
use App\Models\BranchMenu;
use App\Models\BranchMenuAddon;
use App\Models\BranchMenuCategory;
use App\Models\BranchMenuSize;
use App\Models\ClientAddress;
use App\Models\Discount;
use App\Models\DishDiscount;
use App\Models\Order;
use App\Models\PrivacyPolicy;
use App\Models\Recipe;
use App\Models\ReturnPolicy;
use App\Models\Slider;
use App\Models\TermsAndCondition;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{

    protected $orderService;
    protected $lang;
    protected $checkToken;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->lang =  app()->getLocale();
        $this->checkToken = false;
    }
    /**
     * Display a listing of the resource.
     */
    public function getDishDetail(Request $request)
    {
        $userLat = $request->cookie('latitude') ?? ($_COOKIE['latitude'] ?? null);
        $userLon = $request->cookie('longitude') ?? ($_COOKIE['longitude'] ?? null);

        if ($userLat && $userLon) {
            Log::info('Received location from cookies', ['latitude' => $userLat, 'longitude' => $userLon]);
        } else {
            Log::warning('No coordinates found in cookies');
        }

        if ($userLat && $userLon) {
            $nearestBranch = getNearestBranch($userLat, $userLon);
            if ($nearestBranch) {
                $branchId = $nearestBranch->id;
                Log::info('Nearest branch selected', ['branchId' => $branchId]);
            } else {
                $branchId = getDefaultBranch();
                Log::warning('Fallback to default branch', ['branchId' => $branchId]);
            }
        } else {
            $branchId = getDefaultBranch();
            Log::warning('No coordinates found, using default branch', ['branchId' => $branchId]);
        }
        // Fetch the dish details for the branch
        $BranchMenu = BranchMenu::where('dish_id', $request->id)
            ->where('branch_id', $branchId)
            ->first();

        // Check if the dish exists
        if (!$BranchMenu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dish not found in this branch.'
            ], 404);
        }
        $Branch = Branch::find($branchId);

        // Fetch the sizes and addons for the dish
        $BranchMenuSize = BranchMenuSize::where('dish_id', $request->id)
            ->where('branch_id', $branchId)
            ->get();
        // dd($BranchMenuSize);

        $BranchMenuAddon = BranchMenuAddon::where('dish_id', $request->id)
            ->where('branch_id', $branchId)
            ->get();
        // dd($BranchMenu);
        $price = 0;
        if ($BranchMenu->dish->has_sizes) {
            foreach ($BranchMenuSize as $key => $size) {
                if ($size->dishSizes && $size->dishSizes->default_size) {
                    $price =  $size->price;
                }
            }
        } else {
            $price =  $BranchMenu->price;
        }
        // dd($Branch->country->currency_symbol);
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
                'price' => $BranchMenu->dish->has_sizes ? $price : $BranchMenu->price,
                'image' => $BranchMenu->dish->image ?? null,
                'has_size' => $BranchMenu->dish->has_sizes,
                'has_addon' => count($BranchMenuAddon) > 0 ? 1 : 0,

                'mostOrdered' => checkDishExistMostOrderd($branchId, $BranchMenu->dish_id)

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
        // dd($response);

        // Return JSON response
        return response()->json($response, 200);
    }
    public function Cart()
    {
        $address = '';
        // $branches = Branch::all();
        if (auth('client')->check()) {

            $address = ClientAddress::where('is_active', 1)->where('is_default', 1)->where('user_id', auth('client')->user()->id)->first();
        }
        return view('website.cart', compact('address'));
    }
    public function Checkout(Request $request)
    {
        $address = '';
        // $branches = Branch::all();
        if (auth('client')->check()) {

            $address = ClientAddress::where('is_active', 1)->where('is_default', 1)->where('user_id', auth('client')->user()->id)->first();
        }
        // $branches = Branch::all();
        return view('website.checkout', compact('address'));
    }
    public function store(Request $request)
    {
        $userLat = $request->cookie('latitude') ?? ($_COOKIE['latitude'] ?? null);
        $userLon = $request->cookie('longitude') ?? ($_COOKIE['longitude'] ?? null);
        
        if ($userLat && $userLon) {
            Log::info('Received location from cookies', ['latitude' => $userLat, 'longitude' => $userLon]);
        } else {
            Log::warning('No coordinates found in cookies');
        }
        
        if ($userLat && $userLon) {
            $nearestBranch = getNearestBranch($userLat, $userLon);
            if ($nearestBranch) {
                $branchId = $nearestBranch->id;
                Log::info('Nearest branch selected', ['branchId' => $branchId]);
            } else {
                $branchId = getDefaultBranch();
                Log::warning('Fallback to default branch', ['branchId' => $branchId]);
            }
        } else {
            $branchId = getDefaultBranch();
            Log::warning('No coordinates found, using default branch', ['branchId' => $branchId]);
        }
        // //        dd($request->all());
        $cart = json_decode($request->cart_data);
        $request['type'] = 'Online';
        $request['note'] = $cart->notes;
        $request['table_id'] = null;
        $request['branch_id'] = $branchId;
        $request['coupon_code'] = $request->coupon_code;
        $request['details'] = $cart->items;
        // dd($request);

        $response = $this->orderService->store($request, $this->checkToken);
        $responseData = $response->original;
        // dd($responseData);
        if (!$responseData['status'] && isset($responseData['data'])) {
            $validationErrors = $responseData['data'];
            dd($validationErrors);
            return redirect()->back()->withErrors($validationErrors)->withInput();
        }
        $message = $responseData['message'];
        return redirect('orders')->with('message', $message);
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
    public function trackOrder()
    {
        $user = Auth::guard('client')->user();

        $orders = Order::with(['client', 'branch.country', 'address', 'tracking', 'orderDetails', 'orderAddons.Addon', 'orderProducts', 'orderTransactions', 'coupon'])
            ->where('client_id', $user->id)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('website.track-order', compact('orders'));
    }

    public function pastOrders()
    {
        $user = Auth::guard('client')->user();

        $orders = Order::with([
            'client',
            'branch.country',
            'address',
            'tracking',
            'orderDetails',
            'orderAddons.Addon',
            'orderProducts',
            'orderTransactions',
            'coupon',
        ])
            ->where('client_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();



        return view('website.orders', compact('orders'));
    }

    public function paymentDetails($id)
    {
        $user = Auth::guard('client')->user();

        $order =  Order::with([
            'client',
            'branch.country',
            'address',
            'tracking',
            'orderDetails',
            'orderAddons.Addon',
            'orderProducts',
            'orderTransactions',
            'coupon',
        ])
            ->where('client_id', $user->id)
            ->where('id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('website.order-payment-details', compact('order'));
    }
}
