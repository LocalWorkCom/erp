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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'nullable|string',
            'country_id' => 'required|exists:countries,id',
            'phone' => 'required|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'required|boolean',
            'addresses' => 'nullable|array',
            'addresses.*.address' => 'required|string',
            'addresses.*.city' => 'required|string',
            'addresses.*.state' => 'required|string',
            'addresses.*.postal_code' => 'nullable|string',
        ]);

        try {
            $this->clientService->createClient($validatedData, $this->checkToken);
            return redirect()->route('client.index')->with('success', 'Client created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating client: ' . $e->getMessage());
        }
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
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'phone' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'date_of_birth' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $this->clientService->updateClient($id, $validatedData, $this->checkToken);
            return redirect()->route('dashboard.clients.index')->with('success', 'Client updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating client: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $this->clientService->deleteClient($id, $this->checkToken);
            return redirect()->route('dashboard.clients.index')->with('success', 'Client deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting client: ' . $e->getMessage());
        }
    }
}
