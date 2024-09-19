<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        $lang = $request->header('lang', 'en');  // Set locale from header

        // Check for token validity
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'color_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Retrieve data from the request
        $product_id = $request->product_id;
        $color_id = $request->color_id;
        $factor = $request->factor;

        // Get the ID of the authenticated user
        $created_by = Auth::guard('api')->user()->id;

        // Create and save the ProductUnit
        $productUnit = new ProductColor();
        $productUnit->product_id = $product_id;
        $productUnit->color_id = $color_id;
        $productUnit->created_by = $created_by;
        $productUnit->save();

        // Return a successful response
        return RespondWithSuccessRequest($lang, 1);
    }

    public function update(Request $request, $id)
    {
        $lang = $request->header('lang', 'en');
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Validate the input
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'color_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Retrieve the unit by ID, or throw an exception if not found
        $productUnit = ProductColor::findOrFail($id);
        $factor = $request->factor;

        $modify_by = Auth::guard('api')->user()->id;
        // Assign the updated values to the unit model
        $productUnit->product_id = $request->product_id;
        $productUnit->color_id = $request->color_id;
        $productUnit->modify_by = $modify_by;
        // Update the unit in the database
        $productUnit->save();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
    public function delete(Request $request, $id)
    {
        // Fetch the language header for response
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Find the unit by ID, or throw a 404 if not found
        $productUnit = ProductColor::findOrFail($id);

        // Delete the unit
        $productUnit->delete();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}

