<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Position;
use App\Models\UserDesignation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class UserDesignationController extends Controller
{
    public function index()
    {
        $designations = UserDesignation::with(['user', 'role', 'position'])->get();
        $users = User::all();
        $roles = Role::all();
        $positions = Position::all();
        return view('user-designation.index', compact('designations', 'users', 'roles', 'positions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required|numeric|exists:users,id',
            'role_id'     => 'required|numeric|exists:roles,id',
            'position_id' => 'required|numeric|exists:positions,id',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('validation_errors', $validator->errors()->all());
        }

        UserDesignation::create([
            'user_id'     => $request->user_id,
            'role_id'     => $request->role_id,
            'position_id' => $request->position_id,
            'status'      => $request->status,
        ]);

        return redirect()->route('user-designations.index')->with('success', 'User designation created successfully.');
    }

    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decrypt(urldecode($encryptedId));
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required|numeric|exists:users,id',
            'role_id'     => 'required|numeric|exists:roles,id',
            'position_id' => 'required|numeric|exists:positions,id',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('validation_errors', $validator->errors()->all());
        }

        $designation = UserDesignation::findOrFail($id);
        $designation->update([
            'user_id'     => $request->user_id,
            'role_id'     => $request->role_id,
            'position_id' => $request->position_id,
            'status'      => $request->status,
        ]);

        return redirect()->route('user-designations.index')->with('success', 'User designation updated successfully.');
    }

    public function destroy($id)
    {
        $designation = UserDesignation::findOrFail($id);
        $designation->delete();

        return redirect()->route('user-designations.index')->with('success', 'User designation deleted successfully.');
    }
}
