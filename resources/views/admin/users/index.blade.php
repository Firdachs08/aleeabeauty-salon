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
        <h1 class="h3 mb-0 text-gray-800">{{ __('Users') }}</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('create new')}} <i class="fa fa-plus"> </i></a>
    </div>

    <!-- Search Bar -->
    <div class="mb-4">
        <form action="{{ route('admin.users.index') }}" method="GET" class="form-inline">
            <div class="form-group mr-2">
                <input type="text" name="search" class="form-control" placeholder="{{ __('Search by name or email') }}" value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
        </form>
    </div>

    <!-- Content Row -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Roles') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->role }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                <form onclick="return confirm('Are you sure?')" class="d-inline" action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">{{ __('Data Empty') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
    <!-- Content Row -->

</div>
@endsection
