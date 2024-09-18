<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProductUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided

        $productUnits = ProductUnit::all();
        foreach ($productUnits as $productUnit) {
            $productUnit['unit'] = Unit::find($productUnit->unit_id);
            $productUnit['product'] = Product::find($productUnit->product_id);
        }
        $productUnits->transform(function ($productUnit) {
            $productUnit->makeHidden(['product_id', 'unit_id']);
            return $productUnit;
        });
    
        // removeColumns($productUnits, ['product_id', 'unit_id']);
        return ResponseWithSuccessData($lang, $productUnits,  1);
    }
}
