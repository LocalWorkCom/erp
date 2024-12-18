<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchMenuCategory extends Model
{
    use HasFactory, SoftDeletes;

    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function dish_categories()
    {
        return $this->belongsTo(DishCategory::class, 'dish_category_id');
    }

    public function children()
    {
        return $this->hasMany(BranchMenuCategory::class, 'parent_id');
    }
}
