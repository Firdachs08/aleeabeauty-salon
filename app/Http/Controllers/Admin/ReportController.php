<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Order;
use App\Exports\RevenueExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{
    public function export(Request $request)
    {
        $exportType = $request->input('export');

        if ($exportType == 'pdf') {
            $data = Booking::all()->merge(Order::all());
            $startDate = $data->min('created_at')->format('Y-m-d'); // Tanggal pertama
            $endDate = $data->max('created_at')->format('Y-m-d');

            $pdf = PDF::loadView('admin.reports.exports.revenue_pdf', compact('data', 'startDate', 'endDate'));
            return $pdf->download('revenue_report.pdf');
        } elseif ($exportType == 'xlsx') {
            return Excel::download(new RevenueExport(), 'revenue_report.xlsx');
        }
    }
}
