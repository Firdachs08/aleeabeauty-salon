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
                        <form id="printForm" action="{{ route('admin.reports.download') }}" method="POST" class="mb-5">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control datepicker" readonly value="{{ request()->input('start') }}" name="start" placeholder="from">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <input type="text" class="form-control datepicker" readonly value="{{ request()->input('end') }}" name="end" placeholder="to">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <input type="hidden" name="export" value="xlsx">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <button type="submit" class="btn btn-primary btn-default"><i class="fas fa-download"></i> Download</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Service</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $record)
                                    @if(isset($record->service_name))
                                    <tr>
                                        <td>{{ $record->created_at }}</td>
                                        <td>{{ $record->name }}</td>
                                        <td>{{ $record->category }} - {{ $record->service_name }}</td>
                                        <td>{{ number_format($record->total, 0, '.', '.') }}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
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
