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

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
