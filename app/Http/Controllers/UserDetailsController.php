<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDetailsController extends Controller
{
    public function updateOrCreate(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'x' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        // Cek apakah user sudah punya detail
        $details = UserDetails::where('user_id', $user->id)->first();

        if ($details) {
            $details->update($validated);
        } else {
            $details = new UserDetails($validated);
            $details->user_id = $user->id;
            $details->save();
        }

        return response()->json(['message' => 'User details updated successfully.']);
    }
}
