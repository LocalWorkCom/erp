<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'units';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    // Optionally, you can define other model properties or methods here
}
