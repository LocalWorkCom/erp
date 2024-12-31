<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishDiscount extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'dish_discount';

    protected $fillable = [
        'dish_id',
        'discount_id',
        'created_by'
    ];

    protected $hidden = [
        'created_by',
        'modify_by',
        'deleted_at',
        'deleted_by',
        'created_at',
        'updated_at',
    ];

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id')->whereNull('deleted_at');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id')->whereNull('deleted_at');
    }
}
