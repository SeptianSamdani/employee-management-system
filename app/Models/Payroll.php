<?php

// app/Models/Payroll.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'period',
        'basic_salary',
        'allowances',
        'overtime_pay',
        'bonus',
        'deductions',
        'net_salary',
        'total_working_days',
        'total_present_days',
        'total_absent_days',
        'total_late_days',
        'status',
        'paid_at',
        'generated_by',
        'notes',
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'allowances' => 'decimal:2',
        'overtime_pay' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deductions' => 'decimal:2',
        'net_salary' => 'decimal:2',
        'total_working_days' => 'integer',
        'total_present_days' => 'integer',
        'total_absent_days' => 'integer',
        'total_late_days' => 'integer',
        'paid_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function generator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}