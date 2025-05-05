<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'BookingID';

    protected $fillable = [
        'UserID',
        'VehicleID',
        'PickupDate',
        'ReturnDate',
        'PickupLocation',
        'TotalCost',
        'Status',
        'AdditionalServices',
        'BookingDate'
    ];

    protected $casts = [
        'PickupDate' => 'datetime',
        'ReturnDate' => 'datetime',
        'BookingDate' => 'datetime',
        'TotalCost' => 'decimal:2'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'UserID', 'CustomerID');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'VehicleID', 'VehicleID');
    }
}
