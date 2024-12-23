<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delay extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'time_id',
        'employee_id',
        'note',
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

    public function time(){
        return $this->belongsTo(DelayTime::class, 'time_id')->withTrashed();
    }
    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id')->withTrashed();
    }

    public function delayDeductions(){
        return $this->hasMany(DelayDeduction::class, 'delay_id')->withTrashed();
    }
}
