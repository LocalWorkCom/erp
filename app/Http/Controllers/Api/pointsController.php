<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pointSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class pointsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //point_systems -- show all point system
        try {
            $lang = $request->header('lang', 'ar');  // Default to 'en' if not provided
            if (!CheckToken()) {
                return RespondWithBadRequest($lang, 5);
            }
            $pointSystem = pointSystem::all();

            // Define columns that need translation
            $translateColumns = ['name']; // Add other columns as needed

            // Define columns to remove (translated columns)
            $columnsToRemove = array_map(function ($col) {
                return [$col . '_ar', $col . '_en'];
            }, $translateColumns);
            $columnsToRemove = array_merge(...$columnsToRemove);

            // Map categories to include translated columns and remove unnecessary columns
            $point = $pointSystem->map(function ($points) use ($lang, $translateColumns, $columnsToRemove) {
                // Convert category model to an array
                $data = $points->toArray();

                // Get translated data
                $data = translateDataColumns($data, $lang, $translateColumns);

                // Remove translated columns from data
                $data = removeColumns($data, $columnsToRemove);

                return $data;
            });

            return ResponseWithSuccessData($lang, $point, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //point_systems--add new system
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale($lang);

            $validator = Validator::make($request->all(), [
                "type_en" => "required",
                "type_ar" => "required",
                "num" => "required",
                "value" => "required",
                "expire_type" => "required",
                "time" => "required",
                "active" => "required",
            ]);

            if ($validator->fails()) {
                return RespondWithBadRequestWithData($validator->errors());
            }

            $new = new pointSystem();
            $new->type_en  = $request->type_en;
            $new->type_ar  = $request->type_ar;
            $new->num  = $request->num;
            $new->value = $request->value;
            $new->expire_type = $request->expire_type;
            $new->time = $request->time;
            $new->active = $request->active;
            $new->created_by = auth()->id();
            $new->save();

            return ResponseWithSuccessData($lang, $new, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        try {
            // Get language header, defaulting to 'ar' if not provided
            $lang = $request->header('lang', 'ar');

            // Check token validity
            if (!CheckToken()) {
                return RespondWithBadRequest($lang, 5);
            }

            // Find the point system by the provided ID
            $pointSystem = pointSystem::find($id); // Use $id from method parameter

            // Check if the point system exists
            if (!$pointSystem) {
                return RespondWithBadRequestData($lang, 4); // Customize error message for not found
            }

            // Define columns that need translation
            $translateColumns = ['name']; // Add other columns as needed

            // Define columns to remove (translated columns)
            $columnsToRemove = array_map(function ($col) {
                return [$col . '_ar', $col . '_en'];
            }, $translateColumns);
            $columnsToRemove = array_merge(...$columnsToRemove);

            // Convert model to an array
            $data = $pointSystem->toArray();

            // Get translated data
            $data = translateDataColumns($data, $lang, $translateColumns);

            // Remove unnecessary columns
            $data = removeColumns($data, $columnsToRemove);

            return ResponseWithSuccessData($lang, $data, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2); // Customize error message for exceptions
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //point_systems -- show all point system
        try {
            // Get language header, defaulting to 'ar' if not provided
            $lang = $request->header('lang', 'ar');

            // Check token validity
            if (!CheckToken()) {
                return RespondWithBadRequest($lang, 5);
            }

            // Find the point system by the provided ID
            $pointSystem = pointSystem::find($id); // Use $id from method parameter

            // Check if the point system exists
            if (!$pointSystem) {
                return RespondWithBadRequestData($lang, 4); // Customize error message for not found
            }

            // Define columns that need translation
            $translateColumns = ['name']; // Add other columns as needed

            // Define columns to remove (translated columns)
            $columnsToRemove = array_map(function ($col) {
                return [$col . '_ar', $col . '_en'];
            }, $translateColumns);
            $columnsToRemove = array_merge(...$columnsToRemove);

            // Convert model to an array
            $data = $pointSystem->toArray();

            // Get translated data
            $data = translateDataColumns($data, $lang, $translateColumns);

            // Remove unnecessary columns
            $data = removeColumns($data, $columnsToRemove);

            return ResponseWithSuccessData($lang, $data, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang, 2); // Customize error message for exceptions
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //point_systems
        try {
            $lang = $request->header('lang', 'ar');
            App::setLocale($lang);

            $validator = Validator::make($request->all(), [

                "key" => "required",
                'active' => 'required',
                'value' => 'required',

            ]);

            if ($validator->fails()) {
                return RespondWithBadRequestWithData($validator->errors());
            }
            if($request->active == 1){
                $is_active = pointSystem::where('active' , 1)->where('id', '!=', $id)->exists();
                if($is_active){
                    return RespondWithBadRequestData($lang, 24);
                }
            }else{
                $is_active = pointSystem::where('active' , 1)->where('id', '!=', $id)->exists();

                if(!($is_active)){
                    return RespondWithBadRequestData($lang, code: 25);
                }
            }
            $new = pointSystem::findOrFail($id);
            $new->name_ar  = $request->name_ar;
            $new->name_en  = $request->name_en;
            $new->key  = $request->key;
            $new->value = $request->value;
            $new->active = $request->active;

            $new->modified_by = auth()->id();
            $new->save();
            $translateColumns = ['name']; // Add other columns as needed

            // Define columns to remove (translated columns)
            $columnsToRemove = array_map(function ($col) {
                return [$col . '_ar', $col . '_en'];
            }, $translateColumns);
            $columnsToRemove = array_merge(...$columnsToRemove);

            // Convert model to an array
            $data = $new->toArray();

            // Get translated data
            $data = translateDataColumns($data, $lang, $translateColumns);

            // Remove unnecessary columns
            $data = removeColumns($data, $columnsToRemove);

            return ResponseWithSuccessData($lang, $data, 1);
        } catch (\Exception $e) {
            return RespondWithBadRequestData($lang,  2);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
