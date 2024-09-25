<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderAddon extends Model
{
    use HasFactory, SoftDeletes;

    // Table associated with the model
    protected $table = 'order_addons';

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
        return $this->belongsTo(RecipeAddon::class, 'recipe_addon_id');
    }
}
