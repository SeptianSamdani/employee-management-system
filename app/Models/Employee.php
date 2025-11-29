<?php

// app/Models/Employee.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'employee_number',
        'full_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'identity_number',
        'department_id',
        'position_id',
        'join_date',
        'resign_date',
        'employment_status',
        'status',
        'photo',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'join_date' => 'date',
        'resign_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    public function leaveBalances(): HasMany
    {
        return $this->hasMany(EmployeeLeaveBalance::class);
    }

    // TAMBAHKAN RELATIONSHIP INI
    public function documents(): HasMany
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    // Helper method
    public function getActiveStatusAttribute(): string
    {
        return $this->status === 'active' ? 'Aktif' : 'Tidak Aktif';
    }
    
    public function getDocumentCompletenessAttribute(): array
    {
        $requiredDocs = ['ktp', 'npwp', 'bpjs_kesehatan', 'bpjs_ketenagakerjaan'];
        $uploaded = $this->documents()->pluck('type')->toArray();
        
        $missing = array_diff($requiredDocs, $uploaded);
        $total = count($requiredDocs);
        $completed = $total - count($missing);
        
        return [
            'percentage' => ($completed / $total) * 100,
            'completed' => $completed,
            'total' => $total,
            'missing' => $missing,
        ];
    }
}