<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['name', 'address'];

    protected $fillable = [
        'name_en',
        'name_ar',
        'address_en',
        'address_ar',
        'latitute',
        'longitute',
        'country_id',
        'phone',
        'email',
        'manager_name',
        'opening_hour',
        'closing_hour',
        'has_kids_area',
        'is_delivery',
        'created_by',
        'modified_by',
        'deleted_by'
    ];

    protected $hidden = [
        'name_en',
        'name_ar',
        'address_en',
        'address_ar',
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

    public function getAddressAttribute()
    {
        return request()->header('lang', 'ar') === 'en' ? $this->address_en : $this->address_ar;
    }

    // Relationships
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'branch_recipe');
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class, 'branch_dish');
    }

    public function floors()
    {
        return $this->hasMany(Floor::class, 'branch_id');
    }
}
