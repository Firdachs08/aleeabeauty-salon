@extends('layouts.frontend')
@section('title', 'Services')
@section('content')
    <div class="section-title-furits text-center">
        <h2>Order with <span class="font-weight-bold">Cash</span> payment <span class="text-success">Successful</span></h2>
    </div>
    <div class="shop-page-wrapper shop-page-padding ptb-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h3 class="text-center">Please take the product you ordered and pay with a nominal amount of <span class="font-weight-bold">IDR. {{ number_format( $order->base_total_price, 0, '.', '.') }}.</span></h1>
                    <div class="text-center">
                        <a class="btn btn-dark mt-2" href="{{ route('homepage') }}">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
