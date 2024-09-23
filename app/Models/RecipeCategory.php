<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecipeCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'parent_id',
        'image_path',
        'is_active',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    // Relationships

    // Self-referential relationship for parent category
    public function parent()
    {
        return $this->belongsTo(RecipeCategory::class, 'parent_id');
    }

    // Self-referential relationship for child categories
    public function children()
    {
        return $this->hasMany(RecipeCategory::class, 'parent_id');
    }

    // Relationship with recipes
    public function recipes()
    {
        return $this->hasMany(Recipe::class, 'category_id');
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
