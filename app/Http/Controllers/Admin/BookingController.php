<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bookings = Booking::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('handphone', 'LIKE', "%{$search}%")
            ->orWhere('service_name', 'LIKE', "%{$search}%")
            ->orWhere('category', 'LIKE', "%{$search}%")
            ->orWhere('status', 'LIKE', "%{$search}%")
            ->orWhereHas('schedule', function ($query) use ($search) {
                $query->withTrashed()->where('date', 'LIKE', "%{$search}%")
                    ->orWhere('start_time', 'LIKE', "%{$search}%")
                    ->orWhere('end_time', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.booking.index', compact('bookings'));
    }

    public function view($id)
    {
        $booking = Booking::with(['schedule' => function($query) {
            $query->withTrashed();
        }])->findOrFail($id);

        return view('admin.booking.view', compact('booking'));
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.booking.index')->with('message', 'Booking deleted successfully.');
    }

    
}
