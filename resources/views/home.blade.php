@extends('layouts.app')
@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
@endphp

@section('content')
<style>
    .carousel-item img{
        height:80% !important;
        object-fit: cover;
    }
    .main-home-filter-sec{
        margin-top: 11px !important;
    }
    .active {
    background-color: #760e13 !important;
    color: #f3f3f3 !important;
    border-color: #760e13 !important;
}

</style>
<!-- home slider -->
<div id="demo" class="carousel slide home-slider" data-ride="carousel">
    <!-- Indicators -->
    <ul class="carousel-indicators">
        <li data-target="#demo" data-slide-to="0"></li>
        <li data-target="#demo" data-slide-to="1"></li>
        <li data-target="#demo" data-slide-to="2" class="active"></li>
    </ul>
    <!-- The slideshow -->
    <div class="carousel-inner">
        <div class="carousel-item">
            <img class="img-fluid w-100"
                src="{{asset('1.jpg')}}"
                alt="Los Angeles">
        </div>
        <div class="carousel-item">
            <img class="img-fluid w-100"
                src="{{asset('2.jpg')}}"
                alt="Chicago">
        </div>
        <div class="carousel-item">
            <img class="img-fluid w-100"
                src="{{asset('3.jpg')}}"
                alt="Chicago">
        </div>
        <div class="carousel-item active">
            <img class="img-fluid w-100"
                src="{{asset('4.jpg')}}"
                alt="New York">
        </div>
    </div>
    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>

<!-- Start filter home with items -->
<div class="container my-5 main-home-filter-sec text-center">
    <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="{{route('cars.index')}}" class="nav-btn {{Request::url() == url('/') ?  'active' : ''}}">All Car</a>
        <a href="{{route('spareParts.index')}}"
            class="nav-btn {{request()->route() == 'spareParts.index' ?  'active' : ''}}">Spare Parts</a>
    </div>
    @yield('page')
</div>

<div class="container text-center py-5">
    <h2 class="section-title">Search for your favorite car or sell your car on AutoDecar</h2>
    <div class="row">
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="look p-4 text-center">
                <i class="fas fa-search fa-2x"></i>
                <h5 class="font-weight-bold">Are you looking for a car?</h5>
                <p>Save time and effort as you no longer need to visit multiple stores to find the right car.</p>
                <a href="{{route('cars.index')}}">
                    <button class="btn btn-orange">Find cars</button>
                </a>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 mb-4 d-flex align-items-center justify-content-center">
            <img class="img-fluid w-100" src="https://www.car-mart.com/wp-content/uploads/2024/06/red-chevy-sedan.png"
                alt="">
        </div>
        <div class="col-md-4 col-sm-6 mb-4">
            <div class="look p-4 text-center">
                <i class="fas fa-search fa-2x"></i>
                <h5 class="font-weight-bold">Do you want to sell a car?</h5>
                <p>Find your perfect car match and sell your car quickly with our user-friendly online service.</p>
                <button class="btn btn-orange">Sell a car</button>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <h2 class="mb-4">Popular Brands</h2>
    <div class="row">
        @foreach ($brands as $brand)
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
            <div class="brand-card text-center">
                {{--<img class="img-fluid" src="{{ $brand->logo_url }}" alt="{{ $brand->name }}">--}}
                <p class="brand-title">{{ $brand->name }}</p>
                <p class="brand-subtitle">{{ $brand->cars_count ?? 'N/A' }} Cars</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="container our-partner-sec mb-5">
    <h1 class="text-center mb-5">Our Partner</h1>
    <div class="row">
        @foreach ([1, 2, 3, 4, 5, 6] as $index)
        <div class="col-6 col-sm-4 col-md-2 mb-4">
            <img src="https://carllymotors.com/demo/images/{{$index}}.png" alt="" class="img-fluid w-100">
        </div>
        @endforeach
    </div>
</div>

<div class="container py-5 last-home-sec">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="custom-card dark-card d-flex flex-column flex-md-row">
                <img class="img-fluid mb-3 mb-md-0" src="{{asset('carllyProvider.webp')}}" alt="App Screenshot">
                <div class="ml-3">
                    <h5>Download Carlly Providers App</h5>
                    <p>Connect with customers and manage your services efficiently.</p>
                    <div class="d-flex gap-2">
                        <a href="https://apps.apple.com/us/app/carlly-provider/id6478307755">
                            <img class="img-fluid"
                                src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" />
                        </a>

                        <a href="https://play.google.com/store/apps/details?id=com.carllymotors.carllyprovider">
                            <img class="img-fluid"
                                src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                                alt="Google Play">
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="custom-card dark-card d-flex flex-column flex-md-row">
                <img class="img-fluid mb-3 mb-md-0" src="{{asset('carllyCustomer.webp')}}" alt="Car Image">
                <div class="ml-3">
                    <h5>Download Carlly Customers App</h5>
                    <p>Access car buying, selling, and maintenance services effortlessly.</p>
                    <a href="https://apps.apple.com/us/app/carlly-motors/id6478306259">
                        <img class="img-fluid"
                            src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" />
                    </a>
                    <a href="https://play.google.com/store/apps/details?id=com.carllymotors.carllyuser">
                        <img class="img-fluid"
                            src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                            alt="Google Play">
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection