<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DelayTime extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'time',
        'type',
        'punishment_ar',
        'punishment_en',
        'created_by',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'modified_by',
        'deleted_by',
    ];

    public function delays()
    {
        return $this->hasMany(Delay::class, 'delay_time_id');
    }
}
