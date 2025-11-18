<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
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

        return view('dashboard', compact('stats'));
    }
}