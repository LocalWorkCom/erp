<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DishSize extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['name_site']; 

    protected $fillable = [
        'dish_id',
        'size_name_en',
        'size_name_ar',
        'price',
        'default_size'
       
    ];

    public function getNameSiteAttribute()
    {
        return app()->getLocale() === 'en' ? $this->size_name_en : $this->size_name_ar;
    }

    /**
     * Get the dish associated with the size.
     */
    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
    public function details()
    {
        return $this->hasMany(DishDetail::class);
    }
}
