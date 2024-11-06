<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'employee_id',
        'base_salary',
        'bonus',
        'deductions',
        'taxes',
        'insurance',
        'advance',
        'net_salary',
        'pay_date',
        'created_by',
        'modified_by',
        'deleted_by',

    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'modified_by',
        'deleted_by',
    ];
    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id')->withTrashed();
    }


}
