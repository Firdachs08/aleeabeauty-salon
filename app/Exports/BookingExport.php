<?php

namespace App\Exports;

use App\Models\Booking;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingsExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Booking::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select('created_at', 'name', 'category', 'service_name', 'total')
            ->get();
    }

    public function headings(): array
    {
        return ['Date', 'User', 'Category', 'Service', 'Price'];
    }
}
