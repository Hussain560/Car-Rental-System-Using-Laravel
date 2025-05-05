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

    public function getAuthPassword()
    {
        return $this->Password;
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'UserID', 'CustomerID');
    }
}
