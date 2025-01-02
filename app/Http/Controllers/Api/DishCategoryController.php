<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Models\BranchMenuCategory;
use App\Models\BranchMenu;
use App\Models\BranchMenuSize;
use App\Models\BranchMenuAddonCategory;
use App\Models\BranchMenuAddon;
use App\Models\DishCategory;
use App\Models\Offer;
use App\Services\DishCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DishCategoryController extends Controller
{
    protected $dishCategoryService;

    public function __construct(DishCategoryService $dishCategoryService)
    {
        $this->dishCategoryService = $dishCategoryService;
    }

    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $withTrashed = $request->query('withTrashed', false);

            $categories = $this->dishCategoryService->index($withTrashed);

            return ResponseWithSuccessData($lang, $categories, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching dish categories: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $category = $this->dishCategoryService->show($id);

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function create(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $categories = $this->dishCategoryService->index();

            return ResponseWithSuccessData($lang, ['parent_categories' => $categories], 1);
        } catch (\Exception $e) {
            Log::error('Error preparing data for creating dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $category = $this->dishCategoryService->show($id);
            $categories = $this->dishCategoryService->index();

            return ResponseWithSuccessData($lang, ['category' => $category, 'parent_categories' => $categories], 1);
        } catch (\Exception $e) {
            Log::error('Error preparing data for editing dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function store(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $data = $request->all();
            $data['created_by'] = auth()->id();

            $category = $this->dishCategoryService->store($data, $request->file('image'));

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return RespondWithBadRequestWithData($e->errors());
        } catch (\Exception $e) {
            Log::error('Error creating dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $data = $request->all();
            $data['modified_by'] = auth()->id();

            $category = $this->dishCategoryService->update($id, $data, $request->file('image'));

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return RespondWithBadRequestWithData($e->errors());
        } catch (\Exception $e) {
            Log::error('Error updating dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');

            $this->dishCategoryService->destroy($id);

            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $category = $this->dishCategoryService->restore($id);

            return ResponseWithSuccessData($lang, $category, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring dish category: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }
    public function menuDishes(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        $categoryId = $request->query('categoryId', 'all');
        $offers = $request->query('offers', 0);
        $searchName = $request->query('name', null); // Add search query parameter
        $orderBy = $request->query('orderBy', 'newest'); // Add orderBy query parameter ('newest' or 'most_ordered')

        $branchController = new BranchController();
        $branchesResponse = $branchController->listBranchAndNear($request);
        $branchesData = $branchesResponse->getData()->data; // LAT AND LONG OPTIONAL
        $branch = $branchesData->branch ?? null;
        $branchId = $branch->id ?? null;

        if (!is_numeric($categoryId) && $categoryId !== 'all' || !in_array($offers, [0, 1])) {
            return respondError('Validation Error', 400, [
                'categoryId' => $lang == 'en' ? ['it must be a number or all'] : ['يجب ان تكون رقم او all'],
                'offers' => $lang == 'en' ? ['it must be 0 or 1'] : ['يجب ان تكون 0 او 1'],
            ]);
        }

        $nameColumn = ($lang === 'en') ? 'name_en' : 'name_ar';

        if ($branchId) {
            // Fetch most popular dishes once
            $mostPopularController = new MostPopularController();
            $mostPopularResponse = $mostPopularController->index($request);
            $mostPopular = collect($mostPopularResponse->getData()->data);
            $popularDishIds = $mostPopular->pluck('id')->toArray();
            $popularDishCurrencyMap = $mostPopular->pluck('currency_symbol', 'id')->toArray();

            // Scenario 1: If categoryId is greater than 0, fetch dishes for the category
            if (is_numeric($categoryId) && $categoryId > 0) {
                $dishCategory = DishCategory::whereHas('branchMenuCategory', function ($query) use ($categoryId, $branchId) {
                    $query->where('branch_id', $branchId)
                    
                        ->where('dish_category_id', $categoryId);
                })
                    ->whereHas('dishes', function ($query) {
                        $query->where('is_active', true);
                    })
                    ->with([
                        'dishes' => function ($query) use ($searchName, $nameColumn, $orderBy) {
                            $query->where('is_active', true);

                            if ($searchName) {
                                $query->where($nameColumn, 'like', "%{$searchName}%");
                            }

                            if ($orderBy === 'most_ordered') {
                                $query->orderByDesc('total_quantity');
                            } else {
                                $query->orderBy('dishes.created_at', 'desc');
                            }
                        }
                    ])->where('id', $categoryId)->first();
                        $dishCategory['is_active'] = (bool)$dishCategory->is_active;

                if (!$dishCategory) {
                    return RespondWithBadRequestData($lang, 8);
                }

                // Check if user is authenticated
                if (CheckToken()) {
                    $user = auth('api')->user(); // Get authenticated user
                    if ($user) {
                        // Map over dishes to check if each dish is a favorite and is most popular
                        $dishCategory->dishes = $dishCategory->dishes->map(function ($dish) use ($user, $popularDishIds, $popularDishCurrencyMap) {
                            // Initialize flags for favorites and popularity
                            $flagFavorite = 0;
                            $flagPopular = in_array($dish->id, $popularDishIds) ? true : false;
                            $dish->currency_symbol = $popularDishCurrencyMap[$dish->id] ?? null;
                            $dish->is_active = (bool)$dish->is_active;
                            $dish->has_sizes = (bool)$dish->has_sizes;
                            $dish->has_addon = (bool)$dish->has_addon;
                            // Check if the dish is in the user's favorites
                            $isFavorite = DB::table('user_favorite_dishes')
                                ->where('user_id', $user->id)
                                ->where('dish_id', $dish->id)
                                ->exists(); // Using exists() for performance optimization

                            // If the dish is in the favorites, set the flag to 1
                            if ($isFavorite) {
                                $flagFavorite = true ;
                            }else{
                                $flagFavorite = false ;

                            }

                            // Set the flags
                            $dish->is_favorite = $flagFavorite;
                            $dish->is_most_popular = $flagPopular;

                            return $dish;
                        });
                    }
                } else {
                    // If user is not authenticated, only set the most popular flag
                    $dishCategory->dishes = $dishCategory->dishes->map(function ($dish) use ($popularDishIds, $popularDishCurrencyMap) {
                        // Check if the dish is in the most popular dishes
                        $dish->is_most_popular = in_array($dish->id, $popularDishIds) ? true : false;
                        $dish->currency_symbol = $popularDishCurrencyMap[$dish->id] ?? null;
                        $dish->is_favorite = false;
                        $dish->is_active = (bool)$dish->is_active;
                        $dish->has_sizes = (bool)$dish->has_sizes;
                        $dish->has_addon = (bool)$dish->has_addon;
                        return $dish;
                    });
                }

                $dishCategory->makeHidden(['name_site', 'description_site'])->dishes->makeHidden(['name_site', 'description_site']);
                return ResponseWithSuccessData($lang, $dishCategory, 1);
            }

            if ($categoryId === 'all') {
                $dishCategories = DishCategory::whereHas('branchMenuCategory', function ($query) use ($branchId) {
                    $query->where('branch_id', $branchId);
                })
                    ->whereHas('dishes', function ($query) {
                        $query->where('is_active', true);
                    })
                    ->with(['dishes' => function ($query) use ($searchName, $nameColumn, $orderBy) {
                        $query->where('is_active', true);

                        if ($searchName) {
                            $query->where($nameColumn, 'like', "%{$searchName}%");
                        }

                        if ($orderBy === 'most_ordered') {
                            $query->orderByDesc('total_quantity');
                        } else {
                            $query->orderBy('dishes.created_at', 'desc');
                        }
                    }])->get();

                // Check if user is authenticated
                if (CheckToken()) {
                    $user = auth('api')->user(); // Get authenticated user
                    if ($user) {
                        // Map over dishes to check if each dish is a favorite and is most popular
                        $dishCategories->each(function ($dishCategory) use ($user, $popularDishIds, $popularDishCurrencyMap) {
                            $dishCategory->dishes = $dishCategory->dishes->map(function ($dish) use ($user, $popularDishIds, $popularDishCurrencyMap) {
                                // Initialize flags for favorites and popularity
                                $flagFavorite = 0;
                                $flagPopular = in_array($dish->id, $popularDishIds) ? true : false;
                                $dish->currency_symbol = $popularDishCurrencyMap[$dish->id] ?? null;
                                $dish->is_active = (bool)$dish->is_active;
                                $dish->has_sizes = (bool)$dish->has_sizes;
                                $dish->has_addon = (bool)$dish->has_addon;
                                // Check if the dish is in the user's favorites
                                $isFavorite = DB::table('user_favorite_dishes')
                                    ->where('user_id', $user->id)
                                    ->where('dish_id', $dish->id)
                                    ->exists(); // Using exists() for performance optimization

                                // If the dish is in the favorites, set the flag to 1
                                if ($isFavorite) {
                                    $flagFavorite = true ;
                                }else{
                                    $flagFavorite = false ;
    
                                }

                                // Set the flags
                                $dish->is_favorite = $flagFavorite;
                                $dish->is_most_popular = $flagPopular;

                                return $dish;
                            });
                        });
                    }
                } else {
                    // If user is not authenticated, only set the most popular flag
                    $dishCategories->each(function ($dishCategory) use ($popularDishIds, $popularDishCurrencyMap) {
                        $dishCategory->dishes = $dishCategory->dishes->map(function ($dish) use ($popularDishIds, $popularDishCurrencyMap) {
                            // Check if the dish is in the most popular dishes
                            $dish->is_most_popular = in_array($dish->id, $popularDishIds) ? true : false;
                            $dish->currency_symbol = $popularDishCurrencyMap[$dish->id] ?? null;
                            $dish->is_favorite = false;
                            $dish->is_active = (bool)$dish->is_active;
                            $dish->has_sizes = (bool)$dish->has_sizes;
                            $dish->has_addon = (bool)$dish->has_addon;
                            return $dish;
                        });
                    });
                }

                $dishCategories->makeHidden(['name_site', 'description_site']);
                foreach ($dishCategories as $dishCategory) {
                    $dishCategory->dishes->makeHidden(['name_site', 'description_site']);
                    $dishCategory['is_active'] = (bool)$dishCategory->is_active;

                }

                return ResponseWithSuccessData($lang, $dishCategories, 1);
            }

            // Scenario 3: If offers = 1, fetch active offers with details
            if ($offers == 1) {
                $activeOffers = Offer::with('details')
                    ->whereHas('details')
                    ->where('branch_id', $branchId)
                    ->orWhere('branch_id', -1)
                    ->where('is_active', 1)
                    ->get()
                    ->map(function ($offer) {
                        // Assuming you want to add the translated name for each detail
                        $offer->details->each(function ($detail) {
                            if (request()->header('lang', 'ar') === 'en') {
                                $detail->type_name = $detail->getTypeName('en'); // Add English name
                            } else {
                                $detail->type_name = $detail->getTypeName('ar'); // Add Arabic name
                            }
                        });
                        return $offer;
                    }) ?? collect();

                $activeOffers = OfferResource::collection($activeOffers);
                $activeOffers = $activeOffers->filter(function ($offer) {
                    return $offer->details->isNotEmpty();
                });
            
                return ResponseWithSuccessData($lang, OfferResource::collection($activeOffers), 1);
            }
            
            
            
        }


        // Default fallback
        return RespondWithBadRequestData($lang, 2, 'Invalid scenario.');
    }

    public function menuDishesDetails(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        $dishId = $request->dishId;
        $branchId = $request->branchId;

        $validateData = Validator::make($request->all(), [
            'dishId' => 'required|exists:branch_menus,dish_id',
            'branchId' => 'required|integer|exists:branches,id'
        ]);

        if ($validateData->fails()) {
            return RespondWithBadRequestWithData($validateData->errors());
        }

        $menuDetails = BranchMenu::Active()->where('dish_id', $request->dishId)->where('branch_id', $request->branchId)->first();

        if(!$menuDetails){
            return RespondWithBadRequestWithData($validateData->errors());
        }

        $BranchMenuSize = BranchMenuSize::where('dish_id', $request->dishId)
            ->where('branch_id', $request->branchId)
            ->get();

        $BranchMenuAddonCategory = BranchMenuAddonCategory::where('branch_id', $request->branchId)
            ->with('branchMenuAddons', function ($query) use ($dishId, $branchId) {
                return $query->where('branch_id', $branchId)->where('dish_id', $dishId);
            })
            ->get();

        $BranchMenuAddon = BranchMenuAddon::where('dish_id', $request->id)
            ->where('branch_id', $branchId)
            ->get();

        $dish = [
            'dish' => [
                'id' => $menuDetails->dish_id,
                'name' => $menuDetails->dish->name_ar,
                'description' => $menuDetails->dish->description,
                'price' => $menuDetails->dish->has_sizes ? ($menuDetails->dish->sizeDefaults ? $menuDetails->dish->sizeDefaults->price : 0) : $menuDetails->price,
                'has_size' => $menuDetails->dish->has_sizes,
                'image' => $menuDetails->dish->image ?? null,
                'mostOrdered' => checkDishExistMostOrderd($request->branchId, $menuDetails->dish_id)
            ],
            'sizes' => $BranchMenuSize->map(function ($size) {
                return [
                    'id' => $size->id,
                    'name' => $size->dishSizes->name_site,
                    'price' => $size->price,
                    'default_size' => $size->dishSizes->default_size
                ];
            }),
            'addon_categories' => $BranchMenuAddonCategory->map(function ($addon_category) {
                return [

                    'id' => $addon_category->id,
                    'name' => $addon_category->addonCategories->name_site,
                    'min_addons' => $addon_category->min_addons,
                    'max_addons' => $addon_category->max_addons,
                    'addons' => $addon_category->branchMenuAddons->map(function ($addon) {
                        return [
                            'id' => $addon->id,
                            'name' => $addon->dishAddons->addons->name_site,
                            'price' => $addon->price,
                            // 'min' => $addon->dishAddons->addons->min_addons,
                            // 'max' =>  $addon->dishAddons->addons->max_addons,
                        ];
                    })
                ];
            })
        ];

        if (!$dish) {
            return RespondWithBadRequestData($lang, 2);
        }
        return ResponseWithSuccessData($lang, $dish, 1);
    }
}
