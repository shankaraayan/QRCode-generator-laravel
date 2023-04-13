<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return success('User Profile', [
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'role' => $user->role
        ])->response();
    }

    public function update(Request $request)
    {
        validate()->make([
            'name' => 'bail|required|string|min:2|max:100|regex:/^[\pL\s]+$/u',
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->save();
        
        return success('Profile Update')->response();
    }
}
