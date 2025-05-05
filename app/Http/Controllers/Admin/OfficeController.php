<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfficeController extends Controller
{
    private function handleImageUpload($image, $officeName, $oldImagePath = null)
    {
        if ($oldImagePath) {
            $oldPath = str_replace('storage/', '', $oldImagePath);
            if (Storage::exists('public/' . $oldPath)) {
                Storage::delete('public/' . $oldPath);
            }
        }

        $fileName = Str::slug($officeName) . '-' . time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('images/offices', $fileName, 'public');
        return 'storage/' . $path;
    }

    public function index(Request $request)
    {
        $query = Office::withCount(['vehicles', 'admins']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('Status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Name', 'like', "%{$search}%")
                  ->orWhere('Email', 'like', "%{$search}%")
                  ->orWhere('PhoneNumber', 'like', "%{$search}%")
                  ->orWhere('Location', 'like', "%{$search}%")
                  ->orWhere('City', 'like', "%{$search}%");
            });
        }

        $offices = $query->paginate($request->get('per_page', 10));
        
        return view('admin.offices.index', compact('offices'));
    }

    public function create()
    {
        return view('admin.offices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:offices,Email',
            'phone_number' => 'required|string|max:20',
            'status' => 'required|string|in:Active,Inactive,Maintenance',
            'location' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048'  // Updated validation rule
        ]);

        // Handle image upload with custom name
        if ($request->hasFile('image')) {
            $validated['ImagePath'] = $this->handleImageUpload(
                $request->file('image'),
                $validated['name']
            );
        }

        // Format phone number with Saudi prefix
        $phoneNumber = '+966' . substr($validated['phone_number'], -9);

        Office::create([
            'Name' => $validated['name'],
            'Email' => $validated['email'],
            'PhoneNumber' => $phoneNumber,
            'Status' => $validated['status'],
            'Location' => $validated['location'],
            'Address' => $validated['address'],
            'City' => $validated['city'],
            'PostalCode' => $validated['postal_code'],
            'OpeningTime' => $validated['opening_time'],
            'ClosingTime' => $validated['closing_time'],
            'Description' => $validated['description'],
            'Notes' => $validated['notes'],
            'ImagePath' => $validated['ImagePath'] ?? null
        ]);

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office created successfully');
    }

    public function edit(Office $office)
    {
        return view('admin.offices.edit', compact('office'));
    }

    public function update(Request $request, Office $office)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:offices,Email,'.$office->OfficeID.',OfficeID',
            'phone_number' => 'required|string|max:20',
            'status' => 'required|string|in:Active,Inactive,Maintenance',
            'location' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048'  // Updated validation rule
        ]);

        // Handle image upload with custom name
        if ($request->hasFile('image')) {
            $validated['ImagePath'] = $this->handleImageUpload(
                $request->file('image'),
                $validated['name'],
                $office->ImagePath
            );
        }

        // Format phone number with Saudi prefix
        $phoneNumber = '+966' . substr($validated['phone_number'], -9);

        $office->update([
            'Name' => $validated['name'],
            'Email' => $validated['email'],
            'PhoneNumber' => $phoneNumber,
            'Status' => $validated['status'],
            'Location' => $validated['location'],
            'Address' => $validated['address'],
            'City' => $validated['city'],
            'PostalCode' => $validated['postal_code'],
            'OpeningTime' => $validated['opening_time'],
            'ClosingTime' => $validated['closing_time'],
            'Description' => $validated['description'],
            'Notes' => $validated['notes'],
            'ImagePath' => $validated['ImagePath'] ?? $office->ImagePath
        ]);

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office updated successfully');
    }

    public function destroy(Office $office)
    {
        if ($office->vehicles()->exists()) {
            return redirect()->route('admin.offices.index')
                ->with('error', 'Cannot delete office with assigned vehicles');
        }

        if ($office->admins()->exists()) {
            return redirect()->route('admin.offices.index')
                ->with('error', 'Cannot delete office with assigned administrators');
        }

        // Delete the office image if it exists
        if ($office->ImagePath) {
            $imagePath = str_replace('storage/', '', $office->ImagePath);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            // Also check and remove the physical file if it exists
            $fullPath = public_path($office->ImagePath);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }

        $office->delete();

        return redirect()->route('admin.offices.index')
            ->with('success', 'Office and its image were deleted successfully');
    }

    public function show(Office $office)
    {
        $office->loadCount(['vehicles', 'admins']);
        return view('admin.offices.show', compact('office'));
    }
}
