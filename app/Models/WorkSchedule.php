<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    protected $fillable = ['department_id', 'check_in_start', 'check_in_end', 
                          'check_out_start', 'check_out_end', 'late_tolerance_minutes', 'work_days'];
    protected $casts = ['work_days' => 'array'];
    
    public function department() {
        return $this->belongsTo(Department::class);
    }
}
