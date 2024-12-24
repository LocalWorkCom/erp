<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchMenuSize extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dish_id',
        'branch_id',
        'dish_size_id',
        'price',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function dishSizes()
    {
        return $this->belongsTo(DishSize::class, 'dish_size_id');
    }

    public function dishes()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

}
