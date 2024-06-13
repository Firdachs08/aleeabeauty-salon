@extends('layouts.frontend')
@section('title', 'Services')
@section('content')
    <div class="section-title-furits text-center">
        <h2>Booking with <span class="font-weight-bold">Cash</span> payment <span class="text-success">Successful</span></h2>
    </div>
    <div class="shop-page-wrapper shop-page-padding ptb-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                <h3 class="text-center">Silahkan datang ke <span class="font-weight-bold">Aleea Salon</span> pada tanggal <span class="font-weight-bold">{{ $booking->date }}</span> pukul <span class="font-weight-bold">{{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}.</span></h1>
                    <div class="text-center">
                    <div class="text-center">
                        <a class="btn btn-dark mt-2" href="{{ route('bookings.show', $booking->id) }}">Lihat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
