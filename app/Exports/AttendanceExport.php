<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $search;
    protected $dateFrom;
    protected $dateTo;
    protected $status;
    protected $departmentId;

    public function __construct($search, $dateFrom, $dateTo, $status, $departmentId)
    {
        $this->search = $search;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->status = $status;
        $this->departmentId = $departmentId;
    }

    public function collection()
    {
        return Attendance::query()
            ->with(['employee:id,employee_number,full_name,department_id', 'employee.department:id,name'])
            ->when($this->search, fn($q) => 
                $q->whereHas('employee', fn($q2) => 
                    $q2->where('full_name', 'like', "%{$this->search}%")
                        ->orWhere('employee_number', 'like', "%{$this->search}%")
                )
            )
            ->when($this->departmentId, fn($q) =>
                $q->whereHas('employee', fn($q2) =>
                    $q2->where('department_id', $this->departmentId)
                )
            )
            ->when($this->dateFrom, fn($q) => $q->where('date', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->where('date', '<=', $this->dateTo))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->latest('date')
            ->get();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
            'Departemen',
            'Tanggal',
            'Check In',
            'Check Out',
            'Status',
            'Terlambat (Menit)',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->employee->employee_number,
            $attendance->employee->full_name,
            $attendance->employee->department->name,
            $attendance->date->format('d/m/Y'),
            $attendance->check_in ?? '-',
            $attendance->check_out ?? '-',
            ucfirst($attendance->status),
            $attendance->late_minutes ?? 0,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}