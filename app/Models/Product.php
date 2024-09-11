<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

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
        'price',
        'currency_id',
        'category_id',
        'is_valid',
        'expired_date',
        'sku',
        'barcode',
        'code',
        'limit_quantity',
        'is_remind'
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'expired_date' => 'date',
        'price' => 'decimal:2',
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
