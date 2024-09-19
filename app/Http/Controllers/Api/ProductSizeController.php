<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request)
    {
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        $productSizes = ProductSize::all();

        foreach ($productSizes as $productSize) {
            $productSize['size'] = Size::find($productSize->size_id);
            $productSize['product'] = Product::find($productSize->product_id);
        }
        $productSizes->transform(function ($productSize) {
            $productSize->makeHidden(['product_id', 'size_id']);
            return $productSize;
        });

        return ResponseWithSuccessData($lang, $productSizes,  1);
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
            'size_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Retrieve data from the request
        $product_id = $request->product_id;
        $size_id = $request->size_id;
        $factor = $request->factor;

        // Get the ID of the authenticated user
        $created_by = Auth::guard('api')->user()->id;

        // Create and save the ProductUnit
        $productUnit = new ProductSize();
        $productUnit->product_id = $product_id;
        $productUnit->size_id = $size_id;
        $productUnit->factor = $factor;
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
            'size_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Retrieve the unit by ID, or throw an exception if not found
        $productUnit = ProductSize::findOrFail($id);
        $factor = $request->factor;

        $modify_by = Auth::guard('api')->user()->id;
        // Assign the updated values to the unit model
        $productUnit->product_id = $request->product_id;
        $productUnit->size_id = $request->size_id;
        $productUnit->factor = $factor;
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
        $productUnit = ProductSize::findOrFail($id);

        // Delete the unit
        $productUnit->delete();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
