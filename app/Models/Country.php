<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Country extends Model
{
    use HasFactory ,SoftDeletes;
    protected $appends = ['name', 'code', 'currency'];

    protected $fillable = [
        'name_ar',
        'name_en',
        'code',
        'currency_ar',
        'currency_en',
        'currency_code',
        'job_years'
    ];


    protected $hidden = [
        'created_by',
        'deleted_by',
        'modify_by',
        'deleted_at',
        'created_at',
        'updated_at',
        'name_ar',
        'name_en',
        'code',
        'currency_ar',
        'currency_en',
        'job_years'

    ];
    public function getNameAttribute($value)
    {
        return Request()->header('lang') == "en" ? $this->name_en : $this->name_ar;
    }
    public function getCurrencyAttribute($value)
    {
        return Request()->header('lang') == "en" ? $this->currency_en : $this->currency_ar;
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
