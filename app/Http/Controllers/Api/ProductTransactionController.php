<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\ProductTransaction;
use Illuminate\Http\Request;

class ProductTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request)
    {
        try{
            $lang =  $request->header('lang', 'en');
            $products = ProductTransaction::all();
            return ResponseWithSuccessData($lang, $products, 1);
        }catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }
}
