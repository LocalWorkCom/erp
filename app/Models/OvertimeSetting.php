<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OvertimeSetting extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['created_by', 'modified_by', 'deleted_by', 'deleted_at', 'updated_at', 'created_at'];

    public function overtimes()
    {
        return $this->belongsTo(OvertimeType::class, 'overtime_type_id');
    }
}
