@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Produk Card Example -->
        <div class="col-xl-3 col-md-4 mb-4">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Produk
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $product_count }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pesanan Card Example -->
        <div class="col-xl-3 col-md-4 mb-4">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pesanan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $order }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Boking Card Example -->
        <div class="col-xl-3 col-md-4 mb-4">
            <a href="{{ route('admin.booking.index') }}" class="text-decoration-none">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Boking
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{  $booking_count }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Layanan Card Example -->
        <div class="col-xl-3 col-md-4 mb-4">
            <a href="{{ route('admin.service.index') }}" class="text-decoration-none">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Layanan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{  $service_count }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-concierge-bell fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Content Row -->

</div>
@endsection
