@extends('layouts.frontend')
@section('title', 'Services')
@section('content')
    <div class="section-title-furits text-center">
        <h2>Category Service : {{ isset($ser->name) ? $ser->name : 'Empty' }}</h2>
    </div>
    <div class="shop-page-wrapper shop-page-padding ptb-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Service</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($services as $service)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @foreach ($service->obtaineds as $obtained)
                                                {{ $obtained->name }}
                                            @endforeach
                                        </td>
                                        <td>IDR {{ number_format($service->price, 0, '.', '.') }}</td>
                                        <td>
                                            <a href="{{ route('booking.show', $service->id) }}" class="btn btn-dark">Book Now</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-danger">Service Detail List Empty.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
