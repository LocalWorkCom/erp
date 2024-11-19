<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Table associated with the model
    protected $table = 'products';
    protected $appends = ['name', 'image','description'];

    // The attributes that are mass assignable
    protected $fillable = [
        'main_image',
        'type',
        'main_unit_id',
        'currency_id',
        'category_id',
        'is_have_expired',
        'sku',
        'barcode',
        'code',
        'limit_quantity',
        'is_remind',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
    ];

    protected $hidden = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'created_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'modify_by',
        'deleted_at',
        'main_image',



    ];

    public function getNameAttribute($value)
    {
        return Request()->header('lang') == "en" ? $this->name_en : $this->name_ar;
        // return $this->name_en;
    }
    // public function getNameAr()
    // {
    //     self::$staticMakeVisible = ['name_ar'];

    //     return  $this->name_ar;
    //     // return $this->name_en;
    // }
    public function getDescriptionAttribute($value)
    {
        return Request()->header('lang') == "en" ? $this->name_en : $this->name_ar;
    }
    public function getImageAttribute($value)
    {
        return BaseUrl() . '/' . $this->main_image;
    }
    // The attributes that should be cast to native types
    protected $casts = [
        'is_have_expired' => 'boolean',
    ];

    // Define relationships
    public function mainUnit()
    {
        return $this->belongsTo(Unit::class, 'main_unit_id');
    }

    public function currency()
    {
        return $this->belongsTo(Country::class, 'country_code');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function productUnits()
    {
        return $this->belongsToMany(Unit::class, 'product_units', 'product_id', 'unit_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors', 'product_id', 'color_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes', 'product_id', 'size_id');
    }

    public function productUnites()
    {
        return $this->hasOne(ProductUnit::class, 'product_id');
    }

    public function ingredients()
    {
        return $this->hasManyThrough(Ingredient::class, ProductUnit::class, 'product_id', 'product_unit_id');
    }
}
