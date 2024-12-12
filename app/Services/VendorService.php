<?php


namespace App\Services;

use App\Models\Position;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VendorService
{
    private $lang;
    public function __construct()
    {
        $this->lang = app()->getLocale();
        app()->setLocale($this->lang);
    }

    public function getAllVendors($checkToken)
    {

        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        return Vendor::all();
    }

    public function getVendor($id)
    {
        return Vendor::findOrFail($id);
    }

    public function createVendor($data, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $vendor = new Vendor();
        $vendor->name_ar = $data['name_ar'];
        $vendor->name_en = $data['name_en'];
        $vendor->description_ar = $data['description_ar'];
        $vendor->description_en = $data['description_en'];
        $vendor->department_id = $data['department_id'];
        $vendor->created_by = Auth::user()->id;
        $vendor->created_at = now();
        $vendor->save();
    }

    public function updateVendor($data, $id, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        $vendor = Vendor::findOrFail($id);
        $vendor->name_ar = $data['name_ar'];
        $vendor->name_en = $data['name_en'];
        $vendor->description_ar = $data['description_ar'];
        $vendor->description_en = $data['description_en'];
        $vendor->department_id = $data['department_id'];
        $vendor->modified_by = Auth::user()->id;
        $vendor->updated_at = now();
        $vendor->save();
    }

    public function deleteVendor($id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        $vendor = Vendor::find($id);
        $vendor->deleted_by = Auth::user()->id;
        $vendor->save();
        $vendor->delete();
    }
}
