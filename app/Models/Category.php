<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'image',
        'active',
        'code',
        'is_freeze',
        'parent_id',
        'is_deleted',

    ];

    
    protected $hidden = [
        'created_by',
        'deleted_by',
        'modify_by',

        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'active' => 'boolean',
        'is_freeze' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    /**
     * Get the parent category for this category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the creator of this category.
     */
    public function creatorby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }
    /**
     * Get the user who deleted this category.
     */
    public function deletedby()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
