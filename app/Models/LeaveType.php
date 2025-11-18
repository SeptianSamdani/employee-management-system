<?php

// app/Models/LeaveType.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveType extends Model
{
    protected $fillable = [
        'name',
        'code',
        'max_days',
        'is_paid',
        'description',
        'is_active',
    ];

    protected $casts = [
        'max_days' => 'integer',
        'is_paid' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }
}