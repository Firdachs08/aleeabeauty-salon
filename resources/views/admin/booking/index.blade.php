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
                                <td>{{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}</td>
                                <td>{{ $booking->category }} - {{ $booking->service_name }} ({{ number_format($booking->total, 0, '.', '.') }})</td>
                                 
                                <td>{{ $booking->name }}</td>
                                <td>{{ $booking->handphone }}</td>
                                
                                {{-- <td>
                                    <a href="{{ route('admin.service.edit', $service->id) }}" class="btn btn-info">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <form onclick="return alert('are you sure ? ')" class="d-inline" action="{{ route('admin.service.destroy', $service->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td> --}}
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">{{ __('Booking Data Empty') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="card-footer">
                {{ $services->links() }}
            </div> --}}
        </div>
    <!-- Content Row -->

</div>
@endsection
