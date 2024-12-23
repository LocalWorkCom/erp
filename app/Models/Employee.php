<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    //use HasFactory, SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_code',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'gender',
        'birth_date',
        'national_id',
        'passport_number',
        'marital_status',
        'blood_group',
        'emergency_contact_name',
        'emergency_contact_relationship',
        'emergency_contact_phone',
        'address',
        'nationality',
        'department_id',
        'position_id',
        'supervisor_id',
        'hire_date',
        'salary',
        'employment_type',
        'status',
        'notes',
        'is_biometric',
        'biometric_id',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }
    public function delays()
    {
        return $this->hasMany(Delay::class);
    }
    public function advances()
    {
        return $this->hasMany(Advance::class);
    }
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
