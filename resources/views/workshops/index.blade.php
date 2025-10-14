@extends('layouts.app')
@php
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Str;

@endphp
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<style>
    .main-home-filter-sec {
        margin-top: 11px !important;
        z-index: 1;
        position: relative;
    }

    .main-car-list-sec .badge-featured,
    .badge-year {
        background-color: #760e13 !important;
    }

    .btn-outline-danger {
        /* background-color: #760e13 !important; */
        /* color: #760e13 !important; */
        border-color: #760e13 !important;
    }

    .btn-outline-danger:hover {
        background-color: #5a0b0f !important;
        border-color: #5a0b0f !important;
        color: #f3f3f3 !important;
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
        font-size: 13px;
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



    .home-slider .carousel-inner img {
        height: 83% !important;
        width: 75% !important;
        /* Adjust to match the required height */
        border-radius: 10px;
        overflow: hidden;
        /* Ensures content fits well */
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 8%;
        background-color: rgba(0, 0, 0, 0.5) !important;

    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5) !important;
        padding: 5px;
        border-radius: 50%;
        /* color: rgba(0, 0, 0, 0.5) !important; */
    }

    /* تخصيص اقاط */
    .carousel-indicators [data-bs-target] {
        background-color: #fff;
        width: 12px;
        height: 12px;
        border-radius: 50%;
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


    @media (max-width: 572px) {
        .home-slider .carousel-inner img {
            height: 100% !important;
            width: 100% !important;
            /* Adjust to match the required height */
            border-radius: 10px;
            overflow: hidden;
            /* Ensures content fits well */
        }

        .home-slider .carousel-item {
            height: 60%;
            /* Ensure all items have the same height mnbdm    */
            /* Ensure all items have the same height mnbdm    */
        }

        .home-slider .carousel-inner {
            height: 30%;
        }

        .home-slider .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Prevents distortion */
        }

    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 8%;
        padding: 5px;
        background-color: rgba(0, 0, 0, 0.5) !important;

    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.5) !important;
        padding: 5px;
        width: 8%;
        border-radius: 50%;
        /* color: rgba(0, 0, 0, 0.5) !important; */
    }

    /* تخصص النقاط */
    .carousel-indicators [data-bs-target] {
        background-color: #fff;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-bottom: 4px;
    }
</style>
<!-- home slider -->

<style>
    .custom-container {
        width: 100%;

    }


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
            height: 70vh;
            background-color: #5a0b0f !important;
            object-fit: contain;
            width: 100%;
        }

        .carousel-item img {

            width: 100vw;
            /* min-height: 100vh;  */
            object-fit: contain;

        }
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

@section('content')
    <!-- home slider -->
    <div id="demo" class="carousel slide mt-1" data-bs-ride="carousel" data-bs-interval="2000">
        <!-- لناط -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
        </div>

        <!-- الصور -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block   " src="{{asset('1.jpg')}}" alt="Los Angeles">
            </div>
            <div class="carousel-item">
                <img class="d-block   " src="{{asset('2.jpg')}}" alt="Chicago">
            </div>
            <div class="carousel-item">
                <img class="d-block   " src="{{asset('3.jpg')}}" alt="Chicago">
            </div>
            <div class="carousel-item">
                <img class="d-block   " src="{{asset('4.jpg')}}" alt="New York">
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
    <!-- filter -->
    <!-- Start filter home with items -->

    <div class="container ">
        <!-- Navigation Buttons -->

        <div class="d-flex flex-wrap justify-content-center gap-3 my-2">
            <a href="{{route('cars.index')}}" class="nav-btn text-decoration-none">
                Cars</a>
            <a href="{{route('spareParts.index')}}" class="nav-btn text-decoration-none">Spare Parts</a>
            <a href="{{route('workshops.index')}}" class="nav-btn active text-decoration-none">WorkShops</a>
        </div>

        <!-- Filter Bar -->
        <div class="card shadow-sm p-2">
            <div class="overflow-auto">
                <form class="d-flex flex-nowrap gap-2 justify-around" id="filterForm" method="GET"
                    style="min-width: 600px;">
                    <!-- Make Dropdown -->
                    <div style="min-width: 150px;">
                        <select class="form-select" id="brand" name="brand_id">
                            <option value="" selected class="text-muted">Make</option>
                            @foreach($brands as $key => $brand)
                                <option value="{{ $key }}" {{ request('brand_id') == $key ? 'selected' : '' }}>
                                    {{ $brand }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Category Dropdown -->
                    <div style="min-width: 150px;">
                        <select class="form-select" id="workshop" name="workshop_category_id">
                            <option value="" selected class="text-muted">Category</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $key }}" {{ request('category_id') == $key ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- City Dropdown -->
                    <div style="min-width: 150px;">
                        <select class="form-select" id="city" name="city">
                            <option value="" selected class="text-muted">City</option>
                            @foreach($cities as $city)
                                @if(!empty($city))
                                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div style="min-width: 100px;">
                        <button type="submit" class="btn w-100 text-white" style="background-color: #760e13;">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>



    <!-- List -->
    <div class="custom-container main-car-list-sec my-4">
        <div class="row">
            @foreach ($workshops as $workshop)
                @php

                    $shareUrl = request()->path() == 'workshops'
                        ? request()->url() . '?id=' . $workshop->id
                        : request()->fullUrl() . '?id=' . $workshop->id;
                @endphp
                <div class="col-sm-3 col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-3">

                    <!-- <div class="card shadow border-0 d-flex flex-column h-100" style="border-radius: 12px; overflow: hidden;"> -->
                    <div class="car-card border-0 shadow d-flex flex-column h-100 "
                        style="border-radius: 12px; overflow: hidden;">



                        <div class="car-image position-relative" style="
                                                                            width: 100%;
                                                                            height: 220px;
                                                                            background-color: #f0f0f0;
                                                                            border-radius: 10px;
                                                                            overflow: hidden;
                                                                            display: flex;
                                                                            align-items: center;
                                                                            justify-content: center;

                                                                            ">
                     @php
    $image = $workshop->workshop_logo
        ? (Str::startsWith($workshop->workshop_logo, ['http://', 'https://'])
            ? $workshop->workshop_logo
            : env('CLOUDFLARE_R2_URL') . $workshop->workshop_logo)
        : asset('workshopNotFound.png');
@endphp

<img id="cardImage"
     src="{{ $image }}"
     alt="Car Image"
     style="height: 100% !important; width: 100% !important; object-fit: cover; object-position: center; transition: transform 0.3s ease-in-out; aspect-ratio: 16/9;"
     loading="lazy"
     onerror="this.onerror=null; this.src='{{ asset('workshopNotFound.png') }}'">

                        </div>




                        <div class="card-body d-flex flex-column justify-content-between  text-start mx-4 mt-2">
                            <div>
                                <h5 class="card-title  text-truncate" title="{{ $workshop->workshop_name }}"
                                    style="color:  #760e13; font-weight: bold ">
                                    {{ Str::limit(ucwords(strtolower($workshop->workshop_name)), 25, '...') }}
                                </h5>
                                {{-- <p class="card-text mb-1">
                                    <i class="fas fa-star text-warning" style="color:#760e13; "></i> 4.5
                                </p> --}}
                                <!-- <p class="card-text text-muted mb-1">
                                                        <i class="fas fa-map-marker-alt" style="color:#760e13; "></i> {{ $workshop->address }}
                                                    </p> -->
                                <p class="card-text text-muted mb-1 text-truncate" title="{{ $workshop->address }}"
                                    style="max-width: 100%; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
                                    <i class="fas fa-map-marker-alt" style="color:#760e13;"></i>
                                    {{ $workshop->address }}
                                </p>

                                <br>


                                <p class="card-text text-muted">
                                    {{-- اليوم الأول --}}
                                    @if(isset($workshop->days[0]))
                                        <i class="fas fa-clock" style="color:#760e13;"></i>
                                        {{ $workshop->days[0]->day }}: {{ $workshop->days[0]->from }} - {{ $workshop->days[0]->to }}
                                    @endif

                                    {{-- Dropdown لبقي الأيام --}}
                                    @if(count($workshop->days) > 1)
                                        <div class="dropdown mt-2">
                                            <a class="btn btn-sm btn-outline-secondary dropdown-toggle" href="#" role="button"
                                                id="dropdownDays" data-bs-toggle="dropdown" aria-expanded="false"
                                                style="border-radius: 10px;">
                                                more...
                                            </a>

                                            <ul class="dropdown-menu" aria-labelledby="dropdownDays">
                                                @foreach($workshop->days as $key => $day)
                                                    @if($key == 0) @continue @endif
                                                    <li class="px-3 py-1 text-muted">
                                                        <i class="fas fa-clock" style="color:#760e13;"></i>
                                                        {{ $day->day }}: {{ $day->from }} - {{ $day->to }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </p>

                                <br>
                            </div>

                            <div class="actions mt-auto">
                                <a href="https://wa.me/{{ $workshop->user->phone }}" target="_blank">
                                    <button class="btn btn-outline-danger w-100 mb-2" style="border-radius: 15px;">
                                        <i class="fab fa-whatsapp" style="color: #198754;"></i> WhatsApp
                                    </button>
                                </a>

                                <a href="tel:{{ $workshop->user->phone }}">
                                    <button class="btn btn-outline-danger w-100 mb-2"
                                        style="border-radius: 15px; margin-left:1px; margin-right:1px">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>

                                <a href="https://wa.me/?text={{ urlencode('Hello, I recommend you to check this Store ' . $shareUrl) }}"
                                    target="_blank" class="flex-grow-1">
                                    <button class="btn btn-outline-danger w-100" style="border-radius: 15px;">
                                        <i class="fa fa-share"></i> Share
                                    </button>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!--

            -->

    @push('carlistingscript')
        {{-- Script related filters on spareParts page --}}
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
            function copyUrl() {
                const url = window.location.href; // Get current URL

                navigator.clipboard.writeText(url).then(() => {
                    alert('URL copied : ' + url);
                }).catch(err => {
                    console.error('Failed to copy URL: ', err);
                });
            }

            $(document).on('change', '#brand', function () {
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
                        success: function (response) {
                            // console.log(response);

                            // Populate the child select box
                            $('#model').empty().append('<option value="">Select Model</option>');

                            response.models.forEach(function (model) {
                                let modelName = model ?? 'No Parent';

                                $('#model').append('<option value="' + modelName + '">' +
                                    modelName +
                                    '</option>');
                            });
                        },
                        error: function (xhr) {
                            console.error("Error fetching models:", xhr.responseText);
                        }
                    });
                } else {
                    // Reset the child select box if no item is selected
                    $('#model').empty().append('<option value="">model</option>');
                }


            });

            $(document).on('change', '#category', function () {
                let category = $(this).val();

                if (category) {
                    $.ajax({
                        url: "{{ route('getSubCategories') }}", // Adjust this route as needed
                        method: "POST",
                        data: {
                            category: category,
                            _token: $('meta[name="csrf-token"]').attr(
                                'content') // CSRF token for security
                        },
                        success: function (response) {
                            // console.log(response);

                            // Populate the child select box
                            $('#subCategory').empty().append('<option value="">Select subCategory</option>');

                            response.subCategories.forEach(function (subCategory) {
                                let subCategoryName = subCategory ?? 'No Parent';

                                $('#subCategory').append('<option value="' + subCategoryName + '">' +
                                    subCategoryName +
                                    '</option>');
                            });
                        },
                        error: function (xhr) {
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