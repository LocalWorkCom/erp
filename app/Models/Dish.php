<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dish extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'category_id',
        'cuisine_id',
        'price',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    protected $hidden = [
        'created_by',
        'modified_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function dishCategory()
    {
        return $this->belongsTo(DishCategory::class, 'category_id');
    }

    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }

    public function recipes()
    {
        return $this->hasMany(DishDetail::class, 'dish_id');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_dish');
    }

    public function addons()
    {
        return $this->belongsToMany(Dish::class, 'dish_addons', 'dish_id', 'addon_id');
    }
}
