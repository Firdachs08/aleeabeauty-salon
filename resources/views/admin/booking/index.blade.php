@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    @if(session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Bookings') }}</h1>
            {{-- <a href="{{ route('admin.service.create') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('create new')}} <i class="fa fa-plus"> </i></a> --}}
    </div>

    <!-- Content Row -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{ route('admin.booking.index') }}" method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Payment</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Service</th>
                            <th>Customer Name</th>
                            <th>Contact</th>
                            <th>Actions</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($booking->status === 'Cash')
                                    {{ $booking->status }}
                                @else
                                    @if ($booking->status === 'Paid')
                                        <span class="text-success">Cashless - Paid</span>
                                    @elseif ($booking->status === 'Unpaid')
                                        <span class="text-danger">Cashless - Unpaid</span>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $booking->date }}</td>
                            <td>
                                @if($booking->schedule)
                                    {{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}
                                @else
                                    <span class="text-danger">Schedule Deleted</span>
                                @endif
                            </td>
                            <td>{{ $booking->category }} - {{ $booking->service_name }} ({{ number_format($booking->total, 0, '.', '.') }})</td>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->handphone }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.booking.view', $booking->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <form onclick="return confirm('Are you sure you want to delete this booking?');" action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">{{ __('Booking Data Empty') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="card-footer">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
