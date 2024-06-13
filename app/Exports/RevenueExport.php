<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RevenueExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $startDate;
    protected $endDate;
    protected $totalRevenuePerService;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->calculateTotalRevenuePerService();
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

    public function map($row): array
    {
        return [
            $row->created_at,
            $row->name,
            $row->category,
            $row->service_name,
            $row->total
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();
                $row = $highestRow + 2;

                // Append total revenue per service headers
                $sheet->insertNewRowBefore($row, 2);
                $sheet->setCellValue("A{$row}", 'Total Revenue per Service');
                $sheet->setCellValue("A" . ($row + 1), 'Service');
                $sheet->setCellValue("B" . ($row + 1), 'Total Revenue');

                // Append total revenue per service data
                $currentRow = $row + 2;
                foreach ($this->totalRevenuePerService as $service => $total) {
                    $sheet->insertNewRowBefore($currentRow, 1);
                    $sheet->setCellValue("A{$currentRow}", $service);
                    $sheet->setCellValue("B{$currentRow}", $total);
                    $currentRow++;
                }

                // Mengatur format kolom angka
                $sheet->getStyle("E2:E{$highestRow}")
                      ->getNumberFormat()
                      ->setFormatCode('#,##0'); // Format angka dengan ribuan pemisah dan tanpa desimal

                // Mengatur format untuk kolom Total Revenue
                $sheet->getStyle("B{$row}:B{$currentRow}")
                      ->getNumberFormat()
                      ->setFormatCode('#,##0'); // Format angka dengan ribuan pemisah dan tanpa desimal
            }
        ];
    }

    private function calculateTotalRevenuePerService()
    {
        $bookings = Booking::whereBetween('created_at', [$this->startDate, $this->endDate])->get();
        $this->totalRevenuePerService = [];

        foreach ($bookings as $record) {
            if (isset($record->service_name)) {
                if (!isset($this->totalRevenuePerService[$record->service_name])) {
                    $this->totalRevenuePerService[$record->service_name] = 0;
                }
                $this->totalRevenuePerService[$record->service_name] += $record->total;
            }
        }
    }
}
