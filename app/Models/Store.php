<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Store extends Model
{
    use HasFactory, SoftDeletes; // Use SoftDeletes

  
    protected $fillable = [
        'branch_id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'is_freeze',
        'is_kitchen',
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

    protected $dates = ['deleted_at']; // To handle soft deletes

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function lines()
    {
        return $this->hasMany(Line::class);
    }
    public function storeCategories()
    {
        return $this->hasMany(StoreCategory::class);
    }

    public function categories()
    {
        return $this->hasManyThrough(Category::class, StoreCategory::class, 'store_id', 'id', 'id', 'category_id');
    }
}
