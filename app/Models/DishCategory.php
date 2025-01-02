<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['name', 'description', 'name_site', 'description_site'];

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'parent_id',
        'image_path',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    protected $hidden = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'created_by',
        'modified_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getNameAttribute()
    {
        return request()->header('lang', 'ar') === 'en' ? $this->name_en : $this->name_ar;
    }

    public function getDescriptionAttribute()
    {
        return request()->header('lang', 'ar') === 'en' ? $this->description_en : $this->description_ar;
    }

    public function getNameSiteAttribute()
    {
        return app()->getLocale() === 'en' ? $this->name_en : $this->name_ar;
    }

    public function getDescriptionSiteAttribute()
    {
        return app()->getLocale() === 'en' ? $this->description_en : $this->description_ar;
    }

    // Relationships
    public function parent()
    {
        return $this->belongsTo(DishCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(DishCategory::class, 'parent_id');
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

    // Scope to get only active dish categories
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function dishes()
    {
        return $this->hasMany(Dish::class, 'category_id');
    }

    public function branchMenuCategory()
    {
        return $this->hasOne(BranchMenuCategory::class, 'dish_category_id', 'id');
    }
}
