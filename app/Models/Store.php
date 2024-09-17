<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes

class Store extends Model
{
    use HasFactory, SoftDeletes; // Use SoftDeletes

    protected $fillable = [
        'branch_id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'created_by',
        'modified_by',
        'deleted_by'
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
}
