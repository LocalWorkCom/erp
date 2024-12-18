<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchMenuAddon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'menu_id',
        'branch_id',
        'dish_addon_id',
        'addon_category_id',
        'price',
        'quantity',
        'min_addons',
        'max_addons',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
