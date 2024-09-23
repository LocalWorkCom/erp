<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecipeAddon extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'recipe_addons';

    protected $fillable = [
        'recipe_id',
        'addon_id',
    ];

    // Relationships
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }
}
