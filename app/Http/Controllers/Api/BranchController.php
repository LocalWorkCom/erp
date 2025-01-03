<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $withTrashed = $request->query('withTrashed', false);

            $branches = $withTrashed
                ? Branch::withTrashed()->with(['country', 'creator', 'deleter'])->get()
                : Branch::with(['country', 'creator', 'deleter'])->get();

            return ResponseWithSuccessData($lang, $branches, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching branches: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        // Validation
        $validator = Validator::make($request->all(), [
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'required|string|max:255',
            'address_en' => 'nullable|string',
            'address_ar' => 'nullable|string',
            'latitute' => 'nullable|string',
            'longitute' => 'nullable|string',
            'country_id' => 'required|integer|exists:countries,id',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:255',
            'manager_name' => 'nullable|string|max:255',
            'opening_hour' => 'nullable|date_format:H:i',
            'closing_hour' => 'nullable|date_format:H:i',
            'has_kids_area' => 'required|boolean',
            'is_delivery' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        try {
            $branch = Branch::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'address_en' => $request->address_en,
                'address_ar' => $request->address_ar,
                'latitute' => $request->latitute,
                'longitute' => $request->longitute,
                'country_id' => $request->country_id,
                'phone' => $request->phone,
                'email' => $request->email,
                'manager_name' => $request->manager_name,
                'opening_hour' => $request->opening_hour,
                'closing_hour' => $request->closing_hour,
                'has_kids_area' => $request->has_kids_area,
                'is_delivery' => $request->is_delivery,
                'created_by' => auth()->id(),
            ]);

            return ResponseWithSuccessData($lang, $branch, 1);
        } catch (\Exception $e) {
            Log::error('Error creating branch: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $branch = Branch::with(['country', 'creator', 'deleter'])->findOrFail($id);
            return ResponseWithSuccessData($lang, $branch, 1);
        } catch (\Exception $e) {
            Log::error('Error fetching branch: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lang = $request->header('lang', 'ar');
        App::setLocale($lang);

        // Validation
        $validator = Validator::make($request->all(), [
            'name_en' => 'nullable|string|max:255',
            'name_ar' => 'required|string|max:255',
            'address_en' => 'nullable|string',
            'address_ar' => 'nullable|string',
            'latitute' => 'nullable|string',
            'longitute' => 'nullable|string',
            'country_id' => 'required|integer|exists:countries,id',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:255',
            'manager_name' => 'nullable|string|max:255',
            'opening_hour' => 'nullable|date_format:H:i',
            'closing_hour' => 'nullable|date_format:H:i',
            'has_kids_area' => 'required|boolean',
            'is_delivery' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        try {
            $branch = Branch::findOrFail($id);

            $branch->update([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
                'address_en' => $request->address_en,
                'address_ar' => $request->address_ar,
                'latitute' => $request->latitute,
                'longitute' => $request->longitute,
                'country_id' => $request->country_id,
                'phone' => $request->phone,
                'email' => $request->email,
                'manager_name' => $request->manager_name,
                'opening_hour' => $request->opening_hour,
                'closing_hour' => $request->closing_hour,
                'has_kids_area' => $request->has_kids_area,
                'is_delivery' => $request->is_delivery,
                'modified_by' => auth()->id(),
            ]);

            return ResponseWithSuccessData($lang, $branch, 1);
        } catch (\Exception $e) {
            Log::error('Error updating branch: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Soft delete the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $branch = Branch::findOrFail($id);
            $branch->update(['deleted_by' => auth()->id()]);
            $branch->delete();
            return ResponseWithSuccessData($lang, null, 1);
        } catch (\Exception $e) {
            Log::error('Error deleting branch: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    /**
     * Restore a soft-deleted branch.
     */
    public function restore(Request $request, $id)
    {
        try {
            $lang = $request->header('lang', 'ar');
            $branch = Branch::withTrashed()->findOrFail($id);
            $branch->restore();
            return ResponseWithSuccessData($lang, $branch, 1);
        } catch (\Exception $e) {
            Log::error('Error restoring branch: ' . $e->getMessage());
            return RespondWithBadRequestData($lang, 2);
        }
    }

    public function listBranchAndNear(Request $request)
    {
        $lang = $request->header('lang', 'ar');
        $request->validate([
            'latitute' => [ 'numeric', 'regex:/^-?\d+(\.\d+)?$/'],
            'longitute' => ['numeric', 'regex:/^-?\d+(\.\d+)?$/'],
        ], [
            'latitute.required' => __('validation.latitute.required'),
            'latitute.numeric' => __('validation.latitute.numeric'),
            'latitute.regex' => __('validation.latitute.regex'),
            'longitute.required' => __('validation.longitute.required'),
            'longitute.numeric' => __('validation.longitute.numeric'),
            'longitute.regex' => __('validation.longitute.regex'),
        ]);
        // Retrieve validated data
        $userLat = $request->query('latitute');
        $userLon = $request->query('longitute');
        $all = $request->query('all', 1);
        $searchName = $request->query('name'); // Capture the search query for branch name

        // Determine the correct column for branch name based on language
        $nameColumn = ($lang === 'ar') ? 'name_ar' : 'name_en';

        // Fetch all branches if 'all' parameter is set to 1
        $branchesQuery = Branch::whereNull('deleted_at');

        if ($searchName) {
            $branchesQuery->where($nameColumn, 'like', "%{$searchName}%");
        }

        $get_all_branches = $branchesQuery->get()->map(function ($branch) {
            // Convert is_delivery and is_default to boolean
            $branch->is_delivery = (bool) $branch->is_delivery;
            $branch->is_default = (bool) $branch->is_default;
            //$branch->is_open = (bool) $branch->is_open;
            return $branch;
        });

        $get_all_branches->makeHidden(['name_site', 'address_site']);

        $branches = ($all == 1) ? $get_all_branches : null;

        $data = [];

        if ($userLat && $userLon) {
            $nearestBranch = getNearestBranch($userLat, $userLon);

            if ($nearestBranch) {
                $nearestBranch->is_delivery = (bool) $nearestBranch->is_delivery;
                $nearestBranch->is_default = (bool) $nearestBranch->is_default;
                //$nearestBranch->is_open = (bool) $nearestBranch->is_open;
                $data['branch'] = $nearestBranch;
            } else {
                $defaultBranchId = getDefaultBranch();
                $data['branch'] = Branch::find($defaultBranchId);
                $defaultBranchId->is_delivery = (bool) $defaultBranchId->is_delivery;
                $defaultBranchId->is_default = (bool) $defaultBranchId->is_default;
                //$defaultBranchId->is_open = (bool) $defaultBranchId->is_open;

            }
            $data['branch']->makeHidden(['name_site', 'address_site']);
        } else {
            $defaultBranchId = getDefaultBranch();
            $defaultBranch = Branch::find($defaultBranchId);
            if ($defaultBranch) {
                $defaultBranch->is_delivery = (bool) $defaultBranch->is_delivery;
                $defaultBranch->is_default = (bool) $defaultBranch->is_default;
                //$defaultBranch->is_open = (bool) $defaultBranch->is_open;

                // Hide unnecessary attributes
                $defaultBranch->makeHidden(['name_site', 'address_site']);
                $data['branch'] = $defaultBranch;
            }
        }

        // Include all branches if fetched
        $data['branches'] = $branches;

        return ResponseWithSuccessData($lang, $data, 1);
    }
}
