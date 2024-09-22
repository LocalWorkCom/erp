<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTransactionDetails extends Model
{
    use HasFactory;

    //protected $hidden = ['store_transaction_id', 'product_id', 'product_unit_id', 'product_size_id', 'product_color_id', 'country_id', 'created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    public function storeTransactions()
    {
        return $this->belongsTo(StoreTransaction::class ,'store_transaction_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function units()
    {
        return $this->belongsTo(Unit::class, 'product_unit_id');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
