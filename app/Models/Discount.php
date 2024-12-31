<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['name'];

    protected $fillable = [
        'name_en',
        'name_ar',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by'
    ];

    protected $hidden = [
        'name_en',
        'name_ar',
        'created_by',
        'modified_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function getNameAttribute()
    {
        return request()->header('lang', 'ar') === 'en' ? $this->name_en : $this->name_ar;
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

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    public function getTypeLabelAttribute()
    {
        return $this->type === 'percentage' ? 'Percentage' : 'Fixed Amount';
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_discount');
    }

    // public function dishes()
    // {
    //     return $this->belongsToMany(Dish::class, 'dish_discount');
    // }
    public function dishDiscounts()
    {
        return $this->hasMany(DishDiscount::class);
    }

    public function discount_dishes()
    {
        return $this->belongsToMany(Dish::class, 'dish_discount')
            ->withPivot('dish_id') // Include all necessary pivot fields
            ->wherePivotNull('deleted_at') // Exclude deleted entries
            ->withTimestamps(); // Optional: if your pivot table has timestamps
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'dish_discount', 'discount_id', 'dish_id')
            ->whereNull('dish_discount.deleted_at'); // Ensure only non-deleted dishes
    }
    public function slider_discounts()
    {
        return $this->hasMany(DishDiscount::class);
    }
}
