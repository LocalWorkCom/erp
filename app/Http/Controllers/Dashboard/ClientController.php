<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientService;
    protected $checkToken;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
        $this->checkToken = false;
    }

    public function index()
    {
        $users = $this->clientService->getAllClients($this->checkToken);
        return view('dashboard.clients.index', compact('users'));
    }
    public function show($id)
    {
        $client = $this->clientService->getClient($id);
        return view('dashboard.clients.show', compact('client'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('dashboard.clients.create', compact('countries'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            // 'password' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'country_code' => 'required|string',
            'phone' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'required|boolean',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'nullable|string',
            'address_phone' => 'required|string',
            'is_default' => 'nullable|boolean'
        ]);

        $this->clientService->createClient($validatedData, $this->checkToken);
        return redirect()->route('client.index')->with('success', 'Client created successfully!');
    }

    public function edit($id)
    {
        $client = User::where('flag', 'client')->with('clientDetails', 'addresses')->findOrFail($id);
        $countries = Country::all();
        return view('dashboard.clients.edit', compact('countries', 'client'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $id,
            // 'password' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'phone' => 'nullable|string',
            'country_code' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'address_phone' => 'nullable|string',
            'is_default' => 'nullable|boolean'
        ]);

        $this->clientService->updateClient($validatedData, $id, $this->checkToken);
        return redirect()->route('client.index')->with('success', 'Client updated successfully!');
    }
    public function destroy($id)
    {
        $this->clientService->deleteClient($id, $this->checkToken);
        return redirect()->route('client.index')->with('success', 'Client deleted successfully!');
    }
}
