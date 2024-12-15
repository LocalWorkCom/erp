<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnit extends Model
{
    use HasFactory ,SoftDeletes;

    protected $table = 'product_units';

    protected $fillable = [
        'unit_id',
        'product_id',
        'factor',
        'created_by',
    ];

    protected $hidden = [
        'created_by',
        'modify_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',

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

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class, 'product_unit_id');
    }
}
