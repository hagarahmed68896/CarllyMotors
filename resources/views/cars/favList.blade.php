@extends('layouts.app')
@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

@endphp

<style>
/* Price Input Fields */
.price-range {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 16px;
    font-weight: bold;
    margin-top: 10%;

}

input[type="number"] {}

/* Range Slider Wrapper */
.range-slider {
    position: relative;
    width: 100%;
    margin: 20px 0;
    height: 6px;
    background: #e3c5b5;
    /* Light brown background */
    border-radius: 5px;
}

/* Range Inputs */
.range-slider input[type="range"] {
    position: absolute;
    width: 100%;
    appearance: none;
    background: transparent;
    pointer-events: none;
    /* Makes the background clickable */
}

/* Styling the Track */
.range-slider input[type="range"]::-webkit-slider-runnable-track {
    height: 6px;
    background: transparent;
    border-radius: 5px;
}

/* Styling the Thumbs */
.range-slider input[type="range"]::-webkit-slider-thumb {
    appearance: none;
    width: 20px;
    height: 20px;
    background: #7b4b40;
    border-radius: 50%;
    cursor: pointer;
    pointer-events: auto;
    /* Allows interaction */
    margin-top: -7px;
    /* Adjust thumb position */
}

/* Filter Button */
.filter-btn {
    width: 100% !important;
    padding: 12px !important;
    background: #9b3128 !important;
    color: white !important;
    font-size: 16px !important;
    font-weight: bold !important;
    border: none !important;
    border-radius: 8px !important;
    cursor: pointer !important;
    margin-top: 20px !important;
}

.filter-btn:hover {
    background: #80251e;
}

.close {
    cursor: pointer;
}

.button-like-select {
    background-color: #80251e;

    /* Adjust padding */
    border: 1px solid #ccc !important;

}

/* Optional: Hover effect similar to select */
.button-like-select:hover {
    background-color: #f0f0f0 !important;
}

/* Optional: Active effect */
.button-like-select:active {
    background-color: #e0e0e0 !important;

}

.main-home-filter-sec {
    margin-top: 11px !important;
    z-index: 1;
    position: relative;
}

.main-car-list-sec .badge-featured,
.badge-year {
    background-color: #760e13 !important;
}


.car-card-body {
    background-color: #f3f3f3;
    /* border-radius: 15px; */
    padding: 15px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    color: #4a4a4a;
    /* border-top: 5px solid #760e13; */

}

.price-location {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.price {
    color: #760e13;
    font-size: 22px;
}

.location {
    color: #4a4a4a;
    font-size: 16px;
    display: flex;
    align-items: center;
}

.location i {
    margin-right: 5px;
    color: #760e13;
}

.showroom-name {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 12px;
    color: #333;
}

.car-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 5px;
    font-size: 14px;

    color: #6b6b6b;
}

.car-details p {
    margin: 5px 0;
}

.car-details strong {
    color: #4a4a4a;
    font-weight: bold;
}

.actions {
    display: flex;
    justify-content: space-around;
    margin-top: 15px;
}

.call-btn {
    background-color: #760e13;
    color: white;
    border-color: #760e13;
}

.share-btn {
    background-color: #f3f3f3;
    color: #760e13;
    border-color: #760e13;
}

.actions i {
    font-size: 16px;
}
.carousel-control-prev, .carousel-control-next {
            width: 8%;
            padding: 5px;
            background-color: rgba(0, 0, 0, 0.5) !important;
            
        }

        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5) !important;
            padding: 5px;
            width: 8%;
            border-radius: 50%;
            /* color: rgba(0, 0, 0, 0.5) !important; */
        }

        
        .carousel-indicators [data-bs-target] {
            background-color: #fff;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-bottom: 4px;
        }
</style>

<style>
    .custom-container {
    width: 100%; /*`container-fluid` */

}

/*`container` */
@media (min-width: 1400px) {
    .custom-container {
        max-width: 1250px;
        margin: 0 auto;
    }


}
.carousel-item img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100vw;  

    min-width: 100vw; 
    /* min-height: 100vh;  */
    object-fit: contain;

}
.carousel-inner {
    height: 80vh;
    background-color: #5a0b0f !important;
}

.carousel {
    position: relative;
}

@media (max-width: 470px) {
    .carousel-inner {
    height: 18vh;
    background-color: #5a0b0f !important;
}
} 

@media (min-width: 1600px) {
    .carousel {
        max-width: 1250px; 
        margin: 0 auto;
        width: 100vw; 
        /* height: 30vh; */
    }
    .carousel-inner {
    height: 40vh; 
    background-color: #5a0b0f !important;
}
.carousel-item img {
    
    width: 100vw; 
    /* min-height: 100vh;  */
    object-fit: contain;

}
}

    
</style>
@section('content')
<!-- home slider -->
<div id="demo" class=" carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
    <!--  النقاط -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
    </div>

    <!-- الصور -->
    <div class="carousel-inner">
    <div class="carousel-item active">
            <img class="d-block   "   src="{{asset('1.jpg')}}" alt="Los Angeles">
        </div>
        <div class="carousel-item">
            <img class="d-block   "  src="{{asset('2.jpg')}}" alt="Chicago">
        </div>
        <div class="carousel-item">
            <img class="d-block   "  src="{{asset('3.jpg')}}" alt="Chicago">
        </div>
        <div class="carousel-item">
            <img class="d-block   "  src="{{asset('4.jpg')}}" alt="New York">
        </div>
    </div>

    <!-- أزرار التنقل -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- <div class="container my-6 main-home-filter-sec text-center" style="margin-top: 11px;"> -->
    <!-- List -->
    <div class="tab-content  text-center" id="bodyTypeTabsContent">
        <div class="custom-container main-car-list-sec" >
            <div class="row">
                @foreach ($carlisting as $key => $car)

              
                <div class="col-sm-3 col-sm-12 col-md-6 col-lg-4 col-xl-3 ">
                    <div class="car-card border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                        <!-- Car Image Section with Consistent Aspect Ratio -->
                        <div class="car-image position-relative" style="
                        width: 100%;
                        height: 220px;
                        background-color: #f0f0f0;
                        border-radius: 10px;
                        overflow: hidden;
                        display: flex;
                        align-items: center;
                        justify-content: center;">

                            <a href="{{ route('car.detail',$car->id)}}"
                                style="width: 100%; height: 100%; display: block;">
                                <img id="cardImage" src="{{ config('app.file_base_url') . $car->listing_img1 }}"
                                    alt="Car Image" style="
            height: 100% !important;
            width: 100% !important;
            object-fit: cover;
            object-position: center;
            transition: transform 0.3s ease-in-out;
            aspect-ratio: 16/9;
            cursor: pointer;" loading="lazy"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/350x219?text=No+Image';">
                            </a>
                            <!-- Badges -->
                            <div class="badge-year">{{ $car->listing_year }}</div>
                        </div>

                        <!-- Car Content Section -->
                        <div class="car-card-body">

                            <div class="price-location">
                                <span class="price">AED {{$car->listing_price}}</span>
                                @if($car->user?->lat && $car->user?->lng)
                                <a href="https://www.google.com/maps?q={{$car->user->lat}},{{$car->user->lng}}">
                                    <span class="location"><i class="fas fa-map-marker-alt"></i> {{$car->city}}</span>
                                </a>
                                @endif
                            </div>

                            <h4 class="showroom-name">{{$car->user?->fname}} {{$car->user?->lname}}</h4>

                            <div class="car-details">
                                <p><strong>Make:</strong> <span>{{$car->listing_type}}</span></p>
                                <p><strong>Model:</strong> <span>{{$car->listing_model}}</span></p>
                                <p><strong>Year:</strong> <span>{{$car->listing_year}}</span></p>
                                <p><strong>Mileage:</strong> <span>215000 Kms</span></p>
                            </div>

                            <div class="actions">
                                <a href="https://wa.me/{{ $car->user->phone }}" target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 15px;">
                                        <i class="fab fa-whatsapp "  style="color: #198754; "></i> WhatsApp
                                    </button>
                                </a>
                                @if($os == 'Windows' || $os == 'Linux' )
                                <a href="https://wa.me/{{ $car->user->phone }}" target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 15px; margin-left:2px; margin-right:2px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @elseif($os == 'Mac')
                                <a href={{ 'https://faceapp.com?phone=' . urlencode($car->user->phone) }}>
                                    <button class="btn btn-outline-danger" style="border-radius: 15px; margin-left:2px; margin-right:2px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @elseif($os == 'Android' || $os='iOS')
                                <a href="tel:{{ $car->user->phone }}">
                                    <button class="btn btn-outline-danger" style="border-radius: 15px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @else
                                No OS Detected
                                @endif

                                <a href=" https://wa.me/?text={{ urlencode('Hello, i recommend you to check this car ' . route('car.detail', $car->id)) }}"
                                    target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 15px;">
                                        <i class="fa fa-share"></i>
                                        Share
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
<!-- </div> -->

@push('carlistingscript')
{{-- Script related filters on carlisting page --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
function copyUrl(carUrl) {
    navigator.clipboard.writeText(carUrl).then(() => {
        alert('URL copied: ' + carUrl);
    }).catch(err => {
        console.error('Failed to copy URL: ', err);
    });
}
</script>
@endpush
@endsection