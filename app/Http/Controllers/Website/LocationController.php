<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\ClientAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function showAddress()
    {
        $address = ClientAddress::where('user_id',Auth::guard('client')->user()->id)->get();
     return view('website.auth.address',compact('address'));
    }
    public function saveAddress(Request $request)
    {
        if ($request->nameapart) {
            // Validation for the apartment
            $validator = Validator::make($request->all(), [
                'nameapart' => 'required|string|max:255',
                'numapart' => 'required|string|max:100',
                'floor' => 'required|string|max:100',
                'addressdetailapart' => 'nullable|string',
                'markapart' => 'nullable|string',
                'phoneapart' => 'required|string|phone',
                'country_code_apart' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Handle apartment-specific logic
        } elseif ($request->namevilla) {
            // Validation for the villa
            $validator = Validator::make($request->all(), [
                'namevilla' => 'required|string|max:255',
                'villanumber' => 'required|string|max:100',
                'addressdetailvilla' => 'nullable|string',
                'markvilla' => 'nullable|string',
                'phonevilla' => 'required|string|phone',
                'country_code_villa' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Handle villa-specific logic
        } else {
            // General validation if neither apartment nor villa is provided
            $validator = Validator::make($request->all(), [
                'nameoffice' => 'required|string|max:255',
                'numaoffice' => 'required|string|max:100',
                'addressdetailoffice' => 'nullable|string',
                'markoffice' => 'nullable|string',
                'phoneoffice' => 'required|string|phone',
                'country_code_office' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Handle office-specific logic
        }
    }

}
