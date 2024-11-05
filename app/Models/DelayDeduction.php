<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DelayDeduction extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'delay_id',
        'deduction_amount',
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

    public function delay()
    {
        return $this->belongsTo(Delay::class, 'delay_id')->withTrashed();
    }
}
