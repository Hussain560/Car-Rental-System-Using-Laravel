<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    protected $table = 'maintenance';
    
    protected $primaryKey = 'MaintenanceID';

    protected $fillable = [
        'VehicleID',
        'StartDate',
        'EndDate',
        'MaintenanceType',
        'Description',
        'Cost',
        'Status'
    ];

    protected $casts = [
        'StartDate' => 'datetime',
        'EndDate' => 'datetime',
        'Cost' => 'decimal:2',
        'CreatedAt' => 'datetime'
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'VehicleID', 'VehicleID');
    }
}
