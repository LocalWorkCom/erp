<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FloorPartition extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['name', 'exist_table'];

    protected $hidden = ['name_ar', 'name_en', 'created_by', 'modified_by', 'deleted_by', 'deleted_at', 'updated_at', 'created_at'];

    public function getNameAttribute($value){
        return Request()->header('lang') == "en" ? $this->name_en : $this->name_ar;
    }

    public function getExistTableAttribute($value){
        return $this->tables->count();
    }

    public function tables()
    {
        return $this->hasMany(Table::class, 'floor_partition_id', 'id');
    }

    public function floors()
    {
        return $this->belongsTo(Floor::class, 'floor_id', 'id');
    }

}
