<?php

namespace App\Http\Controllers;
use Midtrans\Config;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'handphone' => 'required|numeric',
        'category' => 'required',
        'schedule_id' => 'required|exists:schedules,id',
    ]);

    $schedule = Schedule::find($request->schedule_id);
    $scheduleId = $schedule->id; 
    $currentBookings = Booking::where('schedule_id', $request->schedule_id)->count();

    if ($currentBookings >= $schedule->max_slot) {
        return redirect()->back()->with('error', 'Schedule is fully booked');
    }

    $date = $schedule->date;
    $time = $schedule->time;

    // Periksa apakah hanya satu metode pembayaran yang dipilih
    if ($request->cash && $request->cashless) {
        return redirect()->back()->with('error', 'Hanya pilih satu metode pembayaran');
    }

    // Set status berdasarkan metode pembayaran yang dipilih
$status = $request->cash ? 'Cash' : 'Cashless';

$booking = Booking::create([
    'service_name' => $request->service_name,
    'name' => $request->name,
    'handphone' => $request->handphone,
    'category' => $request->category,
    'date' => $date,
    'time' => $time,
    'total' => $request->price,
    'status' => $status === 'Cashless' ? 'Unpaid' : 'Paid', // Ubah status sesuai dengan metode pembayaran yang dipilih
    'schedule_id' => $request->schedule_id,
    'order_id' => Str::uuid(),
]);

if ($currentBookings + 1 >= $schedule->max_slot) {
    $schedule->status = 'not available';
    $schedule->save();
}

// Jika pembayaran dilakukan menggunakan cash, langsung tampilkan halaman pembayaran
if ($status === 'Cash') {
    $booking->update(['status' => 'Cash']);
    return view('frontend.booking.paycash', compact('booking'));
}

// Jika pembayaran dilakukan menggunakan cashless, langsung ubah status menjadi Paid
if ($status === 'Cashless') {
    $booking->update(['status' => 'Paid']);
    // Lanjutkan dengan logika untuk pembayaran cashless
}



    // Set your Merchant Server Key
    \Midtrans\Config::$serverKey = config('midtrans.serverKey');
    // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    \Midtrans\Config::$isProduction = false;
    // Set sanitization on (default)
    \Midtrans\Config::$isSanitized = true;
    // Set 3DS transaction for credit card to true
    \Midtrans\Config::$is3ds = true;

    $params = array(
        'transaction_details' => array(
            'order_id' => Str::random(15),
            'gross_amount' => $request->price,
        ),
        'customer_details' => array(
            'name' => $request->name,
            'handphone' => $request->handphone,
        ),
    );

    $snapToken = \Midtrans\Snap::getSnapToken($params);

    return view('frontend.booking.detail', compact('snapToken', 'booking', 'scheduleId'));
}



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $schedules = Schedule::where(['status' => 'available'])->get();
        return view('frontend.booking.index', compact('service', 'schedules'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }

    public function midtrans_callback(Request $request)
    {
        $serverKey = config('midtrans.serverKey');
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture') {
                $booking = Booking::find($request->order_id);
                $booking->update(['status' => 'Paid']);
            }
        }
    }

    public function payment_success($bookingId, $scheduleId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->update(['status' => 'Paid']); // Update status pembayaran menjadi "Paid"
    
        $schedule = Schedule::findOrFail($scheduleId);
        //$schedule->update(['status' => 'booked']);
    
        return redirect()->route('booking.print', ['bookingId' => $booking->id]); // Redirect ke halaman struk pembayaran
    }
    
    public function showBooking($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        return view('frontend.booking.show', compact('booking'));
    }
    public function printBill($bookingId)
{
    $booking = Booking::findOrFail($bookingId);
    return view('frontend.booking.show', compact('booking'));
}

}
