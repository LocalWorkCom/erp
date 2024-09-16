<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    use HasFactory;

    protected $hidden = ['product_id', 'store_id', 'created_by', 'deleted_by', 'created_at', 'updated_at'];

    public function stores()
    {
        return $this->belongsTo(Store::class ,'store_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class ,'product_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
