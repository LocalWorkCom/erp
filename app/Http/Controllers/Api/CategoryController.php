<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request)
    {
        $lang =  $request->header('lang', 'en');
        $categoris = Category::all();
        return ResponseWithSuccessData($lang, $categoris, 1);
    }
}
