@extends('layouts.frontend')
@section('title', 'Homepage')
@section('content')
   

<!-- Welcome section -->
<section class="home" id="home">
    <div class="content" style="position: relative;">
        <img src="{{ asset('frontend/assets/img/logo/home-bg2.png') }}" alt="Aleea Salon Image" style="width: 100%;">

        <div class="welcome-text" style="position: absolute; top: 50%; left: 20%; transform: translate(-30%, -50%); text-align: left; color: #8B4513;">
            <h2 style="font-size: 48px; font-weight: bold; margin-bottom: 20px;">Welcome to Aleea Salon</h2>
            <h3 style="font-size: 48px; font-weight: bold; margin-bottom: 20px;">
                We make <br />
                hair beautiful <br />
                & unique
            </h3>
            <a class="btn btn-primary" href="{{ route('service.index') }}" role="button" style="font-size: 30px; padding: 40px 20px; background-color: #D2B48C; color: white; display: flex; justify-content: center; align-items: center; border: none;">Book Now</a>


        </div>
    </div>
</section>
<!-- End Welcome section -->





    

    <!-- services -->
    <div class="services-area wrapper-padding-4 gray-bg pt-120 pb-80">
    <div class="container-fluid">
        <div class="section-title-furits text-center">
            <h2>Why Choose Us</h2>
        </div>
        <br>
        <div class="services-wrapper mt-40">
            <div class="single-services mb-40">
                <div class="services-img">
                    <img src="{{ asset('frontend/assets/img/icon-img/26.png') }}" alt="">
                </div>
                <div class="services-content">
                    <h4>Professional Services</h4>
                </div>
            </div>
            <div class="single-services mb-40">
                <div class="services-img">
                    <img src="{{ asset('frontend/assets/img/icon-img/27.png') }}" alt="">
                </div>
                <div class="services-content">
                    <h4>24/7 Availability</h4>
                </div>
            </div>
            <div class="single-services mb-40">
                <div class="services-img">
                    <img src="{{ asset('frontend/assets/img/icon-img/28.png') }}" alt="">
                </div>
                <div class="services-content">
                    <h4>Secure Payments</h4>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- end services -->
@endsection
