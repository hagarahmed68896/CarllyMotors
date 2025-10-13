@extends('layouts.app')
@section('content')
    <head>
        <style>
            #map {
                height: 400px;
                width: 100%;
                cursor: pointer;
            }

            /* Fullscreen Map Styles */
            #fullMapModal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.9);
                z-index: 1000;
                display: none;
            }

            #fullMap {
                height: 100%;
                width: 100%;
            }

            .close-btn {
                position: absolute;
                top: 20px;
                right: 30px;
                font-size: 30px;
                color: white;
                cursor: pointer;
                z-index: 1100;
            }

            .btn-outline-danger {
                /* background-color: #760e13 !important; */
                color: #760e13 !important;
                border-color: #760e13 !important;
            }

            .btn-outline-danger:hover {
                background-color: #5a0b0f !important;
                border-color: #5a0b0f !important;
                color: #f3f3f3 !important;
            }
        </style>

    </head>
    <!-- #strat breadcrums-->
    <div class="car-list-details-breadcrums container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    Used cars for sale
                </li>
            </ol>
        </nav>
        <hr />
    </div>

    <div class="container mt-4 listing-detail">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div id="carCarousel" class="carousel slide rounded-2" data-ride="carousel">
                            <div class="carousel-inner">
                                @if($images != null)
                                {{-- @dd($images) --}}
                                @foreach ($images as $index => $image)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ $image }}"
                                            class="d-block w-100 h-40" alt="Car Image">

                                    </div>
                                @endforeach
                                @else
                                <div class="carousel-item active">
                                    <img src="{{ asset('carNotFound.jpg') }}"
                                        class="d-block w-100 h-40" alt="Car Image">

                                </div>
                                @endif
                            </div>

                            <a class="carousel-control-prev" href="#carCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next" href="#carCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        </div>
                        <ul class="nav nav-tabs mt-3" id="carTabs" role="tablist">
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#overview" role="tab"
                                    aria-selected="true">Overview</a></li>

                        </ul>
                        <div class="container mt-4" style="margin-top:10px;">
                            <div class="tab-content " style="margin-bottom:10px;">
                                <div class="tab-pane fade active show" id="overview" role="tabpanel">
                                    <h3 class="overview-title mt-3">Description</h3>
                                    <p>{{$car->listing_desc}}</p>

                                    <h4 class="mt-4 overview-title">Car Overview</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item  overview-item"><i class="fas fa-car "></i>
                                                    <strong>Condition:</strong><span class="fs-3 pl-2">
                                                        {{$car->car_type}}</span> </li>
                                                <li class="list-group-item  overview-item"><i class="fas fa-barcode"></i>
                                                    <strong>VIN number:</strong><span class="fs-3 pl-2">
                                                        {{$car->vin_number}}</span> </li>
                                                <li class="list-group-item  overview-item"><i
                                                        class="fas fa-calendar-alt"></i> <strong>Year:</strong><span
                                                        class="fs-3 pl-2"> {{$car->listing_year}}</span></li>
                                                <li class="list-group-item  overview-item"><i class="fas fa-users"></i>
                                                    <strong>Seats:</strong><span
                                                        class="fs-3 pl-2">{{$car->features_seats}}</span> </li>
                                                <li class="list-group-item  overview-item"><i class="fas fa-city"></i>
                                                    <strong>City:</strong><span class="fs-3 pl-3"> {{$car->city}} </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item  overview-item"><i class="fas fa-cogs"></i>
                                                    <strong>Cylinders:</strong><span class="fs-3 pl-2">
                                                        {{$car->features_cylinders}} </span></li>
                                                <li class="list-group-item  overview-item"><i class="fas fa-gas-pump"></i>
                                                    <strong>Fuel Type:</strong><span class="fs-3 pl-2">
                                                        {{$car->features_fuel_type}}</span></li>
                                                <li class="list-group-item  overview-item"><i
                                                        class="fas fa-door-closed"></i> <strong>Doors:</strong> <span
                                                        class="fs-3 pl-2"> {{$car->features_door}} </span></li>
                                                <li class="list-group-item  overview-item"><i class="fas fa-palette"></i>
                                                    <strong>Color:</strong> <span class="fs-3 pl-2"> {{$car->color?->name}}
                                                    </span></li>
                                                <li class="list-group-item  overview-item"><i class="fas fa-cog"></i>
                                                    <strong>Transmission:</strong><span class="fs-3 pl-2">
                                                        {{$car->features_gear}} </span></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <h4 class="mt-4">Features</h4>
                                    @if (!empty($car->features_others))
                                        @php $features = json_decode($car->features_others, true); @endphp
                                        @if (is_array($features) && count($features) > 0)
                                            <div class="row">
                                                @foreach (array_chunk($features, ceil(count($features) / 3)) as $column)
                                                    <div class="col-md-4">
                                                        <ul class="list-group list-group-flush">
                                                            @foreach ($column as $feature)
                                                                <li class="list-group-item"><i class="fas fa-check-circle text-success"></i>
                                                                    {{ trim($feature) }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>No features available.</p>
                                        @endif
                                    @else
                                        <p>No features available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="right-listing-detail-section">
                    <!-- Car Details Section -->
                    <div class="card">
                        <h4 class="mb-2">{{$car->listing_type}} | {{$car->listing_model}}</h4>
                        <p class="text-muted mb-4">
                            <i class="fas fa-road"></i>
                            {{$car->features_speed}} kms &nbsp;
                            <i class="fas fa-gas-pump"></i>
                            {{$car->features_fuel_type}} &nbsp;
                            <br>
                            <i class="fas fa-cogs"></i>
                            {{$car->features_gear}} &nbsp;
                            <i class="fas fa-user"></i>
                            {{$car->user?->fname}} {{$car->user?->lname}}
                        </p>
                        <p class="price" style="color:#760e13">AED {{$car->listing_price}}</p>
                        @if(auth()->check())
                                            @php
                                                $favCars = auth()->user()->favCars()->pluck('id')->toArray();
                                            @endphp
                                            <div class="icon-group mt-3">
                                                <form action="{{route('cars.addTofav', $car->id)}}" method="post">
                                                    @csrf
                                                    <button title="add to fav" class="btn btn-sm" type="submit">
                                                        <i class="fas fa-heart"
                                                            style="color:{{in_array($car->id, $favCars) ? '#760e13' : 'gray'}}"></i>
                                                    </button>
                                                </form>
                                            </div>
                        @endif
                    </div>

                    <!-- Dealer Details Section -->
                    <div class="card">
                        <div class="d-flex align-items-center mb-3">
                            <div class="ml-3">
                                <h6 class="">Car Empire</h6>
                                <span class="verified-badge">Verified dealer</span>
                            </div>
                        </div>
                        <p class="text-muted"> {{$car->user?->location}}</p>
                        <div class="bg-light rounded mb-3" id="map" onclick="openFullMap()" style="height: 100px;"></div>
                        <div id="fullMapModal">
                            <span class="close-btn" onclick="closeFullMap()">&times;</span>
                            <div id="fullMap"></div>
                        </div>
                        <h6 class="mb-3">Contact dealer</h6>
                        <div class="d-flex justify-content-between">
                            <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank">
                                <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </button>
                            </a>
                            @if($os == 'Windows' || $os == 'Linux')
                                <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                            @elseif($os == 'Mac')
                                <a href={{ 'https://faceapp.com?phone=' . urlencode($car->user?->phone) }}>
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                            @elseif($os == 'Android' || $os = 'iOS')
                                <a href="tel:{{ $car->user?->phone }}">
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                            @else
                                No OS Detected
                            @endif
                            <a href=" https://wa.me/?text={{ urlencode('Hello, i recommend you to check this car ' . route('car.detail', [Crypt::encrypt($car->id)])) }}"
                                target="_blank">
                                <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                    <i class="fa fa-share"></i>
                                    Share
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="report-list-car-right">
                    <ul>
                        <li>
                            <a href="#"><i class="fa fa-light fa-flag"></i>Report this listing</a>
                        </li>
                    </ul>
                </div>
                <div class="container my-4 recmended-used-car-section px-0">
                    <!-- Recommended Cars Section -->
                    <div class="card">
                        <h5>Recommended Used Cars</h5>
                        <p class="text-muted">Showing {{ count($recommendedCars) }} more cars you might like</p>
                        <ul class="car-list">
                            @foreach ($recommendedCars as $recommendedCar)

                                <a href="{{route('car.detail', [Crypt::encrypt($recommendedCar->id)])}}">
                                    <li class="car-list-item">
                                        <div class="car-image">
                                            <!-- Display the car image -->
                                            <img src="{{ env('FILE_BASE_URL') . $recommendedCar->listing_img1 }}"
                                                alt="Car Image" class="img-fluid">
                                        </div>
                                        <div class="text-list-para">
                                            <p class="car-title">{{$recommendedCar->listing_year}}
                                                {{ $recommendedCar->listing_type }} {{ $recommendedCar->listing_model }}
                                            </p>
                                            <p class="car-price">{{ 'AED ' . number_format($recommendedCar->listing_price) }}
                                            </p>
                                        </div>
                                    </li>
                                </a>
                            @endforeach
                        </ul>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function copyUrl() {
            const url = window.location.href; // Get current URL
            navigator.clipboard.writeText(url).then(() => {
                alert('URL copied to clipboard!' + url);
            }).catch(err => {
                console.error('Failed to copy URL: ', err);
            });
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAg11eAiAzKB6kMmJXfRbElSfK96RkDVq4&callback=initMap&libraries=maps,marker"
        async defer></script>

    <script>
        function copyUrl() {
            const url = window.location.href; // Get current URL
            navigator.clipboard.writeText(url).then(() => {
                alert('URL copied : ' + url);
            }).catch(err => {
                console.error('Failed to copy URL: ', err);
            });
        }
        var latitude = {{$car->lat}}
    var longitude = {{$car->lng}}

            // Initialize Small Map
            function initSmallMap() {
                var location = {
                    lat: latitude,
                    lng: longitude
                };
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 13,
                    center: location,
                });
                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    title: "Selected Location",
                });
            }

        // Function to open Fullscreen Map
        function openFullMap() {
            document.getElementById('fullMapModal').style.display = 'block';

            var location = {
                lat: latitude,
                lng: longitude
            };
            var fullMap = new google.maps.Map(document.getElementById('fullMap'), {
                zoom: 15,
                center: location,
            });
            new google.maps.Marker({
                position: location,
                map: fullMap,
                title: "Selected Location",
            });
        }

        // Function to close Fullscreen Map
        function closeFullMap() {
            document.getElementById('fullMapModal').style.display = 'none';
            document.getElementById('fullMap').innerHTML = ''; // Clear Full Map
        }

        // Initialize Small Map on Load
        window.onload = initSmallMap;
    </script>

@endsection