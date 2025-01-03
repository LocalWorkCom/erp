<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaticPageResource;
use App\Models\Branch;
use App\Models\BranchMenu;
use App\Models\BranchMenuCategory;
use App\Models\Discount;
use App\Models\DishDiscount;
use App\Models\FAQ;
use App\Models\Offer;
use App\Models\PrivacyPolicy;
use App\Models\Rate;
use App\Models\ReturnPolicy;
use App\Models\Slider;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the latitude and longitude from cookies
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

        $sliders = Slider::all();
        $branches = Branch::all();
        $discounts = DishDiscount::with(['dish' => function ($query) {
            $query->select('id', 'name_ar', 'name_en', 'image');
        }])
            ->with('discount') // Make sure to include the discount relationship
            ->whereHas('discount', function ($query) {
                $query->where('is_active', 1);
            })
            ->join('branch_menus', 'branch_menus.dish_id', '=', 'dish_discount.dish_id')
            ->join('branches', 'branches.id', '=', 'branch_menus.branch_id')
            ->join('countries', 'countries.id', '=', 'branches.country_id')
            ->where('branches.is_default', 1)  // Only get the branch where is_default = 1
            ->select('dish_discount.*', 'countries.currency_symbol') // Select only necessary columns
            ->distinct() // Ensure no duplicates are returned
            ->get();



        // Get popular dishes for the selected branch
        $popularDishes = getMostDishesOrdered($branchId, 5);

        // Get the menu categories for the selected branch
        $menueDishes = BranchMenu::where('branch_id', $branchId)->pluck('branch_menu_category_id')->toArray();
        $menuCategories = BranchMenuCategory::with('dish_categories')
            ->where('branch_id', $branchId)->whereIn('dish_category_id', $menueDishes)
            ->where('is_active', true)
            ->get();

        // Get user favorites, if the user is authenticated
        $userFavorites = [];
        if (Auth::guard('client')->check()) {
            $userFavorites = DB::table('user_favorite_dishes')
                ->where('user_id', Auth::guard('client')->id())
                ->pluck('dish_id')
                ->toArray();
        }

        // Pass the current locale and selected brandId to the view
        $locale = app()->getLocale();

        return view(
            'website.landing',
            compact(['sliders', 'discounts', 'popularDishes', 'menuCategories', 'branches', 'userFavorites', 'locale', 'branchId'])
        );
    }


    public function showMenu(Request $request)
    {
        $categoryId = $request->query('category_id');
        $userLat = $request->cookie('latitude') ?? ($_COOKIE['latitude'] ?? null);
        $userLon = $request->cookie('longitude') ?? ($_COOKIE['longitude'] ?? null);

        if ($userLat && $userLon) {
            $nearestBranch = getNearestBranch($userLat, $userLon);
            if ($nearestBranch) {
                $branchId = $nearestBranch->id;
                Log::info('Nearest branch selected:', ['branchId' => $branchId]);
            } else {
                $branchId = getDefaultBranch();
                Log::warning('Fallback to default branch:', ['branchId' => $branchId]);
            }
        }elseif($request->query('branch_id')){
            $branchId =$request->query('branch_id');
        } else {
            $branchId = getDefaultBranch();
            Log::warning('No coordinates found, using default branch:', ['branchId' => $branchId]);
        }

        if (!$branchId) {
            return redirect()->back()->with('error', 'لا يوجد فرع متاح حاليًا.');
        }
        $menueDishes = BranchMenu::where('branch_id', $branchId)->pluck('branch_menu_category_id')->toArray();
        $menuCategories = BranchMenuCategory::with('dish_categories')
            ->where('branch_id', $branchId)->whereIn('dish_category_id', $menueDishes)
            ->where('is_active', true)
            ->get();

        $userFavorites = [];
        if (Auth::guard('client')->check()) {
            $userFavorites = DB::table('user_favorite_dishes')
                ->where('user_id', Auth::guard('client')->id())
                ->pluck('dish_id')
                ->toArray();
        }
        $offers = Offer::where('is_active', 1)
        ->where(function ($query) use ($branchId) {
            $query->whereRaw('FIND_IN_SET(?, branch_id)', [$branchId])
                ->orWhere('branch_id', -1);
        })
        ->whereHas('details', function ($query) {
            $query->whereNull('deleted_at');
        })
        ->get();
        return view(
            'website.menu',
            compact(['menuCategories', 'userFavorites', 'categoryId','offers'])
        );
    }

    public function showOffers(Request $request)
    {
        $categoryId = 'offers';
        $userLat = $request->cookie('latitude') ?? ($_COOKIE['latitude'] ?? null);
        $userLon = $request->cookie('longitude') ?? ($_COOKIE['longitude'] ?? null);

        if ($userLat && $userLon) {
            $nearestBranch = getNearestBranch($userLat, $userLon);
            if ($nearestBranch) {
                $branchId = $nearestBranch->id;
                Log::info('Nearest branch selected:', ['branchId' => $branchId]);
            } else {
                $branchId = getDefaultBranch();
                Log::warning('Fallback to default branch:', ['branchId' => $branchId]);
            }
        } else {
            $branchId = getDefaultBranch();
            Log::warning('No coordinates found, using default branch:', ['branchId' => $branchId]);
        }

        if (!$branchId) {
            return redirect()->back()->with('error', 'لا يوجد فرع متاح حاليًا.');
        }
        $menueDishes = BranchMenu::where('branch_id', $branchId)->pluck('branch_menu_category_id')->toArray();
        $menuCategories = BranchMenuCategory::with('dish_categories')
            ->where('branch_id', $branchId)->whereIn('dish_category_id', $menueDishes)
            ->where('is_active', true)
            ->get();

        $userFavorites = [];
        if (Auth::guard('client')->check()) {
            $userFavorites = DB::table('user_favorite_dishes')
                ->where('user_id', Auth::guard('client')->id())
                ->pluck('dish_id')
                ->toArray();
        }
        $offers = Offer::where('is_active', 1)
            ->where(function ($query) use ($branchId) {
                $query->whereRaw('FIND_IN_SET(?, branch_id)', [$branchId])
                    ->orWhere('branch_id', -1);
            })
            ->whereHas('details', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get();
        return view(
            'website.menu',
            compact(['menuCategories', 'userFavorites', 'categoryId', 'offers'])
        );
    }

    public function contactUs()
    {
        $branches = Branch::all();
        return view(
            'website.contact-us',
            compact(['branches'])
        );
    }

    public function privacy()
    {
        $privacies = StaticPageResource::collection(
            PrivacyPolicy::where('active', 1)->get()
        );
        $privaciesArray = $privacies->toArray(request());
        $branches = Branch::all();
        return view('website.privacy', compact('privaciesArray', 'branches'));
    }

    public function return()
    {
        $returns = StaticPageResource::collection(
            ReturnPolicy::where('active', 1)->get()
        );
        $returnsArray = $returns->toArray(request());
        $branches = Branch::all();
        return view('website.return', compact('returnsArray', 'branches'));
    }

    public function terms()
    {
        $terms = StaticPageResource::collection(
            TermsAndCondition::where('active', 1)->get()
        );
        $termsArray = $terms->toArray(request());
        $branches = Branch::all();
        return view('website.terms', compact('termsArray', 'branches'));
    }

    public function addFavorite(Request $request)
    {
        if (!Auth::guard('client')->check()) {
            return redirect()->back()->with('error', 'يجب تسجيل الدخول لإضافة الطبق إلى المفضلة.');
        }

        $user = Auth::guard('client')->user();
        $dishId = $request->dish_id;

        $favorite = DB::table('user_favorite_dishes')
            ->where('user_id', $user->id)
            ->where('dish_id', $dishId)
            ->first();

        if ($favorite) {
            // Remove favorite
            DB::table('user_favorite_dishes')
                ->where('user_id', $user->id)
                ->where('dish_id', $dishId)
                ->delete();

            return redirect()->back()->with('success', 'تم إزالة الطبق من المفضلة.');
        } else {
            // Add to favorites
            DB::table('user_favorite_dishes')->insert([
                'user_id' => $user->id,
                'dish_id' => $dishId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'تم إضافة الطبق إلى المفضلة.');
        }
    }

    public function showFavorites(Request $request)
    {
        $userLat = $request->cookie('latitude') ?? ($_COOKIE['latitude'] ?? null);
        $userLon = $request->cookie('longitude') ?? ($_COOKIE['longitude'] ?? null);

        if ($userLat && $userLon) {
            $nearestBranch = getNearestBranch($userLat, $userLon);
            if ($nearestBranch) {
                $branchId = $nearestBranch->id;
            } else {
                $branchId = getDefaultBranch();
            }
        } else {
            $branchId = getDefaultBranch();
        }

        $menuCategories = BranchMenuCategory::with(['dish_categories' => function ($query) {
            $query->where('is_active', true);
        }, 'dish_categories.dishes' => function ($query) {
            $query->where('is_active', true);
        }])
            ->where('branch_id', $branchId)
            ->get();

        $userFavorites = [];
        if (Auth::guard('client')->check()) {
            $userFavorites = DB::table('user_favorite_dishes')
                ->where('user_id', Auth::guard('client')->id())
                ->pluck('dish_id')
                ->toArray();
        }
        return view(
            'website.favorites',
            compact(['menuCategories', 'userFavorites'])
        );
    }

    public function getfaqs()
    {
        $lang = app()->getLocale(); // Get the current language

        // Select only the necessary fields based on the language
        $faqs = FAQ::select(
            "name_{$lang} as name",
            "question_{$lang} as question",
            "answer_{$lang} as answer",
            'active'
        )->where('active', 1) // Only fetch active FAQs
            ->get();

        return view('website.faq', compact('faqs'));
    }

    public function showRate()
    {
        $rates = Rate::all();
        return view('website.rate', compact('rates'));
    }

    public function addRate(Request $request)
    {
        $validatedData = $request->validate([
            'value' => 'required|integer|min:1|max:5',
            'note' => 'nullable|string|max:1000',
        ]);

        $rating = new Rate();
        $rating->value = $validatedData['value'];
        $rating->note = $validatedData['note'];
        $rating->created_by = auth()->id();
        $rating->save();

        return redirect()->back()->with('success', 'شكراً لتقييمك!');
    }
}
