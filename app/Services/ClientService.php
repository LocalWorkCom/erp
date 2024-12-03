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
        $user->name = $data['first_name'] . ' ' . $data['last_name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->country_id = $data['country_id'];
        $user->phone = $data['phone'];
        $user->flag = 'client';
        $user->save();

        $clientDetail = new ClientDetail();
        $clientDetail->user_id = $user->id;
        $clientDetail->first_name = $data['first_name'];
        $clientDetail->last_name = $data['last_name'];
        if (isset($data['image'])) {
            UploadFile('images/clients', 'image', $clientDetail,  $data['image']);
        }
        $clientDetail->date_of_birth = $data['date_of_birth'];
        $clientDetail->is_active = $data['is_active'];
        $clientDetail->save();

        if (isset($data['addresses'])) {
            foreach ($data['addresses'] as $address) {
                $clientAddress = new ClientAddress();
                $clientAddress->user_id = $user->id;
                $clientAddress->address = $address['address'];
                $clientAddress->city = $address['city'];
                $clientAddress->state = $address['state'];
                $clientAddress->postal_code = $address['postal_code'] ?? null;
                $clientAddress->latitude = $address['latitude'] ?? null;
                $clientAddress->longitude = $address['longitude'] ?? null;
                $clientAddress->is_default = $address['is_default'] ?? 0;
                $clientAddress->is_active = 1;
                $clientAddress->save();
            }
        }

        return $user;
    }

    public function updateClient($data, $id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $user = User::findOrFail($id);
        $user->name = $data['first_name'] . ' ' . $data['last_name'];
        $user->email = $data['email'];
        $user->password = isset($data['password']) ? Hash::make($data['password']) : $user->password;
        $user->country_id = $data['country_id'];
        $user->phone = $data['phone'];
        $user->is_active = $data['is_active'];
        $user->save();

        $clientDetail = ClientDetail::where('user_id', $id)->first();
        $clientDetail->first_name = $data['first_name'];
        $clientDetail->last_name = $data['last_name'];
        if (isset($data['image'])) {
            if ($clientDetail->image) {
                Storage::delete('images/clients/' . $clientDetail->image);
            }
            UploadFile('images/clients', 'image', $clientDetail, $data['image']);
        }
        $clientDetail->date_of_birth = $data['date_of_birth'];
        $clientDetail->is_active = $data['is_active'];
        $clientDetail->save();

        return $user;
    }

    public function deleteClient($id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $user = User::findOrFail($id);
        $clientDetail = ClientDetail::where('user_id', $id)->first();

        $clientAddress = ClientAddress::where('user_id', $id)->first();

        dd($user,$clientDetail, $clientAddress);

        if ($clientDetail && $clientDetail->image) {
            Storage::delete('images/clients/' . $clientDetail->image);
        }

        if ($clientAddress) {
            $clientAddress->delete();
        }
    
        if ($clientDetail) {
            $clientDetail->delete();
        }
    
        $user->delete();
    }
}
