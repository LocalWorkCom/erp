<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfferDetail extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'offer_id',
        'offer_type',
        'type_id',
        'count',
        'discount',
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

    public function offer()
    {
        return $this->belongsTo(Offer::class,'offer_id','id');
    }
}
