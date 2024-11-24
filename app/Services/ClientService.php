<?php

namespace App\Services;

use App\Models\ClientDetail;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ClientService
{

    public function index(Request $request, $checkToken)
    {

        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $clients = User::with('clientDetails')->get();


        if (!$checkToken) {
            $clients = $clients->makeVisible(['name', 'email', 'phone', 'image']);
        }

        return ResponseWithSuccessData($lang, $clients, 1);
    }
    public function store(Request $request, $checkToken)
    {
        $lang = app()->getLocale();
        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique',
            'password' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'phone' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }
        if (CheckExistColumnValue('users', 'email', $request->email)) {
            return RespondWithBadRequest($lang, 9);
        }


        $user = new User();
        $user->name = $request->first_name . $request->last_name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->country_id =  $request->country_id;
        $user->phone =  $request->phone;
        $user->flag =  'client';

        $client = new ClientDetail();
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->last_name = $request->last_name;
        $client->img = $request->file('img');
        $client->date_of_birth = $request->date_of_birth;
        $client->is_active = $request->is_active;

        return RespondWithSuccessRequest($lang, 1);
    }
    public function update(Request $request, $id, $checkToken)
    {
        $lang = app()->getLocale();

        if (!CheckToken() && $checkToken) {
            return RespondWithBadRequest($lang, 5);
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'email' => 'nullable|email|unique',
            'password' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'phone' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return RespondWithBadRequestWithData($validator->errors());
        }

        // Retrieve the category by ID, or throw an exception if not found
        $user = User::find($id);
    //     
    }
}
