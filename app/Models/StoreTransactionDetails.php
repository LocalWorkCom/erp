<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTransactionDetail extends Model
{
    use HasFactory;

    public function storeTransactions()
    {
        return $this->belongsTo(StoreTransactions::class ,'store_transaction_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class ,'product_id');
    }

    public function units()
    {
        return $this->belongsTo(Unit::class ,'unit_id');
    } 

    public function countries()
    {
        return $this->belongsTo(Country::class ,'country_id');
    }

}
