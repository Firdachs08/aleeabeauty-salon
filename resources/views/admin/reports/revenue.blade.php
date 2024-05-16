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
                        <form action="{{ route('admin.reports.export') }}" method="POST" class="mb-5">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group mb-2">
                                        <input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('start')) ? request()->input('start') : '' }}" name="start" placeholder="from">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('end')) ? request()->input('end') : '' }}" name="end" placeholder="to">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <select name="export" class="form-control">
                                            <option value="xlsx">excel</option>
                                            <option value="pdf">pdf</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <button type="submit" class="btn btn-primary btn-default">Go</button>
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
                                        <th>Activity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $record)
                                    <tr>
                                        <td>{{ $record->created_at }}</td>
                                        <td>{{ $record->name }}</td>
                                        <td>
                                            @if(isset($record->service_name))
                                            Booking: {{ $record->service_name }}
                                            @elseif(isset($record->code))
                                            Order: {{ $record->code }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($record->service_name))
                                            {{ $record->total }} <!-- Menampilkan harga booking -->
                                            @elseif(isset($record->code))
                                            {{ $record->grand_total }} <!-- Menampilkan harga order -->
                                            @endif
                                        </td>
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

@push('script-alt')
<script src="{{ asset('backend/plugins/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
</script>
@endpush
