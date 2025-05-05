<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'Username' => 'required|unique:car_rental_users,Username|min:3',
            'Email' => 'required|email|unique:car_rental_users,Email',
            'Password' => 'required|min:8|confirmed',
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'PhoneNumber' => 'required|string|min:10',
            'EmergencyPhone' => 'required|string|min:10',
            'NationalID' => 'required|string|unique:car_rental_users,NationalID',
            'Address' => 'required|string',
            'DateOfBirth' => 'required|date|before:today',
            'Gender' => 'required|in:Male,Female',
            'LicenseExpiryDate' => 'required|date|after:today',
        ]);

        $customer = Customer::create([
            'Username' => $request->Username,
            'Password' => Hash::make($request->Password),
            'FirstName' => $request->FirstName,
            'LastName' => $request->LastName,
            'PhoneNumber' => $request->PhoneNumber,
            'Email' => $request->Email,
            'NationalID' => $request->NationalID,
            'Address' => $request->Address,
            'DateOfBirth' => $request->DateOfBirth,
            'Gender' => $request->Gender,
            'EmergencyPhone' => $request->EmergencyPhone,
            'LicenseExpiryDate' => $request->LicenseExpiryDate,
            'AccountStatus' => 'active'
        ]);

        return redirect()->route('customer.login')
            ->with('success', 'Registration successful! Please login to continue.');
    }
}
