<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Excuse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'reason',
        'date',
        'start_time',
        'end_time',
        'requested_time',
        'status',
        'approver_id',
        'approved_date',
        'rejection_reason',
        'is_paid',
        
        'excuse_request_id' 
    ];

    protected $hidden = [
        'created_by',
        'modified_by',
        'created_by',
        'modified_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modifier()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    // New relationship with ExcuseRequest
    public function excuseRequest()
    {
        return $this->belongsTo(ExcuseRequest::class, 'excuse_request_id');
    }

    // Scopes for different statuses
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
