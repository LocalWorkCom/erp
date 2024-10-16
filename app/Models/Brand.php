<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'logo_path',  // Path for brand logo
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

    /**
     * Get the creator of the brand.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the modifier of the brand.
     */
    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    /**
     * Get the deleter of the brand.
     */
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Define a relationship with products (if each product belongs to a brand).
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}
