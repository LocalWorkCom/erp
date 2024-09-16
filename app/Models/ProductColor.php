<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $table = 'product_colors'; // Optional if the table name follows Laravel's convention

    protected $fillable = [
        'color_id',
        'product_id',
    ];
    
    protected $hidden = [
        'created_by',
        'modify_by',

        'deleted_by',
        'created_at',
        'updated_at',
    ];
    /**
     * Get the color associated with the product color.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    /**
     * Get the product associated with the product color.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
