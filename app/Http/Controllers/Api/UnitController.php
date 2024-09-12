<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // YourController.php

    public function index(Request $request)
    {
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided

        $units = Unit::all();

        // Define columns that need translation
        $translateColumns = ['name']; // Add other columns as needed

        // Define columns to remove (translated columns)
        $columnsToRemove = array_map(function($col) {
            return [$col . '_ar', $col . '_en'];
        }, $translateColumns);
        $columnsToRemove = array_merge(...$columnsToRemove);

        // Map categories to include translated columns and remove unnecessary columns
        $units = $units->map(function ($category) use ($lang, $translateColumns, $columnsToRemove) {
            // Convert category model to an array
            $data = $category->toArray();

            // Get translated data
            $data = translateDataColumns($data, $lang, $translateColumns);

            // Remove translated columns from data
            $data = removeColumns($data, $columnsToRemove);

            return $data;
        });

        return ResponseWithSuccessData($lang, $units, code: 1);
    }
}
