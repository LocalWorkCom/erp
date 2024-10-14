<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoicesDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_invoices_id',
        'category_id',
        'product_id',
        'unit_id',
        'price',
        'quantity',
        'total_price'
    ];

    public function PurchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoices_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
