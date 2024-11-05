<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeOpeningBalance extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['total_opening', 'total_closing', 'total_realing', 'total_deficiting'];

    protected $hidden = ['created_by', 'modified_by', 'deleted_by', 'deleted_at', 'updated_at', 'created_at'];

    public function getTotalOpeningAttribute($value){
        return $total_opening = ($this->open_cash + $this->open_visa);
    }

    public function getTotalClosingAttribute($value){
        return $total_closing = ($this->close_cash + $this->close_visa);
    }

    public function getTotalRealingAttribute($value){
        return $total_realing = ($this->real_cash + $this->real_visa);
    }

    public function getTotalDeficitingAttribute($value){
        return $total_deficiting = ($this->deficit_cash + $this->deficit_visa);
    }

    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function employeeSchedules()
    {
        return $this->belongsTo(EmployeeSchedule::class, 'employee_schedule_id', 'id');
    }

}
