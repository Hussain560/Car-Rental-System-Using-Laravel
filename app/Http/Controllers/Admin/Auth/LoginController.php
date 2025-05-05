<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
    {
        if ($user->Role === 'Employee' && $user->RequirePasswordChange) {
            return redirect()->route('admin.password.change')
                ->with('warning', 'Please change your password before proceeding.');
        }

        return redirect()->intended(route('admin.dashboard'));
    }
}
