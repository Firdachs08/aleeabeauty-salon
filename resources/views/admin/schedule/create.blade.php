@extends('layouts.admin')
@push('style-alt')
    <style>
        .gj-icon.clock {
            display: none;
        }
    </style>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Create Schedule') }}</h1>
        <a href="{{ route('admin.schedule.index') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('Go Back') }}</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Content Row -->
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.schedule.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="datepicker">{{ __('Date') }}</label>
                            <input type="text" class="form-control pl-3" id="datepicker" name="date" readonly autocomplete="off" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="start_time">{{ __('Start Time') }}</label>
                            <input type="text" class="form-control pl-3 timepicker" id="start_time" name="start_time" autocomplete="off" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="end_time">{{ __('End Time') }}</label>
                            <input type="text" class="form-control pl-3 timepicker" id="end_time" name="end_time" autocomplete="off" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="max_slot">{{ __('Max Slot') }}</label>
                            <input type="text" class="form-control pl-3" id="max_slot" name="max_slot" value="{{ old('max_slot') }}" autocomplete="off" />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">{{ __('Save') }}</button>
            </form>
        </div>
    </div>

</div>
@endsection

@push('script-alt')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#datepicker').datepicker({
                format: 'dd-mm-yyyy',
                showOnFocus: true,
                showRightIcon: false,
                todayHighlight: true,
                autoclose: true
            });

            $('.timepicker').timepicker({
                mode: '24hr',
                showRightIcon: false,
                footer: true,
                modal: true
            });
        });
    </script>
@endpush

