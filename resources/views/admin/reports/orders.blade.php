@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Revenue Report</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.reports.print') }}" method="POST" class="mb-5">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control datepicker" readonly value="{{ request()->input('start') }}" name="start" placeholder="From">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <input type="text" class="form-control datepicker" readonly value="{{ request()->input('end') }}" name="end" placeholder="To">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <input type="hidden" name="export" value="xlsx"> <!-- Only export to Excel -->
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <button type="submit" class="btn btn-primary btn-default"><i class="fas fa-print"></i> Print</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Order Code</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalQuantity = 0;
                                        $totalPrice = 0;
                                    @endphp
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>{{ $order->customer_first_name }}<br/>{{ $order->customer_email }}</td>
                                        <td>{{ $order->code }}</td>
                                        <td>{{ $order->qty }}</td>
                                        <td>Rp. {{ number_format($order->base_total_price, 0, '.', '.') }}</td>
                                    </tr>
                                    @php
                                        $totalQuantity += $order->qty;
                                        $totalPrice += $order->base_total_price;
                                    @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total Quantity</th>
                                        <th>{{ $totalQuantity }}</th>
                                      
                                        <th>Rp. {{ number_format($totalPrice, 0, '.', '.') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Summary of total revenue per service -->
                        <div class="mt-5">
                            <h4>Total Revenue per Service</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Total Revenue</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalRevenuePerService = [];
                                        foreach($orders as $order) {
                                            if(isset($order->service_name)) {
                                                if(!isset($totalRevenuePerService[$order->service_name])) {
                                                    $totalRevenuePerService[$order->service_name] = 0;
                                                }
                                                $totalRevenuePerService[$order->service_name] += $order->grand_total;
                                            }
                                        }
                                        @endphp
                                        @foreach($totalRevenuePerService as $service => $total)
                                        <tr>
                                            <td>{{ $service }}</td>
                                            <td>Rp.{{ number_format($total, 0, '.', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-alt')
<script src="{{ asset('backend/plugins/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
</script>
@endpush
