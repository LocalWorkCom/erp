<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuisine extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'image_path',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    protected $hidden = [
        'created_by',
        'modified_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Relationships
    public function dishes()
    {
        return $this->hasMany(Dish::class);
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
    
    // Scope to get only active cuisines
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
