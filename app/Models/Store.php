<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id', 'name_en', 'name_ar', 'description_en', 'description_ar'
    ];

    // A store belongs to a branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // A store can have many lines
    public function lines()
    {
        return $this->hasMany(Line::class);
    }
}
