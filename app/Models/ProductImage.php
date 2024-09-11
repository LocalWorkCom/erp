<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_images';

    protected $fillable = [
        'product_id',
        'image',
        'created_by',
        'deleted_by',
    ];

    /**
     * Get the product that owns the image.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that created the image.
     */
    public function creatorby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user that deleted the image.
     */
    public function deletedby()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
