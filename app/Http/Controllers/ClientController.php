<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        $theme = config('themes.active');
        return view("themes.$theme.clients.index", compact('clients'));
    }

    public function create()
    {
        $theme = config('themes.active');
        return view("themes.$theme.clients.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alias' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        $theme = config('themes.active');
        return view("themes.$theme.clients.edit", compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'alias' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $client->fill($validated);
        $client->save();

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }
}
