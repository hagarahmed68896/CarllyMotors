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
        
        /* ❤️ Heart icon on top of image */
        .carSwiper form {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }

        .carSwiper i.fa-heart {
            font-size: 28px;
            color: white;
            text-shadow: 0 0 5px rgba(0,0,0,0.6);
            transition: transform 0.3s;
        }

        .carSwiper i.fa-heart:hover {
            transform: scale(1.2);
        }
    </style>
</head>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

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
  <div class="swiper carSwiper rounded-3">
            <!-- Heart Icon -->
                    @auth
                        @php
                            $favCars = auth()->user()->favCars()->pluck('id')->toArray();
                        @endphp
                        <form action="{{ route('cars.addTofav', $car->id) }}" method="post">
                            @csrf
                            <button class="btn btn-link p-0">
                                <i class="fas fa-heart" style="color: {{ in_array($car->id, $favCars) ? '#760e13' : 'white' }}"></i>
                            </button>
                        </form>
                    @endauth
    <div class="swiper-wrapper">
      @if($images && count($images) > 0)
        @foreach ($images as $image)
          <div class="swiper-slide">
            <img src="{{ $image }}" alt="Car Image">
          </div>
        @endforeach
      @else
        <div class="swiper-slide">
          <img src="{{ asset('carNotFound.jpg') }}" alt="Car Not Found">
        </div>
      @endif
    </div>

    <!-- Navigation arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>

    <!-- Pagination dots -->
    <div class="swiper-pagination"></div>
  </div>
</div>
<style>
.carSwiper {
  width: 100%;
  height: 500px; /* consistent height */
  border-radius: 15px;
  overflow: hidden;
  position: relative;
}

.carSwiper .swiper-slide {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.carSwiper img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* ✅ fill area completely */
  object-position: center; /* keep car centered */
  border-radius: 0;
  transition: transform 0.4s ease;
}

.carSwiper img:hover {
  transform: scale(1.03); /* smooth zoom */
}

/* Navigation arrows */
.swiper-button-next,
.swiper-button-prev {
  color: #fff;
  text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

/* Pagination dots */
.swiper-pagination-bullet {
  background: #fff;
  opacity: 0.8;
}
.swiper-pagination-bullet-active {
  background: #dc3545;
}

/* Responsive */
@media (max-width: 992px) {
  .carSwiper {
    height: 400px;
  }
}
@media (max-width: 576px) {
  .carSwiper {
    height: 300px;
  }
}
</style>


<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  const swiper = new Swiper('.carSwiper', {
    loop: true,
    grabCursor: true,
    centeredSlides: true,
    spaceBetween: 10,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });
</script>

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

                {{-- @auth
                    @php
                        $favCars = auth()->user()->favCars()->pluck('id')->toArray();
                    @endphp
                    <form action="{{ route('cars.addTofav', $car->id) }}" method="post">
                        @csrf
                        <button class="btn btn-link text-decoration-none p-0">
                            <i class="fas fa-heart" style="font-size: 22px; color: {{ in_array($car->id, $favCars) ? '#760e13' : 'gray' }}"></i>
                        </button>
                    </form>
                @endauth --}}
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
@if(!empty($car->user?->phone))
    <a href="https://wa.me/{{ $car->user?->phone }}?text={{ urlencode(
    "Carlly Motors\n\n" .
    "مرحبًا، أتواصل معك للاستفسار عن السيارة المعروضة للبيع، " . $car->listing_type . " " . $car->listing_model . "، في Carlly Motors. هل لا تزال متوفرة؟\n\n" .
    "Hello, We are contacting you about the car for sale, " . $car->listing_type . " " . $car->listing_model . ", at Carlly Motors. Is it available?\n\n" .
    "Car Model : " . $car->listing_model . "\n" .
    "Car Type : " . $car->listing_type . "\n" .
    "Year Of Manufacture : " . $car->listing_year . "\n" .
    "Car Price : " . number_format($car->listing_price) . " AED\n" .
    "Car URL : " . route('car.detail', $car->id)
) }}"
    target="_blank"
    class="flex-fill text-decoration-none">
        <button class="btn btn-outline-success w-100 rounded-4">
            <i class="fab fa-whatsapp me-1"></i> 
        </button>
    </a>
@endif



  @php
    $isMobile = Str::contains(request()->header('User-Agent'), ['Android', 'iPhone', 'iPad']);
    $phone = $car->user?->phone;
@endphp

@if(!empty($phone))
    @if($isMobile)
        <a href="tel:{{ $phone }}" class="btn btn-outline-danger flex-fill rounded-4">
            <i class="fa fa-phone"></i>
        </a>
    @else
        <a href="https://wa.me/{{ $phone }}" target="_blank" class="btn btn-outline-danger flex-fill rounded-4">
            <i class="fa fa-phone"></i>
        </a>
    @endif
@endif


  <a href="https://wa.me/?text={{ urlencode(
    'اطّلع على هذه السيارة على موقع Carlly! عروض مميّزة بانتظارك' . "\n\n" .
    'Check out my latest find on Carlly! Great deals await. Don’t miss out!' . "\n" .
    route('car.detail', $car->id)
) }}"
target="_blank" 
title="Share via WhatsApp"
aria-label="Share via WhatsApp"
class="btn btn-outline-primary flex-fill rounded-4">
    <i class="fas fa-share-alt"></i>
</a>

</div>

            </div>

            <!-- Recommended Cars -->
            <div class="card shadow-sm border-0 p-3">
                <h5 class="fw-bold mb-1">Recommended Cars</h5>
                <small class="text-muted mb-3">You might also like</small>

                @foreach ($recommendedCars as $recommendedCar)
                    <a href="{{ route('car.detail', $recommendedCar->id) }}" class="text-decoration-none text-dark">
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
