<?php


namespace App\Services;

use App\Models\Position;
use App\Models\PurchaseInvoice;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PurchaseService
{
    private $lang;
    public function __construct()
    {
        $this->lang = app()->getLocale();
        app()->setLocale($this->lang);
    }

    public function getAllPurchases($checkToken)
    {

        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        return PurchaseInvoice::with('country')->get();
    }

    public function getPurchase($id)
    {
        return PurchaseInvoice::findOrFail($id);
    }

    public function createPurchase($data, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $purchase = new PurchaseInvoice();
        $purchase->name_ar = $data['name_ar'];
        $purchase->name_en = $data['name_en'];
        $purchase->contact_person = $data['contact_person'];
        $purchase->phone = $data['phone'];
        $purchase->email = $data['email'];
        $purchase->address_ar = $data['address_ar'];
        $purchase->address_en = $data['address_en'];
        $purchase->country_id = $data['country_id'];
        $purchase->created_by = Auth::user()->id;
        $purchase->created_at = now();
        $purchase->save();
    }

    public function updatePurchase($data, $id, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        $purchase = PurchaseInvoice::findOrFail($id);
        $purchase->name_ar = $data['name_ar'];
        $purchase->name_en = $data['name_en'];
        $purchase->contact_person = $data['contact_person'];
        $purchase->phone = $data['phone'];
        $purchase->email = $data['email'];
        $purchase->address_ar = $data['address_ar'];
        $purchase->address_en = $data['address_en'];
        $purchase->country_id = $data['country_id'];
        $purchase->modified_by = Auth::user()->id;
        $purchase->updated_at = now();
        $purchase->save();
    }

    public function deletePurchase($id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        $purchase = PurchaseInvoice::find($id);
        $purchase->deleted_by = Auth::user()->id;
        $purchase->save();
        $purchase->delete();
    }
}
