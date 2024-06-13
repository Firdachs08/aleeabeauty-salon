@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="content">
        <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5">
            <div class="d-flex justify-content-between">
                <h2 class="text-dark font-weight-medium">Booking Detail</h2>
                <div class="btn-group">
                    <a href="{{ route('admin.booking.index') }}" class="btn btn-sm btn-warning">
                     Go Back</a>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-xl-4 col-lg-4">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Date</p>
                    <address>
                        {{ $booking->date }}
                    </address>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Time</p>
                    <address>
                        {{ $booking->schedule ? $booking->schedule->start_time . ' - ' . $booking->schedule->end_time : 'No Schedule' }}
                    </address>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Service</p>
                    <address>
                        {{ $booking->category }} - {{ $booking->service_name }}
                    </address>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-xl-4 col-lg-4">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Customer Name</p>
                    <address>
                        {{ $booking->name }}
                    </address>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Contact</p>
                    <address>
                        {{ $booking->handphone }}
                    </address>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:16px; text-transform: uppercase;">Status</p>
                    <address>
                        {{ $booking->status }}
                    </address>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-lg-5 col-xl-4 col-xl-3 ml-sm-auto">
                    <ul class="list-unstyled mt-4">
                        {{-- You can add additional details here if needed --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
