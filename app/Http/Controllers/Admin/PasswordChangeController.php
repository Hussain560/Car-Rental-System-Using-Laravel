<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function showChangeForm()
    {
        return view('admin.auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed'
        ]);

        $user = auth()->user();
        $user->update([
            'Password' => Hash::make($request->new_password),
            'LastLogin' => now(),
            'RequirePasswordChange' => false
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Password changed successfully');
    }
}
