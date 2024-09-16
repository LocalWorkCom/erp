<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApICode extends Model
{
    use HasFactory;
    protected $table = 'apicodes'; // Optional if the table name follows Laravel's convention
    
    protected $hidden = [
        'modify_by',
        'created_at',
        'updated_at',
    ];
}