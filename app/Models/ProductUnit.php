<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;

    protected $table = 'product_units';

    protected $fillable = [
        'unit_id',
        'product_id',
        'factor',
        'price',
    ];

    // Define relationships
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
