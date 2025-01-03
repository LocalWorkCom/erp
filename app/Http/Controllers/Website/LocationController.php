<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\ClientAddress;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function showAddress()
    {        $lang = app()->getLocale();


        $address = ClientAddress::where('user_id', Auth::guard('client')->user()->id)->where('is_active',1)
            ->withCount([
                'orders as has_inprogress_or_pending_orders' => function ($query) {
                    $query->whereIn('status', ['inprogress', 'pending']);
                }
            ])
            ->get();

        return view('website.auth.address', compact('address'));
    }

    public function createAddress($id = null)
    {
        $lang = app()->getLocale();

        // If an address ID is passed, fetch the address for editing, otherwise create a new address
        $address = $id ? ClientAddress::find($id) : null;

        return view('website.auth.create-address', compact('address'));
    }

    public function createOrUpdateAddress(Request $request)
    {
        $lang = app()->getLocale();

        // Fetch existing address or create a new one if no ID is provided
        $address = $request->id ? ClientAddress::findOrFail($request->id) : new ClientAddress();

        // Initialize validation rules and messages
        $rules = $messages = [];

        // Set validation rules based on the selected delivery place
        switch ($request->deliveryPlace) {
            case 'apartment':
                $rules = [
                    'nameapart' => 'required|string|max:255',
                    'numapart' => 'required',
                    'floorapart' => 'required',
                    'phoneapart' => 'required',
                    'country_code_apart' => 'required',
                    'addressdetailapart' => 'required',
                    'markapart' => 'nullable',
                ];
                $messages = [
                    'nameapart.required' => __('validation.required', ['attribute' => __('auth.nameapart')]),
                    'numapart.required' => __('validation.required', ['attribute' => __('auth.numapart')]),
                    'floorapart.required' => __('validation.required', ['attribute' => __('auth.floorapart')]),
                    'phoneapart.required' => __('validation.required', ['attribute' => __('auth.phoneapart')]),
                    'country_code_apart.required' => __('validation.required', ['attribute' => __('auth.country_code_apart')]),
                    'addressdetailapart.required' => __('validation.required', ['attribute' => __('auth.addressdetailapart')]),
                ];
                break;

            case 'villa':
                $rules = [
                    'namevilla' => 'required|string|max:255',
                    'villanumber' => 'required',
                    'addressdetailvilla' => 'required',
                    'phonevilla' => 'required',
                    'country_code_villa' => 'required',
                    'markvilla' => 'nullable',
                ];
                $messages = [
                    'namevilla.required' => __('validation.required', ['attribute' => __('validation.namevilla')]),
                    'villanumber.required' => __('validation.required', ['attribute' => __('validation.villanumber')]),
                    'addressdetailvilla.required' => __('validation.required', ['attribute' => __('validation.addressdetailvilla')]),
                    'phonevilla.required' => __('validation.required', ['attribute' => __('validation.phonevilla')]),
                    'country_code_villa.required' => __('validation.required', ['attribute' => __('validation.country_code_villa')]),

                ];
                break;

            case 'office':
                $rules = [
                    'nameoffice' => 'required|string|max:255',
                    'numaoffice' => 'required',
                    'addressdetailoffice' => 'required',
                    'phoneoffice' => 'required',
                    'country_code_office' => 'required',
                    'flooroffice' => 'required',
                    'markoffice' => 'nullable',
                ];
                $messages = [
                    'nameoffice.required' => __('validation.required', ['attribute' => __('auth.nameoffice')]),
                    'numaoffice.required' => __('validation.required', ['attribute' => __('validation.numaoffice')]),
                    'addressdetailoffice.required' => __('validation.required', ['attribute' => __('validation.addressdetailoffice')]),
                    'phoneoffice.required' => __('validation.required', ['attribute' => __('validation.phoneoffice')]),
                    'country_code_office.required' => __('validation.required', ['attribute' => __('validation.country_code_office')]),
                    'flooroffice.required' => __('validation.required', ['attribute' => __('validation.floor')]),
                ];
                break;
        }

        // Validate the request with the dynamic rules and messages
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Set common fields
        $address->user_id = Auth::guard('client')->user()->id;
        $address->state = $request->input('state', 'state');
        // $address->country = $request->input('country', 'country');
        $address->latitude = $request->input('latitude', 30.0308979);
        $address->longtitude = $request->input('longitude', 31.2053958);
        $address->city = $request->input('city', 'city');

        // Map address fields based on deliveryPlace type (apartment, villa, office)
        $this->mapAddressFields($address, $request);

        // Save the address
        $address->save();

        // Redirect with a success message
        return redirect()->route('showAddress')->with(['showModal' => true]);
    }

    // Map fields based on delivery type (apartment, villa, office)
    private function mapAddressFields(ClientAddress $address, Request $request)
    {
        switch ($request->deliveryPlace) {
            case 'apartment':
                $address->address_type = 'apartment';
                $address->building = $request->input('nameapart');
                $address->floor_number = $request->input('floorapart');
                $address->apartment_number = $request->input('numapart');
                $address->country_code = $request->input('country_code_apart');
                $address->address_phone = $request->input('phoneapart');
                $address->address = $request->input('addressdetailapart');
                $address->notes = $request->input('markapart');

                break;

            case 'villa':
                $address->address_type = 'villa';
                $address->building = $request->input('namevilla');
                $address->apartment_number = $request->input('villanumber');
                $address->country_code = $request->input('country_code_villa');
                $address->address_phone = $request->input('phonevilla');
                $address->address = $request->input('addressdetailvilla');
                $address->notes = $request->input('markvilla');
                break;

            case 'office':
                $address->address_type = 'office';
                $address->building = $request->input('nameoffice');
                $address->floor_number = $request->input('flooroffice');
                $address->apartment_number = $request->input('numaoffice');
                $address->country_code = $request->input('country_code_office');
                $address->address_phone = $request->input('phoneoffice');
                $address->address = $request->input('addressdetailoffice');
                $address->notes = $request->input('markoffice');
                break;
        }
    }

    public function destroyAddress($id)
    {
        $check = Order::where('client_address_id', $id)
            ->where(function ($query) {
                $query->where('status', 'inprogress')
                    ->orWhere('status', 'pending');
            })
            ->exists();
        if (!$check) {
            $address = ClientAddress::findOrFail($id);
            $address->delete();
            return redirect()->route('showAddress')->with('success', __('Address deleted successfully.'));

        } else {
            return redirect()->route('showAddress')->with('error', __('Address cannot deleted.'));
        }
    }
    public function getNearestBranchl(Request $request)
    {

        $userLat = $request->input('latitude');
        $userLon = $request->input('longitude');

        $nearestBranch =getNearestBranch($userLat, $userLon);
        return response()->json([
            'branch' => $nearestBranch
        ]);
    }



}
