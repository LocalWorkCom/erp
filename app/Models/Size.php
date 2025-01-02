<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('size_id', 'code_size');
    }
    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }
}
