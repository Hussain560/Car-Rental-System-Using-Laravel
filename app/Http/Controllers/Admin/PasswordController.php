<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('admin.profile.change-password');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = auth()->guard('admin')->user();
        
        $user->update([
            'Password' => Hash::make($validated['password']),
            'RequirePasswordChange' => false,
            'LastLogin' => now()
        ]);

        return redirect()->route('admin.profile.show')
            ->with('success', 'Password updated successfully');
    }
}
