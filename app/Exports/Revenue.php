<?php

namespace App\Exports;

use App\Models\Booking;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;

class RevenueExport implements FromCollection
{
    public function collection()
    {
        // Retrieve data from Booking and Order models
        $bookings = Booking::all();
        $orders = Order::all();

        // Merge data from bookings and orders into one collection
        $data = $bookings->merge($orders);

        return $data;
    }
}
