<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'type', // 1 for recipe, 2 for addon
        'price',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    protected $hidden = [
        'created_by',
        'modified_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Scope to filter recipes only (type = 1)
    public function scopeOnlyRecipes($query)
    {
        return $query->where('type', 1);
    }

    // Scope to filter addons only (type = 2)
    public function scopeOnlyAddons($query)
    {
        return $query->where('type', 2);
    }

    // Relationships
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function images()
    {
        return $this->hasMany(RecipeImage::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Relationship to link an addon to recipes through recipe_addons table
    public function recipeAddons()
    {
        return $this->hasMany(RecipeAddon::class, 'addon_id');
    }
    public function branches()
{
    return $this->belongsToMany(Branch::class, 'branch_recipe');
}
}
