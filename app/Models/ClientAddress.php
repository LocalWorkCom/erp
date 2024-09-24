<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'is_default',
        'is_active',
    ];

    public function clientDetail()
    {
        return $this->belongsTo(ClientDetail::class, 'client_details_id');
    }
}
