<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecipeAddon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recipe_id',
        'addon_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Relationships
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }

    public function addon()
    {
        return $this->belongsTo(Recipe::class, 'addon_id');
    }
}
