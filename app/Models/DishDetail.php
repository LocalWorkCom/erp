<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DishDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'dish_id',
        'recipe_id',
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
}
