<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchMenuAddonCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['min_addons', 'max_addons'];

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

    public function getMinAddonsAttribute()
    {
        $min_addons = 0;
        if($this->branchMenuAddon){
            if($this->branchMenuAddon->dishAddons){
                $min_addons = $this->branchMenuAddon->dishAddons->min_addons;
                return $min_addons;
            }
        }
    }

    public function getMaxAddonsAttribute()
    {
        $max_addons = 0;
        if($this->branchMenuAddon){
            if($this->branchMenuAddon->dishAddons){
                $max_addons = $this->branchMenuAddon->dishAddons->max_addons;
                return $max_addons;
            }
        }
    }

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

    public function branchMenuAddon()
    {
        return $this->hasOne(BranchMenuAddon::class, 'branch_menu_addon_category_id');
    }
}
