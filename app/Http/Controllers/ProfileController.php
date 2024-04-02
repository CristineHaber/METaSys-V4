<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('auth.passwords.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function profile(Request $request)
    {
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255'
        ]);

        // Update the user's name using an associative array
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name')
        ]);

        return redirect()->back()->with("message", "Profile updated successfully!");
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        // Check if the current password matches the user's password
        if (!(Hash::check($request->input('current-password'), $user->password))) {
            return redirect()->back()->with("error", "Your current password does not match with the password you provided. Please try again.");
        }

        // Check if the new password is different from the current password
        if (strcmp($request->input('current-password'), $request->input('new-password')) == 0) {
            return redirect()->back()->with("error", "New Password cannot be the same as your current password. Please choose a different password.");
        }

        // Update the user's password
        $user->update([
            'password' => bcrypt($request->input('new-password')),
        ]);

        return redirect()->back()->with("message", "Password changed successfully!");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
