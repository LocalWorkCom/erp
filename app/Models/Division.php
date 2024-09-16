<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'line_id',
        'name_en',
        'name_ar',
        'created_by',
        'deleted_by'
    ];

    public function line()
    {
        return $this->belongsTo(Line::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function shelves()
    {
        return $this->hasMany(Shelf::class);
    }
}
