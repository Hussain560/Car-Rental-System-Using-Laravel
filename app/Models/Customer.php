<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Authenticatable
{
    protected $table = 'customers';
    protected $primaryKey = 'CustomerID';

    protected $fillable = [
        'Username',
        'Password',
        'FirstName',
        'LastName',
        'PhoneNumber',
        'Email',
        'NationalID',
        'Address',
        'DateOfBirth',
        'Gender',
        'EmergencyPhone',
        'LicenseExpiryDate',
        'AccountStatus',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['Password'];

    protected $casts = [
        'DateOfBirth' => 'date',
        'LicenseExpiryDate' => 'date',
        'LastLogin' => 'datetime',
    ];

    protected $attributes = [
        'AccountStatus' => 'Active' // Set default status
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'UserID', 'CustomerID');
    }

    public function getAccountStatusAttribute($value)
    {
        return $value ?: 'Active'; // Ensure we always have a status
    }
}
