<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    use HasFactory;

    protected $table = 'store_category'; 

    protected $fillable = [
        'store_id',
        'category_id',
       
    ];

    public $timestamps = true; 
}
