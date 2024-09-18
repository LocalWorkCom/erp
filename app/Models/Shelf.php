<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Shelf extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'division_id',
        'name_en',
        'name_ar',
        'code',  
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    protected $dates = ['deleted_at']; 

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
