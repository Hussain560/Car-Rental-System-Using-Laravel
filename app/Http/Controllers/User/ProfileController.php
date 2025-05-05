<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class ProfileController extends Controller
{
    public function show()
    {
        return view('user.profile.show');
    }

    public function edit()
    {
        return view('user.profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'FirstName' => 'required|string|max:50',
            'LastName' => 'required|string|max:50',
            'PhoneNumber' => 'required|string|max:20',
            'EmergencyPhone' => 'required|string|max:20',
            'Address' => 'required|string',
            'Email' => 'required|email|unique:customers,Email,'.$user->CustomerID.',CustomerID',
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed'
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->Password)) {
                return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
            }
            $validated['Password'] = Hash::make($request->new_password);
        }

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
