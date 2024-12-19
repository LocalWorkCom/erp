<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DishDiscount extends Model
{
    use HasFactory;
    protected $table = 'dish_discount';

    protected $fillable = [
        'dish_id',
        'discount_id',
    ];

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
