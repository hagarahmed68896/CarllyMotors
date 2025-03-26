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
    border-radius: 15px;
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

        /* تخصيص النقاط */
        .carousel-indicators [data-bs-target] {
            background-color: #fff;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-bottom: 4px;
        }


</style>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

@section('content')
 <!-- home slider -->
 <style>
    .carousel-item img {
        position: absolute;
        top: 0;
        left: 0;
        /* min-width: 100vw !important;  */
        height: 100vh;
        object-fit: cover ;
    }

    .carousel-inner {
        height: 70vh;
         background-color: #5a0b0f !important;
    }

    .carousel {
        position: relative;
    }
    
</style>

<div id="demo" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
    <!-- النقاط -->
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
<!-- filter -->
<!-- Start filter home with items -->

<div class=" my-6 main-home-filter-sec text-center">
    <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="{{route('cars.index')}}" class="nav-btn">
            All Car
        </a>
        <a href="{{route('spareParts.index')}}" class="nav-btn active">
            Spare Parts
        </a>
    </div>
    @if(request()->path() == "spareParts")
    <div class="container filter-bar my-2">
        <form class="form-row mb-0" id="filterForm" action="{{route('filter.spareParts')}}" method="get">
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
                <select class="form-control" id="model" name="model">
                    <option value="" selected>Model</option>
                </select>
            </div>

            <!-- Year Dropdown -->
            <div class="col-">
                <select class="form-control" name="year">
                    <option value="" selected>Year</option>
                    @foreach($years as $year)

                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-">
                <select class="form-control" name="city">
                    <option value="" selected>city</option>
                    @foreach($cities as $city)
                    @if($city == null || $city == '')
                    @continue
                    @endif
                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                        {{ $city }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Make Dropdown -->
            <div class="col-">
                <select class="form-control" id="category" name="category">
                    <option value="" selected>category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Model Dropdown -->
            <div class="col-">
                <select class="form-control" id="subCategory" name="subCategory">
                    <option value="" selected>Sub-Category</option>
                </select>
            </div>

            <div class="col-">
                <select class="form-control" name="condition">
                    @foreach($conditions as $condition)
                    <option value="{{ $condition }}" {{ request('condition') == $condition ? 'selected' : '' }}>
                        {{ $condition }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-">
                <button class="btn btn-outline-danger bg-carlly" type="submit" style="border-radius: 25px;">
                    Search
                </button>
            </div>
        </form>
       
    </div>
    @else
    <div class="max-w-lg mx-auto p-4 bg-white shadow-md rounded-2xl mt-3">
        <div class="text-center font-bold text-xl mb-4">Your Car</div>
        <div class="grid grid-cols-2 gap-2 text-sm">
            <div class="font-semibold">Car Type:</div>
            <div class="bg-gray-200 px-2 py-1 rounded-md">{{request()->make ?? '--'}}</div>

            <div class="font-semibold">Car Model:</div>
            <div class="bg-gray-200 px-2 py-1 rounded-md">{{request()->model ?? '--'}}</div>

            <div class="font-semibold">Car Year:</div>
            <div class="bg-gray-200 px-2 py-1 rounded-md">{{request()->year ?? '--'}}</div>

            <div class="font-semibold">Category:</div>
            <div class="bg-gray-200 px-2 py-1 rounded-md">{{request()->category ?? '--'}}</div>

            <div class="font-semibold">Sub-category:</div>
            <div class="bg-gray-200 px-2 py-1 rounded-md">{{request()->subCategory ?? '--'}}</div>
        </div>
    </div>

    @endif
    <!-- List -->
    <div class="tab-content" id="bodyTypeTabsContent">
    <div class="mr-10 main-car-list-sec" style="margin-right:50px; margin-left:50px;">
            <div class="row">
                @foreach ($dealers as $key => $dealer)
                <div class="col-sm-3 col-sm-12 col-md-6 col-lg-4 col-xl-3">
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
                        justify-content: center;
                     
                        "
                        
                        >
                            @php
                            $image = Str::after($dealer->company_img, url('/').'/');
                            $dealerName = ucfirst(strtolower($dealer->company_name));
                            $dealerName = substr($dealerName,0,25);

                            @endphp
                            <img id="cardImage" src="{{ config('app.file_base_url') . $image }}" alt="Car Image" style="
                              height: 100%; !important;
                              width: 100%; !important;
                                object-fit: cover;
                                object-position: center;
                                transition: transform 0.3s ease-in-out;
                                aspect-ratio: 16/9;" loading="lazy"
                                onerror="this.onerror=null; this.src='https://via.placeholder.com/350x219?text=No+Image';">
                        </div>

                        <!-- Car Content Section -->
                        <div class="car-card-body">
                            <div class="price-location">
                                <span style="color: #760e13; font-size:16px;" title="{{$dealer->company_name}}">
                                    {{$dealerName}}{{strlen($dealer->company_name) >= 25 ? '...' : ''}}
                                </span>
                                <a
                                    href={{"https://www.google.com/maps/search/?api=1&query=" . urlencode($dealer->company_address)}}>

                                    <span class="location"><i class="fas fa-map-marker-alt"></i>Location</span>
                                </a>
                            </div>
                            <div class="actions">
                                <a href="https://wa.me/{{ $dealer->user->phone }}" target="_blank">
                                <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fab fa-whatsapp "  style="color: #198754; "></i> WhatsApp
                                    </button>
                                </a>
                                @if($os == 'Windows' || $os == 'Linux' )
                                <a href="https://wa.me/{{ $dealer->user->phone }}" target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 25px; margin-left:2px; margin-right:2px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @elseif($os == 'Mac')
                                <a href={{ 'https://faceapp.com?phone=' . urlencode($dealer->user->phone) }}>
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @elseif($os == 'Android' || $os='iOS')
                                <a href="tel:{{ $dealer->user->phone }}">
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @else
                                No OS Detected
                                @endif
                                @if(request()->path() == 'spareParts')
                                <a href=" https://wa.me/?text={{ urlencode('Hello, i recommend you to check this Store ' . request()->url() . '?dealer_id='. $dealer->id)}}"
                                    target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fa fa-share"></i>
                                        Share
                                    </button>
                                </a>
                                @else
                                <a href=" https://wa.me/?text={{ urlencode('Hello, i recommend you to check this Store ' . request()->fullUrl() . '&dealer_id='. $dealer->id)}}"
                                    target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                        <i class="fa fa-share"></i>
                                        Share
                                    </button>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{--<div class="pagination-links mb-0 d-flex justify-content-center" style="margin: 0;">
                {{ $dealers->appends(['perPage' => request('perPage')])->links('pagination::bootstrap-4') }}

        </div>--}}
    </div>
</div>
</div>

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

$(document).on('change', '#category', function() {
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
            success: function(response) {
                // console.log(response);

                // Populate the child select box
                $('#subCategory').empty().append('<option value="">Select subCategory</option>');

                response.subCategories.forEach(function(subCategory) {
                    let subCategoryName = subCategory ?? 'No Parent';

                    $('#subCategory').append('<option value="' + subCategoryName + '">' +
                        subCategoryName +
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