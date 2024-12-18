<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'dish_id',
        'recipe_id',
        'dish_size_id',
        'quantity',
    ];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
    public function size()
    {
        return $this->belongsTo(DishSize::class, 'dish_size_id');
    }
}
