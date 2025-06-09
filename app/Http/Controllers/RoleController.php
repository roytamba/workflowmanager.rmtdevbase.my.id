<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('role.index', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            Role::create($request->only('name', 'description', 'status'));
            return redirect()->back()->with('success', 'Role created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decrypt(urldecode($encryptedId));
        $role = Role::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $role->update($request->only('name', 'description', 'status'));
            return redirect()->back()->with('success', 'Role updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update role: ' . $e->getMessage());
        }
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return redirect()->back()->with('success', 'Role deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }
}
