<?php

namespace App\Http\Controllers\Admin;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\Order;
use App\Models\Booking;
use App\Exports\RevenueExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ReportController extends Controller
{
    
    public function print(Request $request)
    {
        $startDate = Carbon::parse($request->input('start'))->startOfDay();
        $endDate = Carbon::parse($request->input('end'))->endOfDay();
        
        $bookings = Booking::whereBetween('created_at', [$startDate, $endDate])->get();
        
        $totalRevenuePerService = [];
        foreach ($bookings as $record) {
            if (isset($record->service_name)) {
                if (!isset($totalRevenuePerService[$record->service_name])) {
                    $totalRevenuePerService[$record->service_name] = 0;
                }
                $totalRevenuePerService[$record->service_name] += $record->total;
            }
        }

        return view('admin.reports.print', compact('bookings', 'startDate', 'endDate', 'totalRevenuePerService'));
    }

    public function download(Request $request)
    {
        $startDate = Carbon::parse($request->input('start'))->startOfDay();
        $endDate = Carbon::parse($request->input('end'))->endOfDay();

        return Excel::download(new RevenueExport($startDate, $endDate), 'revenue_report.xlsx');
    }

    public function revenue()
    {
        $bookings = Booking::all();
        return view('admin.reports.revenue', compact('bookings'));
    }
    public function totalRevenue(Request $request)
    {
        $bookings = Booking::all(); // Ganti sesuai logika bisnis Anda untuk mendapatkan bookings
        return view('admin.reports.total-revenue', compact('bookings'));
    }

    public function orderReport(Request $request)
    {
        $startDate = Carbon::parse($request->input('start'))->startOfDay();
        $endDate = Carbon::parse($request->input('end'))->endOfDay();

        $orders = Order::whereBetween('created_at', [$startDate, $endDate])->get();

        return view('admin.reports.orders', compact('orders', 'startDate', 'endDate'));
    }
}
