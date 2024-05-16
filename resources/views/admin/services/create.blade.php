@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Create Service') }}</h1>
        <a href="{{ route('admin.service.index') }}" class="btn btn-primary btn-sm shadow-sm">{{ __('Go Back') }}</a>
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
                <form action="{{ route('admin.service.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            {{-- <div class="form-group">
                                <label for="serviceName">{{ __('Service Name') }}</label>
                                <input type="text" class="form-control" id="serviceName" placeholder="{{ __('Service Name') }}" name="name" value="{{ old('name') }}" />
                            </div> --}}
                            <div class="form-group">
                                    <label for="serviceCategory">Service Category</label>
                                    <select class="form-control" id="serviceCategory" name="name">
                                        <option selected disabled>Chosee Service Category</option>
                                        @foreach ($serviceCategories as $serviceCategory)
                                            <option value="{{ $serviceCategory->name }}">{{ $serviceCategory->name }}</option>
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="servicePrice">{{ __('Service Price') }}</label>
                                <input type="number" min="0" class="form-control" id="servicePrice" placeholder="{{ __('Service Price') }}" name="price" value="{{ old('price') }}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serviceObtained">{{ __('Service Obtained') }}</label>
                        <select name="obtaineds[]" id="serviceObtained" class="form-control" required>
                            <option selected disabled>Chosee Service Obtained</option>
                            @foreach($obtaineds as $id => $obtaineds)
                                <option value="{{ $id }}" {{ (in_array($id, old('obtaineds', [])) || isset($service) && $service->obtaineds->contains($id)) ? 'selected' : '' }}>{{ $obtaineds }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Save') }}</button>
                </form>
            </div>
        </div>


    <!-- Content Row -->

</div>
@endsection
