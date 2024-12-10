<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name_ar',
        'name_en',
        'description_ar',
        'description_en',
        'image',
        'flag',
        'dish_id',
        'offer_id',
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
}
