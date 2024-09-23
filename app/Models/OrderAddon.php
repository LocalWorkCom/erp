<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    // Table associated with the model
    protected $table = 'orders';

    // The attributes that are mass assignable
    protected $fillable = [
        'price',
        'quantity',
        'order_id',
        'recipe_addon_id'
    ];

    protected $hidden = [
        'created_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'modify_by',
        'deleted_at',


    ];

    // Define relationships
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function Addon()
    {
        return $this->belongsTo(Addon::class, 'addon_id');
    }
}
