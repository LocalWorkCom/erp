<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTransaction extends Model
{
    use HasFactory;

    public function creatorBy()
    {
        return $this->belongsTo(User::class, 'creator_by');
    }

    public function toId()
    {
        return $this->belongsTo(Store::class ,'to_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function storeTransactionDetails()
    {
        return $this->hasMany(StoreTransactionDetails::class ,'id');
    }
    
}
