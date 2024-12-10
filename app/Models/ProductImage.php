<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory ,SoftDeletes;

    protected $table = 'product_images';
    protected $appends = ['main'];
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id',
        'image',

    ];

        
    protected $hidden = [
        'created_by',
        'deleted_by',
        'created_at',
        'modify_by',
        'updated_at',
        'deleted_at',
        'image'

    ];
    public function getMainAttribute($value)
    {
        return BaseUrl() . '/' . $this->image;
    }
    
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
