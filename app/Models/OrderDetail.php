<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    // Table associated with the model
    protected $table = 'order_details';

    // The attributes that are mass assignable
    protected $fillable = [
        'status',
        'quantity',
        'total',
        'price_befor_tax',
        'price_after_tax',
        'tax_value',
        'note',
        'order_id',
        'addon_id',
        'unit_id',
        'recipe_id',
        'product_id'
    ];

    protected $hidden = [
        'created_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'modify_by',
        'deleted_at',


    ];

    // // The attributes that should be cast to native types
    // protected $casts = [
    //     'is_valid' => 'boolean',
    // ];

    // Define relationships
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function Unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function Recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
