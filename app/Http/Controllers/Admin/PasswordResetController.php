<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PasswordResetController extends Controller
{
    public function showForm()
    {
        return view('admin.profile.reset-password');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = auth()->guard('admin')->user();
        $user->update([
            'Password' => Hash::make($validated['password'])
        ]);

        return redirect()
            ->route('admin.profile.show')
            ->with('success', 'Password has been reset successfully');
    }
}
