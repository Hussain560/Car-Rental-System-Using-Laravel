<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Office extends Model
{
    protected $primaryKey = 'OfficeID';

    protected $fillable = [
        'Name',
        'Email',
        'PhoneNumber',
        'Status',
        'Address',
        'City',
        'PostalCode',
        'Location',
        'OpeningTime',
        'ClosingTime',
        'Description',
        'Notes',
        'ImagePath'
    ];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'OfficeID', 'OfficeID');
    }

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'OfficeID', 'OfficeID');
    }

    public function getEmployeeCountAttribute()
    {
        return $this->admins()->count();
    }
}
