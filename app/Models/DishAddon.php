<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishAddon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dish_id',
        'addon_id',
        'quantity',
        'price',
        'addon_category_id', 
        'min_addons',        
        'max_addons',   
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }



    public function addons()
    {
        return $this->belongsTo(Recipe::class, 'addon_id');
    }
    public function addon()
{
    return $this->belongsTo(Recipe::class, 'addon_id');
}
    public function category()
    {
        return $this->belongsTo(AddonCategory::class, 'addon_category_id');
    }
}
