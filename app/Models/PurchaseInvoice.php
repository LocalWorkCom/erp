<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseInvoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'invoice_number',
        'vendor_id',
        'type',
        'store_id',
        'created_by',
        'modified_by',
        'deleted_by'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function purchaseInvoicesDetails()
    {
        return $this->hasMany(PurchaseInvoicesDetails::class, 'purchase_invoices_id', 'id');
    }
}
