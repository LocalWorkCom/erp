<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        $productUnits = ProductUnit::all();

        $translateColumns = ['name']; // Add other columns as needed

        // Define columns to remove (translated columns)
        $columnsToRemove = array_merge(...array_map(function ($col) {
            return [$col . '_ar', $col . '_en'];
        }, $translateColumns));

        $productUnits = $productUnits->map(function ($category) use ($lang, $translateColumns, $columnsToRemove) {
            // Convert category model to an array
            $data = $category->toArray();

            // Check and modify image path if it exists
            if (isset($data['image']) && !empty($data['image'])) {
                $data['image'] = BaseUrl() . '/' . $data['image'];
            }

            // Get related unit and translate its columns
            $unit = Unit::find($data['unit_id']);
            if ($unit) {
                // Convert unit to an array
                $unitArray = $unit->toArray();
                // Translate data columns
                $unitArray = translateDataColumns($unitArray, $lang, $translateColumns);
                // Remove translated columns
                $unitArray = removeColumns($unitArray, $columnsToRemove);
                $data['unit'] = $unitArray;
            }

            // Get related product
            $product = Product::find($data['product_id']);
            $translateColumns = ['name', 'description']; // Add other columns as needed

            // Define columns to remove (translated columns)
            $columnsToRemove = array_merge(...array_map(function ($col) {
                return [$col . '_ar', $col . '_en'];
            }, $translateColumns));
            if ($product) {
                if (isset($product['main_image']) && !empty($product['main_image'])) {
                    $product['main_image'] = BaseUrl() . '/' . $product['main_image'];
                }

                // Convert unit to an array
                $productArray = $product->toArray();

                // Translate data columns
                $productArray = translateDataColumns($productArray, $lang, $translateColumns);

                // Remove translated columns
                $productArray = removeColumns($productArray, $columnsToRemove);
                $category = Category::find($product['category_id']);
                if ($category) {
                    if (isset($category['image']) && !empty($category['image'])) {
                        $category['image'] = BaseUrl() . '/' . $category['image'];
                    }
                    // Convert unit to an array
                    $categoryArray = $category->toArray();

                    // Translate data columns
                    $categoryArray = translateDataColumns($categoryArray, $lang, $translateColumns);

                    // Remove translated columns
                    $categoryArray = removeColumns($categoryArray, $columnsToRemove);

                    $productArray['category'] = $categoryArray;
                }
                $data['product'] = $productArray;
            }

            // Remove 'product_id' and 'unit_id' from the data array
            unset($data['product_id'], $data['unit_id']);

            return $data;
        });



        // removeColumns($productUnits, ['product_id', 'unit_id']);
        return ResponseWithSuccessData($lang, $productUnits,  1);
    }

    public function store(Request $request)
    {
        $lang = $request->header('lang', 'en');  // Set locale from header
        App::setLocale($lang);


        // Check for token validity
        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'factor' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Retrieve data from the request
        $product_id = $request->product_id;
        $unit_id = $request->unit_id;
        $factor = $request->factor;
        $unit = Unit::find($unit_id);
        if (!$unit) {
            return  RespondWithBadRequestData($lang, 8);
        }
        $product = Product::find($product_id);
        if (!$product) {
            return  RespondWithBadRequestData($lang, 8);
        }
        // Get the ID of the authenticated user
        $created_by = Auth::guard('api')->user()->id;

        // Create and save the ProductUnit
        $productUnit = new ProductUnit();
        $productUnit->product_id = $product_id;
        $productUnit->unit_id = $unit_id;
        $productUnit->factor = $factor;
        $productUnit->created_by = $created_by;
        $productUnit->save();

        // Return a successful response
        return RespondWithSuccessRequest($lang, 1);
    }

    public function update(Request $request, $id)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Validate the input
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'factor' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }
        $product_id = $request->product_id;
        $unit_id = $request->unit_id;
        $unit = Unit::find($unit_id);
        if (!$unit) {
            return  RespondWithBadRequestData($lang, 8);
        }
        $product = Product::find($product_id);
        if (!$product) {
            return  RespondWithBadRequestData($lang, 8);
        }
        if (CheckExistColumnValue('product_units', 'product_id', $request->product_id) && CheckExistColumnValue('product_units', 'unit_id', $request->unit_id)) {
            return RespondWithBadRequest($lang, 9);
        }
        // Retrieve the unit by ID, or throw an exception if not found
        $productUnit = ProductUnit::find($id);
        if (
            $productUnit->product_id == $request->product_id && $productUnit->unit_id == $request->unit_id && $productUnit->factor == $request->factor
        ) {
            return  RespondWithBadRequestData($lang,10);
        }
        $factor = $request->factor;

        $modify_by = Auth::guard('api')->user()->id;
        // Assign the updated values to the unit model
        $productUnit->product_id = $request->product_id;
        $productUnit->unit_id = $request->unit_id;
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
        App::setLocale($lang);

        if (!CheckToken()) {
            return RespondWithBadRequest($lang, 5);
        }
        // Find the unit by ID, or throw a 404 if not found
        $productUnit = ProductUnit::find($id);
        if (!$productUnit) {
            return  RespondWithBadRequestData($lang, 8);
        }

        // Delete the unit
        $productUnit->delete();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
