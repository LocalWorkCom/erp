<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id', 'name_en', 'name_ar'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
