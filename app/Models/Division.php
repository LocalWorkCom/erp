<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'line_id', 'name_en', 'name_ar'
    ];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }
}
