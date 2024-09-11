<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionBacklog extends Model
{
    use HasFactory;

        
    protected $hidden = [
        'created_by',
        'created_at',
        'updated_at',
    ];

}
