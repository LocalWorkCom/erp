<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishSize extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dish_id',
        'size_name_en',
        'size_name_ar',
        'price',
    ];

    /**
     * Get the dish associated with the size.
     */
    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
