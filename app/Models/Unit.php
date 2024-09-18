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

    ];
    public function creatorby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    // Optionally, you can define other model properties or methods here
}
