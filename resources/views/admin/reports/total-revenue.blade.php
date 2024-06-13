<!-- resources/views/admin/reports/total-revenue.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Data Rekap</h2>
                    </div>
                    <div class="card-body">
                        <!-- Summary of total revenue per service -->
                        
                           
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
                                        foreach($bookings as $record) {
                                        if(isset($record->service_name)) {
                                        if(!isset($totalRevenuePerService[$record->service_name])) {
                                        $totalRevenuePerService[$record->service_name] = 0;
                                        }
                                        $totalRevenuePerService[$record->service_name] += $record->total;
                                        }
                                        }
                                        @endphp
                                        @foreach($totalRevenuePerService as $service => $total)
                                        <tr>
                                            <td>{{ $service }}</td>
                                            <td>{{ number_format($total, 0, '.', '.') }}</td>
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
@endsection
