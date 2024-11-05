<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penalty extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'reason_id',
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

    public function reason(){
        return $this->belongsTo(PenaltyReason::class, 'reason_id')->withTrashed();
    }
    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id')->withTrashed();
    }
}
