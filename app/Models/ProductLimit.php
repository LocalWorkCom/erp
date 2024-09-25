<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLimit extends Model
{
    use HasFactory;

    protected $table = 'product_limit';

    protected $fillable = [
        'min_limit',
        'max_limit',
        'product_id',
        'store_category_id'
    ];
    
        
    protected $hidden = [
        'created_by',
        'deleted_by',
        'created_at',
        'modify_by',
        'updated_at',
        'deleted_at',

    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function storeCategory()
    {
        return $this->belongsTo(StoreCategory::class, 'store_category_id');
    }
}
