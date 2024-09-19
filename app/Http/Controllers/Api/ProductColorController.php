<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Fetch all ProductColor records with their associated products
        $products = ProductColor::with('product')->get();

        // Format each ProductColor and its associated product into an array
        $response = $products->map(function ($productColor) {
            return [
                'color' => $productColor->toArray(), // Full details of the color
                'product' => $productColor->product ? $productColor->product->toArray() : null, // Full details of the associated product, if exists
            ];
        });

        // Return the response with the detailed data
        return ResponseWithSuccessData( $lang ,$response, code: 1);
    }
}

