<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'Username' => 'required',
            'Password' => 'required'
        ]);

        $user = Customer::where('Username', $credentials['Username'])->first();

        if (!$user) {
            return back()->withErrors([
                'Username' => 'The provided credentials do not match our records.',
            ])->onlyInput('Username');
        }

        if ($user->AccountStatus === 'suspended') {
            return back()->withErrors([
                'Username' => 'Your account has been suspended. Please contact support.',
            ])->onlyInput('Username');
        }

        if (Hash::check($credentials['Password'], $user->Password)) {
            // Update last login timestamp
            $user->LastLogin = now();
            $user->save();
            
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'Username' => 'The provided credentials do not match our records.',
        ])->onlyInput('Username');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'Username' => 'required|unique:customers|min:3',
            'Password' => 'required|min:8|confirmed',
            'FirstName' => 'required|string|max:50',
            'LastName' => 'required|string|max:50',
            'Email' => 'required|email|unique:customers',
            'PhoneNumber' => 'required|string|max:20',
            'NationalID' => 'required|string|unique:customers',
            'Address' => 'required|string',
            'DateOfBirth' => 'required|date',
            'Gender' => 'required|in:Male,Female',
            'EmergencyPhone' => 'required|string',
            'LicenseExpiryDate' => 'required|date|after:today'
        ]);

        $customer = Customer::create([
            'Username' => $validated['Username'],
            'Password' => Hash::make($validated['Password']),
            'FirstName' => $validated['FirstName'],
            'LastName' => $validated['LastName'],
            'Email' => $validated['Email'],
            'PhoneNumber' => $validated['PhoneNumber'],
            'NationalID' => $validated['NationalID'],
            'Address' => $validated['Address'],
            'DateOfBirth' => $validated['DateOfBirth'],
            'Gender' => $validated['Gender'],
            'EmergencyPhone' => $validated['EmergencyPhone'],
            'LicenseExpiryDate' => $validated['LicenseExpiryDate'],
            'AccountStatus' => 'active'
        ]);

        Auth::login($customer);
        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // Add admin login methods
    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'username' => 'Invalid credentials.',
        ]);
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}
