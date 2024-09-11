<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'address_en',
        'address_ar',
        'latitute',
        'longitute',
        'country_id',
        'phone',
        'email',
        'manager_name',
        'opening_hours',
        'created_by',
        'deleted_by'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
