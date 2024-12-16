<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSize extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [
        'size_id',
        'product_id',
        'code_size',
        'created_by',

    ];
    
    protected $hidden = [
        'created_by',
        'deleted_by',
        'modify_by',
        'created_at',
        'updated_at',
        'deleted_at',

    ];
    /**
     * Get the size associated with the product size.
     */
    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    /**
     * Get the product associated with the product size.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
