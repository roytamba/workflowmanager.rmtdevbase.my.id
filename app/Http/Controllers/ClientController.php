<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('client.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'company_name'  => 'nullable|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone'         => 'nullable|string|max:20',
            'status'        => 'required|in:active,inactive',
        ]);

        Client::create($request->only(['name', 'company_name', 'email', 'phone', 'status']));

        return redirect()->back()->with('success', 'Client has been added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'company_name'  => 'nullable|string|max:255',
            'email'         => 'nullable|email|max:255',
            'phone'         => 'nullable|string|max:20',
            'status'        => 'required|in:active,inactive',
        ]);

        $client = Client::findOrFail($id);
        $client->update($request->only(['name', 'company_name', 'email', 'phone', 'status']));

        return redirect()->back()->with('success', 'Client has been updated successfully.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->back()->with('success', 'Client has been deleted successfully.');
    }
}
