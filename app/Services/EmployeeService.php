<?php

namespace App\Services;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class EmployeeService
{
    public function getAllEmployees($checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        return User::where('flag', 'employee')->with('employees', 'country')->get();
    }

    public function getEmployee($id)
    {
        return User::with('clientDetails', 'addresses')->findOrFail($id);
    }

    public function createEmployee($data, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $user = new User();
        $user->name = $data['first_name'] . ' ' . $data['last_name'];
        $user->email = $data['email'];
        $user->password = Hash::make('123');
        $user->country_id = $data['country_id'];
        $user->phone = $data['phone'];
        $user->flag = 'client';
        $user->save();

    }

    public function updateEmployee($data, $id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $user = User::findOrFail($id);
        $user->name = isset($data['first_name']) && isset($data['last_name']) ? $data['first_name'] . ' ' . $data['last_name'] : $user->name;
        $user->email = $data['email'] ?? $user->email;
        // $user->password = isset($data['password']) ? Hash::make($data['password']) : $user->password;
        $user->country_id = $data['country_id'] ?? $user->country_id;
        $user->phone = $data['phone'] ?? $user->phone;
        $user->save();

        $clientDetail = ClientDetail::where('user_id', $id)->first();
        $clientDetail->first_name = $data['first_name'] ?? $clientDetail->first_name;
        $clientDetail->last_name = $data['last_name'] ?? $clientDetail->last_name;
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
        $clientAddress->city = $data['city'] ?? $clientAddress->city;
        $clientAddress->state = $data['state'] ?? $clientAddress->state;
        $clientAddress->postal_code = $data['postal_code'] ?? $clientAddress->postal_code;
        $clientAddress->is_default = $data['is_default'] ?? 0;
        $clientAddress->save();
    }

    public function deleteEmployee($id, $checkToken)
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
