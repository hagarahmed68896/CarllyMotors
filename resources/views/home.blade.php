@extends('layouts.app')
@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
@endphp
<style>
.btn-outline-danger {
    /* background-color: #760e13 !important; */
    border-color: #760e13 !important;
}

.btn-outline-danger:hover {
    background-color: #5a0b0f !important;
    border-color: #5a0b0f !important;
    color: #f3f3f3 !important;
}
</style>
@section('content')

<!-- home slider -->
<div id="demo" class="carousel slide home-slider" data-bs-interval="false">

    <!-- The slideshow -->
    <div class="carousel-inner">
        <div class="carousel-item">
            <img class="img-fluid w-100 mx-auto" src="{{asset('1.jpg')}}" alt="Los Angeles">
        </div>
        <div class="carousel-item">
            <img class="img-fluid w-100 mx-auto" src="{{asset('2.jpg')}}" alt="Chicago">
        </div>
        <div class="carousel-item">
            <img class="img-fluid w-100 mx-auto" src="{{asset('3.jpg')}}" alt="Chicago">
        </div>
        <div class="carousel-item active">
            <img class="img-fluid w-100 mx-auto" src="{{asset('4.jpg')}}" alt="New York">
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
    <div class="filter-bar my-2">
        <form class="form-row mb-0" id="filterForm" action="{{route('cars.index')}}" method="get">

            <!-- car_type Dropdown -->
            <div class="col-">
                <select class="form-control" onchange="submitFilterForm()" name="car_type">
                    <option value="UsedOrNew" {{request('car_type') == 'UsedOrNew' ? 'selected' : ''}}>Used/New</option>
                    <option value="Imported" {{request('car_type') == 'Imported' ? 'selected' : ''}}>Imported</option>
                    <option value="Auction" {{request('car_type') == 'Auction' ? 'selected' : ''}}>Auction</option>
                </select>
            </div>

            <!-- City Dropdown -->
            <div class="col-">
                <select class="form-control" onchange="submitFilterForm()" name="city">
                    <option value="" selected>City</option>
                    @foreach($cities as $city)
                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                        {{ $city }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Make Dropdown -->
            <div class="col-">
                <select class="form-control" id="brand" name="make">
                    <option value="" selected>Make</option>
                    @foreach($makes as $make)
                    <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>
                        {{ $make }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Model Dropdown -->
            <div class="col-">
                <select class="form-control" onchange="submitFilterForm()" id="model" name="model">
                    <option value="" selected>Model</option>
                </select>
            </div>

            <!-- Year Dropdown -->
            <div class="col-">
                <select class="form-control" onchange="submitFilterForm()" name="year">
                    <option value="" selected>Year</option>
                    @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Body Type Dropdown -->
            <div class="col-">
                <select class="form-control" onchange="submitFilterForm()" name="body_type">
                    <option value="" selected>Body Type</option>
                    @foreach($bodyTypes as $bodyType)
                    <option value="{{ $bodyType }}" {{ request('body_type') == $bodyType ? 'selected' : '' }}>
                        {{ $bodyType }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- regionalSpecs Dropdown -->
            <div class="col-">
                <select class="form-control" onchange="submitFilterForm()" name="regionalSpecs">
                    <option value="" selected>regionalSpecs</option>
                    @foreach($regionalSpecs as $regionalSpec)
                    <option value="{{ $regionalSpec }}"
                        {{ request('regionalSpec') == $regionalSpec ? 'selected' : '' }}>
                        {{ $regionalSpec }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Price Dropdown -->
            <div class="col-">
                <button type="button" class="btn button-like-select w-100" onclick="openModal()">Price</button>
                <div id="priceModal" class="modal">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2 style="color:#7b4b40; font-weight:bold; font-size: 20px;">Price</h1>

                        <div class="price-range">
                            <input type="number" id="minPrice" name="priceFrom" min="{{$minPrice}}" max="{{$maxPrice}}"
                                value="{{$minPrice}}">
                            <span>to</span>
                            <input type="number" id="maxPrice" name="priceTo" min="{{$minPrice}}" max="{{$maxPrice}}"
                                value="{{$maxPrice}}">
                        </div>

                        <button class="filter-btn" onclick="submitFilterForm()">Filter</button>
                </div>
            </div>


        </form>
    </div>


    <div class="tab-content" id="bodyTypeTabsContent">
        <div class="container main-car-list-sec">
            <div class="row">
                @foreach ($carlisting as $key => $car)

                <div class="col-sm-3 col-sm-12 col-md-6 col-lg-4 col-xl-4">
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
                            <a href="{{ route('car.detail', [ Crypt::encrypt($car->id)]) }}"
                                style="width: 100%; height: 100%; display: block;">
                                <img id="cardImage" src="{{ config('app.file_base_url') . $car->listing_img1 }}"
                                    alt="Car Image" style="
                              height: 100%; !important;
                              width: 100%; !important;
                                object-fit: cover;
                                object-position: center;
                                transition: transform 0.3s ease-in-out;
                                aspect-ratio: 16/9;" loading="lazy"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/350x219?text=No+Image';">
                            </a>
                            <!-- Badges -->
                            <div class="badge-year">{{ $car->listing_year }}</div>
                        </div>

                        <!-- Car Content Section -->
                        <div class="car-card-body">
                            <div class="price-location">
                                <span class="price">AED {{$car->listing_price}}</span>
                                <a href="https://www.google.com/maps?q={{$car->user->lat}},{{$car->user->lng}}">
                                    <span class="location"><i class="fas fa-map-marker-alt"></i> {{$car->city}}</span>
                                </a>
                            </div>

                            <h4 class="showroom-name">{{$car->user->fname}} {{$car->user->lname}}</h4>

                            <div class="car-details">
                                <p><strong>Make:</strong> <span>{{$car->listing_type}}</span></p>
                                <p><strong>Model:</strong> <span>{{$car->listing_model}}</span></p>
                                <p><strong>Year:</strong> <span>{{$car->listing_year}}</span></p>
                                <p><strong>Mileage:</strong> <span>215000 Kms</span></p>
                            </div>

                            <div class="actions">
                                <a href="https://wa.me/{{ $car->user->phone }}" target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </button>
                                </a>
                                @if($os == 'Windows' || $os == 'Linux' )
                                <a href="https://wa.me/{{ $car->user->phone }}" target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @elseif($os == 'Mac')
                                <a href={{ 'https://faceapp.com?phone=' . urlencode($car->user->phone) }}>
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @elseif($os == 'Android' || $os='iOS')
                                <a href="tel:{{ $car->user->phone }}">
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @else
                                No OS Detected
                                @endif

                                <a href=" https://wa.me/?text={{ urlencode('Hello, i recommend you to check this car ' . route('car.detail', [ Crypt::encrypt($car->id)])) }}"
                                    target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
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
            <div class="mb-0 d-flex justify-content-center" style="margin: 0; float:right">
                <a href="{{route('cars.index')}}" class="btn btn-outline-danger" style="border-radius: 25px;">
                    View More
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
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
        @if($brand->name == 'Honda' || $brand->name == 'Dodge' ||$brand->name == 'Mazda')
        @continue
        @endif
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

<div class="container py-5 last-home-sec">
    <div class="row">
        <!-- Providers App Section -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div
                class="custom-card dark-card d-flex flex-column flex-md-row align-items-center text-center text-md-start">
                <div class="px-3">
                    <h5 class="fw-bold">Providers App</h5>
                    <p>Connect with customers and manage your services efficiently.</p>
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center justify-content-md-start">
                        <a href="https://apps.apple.com/us/app/carlly-provider/id6478307755">
                            <img class="img-fluid store-badge"
                                src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                                alt="App Store">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.carllymotors.carllyprovider">
                            <img class="img-fluid store-badge"
                                src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                                alt="Google Play">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers App Section -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div
                class="custom-card dark-card d-flex flex-column flex-md-row align-items-center text-center text-md-start">
                <div class="px-3">
                    <h5 class="fw-bold">Customers App</h5>
                    <p>Access car buying, selling, and maintenance services effortlessly.</p>
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center justify-content-md-start">
                        <a href="https://apps.apple.com/us/app/carlly-motors/id6478306259"
                            style="background-color:transparent">
                            <img class="img-fluid store-badge"
                                src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                                alt="App Store">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.carllymotors.carllyuser">
                            <img class="img-fluid store-badge"
                                src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                                alt="Google Play">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('carlistingscript')
{{-- Script related filters on carlisting page --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
// Open Modal
function openModal() {
    document.getElementById("priceModal").style.display = "block";
}

// Close Modal
function closeModal() {
    document.getElementById("priceModal").style.display = "none";
}



function submitFilterForm() {
    document.getElementById('filterForm').submit();
}

function copyUrl(carUrl) {
    navigator.clipboard.writeText(carUrl).then(() => {
        alert('URL copied: ' + carUrl);
    }).catch(err => {
        console.error('Failed to copy URL: ', err);
    });
}
$(document).on('change', '#brand', function() {
    let brand = $(this).val();

    if (brand) {
        $.ajax({
            url: "{{ route('getModels') }}", // Adjust this route as needed
            method: "POST",
            data: {
                brand: brand,
                _token: $('meta[name="csrf-token"]').attr(
                    'content') // CSRF token for security
            },
            success: function(response) {
                // console.log(response);

                // Populate the child select box
                $('#model').empty().append('<option value="">Select Model</option>');

                response.models.forEach(function(model) {
                    let modelName = model ?? 'No Parent';

                    $('#model').append('<option value="' + modelName + '">' +
                        modelName +
                        '</option>');
                });
            },
            error: function(xhr) {
                console.error("Error fetching models:", xhr.responseText);
            }
        });
    } else {
        // Reset the child select box if no item is selected
        $('#model').empty().append('<option value="">model</option>');
    }
});
</script>
@endpush
@endsection