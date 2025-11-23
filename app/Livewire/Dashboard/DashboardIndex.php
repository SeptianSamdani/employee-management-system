<?php

namespace App\Livewire\Dashboard;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use Livewire\Component;

class DashboardIndex extends Component
{
    public function render()
    {
        $stats = [
            'total_employees' => Employee::where('status', 'active')->count(),
            'present_today' => Attendance::whereDate('date', today())
                ->where('status', 'present')
                ->count(),
            'pending_leaves' => Leave::where('status', 'pending')->count(),
            'on_leave_today' => Leave::where('status', 'approved')
                ->whereDate('start_date', '<=', today())
                ->whereDate('end_date', '>=', today())
                ->count(),
        ];

        return view('livewire.dashboard.dashboard-index', compact('stats'));
    }
}