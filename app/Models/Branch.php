<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_ar', 'address_en', 'address_ar', 'country', 'phone', 'email', 'manager_name', 'opening_hours'
    ];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
