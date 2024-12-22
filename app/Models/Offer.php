<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'branch_id',
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'image_ar',
        'image_en',
        'is_active',
        'start_date',
        'end_date',
        'discount_type',
        'discount_value',
        'created_by',
        'modified_by',
        'deleted_by',

    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    public function details()
    {
        return $this->hasMany(OfferDetail::class,'offer_id','id')->where('deleted_at',null);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
