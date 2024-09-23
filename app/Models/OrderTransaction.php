<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTransaction extends Model
{
    use HasFactory, SoftDeletes;

    // Table associated with the model
    protected $table = 'order_transactions';

    // The attributes that are mass assignable
    protected $fillable = [
        'payment_status',
        'payment_method',
        'transaction_id',
        'paid',
        'date',
        'refund',
        'order_id',
        'coupon_id',
        'discount_id'
    ];

    protected $hidden = [
        'created_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'modify_by',
        'deleted_at',


    ];

    // The attributes that should be cast to native types
    // protected $casts = [
    //     'is_valid' => 'boolean',
    // ];

    // Define relationships
   
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    
}
