<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Admin::where('Role', 'Employee')
                     ->with('office');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        // Filter by office
        if ($request->filled('office_id')) {
            $query->where('OfficeID', $request->office_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('FirstName', 'like', "%{$search}%")
                  ->orWhere('LastName', 'like', "%{$search}%")
                  ->orWhere('Email', 'like', "%{$search}%")
                  ->orWhere('PhoneNumber', 'like', "%{$search}%");
            });
        }

        $employees = $query->latest()->paginate(10);
        $offices = Office::all();
        
        return view('admin.employees.index', compact('employees', 'offices'));
    }

    public function create()
    {
        $offices = Office::where('Status', 'Active')->get();
        return view('admin.employees.create', compact('offices'));
    }

    private function handleImageUpload($image, $employee, $oldImagePath = null)
    {
        // Delete old image if exists
        if ($oldImagePath) {
            $imagePath = str_replace('storage/', '', $oldImagePath);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        // Create directory if it doesn't exist
        $directory = 'public/images/employees';
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        // Generate filename
        $fileName = Str::slug($employee['first_name'] . '-' . $employee['last_name'] . '-' . $employee['national_id']) 
            . '-' . time() . '.' . $image->getClientOriginalExtension();
        
        // Store the image
        $path = $image->storeAs('images/employees', $fileName, 'public');
        
        // Return the public URL
        return 'storage/' . $path;
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:50|unique:admins,Username',
                'first_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'date_of_birth' => 'required|date|before:today',
                'phone_number' => 'required|string|max:9',
                'emergency_contact' => 'required|string|max:9',
                'emergency_contact_name' => 'required|string|max:100',
                'email' => 'required|email|max:100|unique:admins,Email',
                'address' => 'required|string|max:255',
                'office_id' => 'required|exists:offices,OfficeID',
                'nationality' => 'required|string|max:50',
                'national_id' => 'required|string|max:20|unique:admins,NationalID',
                'id_expiry_date' => 'required|date|after:today',
                'join_date' => 'required|date',
                'image' => 'nullable|image|max:2048'
            ]);

            \DB::beginTransaction();

            // Format dates to match database format
            $startDate = date('Y-m-d', strtotime($validated['date_of_birth']));
            $joinDate = date('Y-m-d', strtotime($validated['join_date']));
            $idExpiryDate = date('Y-m-d', strtotime($validated['id_expiry_date']));

            // Format phone numbers
            $phoneNumber = '+966' . ltrim($validated['phone_number'], '+966');
            $emergencyContact = '+966' . ltrim($validated['emergency_contact'], '+966');

            // Generate password first to ensure it's available
            $generatedPassword = Str::random(12);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                try {
                    $imagePath = $this->handleImageUpload(
                        $request->file('image'),
                        [
                            'first_name' => $validated['first_name'],
                            'last_name' => $validated['last_name'],
                            'national_id' => $validated['national_id']
                        ]
                    );
                } catch (\Exception $e) {
                    \Log::error('Image upload failed: ' . $e->getMessage());
                    // Continue without image if upload fails
                }
            }

            $employee = Admin::create([
                'Username' => $validated['username'],
                'Password' => Hash::make($generatedPassword),
                'FirstName' => $validated['first_name'],
                'LastName' => $validated['last_name'],
                'DateOfBirth' => $startDate,
                'PhoneNumber' => $phoneNumber,
                'EmergencyContact' => $emergencyContact,
                'EmergencyContactName' => $validated['emergency_contact_name'],
                'Email' => $validated['email'],
                'Address' => $validated['address'],
                'OfficeID' => $validated['office_id'],
                'Role' => 'Employee',
                'Status' => 'Active',
                'JoinDate' => $joinDate,
                'Nationality' => $validated['nationality'],
                'NationalID' => $validated['national_id'],
                'IDExpiryDate' => $idExpiryDate,
                'ImagePath' => $imagePath,
                'RequirePasswordChange' => true
            ]);

            \DB::commit();

            // Store credentials in session
            session([
                'employee_credentials' => [
                    'username' => $validated['username'],
                    'password' => $generatedPassword,
                    'expiry' => now()->addSeconds(30)
                ]
            ]);

            return redirect()->route('admin.employees.show_credentials');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Employee creation failed: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error creating employee: ' . $e->getMessage());
        }
    }

    public function showCredentials()
    {
        $credentials = session('employee_credentials');
        
        if (!$credentials) {
            return redirect()->route('admin.employees.index')
                ->with('error', 'No credentials found to display');
        }

        // Don't clear credentials from session immediately
        // This allows the page to maintain the data until redirect

        return view('admin.employees.show-credentials', [
            'username' => $credentials['username'],
            'password' => $credentials['password']
        ]);
    }

    public function edit(Admin $employee)
    {
        $offices = Office::where('Status', 'Active')->get();
        return view('admin.employees.edit', compact('employee', 'offices'));
    }

    public function update(Request $request, Admin $employee)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:admins,Username,'.$employee->AdminID.',AdminID',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'date_of_birth' => 'required|date|before:today',
            'phone_number' => 'required|string|max:9',
            'emergency_contact' => 'required|string|max:9',
            'emergency_contact_name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:admins,Email,'.$employee->AdminID.',AdminID',
            'address' => 'required|string|max:255',
            'office_id' => 'required|exists:offices,OfficeID',
            'nationality' => 'required|string|max:50',
            'national_id' => 'required|string|max:20|unique:admins,NationalID,'.$employee->AdminID.',AdminID',
            'id_expiry_date' => 'required|date',
            'join_date' => 'required|date',
            'status' => 'required|in:Active,Inactive,Suspended',
            'image' => 'nullable|image|max:2048'
        ]);

        try {
            \DB::beginTransaction();

            $updateData = [
                'Username' => $validated['username'],
                'FirstName' => $validated['first_name'],
                'LastName' => $validated['last_name'],
                'DateOfBirth' => $validated['date_of_birth'],
                'PhoneNumber' => '+966' . $validated['phone_number'],
                'EmergencyContact' => '+966' . $validated['emergency_contact'],
                'EmergencyContactName' => $validated['emergency_contact_name'],
                'Email' => $validated['email'],
                'Address' => $validated['address'],
                'OfficeID' => $validated['office_id'],
                'Status' => $validated['status'],
                'JoinDate' => $validated['join_date'],
                'Nationality' => $validated['nationality'],
                'NationalID' => $validated['national_id'],
                'IDExpiryDate' => $validated['id_expiry_date'],
            ];

            if ($request->hasFile('image')) {
                $updateData['ImagePath'] = $this->handleImageUpload(
                    $request->file('image'),
                    [
                        'first_name' => $validated['first_name'],
                        'last_name' => $validated['last_name'],
                        'national_id' => $validated['national_id']
                    ],
                    $employee->ImagePath
                );
            }

            $employee->update($updateData);
            \DB::commit();

            return redirect()->route('admin.employees.index')
                ->with('success', 'Employee updated successfully');

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error updating employee: ' . $e->getMessage());
        }
    }

    public function show(Admin $employee)
    {
        return view('admin.employees.show', compact('employee'));
    }
}
