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
                        <form id="printForm" action="{{ route('admin.reports.view') }}" method="POST" class="mb-5">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group mb-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" readonly value="{{ request()->input('start') }}" name="start" placeholder="From">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" readonly value="{{ request()->input('end') }}" name="end" placeholder="To">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <div class="input-group">
                                            <button type="submit" class="btn btn-primary btn-default ml-2">
                                                <i class="fas fa-print"></i> Lihat
                                            </button>
                                        </div>
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
