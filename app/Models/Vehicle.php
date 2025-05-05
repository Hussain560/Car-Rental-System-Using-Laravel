<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $primaryKey = 'VehicleID';

    protected $fillable = [
        'Make',
        'Model',
        'Year',
        'LicensePlate',
        'SerialNumber',
        'DateOfExpiry',
        'Color',
        'Category',
        'Status',
        'ImagePath',
        'DailyRate',
        'OfficeID',
        'PassengerCapacity',
        'LuggageCapacity',
        'Doors'
    ];

    protected $casts = [
        'DateOfExpiry' => 'date',
        'DailyRate' => 'decimal:2',
        'Year' => 'integer',
        'PassengerCapacity' => 'integer',
        'LuggageCapacity' => 'integer',
        'Doors' => 'integer'
    ];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'OfficeID', 'OfficeID');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'VehicleID', 'VehicleID');
    }

    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(Maintenance::class, 'VehicleID', 'VehicleID');
    }
}
