<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'type',
        'value',
        'minimum_spend',
        'usage_limit',
        'count_usage',
        'start_date',
        'end_date',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by'
    ];

    protected $hidden = [
        'created_by',
        'modified_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

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


 // Scope to get only active coupons
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

    // Check if the coupon has been fully used
    public function isUsedUp()
    {
        return $this->usage_limit && $this->count_usage >= $this->usage_limit;
    }

      // Method to increment count usage
      public function incrementUsage()
    {
        $this->count_usage++;
        $this->save();
    }

      // Function to get coupon type label
      public function getTypeLabelAttribute()
    {
        return $this->type === 'percentage' ? 'Percentage' : 'Fixed Amount';
    }
}
