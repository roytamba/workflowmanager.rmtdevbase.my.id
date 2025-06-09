<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::latest()->get();
        return view('position.index', compact('positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:positions,name',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Position::create($validated);

        return redirect()->back()->with('success', 'Position added successfully.');
    }

    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $position = Position::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:positions,name,' . $position->id,
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $position->update($validated);

        return redirect()->back()->with('success', 'Position updated successfully.');
    }

    public function destroy($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $position = Position::findOrFail($id);
        $position->delete();

        return redirect()->back()->with('success', 'Position deleted successfully.');
    }
}
