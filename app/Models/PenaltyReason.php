<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenaltyReason extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'reason_ar',
        'reason_en',
        'punishment_ar',
        'punishment_en',
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

    public function penalties()
    {
        return $this->hasMany(Penalty::class, 'reason_id');
    }
}
