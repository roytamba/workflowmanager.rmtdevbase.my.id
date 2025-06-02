<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userDetail = UserDetails::where('user_id', $user->id)->first();

        return view('profile.index', [
            'user' => $user,
            'userDetail' => $userDetail
        ]);
    }
}
