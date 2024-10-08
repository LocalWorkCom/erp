<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    use HasFactory;

    protected $table = 'store_categories';

    protected $fillable = [
        'store_id',
        'category_id',
    ];

    public $timestamps = true;

    // Relationships with the Store and Category models
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productLimits()
    {
        return $this->hasMany(ProductLimit::class, 'product_limit_id');
    }
}
