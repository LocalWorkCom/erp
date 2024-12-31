<?php

namespace App\Services;

use App\Models\ClientAddress;
use App\Models\ClientDetail;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class ClientService
{
    public function getAllClients($checkToken)
    {

        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        return User::where('flag', 'client')->with('clientDetails', 'addresses', 'country')->get();
    }

    public function getClient($id)
    {
        return User::with('clientDetails', 'addresses')->findOrFail($id);
    }

    public function createclient($data, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make('123');
        $user->country_id = $data['country_id'];
        $user->country_code = $data['country_code'];
        $user->phone = $data['phone'];
        $user->flag = 'client';
        $user->save();

        $clientDetail = new ClientDetail();
        $clientDetail->user_id = $user->id;
        if (isset($data['image'])) {
            UploadFile('images/clients', 'image', $clientDetail,  $data['image']);
        }
        $clientDetail->date_of_birth = $data['date_of_birth'] ?? null;
        $clientDetail->is_active = $data['is_active'];
        $clientDetail->save();

        $clientAddress = new ClientAddress();
        $clientAddress->user_id = $user->id;
        $clientAddress->country_code = $user->country_code;
        $clientAddress->address = $data['address'];
        $clientAddress->city = $data['city'];
        $clientAddress->state = $data['state'];
        $clientAddress->postal_code = $data['postal_code'] ?? null;
        $clientAddress->latitude = $data['latitude'] ?? null;
        $clientAddress->longtitude = $data['longtitude'] ?? null;
        $clientAddress->is_default = $data['is_default'] ?? 0;
        $clientAddress->is_active = 1;
        $clientAddress->address_phone = $data['address_phone'];
        $clientAddress->save();
    }

    public function updateClient($data, $id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $user = User::findOrFail($id);
        $user->name = $data['name'] ?? $user->name;
        $user->country_code = $data['country_code'] ?? $user->country_code;
        $user->email = $data['email'] ?? $user->email;
        $user->password = isset($data['password']) ? Hash::make($data['password']) : $user->password;
        $user->country_id = $data['country_id'] ?? $user->country_id;
        $user->country_code = $data['country_code'];
        $user->phone = $data['phone'] ?? $user->phone;
        $user->save();

        $clientDetail = ClientDetail::where('user_id', $id)->first();
        if (isset($data['image'])) {
            if ($clientDetail->image) {
                Storage::delete('images/clients/' . $clientDetail->image);
            }
            UploadFile('images/clients', 'image', $clientDetail, $data['image']);
        }
        $clientDetail->date_of_birth = $data['date_of_birth'] ?? $clientDetail->date_of_birth;
        $clientDetail->is_active = $data['is_active'];
        $clientDetail->save();

        $clientAddress = clientAddress::where('user_id', $id)->first();

        $clientAddress->address = $data['address'] ?? $clientAddress->address;
        $clientAddress->address = $data['address_phone'] ?? $clientAddress->address_phone;
        $user->country_code = $data['country_code'] ?? $user->country_code;
        $clientAddress->city = $data['city'] ?? $clientAddress->city;
        $clientAddress->state = $data['state'] ?? $clientAddress->state;
        $clientAddress->postal_code = $data['postal_code'] ?? $clientAddress->postal_code;
        $clientAddress->is_default = $data['is_default'] ?? 0;
        $clientAddress->save();
    }

    public function deleteClient($id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }

        ClientAddress::where('user_id', $id)->delete();
        ClientDetail::where('user_id', $id)->delete();
        User::find($id)->delete();
    }
}
