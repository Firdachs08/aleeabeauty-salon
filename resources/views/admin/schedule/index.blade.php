@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    @if(session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Schedules') }}</h1>
            <a href="{{ route('admin.schedule.create') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('create new')}} <i class="fa fa-plus"> </i></a>
    </div>

    <!-- Content Row -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                < <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Max Slot</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="{{ $schedule->status === 'available' ? 'badge badge-primary' : 'badge badge-danger' }}">{{ $schedule->status }}</span>
                            </td>
                            <td>{{ $schedule->date }}</td>
                            <td>{{ $schedule->start_time }}</td>
                            <td>{{ $schedule->end_time }}</td>
                            <td>{{ $schedule->max_slot }}</td>
                            <td>
    
  
    <a href="{{ route('admin.schedule.edit', $schedule->id) }}" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
    <form action="{{ route('admin.schedule.destroy', $schedule->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</button>
    </form>
</td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">{{ __('Data Schedule Empty') }}</td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="card-footer">
                {{ $schedules->links() }}
            </div> --}}
        </div>
    <!-- Content Row -->

</div>
@endsection
