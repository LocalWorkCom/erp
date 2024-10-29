<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['name'];

    protected $hidden = ['name_ar', 'name_en', 'created_by', 'modified_by', 'deleted_by', 'deleted_at', 'updated_at', 'created_at'];

    public function getNameAttribute($value){
        return $this->name = (Request()->server('lang') == "en") ? $this->name_en : $this->name_ar;
    }

    public function floors()
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }
}
