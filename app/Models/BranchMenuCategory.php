<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchMenuCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dish_category_id',
        'parent_id',
        'branch_id',
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

    public function dish_categories()
    {
        return $this->belongsTo(DishCategory::class, 'dish_category_id');
    }

}
