<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $appends = ['name', 'custom_image', 'description'];

    protected $fillable = [
        'active',
        'code',
        'is_freeze',
        'parent_id',
        'is_deleted',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'image',
    ];


    protected $hidden = [
        'created_by',
        'deleted_by',
        'modify_by',
        'deleted_at',
        'created_at',
        'updated_at',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'image',

    ];
    protected $casts = [
        'active' => 'boolean',
        'is_freeze' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    /**
     * Get the parent category for this category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function getNameAttribute($value)
    {
        return Request()->header('lang') == "en" ? $this->name_en : $this->name_ar;
    }
    public function getDescriptionAttribute($value)
    {
        return Request()->header('lang') == "en" ? $this->name_en : $this->name_ar;
    }
    public function getCustomImageAttribute($value)
    {
        return BaseUrl() . '/' . $this->main_image;
    }
    /**
     * Get the creator of this category.
     */
    public function creatorby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }
    /**
     * Get the user who deleted this category.
     */
    public function deletedby()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    // Define the relationship between Category and Product
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    public function storeCategories()
    {
        return $this->hasMany(StoreCategory::class);
    }

    public function stores()
    {
        return $this->hasManyThrough(Store::class, StoreCategory::class, 'category_id', 'id', 'id', 'store_id');
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    
}
