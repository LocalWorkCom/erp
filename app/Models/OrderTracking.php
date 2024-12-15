<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTracking extends Model
{
    use HasFactory, SoftDeletes;

    // Table associated with the model
    protected $table = 'order_trackings';

    // The attributes that are mass assignable
    protected $fillable = [
        'order_status',
        'order_id',
        
    ];

    protected $hidden = [
        'created_by',
        'deleted_by',
        'updated_at',
        'modify_by',
        'deleted_at',


    ];

    // // The attributes that should be cast to native types
    // protected $casts = [
    //     'is_valid' => 'boolean',
    // ];

    // Define relationships
   
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    

}
