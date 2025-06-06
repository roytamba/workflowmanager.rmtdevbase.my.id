<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = collect(DB::select('SELECT * FROM users u JOIN user_details ud ON u.id = ud.user_id'));
        return view('user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|max:255|unique:users',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Simpan user
            $user = User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => Hash::make('password123'), // Default password
                'email_verified_at' => now(),
            ]);

            // Upload avatar jika ada
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('user/avatars', 'public');
            }

            // Simpan detail user
            UserDetails::create([
                'user_id' => $user->id,
                'image'   => $avatarPath, // kolom image di tabel user_details
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decrypt(urldecode($encryptedId));
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|max:255|unique:users,email,' . $id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $avatarPath = $user->detail->image ?? null;

            if ($request->hasFile('avatar')) {
                // Hapus gambar lama jika ada
                if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
                    Storage::disk('public')->delete($avatarPath);
                }

                // Upload baru
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            UserDetails::updateOrCreate(
                ['user_id' => $user->id],
                ['image' => $avatarPath]
            );

            return redirect()->back()->with('success', 'User updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }
}
