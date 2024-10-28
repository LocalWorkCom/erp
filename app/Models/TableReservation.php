<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TableReservation extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['created_by', 'modified_by', 'deleted_by', 'deleted_at', 'updated_at', 'created_at'];

    public function tables()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    public function clients()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
