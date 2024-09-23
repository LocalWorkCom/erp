<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_addons');
    }
}
