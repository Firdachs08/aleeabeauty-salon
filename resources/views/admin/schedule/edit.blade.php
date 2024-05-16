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
        <h1 class="h3 mb-0 text-gray-800">{{ __('Edit Schedule')}}</h1>
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
            <form action="{{ route('admin.schedule.update', $schedule->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="datepicker">{{ __('Date') }}</label>
                            <input type="text" class="form-control pl-3" id="datepicker" name="date" value="{{ old('date', $schedule->date) }}" readonly autocomplete="off" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="start_time">{{ __('Start Time') }}</label>
                            <input type="text" class="form-control pl-3 timepicker" id="start_time" name="start_time" value="{{ old('start_time', $schedule->start_time) }}" autocomplete="off" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="end_time">{{ __('End Time') }}</label>
                            <input type="text" class="form-control pl-3 timepicker" id="end_time" name="end_time" value="{{ old('end_time', $schedule->end_time) }}" autocomplete="off" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="max_slot">{{ __('Max Slot') }}</label>
                            <input type="text" class="form-control pl-3" id="max_slot" name="max_slot" value="{{ old('max_slot', $schedule->max_slot) }}" autocomplete="off" />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">{{ __('Save') }}</button>
            </form>

            </div>
        </div>


    <!-- Content Row -->

</div>
@endsection
@push('script-alt')
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <script>
        $(function () {
            $('#datepicker').datepicker({
                format: 'dd-mm-yyyy',
                showOnFocus: true,
                showRightIcon: false
            });
        });

        var $timepicker = $('#timepicker').timepicker({
            mode: '24hr',
            showRightIcon: false
        });
    </script>
@endpush
