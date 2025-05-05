<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class EmployeeProfileController extends Controller
{
    public function show()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile.show', compact('admin'));
    }
}
