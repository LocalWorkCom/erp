<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchMenuAddonCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_id',
        'addon_category_id',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function addonCategories()
    {
        return $this->belongsTo(AddonCategory::class, 'addon_category_id');
    }

    public function branchMenuAddons()
    {
        return $this->hasMany(BranchMenuAddon::class, 'branch_menu_addon_category_id');
    }
}
