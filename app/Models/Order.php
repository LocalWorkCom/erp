<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    // Table associated with the model
    protected $table = 'orders';

    // The attributes that are mass assignable
    protected $fillable = [
        'status',
        'type',
        'note',
        'order_number',
        'tax_value',
        'fees',
        'delivery_fees',
        'total_price_befor_tax',
        'total_price_after_tax',
        'client_id',
        'table_id',
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

    // Define relationships
    public function Client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function Table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }
}