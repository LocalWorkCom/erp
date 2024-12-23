<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchMenu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_id',
        'dish_id',
        'price',
        'branch_menu_category_id',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Relationships
    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function branchMenuCategories()
    {
        return $this->belongsTo(BranchMenuCategory::class, 'branch_menu_category_id');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'dish_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
