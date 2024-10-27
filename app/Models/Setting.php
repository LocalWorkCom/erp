<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_transfer_method',
        'tax_application',
        'tax_percentage',
        'pricing_method',
        'coupon_application',
        'store_use'
    ];
}
