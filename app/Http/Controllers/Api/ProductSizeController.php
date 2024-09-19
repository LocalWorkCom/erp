<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Size;
use Illuminate\Http\Request;

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
}
