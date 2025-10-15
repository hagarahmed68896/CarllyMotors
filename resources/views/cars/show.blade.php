@extends('layouts.app')

@section('content')
<head>
    <style>
        /* ========== GENERAL ========== */
        body {
            background-color: #f8f9fa;
        }

        .overview-item i {
            color: #760e13;
            margin-right: 8px;
        }

        .price {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-outline-danger {
            color: #760e13 !important;
            border-color: #760e13 !important;
        }

        .btn-outline-danger:hover {
            background-color: #760e13 !important;
            color: #fff !important;
        }

        .car-feature {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 8px 12px;
            margin: 5px;
            display: inline-block;
            font-size: 14px;
        }

        .verified-badge {
            background-color: #28a745;
            color: white;
            font-size: 12px;
            border-radius: 12px;
            padding: 2px 8px;
            margin-left: 5px;
        }
        .breadcrumb a {
    color: #760e13; /* your preferred dark red color */
    text-decoration: none; /* remove underline */
    font-weight: 500;
}

.breadcrumb a:hover {
    color: #a01318; /* slightly lighter on hover */
    text-decoration: none;
}


        /* ========== CAROUSEL FIX ========== */
        .carousel {
            width: 100%;
            height: 500px;
            border-radius: 12px;
            overflow: hidden;
        }

        .carousel-inner,
        .carousel-item {
            width: 100%;
            height: 100%;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* fills the container nicely */
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.4);
            border-radius: 50%;
            padding: 15px;
        }

        .carousel-indicators [data-bs-target] {
            background-color: #760e13;
        }

        /* ========== MAP STYLES ========== */
        #map {
            height: 180px;
            width: 100%;
            border-radius: 10px;
            cursor: pointer;
        }

        #fullMapModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.95);
            z-index: 1050;
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
            font-size: 36px;
            color: white;
            cursor: pointer;
            z-index: 1100;
        }

        /* Responsive tweak */
        @media (max-width: 768px) {
            .carousel {
                height: 300px;
            }
        }
    </style>
</head>

<div class="container py-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-3 rounded">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Used Cars</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $car->listing_type }} {{ $car->listing_model }}</li>
        </ol>
    </nav>

    <div class="row g-4 mt-2">

        <!-- LEFT COLUMN -->
        <div class="col-lg-8">

            <!-- Carousel -->
            <div class="card shadow-sm border-0 rounded-3 mb-4 overflow-hidden">
                <div id="carCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @if($images && count($images) > 0)
                            @foreach ($images as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ $image }}" alt="Car Image">
                                </div>
                            @endforeach
                        @else
                            <div class="carousel-item active">
                                <img src="{{ asset('carNotFound.jpg') }}" alt="Car Not Found">
                            </div>
                        @endif
                    </div>

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>

                    <!-- Indicators -->
                    @if($images && count($images) > 0)
                        <div class="carousel-indicators mb-0 pb-3">
                            @foreach ($images as $index => $image)
                                <button type="button"
                                        data-bs-target="#carCarousel"
                                        data-bs-slide-to="{{ $index }}"
                                        class="{{ $index == 0 ? 'active' : '' }}"
                                        aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="card shadow-sm border-0 p-4">
                <h3 class="fw-bold mb-3">Description</h3>
                <p class="text-muted">{{ $car->listing_desc }}</p>

                <h4 class="fw-bold mt-4 mb-3">Car Overview</h4>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2 overview-item"><i class="fas fa-car"></i><strong>Condition:</strong> {{ $car->car_type }}</li>
                            <li class="mb-2 overview-item"><i class="fas fa-barcode"></i><strong>VIN:</strong> {{ $car->vin_number }}</li>
                            <li class="mb-2 overview-item"><i class="fas fa-calendar"></i><strong>Year:</strong> {{ $car->listing_year }}</li>
                            <li class="mb-2 overview-item"><i class="fas fa-users"></i><strong>Seats:</strong> {{ $car->features_seats }}</li>
                            <li class="mb-2 overview-item"><i class="fas fa-city"></i><strong>City:</strong> {{ $car->city }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2 overview-item"><i class="fas fa-cogs"></i><strong>Cylinders:</strong> {{ $car->features_cylinders }}</li>
                            <li class="mb-2 overview-item"><i class="fas fa-gas-pump"></i><strong>Fuel:</strong> {{ $car->features_fuel_type }}</li>
                            <li class="mb-2 overview-item"><i class="fas fa-door-closed"></i><strong>Doors:</strong> {{ $car->features_door }}</li>
                            <li class="mb-2 overview-item"><i class="fas fa-palette"></i><strong>Color:</strong> {{ $car->color?->name }}</li>
                            <li class="mb-2 overview-item"><i class="fas fa-cog"></i><strong>Transmission:</strong> {{ $car->features_gear }}</li>
                        </ul>
                    </div>
                </div>

                <h4 class="fw-bold mt-4 mb-3">Features</h4>
                @if (!empty($car->features_others))
                    @php $features = json_decode($car->features_others, true); @endphp
                    @if (is_array($features) && count($features) > 0)
                        <div>
                            @foreach ($features as $feature)
                                <span class="car-feature"><i class="fas fa-check-circle text-success"></i> {{ trim($feature) }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No features available.</p>
                    @endif
                @else
                    <p class="text-muted">No features available.</p>
                @endif
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-4">

            <!-- Car Details -->
            <div class="card shadow-sm border-0 mb-4 p-3">
                <h4 class="fw-bold">{{ $car->listing_type }} | {{ $car->listing_model }}</h4>
                <p class="text-muted small mb-2">
                    <i class="fas fa-road"></i> {{ $car->features_speed }} km &nbsp;
                    <i class="fas fa-gas-pump"></i> {{ $car->features_fuel_type }} <br>
                    <i class="fas fa-cogs"></i> {{ $car->features_gear }} &nbsp;
                    <i class="fas fa-user"></i> {{ $car->user?->fname }} {{ $car->user?->lname }}
                </p>
                <p class="price mt-2">
                    <img src="{{ asset('assets/images/UAE_Dirham_Symbol.svg.png') }}" width="18" height="18" alt="AED">
                    {{ $car->listing_price }}
                </p>

                @auth
                    @php
                        $favCars = auth()->user()->favCars()->pluck('id')->toArray();
                    @endphp
                    <form action="{{ route('cars.addTofav', $car->id) }}" method="post">
                        @csrf
                        <button class="btn btn-link text-decoration-none p-0">
                            <i class="fas fa-heart" style="font-size: 22px; color: {{ in_array($car->id, $favCars) ? '#760e13' : 'gray' }}"></i>
                        </button>
                    </form>
                @endauth
            </div>

            <!-- Dealer -->
            <div class="card shadow-sm border-0 mb-4 p-3">
                <div class="d-flex align-items-center mb-3">
                    <div>
                        <h6 class="fw-bold mb-0">Car Empire <span class="verified-badge">Verified</span></h6>
                        <small class="text-muted">{{ $car->user?->location }}</small>
                    </div>
                </div>

                <!-- Small Map -->
                <div id="map" onclick="openFullMap()"></div>

                <!-- Fullscreen Map -->
                <div id="fullMapModal">
                    <span class="close-btn" onclick="closeFullMap()">&times;</span>
                    <div id="fullMap"></div>
                </div>

                <h6 class="fw-bold mt-4 mb-2">Contact Dealer</h6>
          <div class="d-flex gap-2">
    <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank" class="btn btn-outline-success flex-fill">
        <i class="fab fa-whatsapp"></i>
    </a>

    @php
        $isMobile = Str::contains(request()->header('User-Agent'), ['Android', 'iPhone', 'iPad']);
    @endphp

    @if($isMobile)
        <a href="tel:{{ $car->user?->phone }}" class="btn btn-outline-danger flex-fill">
            <i class="fa fa-phone"></i>
        </a>
    @else
        <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank" class="btn btn-outline-danger flex-fill">
            <i class="fa fa-phone"></i>
        </a>
    @endif

    <a href="https://wa.me/?text={{ urlencode('Check this car: ' . route('car.detail', [Crypt::encrypt($car->id)])) }}"
       target="_blank" class="btn btn-outline-primary flex-fill">
        <i class="fa fa-share"></i>
    </a>
</div>

            </div>

            <!-- Recommended Cars -->
            <div class="card shadow-sm border-0 p-3">
                <h5 class="fw-bold mb-1">Recommended Cars</h5>
                <small class="text-muted mb-3">You might also like</small>

                @foreach ($recommendedCars as $recommendedCar)
                    <a href="{{ route('car.detail', [Crypt::encrypt($recommendedCar->id)]) }}" class="text-decoration-none text-dark">
                        <div class="d-flex align-items-center border-bottom py-2">
                            <img src="{{ env('FILE_BASE_URL') . $recommendedCar->listing_img1 }}" alt="Car" width="80" height="60" class="rounded me-3">
                            <div>
                                <p class="mb-1 fw-semibold">{{ $recommendedCar->listing_year }} {{ $recommendedCar->listing_model }}</p>
                                <p class="text-muted small mb-0">AED {{ number_format($recommendedCar->listing_price) }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAg11eAiAzKB6kMmJXfRbElSfK96RkDVq4&callback=initSmallMap&libraries=maps,marker" async defer></script>
<script>
    const latitude = {{ $car->lat }};
    const longitude = {{ $car->lng }};

    function initSmallMap() {
        const map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: { lat: latitude, lng: longitude },
        });
        new google.maps.Marker({ position: { lat: latitude, lng: longitude }, map });
    }

    function openFullMap() {
        document.getElementById('fullMapModal').style.display = 'block';
        const map = new google.maps.Map(document.getElementById('fullMap'), {
            zoom: 15,
            center: { lat: latitude, lng: longitude },
        });
        new google.maps.Marker({ position: { lat: latitude, lng: longitude }, map });
    }

    function closeFullMap() {
        document.getElementById('fullMapModal').style.display = 'none';
    }
</script>
@endsection
