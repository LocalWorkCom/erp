<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_details';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'address_id',
        'image',
        'date_of_birth',
        'is_active',
        'loyalty_points',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addresses()
    {
        return $this->hasMany(ClientAddress::class, 'client_details_id');
    }
}
