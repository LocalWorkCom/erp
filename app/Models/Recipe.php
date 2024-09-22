<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;

    const CATEGORY_MAIN_DISH = 1;
    const CATEGORY_DRINKS = 2;
    const CATEGORY_DESSERTS = 3;
    const CATEGORY_SIDES = 4;
    const CATEGORY_APPETIZERS = 5;
    const CATEGORY_SALADS = 6; 
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'category_flag', 
        'price',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

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

    // Method to get the category name based on the flag
    public function getCategoryNameAttribute()
    {
        switch ($this->category_flag) {
            case self::CATEGORY_MAIN_DISH:
                return 'Main Dish';
            case self::CATEGORY_DRINKS:
                return 'Drinks';
            case self::CATEGORY_DESSERTS:
                return 'Desserts';
            case self::CATEGORY_SIDES:
                return 'Sides';
            case self::CATEGORY_APPETIZERS:
                return 'Appetizers';
            case self::CATEGORY_SALADS:
                return 'Salads'; 
            default:
                return 'Unknown';
        }
    }
        public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
