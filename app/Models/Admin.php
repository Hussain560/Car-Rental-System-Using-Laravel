<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Authenticatable
{
    protected $primaryKey = 'AdminID';

    protected $fillable = [
        'Username',
        'Password',
        'FirstName',
        'LastName',
        'DateOfBirth',
        'PhoneNumber',
        'EmergencyContact',
        'EmergencyContactName',
        'Email',
        'Address',
        'OfficeID',
        'Role',
        'Status',
        'JoinDate',
        'Nationality',
        'NationalID',
        'IDExpiryDate',
        'ImagePath',
        'LastLogin',
        'RequirePasswordChange'
    ];

    protected $casts = [
        'DateOfBirth' => 'datetime',
        'JoinDate' => 'datetime',
        'IDExpiryDate' => 'datetime',
        'LastLogin' => 'datetime',
        'RequirePasswordChange' => 'boolean'
    ];

    /**
     * Get the name of the unique identifier for the user.
     */
    public function getAuthIdentifierName()
    {
        return 'AdminID';
    }

    /**
     * Get the unique identifier for the user.
     */
    public function getAuthIdentifier()
    {
        return $this->AdminID;
    }

    /**
     * Get the password for the user.
     */
    public function getAuthPassword()
    {
        return $this->Password;
    }

    /**
     * Get the password field name for the user.
     */
    public function getAuthPasswordName()
    {
        return 'Password';
    }

    /**
     * Get the remember token for the user.
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the remember token for the user.
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
    
    /**
     * Check if the admin is a manager.
     */
    public function isManager()
    {
        return $this->Role === 'Manager';
    }

    /**
     * Check if the admin is an employee.
     *
     * @return bool
     */
    public function isEmployee()
    {
        return $this->Role === 'Employee';
    }
    
    /**
     * Define accessor for is_manager property.
     */
    public function getIsManagerAttribute()
    {
        return $this->isManager();
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'OfficeID', 'OfficeID');
    }
}
