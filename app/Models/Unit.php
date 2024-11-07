<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory ,SoftDeletes;

    // The table associated with the model.
    protected $table = 'units';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    protected $hidden = [
        'created_by',
        'modify_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'name_ar',
        'name_en',

    ];
    public function creatorby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function getNameAttribute($value)
    {
        return Request()->header('lang') == "en" ? $this->name_en : $this->name_ar;
    }

  
    // Optionally, you can define other model properties or methods here
}
