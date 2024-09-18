<?php

namespace App\Http\Controllers\Api;

use App\Models\Unit;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

        return ResponseWithSuccessData($lang, $units, 1);
    }
    public function store(Request $request)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale($lang);
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'string',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided

        $name_ar = $request->name_ar;
        $name_en = $request->name_en;
        
        $created_by = Auth::user()->id;

        $unit = new Unit();
        $unit->name_ar = $name_ar;
        $unit->name_en =  $name_en;
        $unit->created_by =  $created_by;
        $unit->save();
       
        return RespondWithSuccessRequest($lang, 1);
    }
    public function update(Request $request, $id)
    {
        $lang = $request->header('lang', 'en');
        App::setLocale($lang);
        // Validate the input
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string',
            'name_en' => 'string',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Retrieve the unit by ID, or throw an exception if not found
        $unit = Unit::findOrFail($id);

        // Assign the updated values to the unit model
        $unit->name_ar = $request->name_ar;
        $unit->name_en = $request->name_en;

        // Update the unit in the database
        $unit->save();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
    public function delete(Request $request, $id)
    {
        // Fetch the language header for response
        $lang = $request->header('lang', 'en');  // Default to 'en' if not provided

        // Find the unit by ID, or throw a 404 if not found
        $unit = Unit::findOrFail($id);

        // Delete the unit
        $unit->delete();

        // Return success response
        return RespondWithSuccessRequest($lang, 1);
    }
}
