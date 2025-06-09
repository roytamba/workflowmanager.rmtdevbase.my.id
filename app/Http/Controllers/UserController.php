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
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = collect(DB::select('SELECT u.id, u.name, u.email, ud.image, u.created_at, u.status FROM users u LEFT JOIN user_details ud ON u.id = ud.user_id'))
            ->map(function ($user) {
                // Kalau image kosong, assign default random avatar
                if (empty($user->image)) {
                    $user->image = 'assets/images/users/avatar-' . rand(1, 8) . '.jpg';
                } else {
                    $user->image = 'storage/' . $user->image;
                }
                return $user;
            });

        return view('user.index', compact('users'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|max:255|unique:users',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('user/images', 'public');
            }

            // Simpan detail user
            UserDetails::create([
                'user_id' => $user->id,
                'image'   => $imagePath, // kolom image di tabel user_details
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
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $imagePath = $user->detail->image ?? null;

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }

                // Upload baru
                $imagePath = $request->file('image')->store('user/images', 'public');
            }

            UserDetails::updateOrCreate(
                ['user_id' => $user->id],
                ['image' => $imagePath]
            );

            return redirect()->back()->with('success', 'User updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }
}
