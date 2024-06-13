@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Create User') }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('Go Back') }}</a>
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
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input type="text" class="form-control" id="name" placeholder="{{ __('Name') }}" name="username" value="{{ old('username') }}" required />
                </div>
                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" placeholder="{{ __('Email') }}" name="email" value="{{ old('email') }}" required />
                </div>
                <div class="form-group">
    <label for="phone">{{ __('Phone') }}</label>
    <input type="text" class="form-control" id="phone" placeholder="{{ __('Phone') }}" name="phone" value="{{ old('phone') }}" required />
</div>
                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input type="password" class="form-control" id="password" placeholder="{{ __('Password') }}" name="password" value="{{ old('password') }}" required />
                </div>
                <div class="form-group">
                    <label for="role">{{ __('Role') }}</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="admin">{{ __('Admin') }}</option>
                        <option value="user">{{ __('User') }}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">{{ __('Save') }}</button>
            </form>
        </div>
    </div>

    <!-- Content Row -->

</div>
@endsection
