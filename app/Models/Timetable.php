<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Timetable extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['name']; 
    protected $fillable = [
        'name_en',
        'name_ar',
        'on_duty_time',
        'off_duty_time',
        'start_sign_in',
        'end_sign_in',
        'start_sign_out',
        'end_sign_out',
        'lateness_grace_period',
        'start_late_time_option',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    protected $hidden = [
        'name_en',
        'name_ar',
        'created_by',
        'modified_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    
    public function getNameAttribute()
    {
        return request()->header('lang', 'ar') == 'en' ? $this->name_en : $this->name_ar;
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
