<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchMenuAddon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_id',
        'dish_addon_id',
        'dish_id',
        'branch_menu_addon_category_id',
        'price',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function dishes()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

    public function dishAddons()
    {
        return $this->belongsTo(DishAddon::class, 'dish_addon_id');
    }

    public function branchMenuAddonCategories()
    {
        return $this->belongsTo(BranchMenuAddonCategory::class, 'branch_menu_addon_category_id');
    }
}
