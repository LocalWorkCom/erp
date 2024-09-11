<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id', 'name_en', 'name_ar', 'is_freeze'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }
}
