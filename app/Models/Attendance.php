<?php

// app/Models/Attendance.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'notes',
        'latitude_in',
        'longitude_in',
        'latitude_out',
        'longitude_out',
    ];

    protected $casts = [
        'date' => 'date',
        'latitude_in' => 'decimal:8',
        'longitude_in' => 'decimal:8',
        'latitude_out' => 'decimal:8',
        'longitude_out' => 'decimal:8',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}