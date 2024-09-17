<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory ,SoftDeletes;

    // Table associated with the model
    protected $table = 'products';

    // The attributes that are mass assignable
    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'main_image',
        'type',
        'main_unit_id',
        'currency_id',
        'category_id',
        'is_valid',
        'sku',
        'barcode',
        'code',
        'is_remind'
    ];
        
    protected $hidden = [
        'created_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'modify_by',
        'deleted_at',


    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'is_valid' => 'boolean',
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
}
