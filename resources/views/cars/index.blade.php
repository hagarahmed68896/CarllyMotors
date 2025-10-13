@extends('layouts.app')
@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

@endphp
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
    /* background-color: #f3f3f3; */
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

        /* تخصيص النقاط */
        .carousel-indicators [data-bs-target] {
            background-color: #fff;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-bottom: 4px;
        }
</style>

@section('content')
<!-- home slider -->

<style>
    .custom-container {
    width: 100%; /* افتراضيًا يكون `container-fluid` */

}

/* عند تجاوز 1400px، يصبح مثل `container` */
@media (min-width: 1400px) {
    .custom-container {
        max-width: 1250px; /* أو أي عرض مناسب */
        margin: 0 auto; /* يضمن أن يكون في المنتصف */
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
.filter-bar .form-row > div {
    margin-right: 0.75rem; /* مسافة بين العناصر */
}
.filter-bar .form-row > div:last-child {
    margin-right: 0; /* إزالة المسافة من العنصر الأخير */
}


    
</style>

<div id="demo" class=" carousel slide mt-1" data-bs-ride="carousel" data-bs-interval="2000">
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
<!-- filter -->

<div class=" my-6 main-home-filter-sec text-center" style="margin-top: 11px;">
    <!-- <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="{{route('cars.index')}}" class="nav-btn active  text-decoration-none }">
            Cars</a>
        <a href="{{route('spareParts.index')}}"
            class="nav-btn  text-decoration-none ">Spare Parts</a>
            <a href="{{route('workshops.index')}}"
            class="nav-btn  text-decoration-none ">WorkShops</a>
    </div> -->
    <div class="d-flex flex-wrap justify-content-center gap-3 my-2">
                <a href="{{route('cars.index')}}" class="nav-btn active  text-decoration-none }">
                    Cars</a>
                <a href="{{route('spareParts.index')}}" class="nav-btn  text-decoration-none ">Spare Parts</a>
                <a href="{{route('workshops.index')}}" class="nav-btn  text-decoration-none ">WorkShops</a>
            </div>

 <div class="container filter-bar my-2">
    <!-- Scrollable wrapper -->
    <div class="d-flex flex-nowrap overflow-auto gap-2 px-2 py-1" style="scroll-snap-type: x mandatory;">
        <form class="form-row mb-0 d-flex flex-nowrap gap-3  justify-around" id="filterForm" action="{{route('cars.index')}}" method="get">

            <!-- car_type Dropdown -->
            <div class="flex-shrink-0 me-3">
                <select class="form-control" onchange="submitFilterForm()" name="car_type" data-placeholder="Select Car Type">
                    <option value="UsedOrNew" {{request('car_type') == 'UsedOrNew' ? 'selected' : ''}}>Used/New</option>
                    <option value="Imported" {{request('car_type') == 'Imported' ? 'selected' : ''}}>Imported</option>
                    <option value="Auction" {{request('car_type') == 'Auction' ? 'selected' : ''}}>Auction</option>
                </select>
            </div>

            <!-- City Dropdown -->
            <div class="flex-shrink-0 me-3">
                <select class="form-control" onchange="submitFilterForm()" name="city" data-placeholder="Select City">
                    <option value="" selected>City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Make Dropdown -->
            <div class="flex-shrink-0">
                <select class="form-control" id="brand" name="make" data-placeholder="Select Make">
                    <option value="" selected>Make</option>
                    @foreach($makes as $make)
                        <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Model Dropdown -->
            <div class="flex-shrink-0">
                <select class="form-control" onchange="submitFilterForm()" id="model" name="model" data-placeholder="Select Model">
                    <option value="" selected>Model</option>
                </select>
            </div>

            <!-- Year Dropdown -->
            <div class="flex-shrink-0">
                <select class="form-control" onchange="submitFilterForm()" name="year" data-placeholder="Select Year">
                    <option value="" selected>Year</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Body Type Dropdown -->
            <div class="flex-shrink-0">
                <select class="form-control" onchange="submitFilterForm()" name="body_type" data-placeholder="Select BodyType">
                    <option value="" selected>Body Type</option>
                    @foreach($bodyTypes as $bodyType)
                        <option value="{{ $bodyType }}" {{ request('body_type') == $bodyType ? 'selected' : '' }}>{{ $bodyType }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Regional Specs -->
            <div class="flex-shrink-0">
                <select class="form-control" onchange="submitFilterForm()" name="regionalSpecs" data-placeholder="Select regionalSpecs">
                    <option value="" selected>Regional Specs</option>
                    @foreach($regionalSpecs as $regionalSpec)
                        <option value="{{ $regionalSpec }}" {{ request('regionalSpec') == $regionalSpec ? 'selected' : '' }}>
                            {{ $regionalSpec }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Price Modal Trigger -->
            <!-- price -->
        <!-- Price Modal Trigger -->
<div class="flex-shrink-0">
    <button type="button" class="form-control" onclick="openModal()">Price</button>


    <div id="priceModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 style="color:#7b4b40; font-weight:bold; font-size: 20px;">Price</h2>
        <div class="price-range">
            <input type="number" id="minPrice" name="priceFrom" min="{{$minPrice}}" max="{{$maxPrice}}" value="{{request('priceFrom') != '' ? request('priceFrom') : $minPrice}}">
            <span>to</span>
            <input type="number" id="maxPrice" name="priceTo" min="{{$minPrice}}" max="{{$maxPrice}}" value="{{request('priceTo') != '' ? request('priceTo') : $maxPrice}}">
        </div>
        <button class="filter-btn" onclick="submitFilterForm()">Filter</button>
    </div>
</div>

        </form>
    </div>
</div>

<!-- Price Modal (كما هو بدون تغيير كبير) -->
<!-- <div id="priceModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2 style="color:#7b4b40; font-weight:bold; font-size: 20px;">Price</h2>
    <div class="price-range">
        <input type="number" id="minPrice" name="priceFrom" min="{{$minPrice}}" max="{{$maxPrice}}" value="{{request('priceFrom') != '' ? request('priceFrom') :$minPrice}}">
        <span>to</span>
        <input type="number" id="maxPrice" name="priceTo" min="{{$minPrice}}" max="{{$maxPrice}}" value="{{request('priceTo') != '' ? request('priceTo') :$maxPrice}}">
    </div>
    <button class="filter-btn" onclick="submitFilterForm()">Filter</button>
</div> -->

    <!-- List -->

 <div class="tab-content" id="bodyTypeTabsContent">
    <div class="custom-container main-car-list-sec">
            <div class="row">
                @foreach ($carlisting as $key => $car)

                <div class="col-sm-3 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="car-card border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                        <!-- Car Image Section with Consistent Aspect Ratio -->
                        <div class="car-image position-relative" style="
                        width: 100%;
                        height: 220px;
                        background-color: #f0f0f0;
                        /* border-radius: 10px; */
                        overflow: hidden;
                        display: flex;
                        align-items: center;
                        justify-content: center;
 ">

                            <a href="{{ route('car.detail', $car->id) }}"
                                style="width: 100%; height: 100%; display: block;">
                                @if($car->image != null)
                                <img id="cardImage" src="{{ env("CLOUDFLARE_R2_URL").$car->images[0]->image}}"
                                    alt="Car Image"
                                       class=""
                                     style="
                                         height: 90% !important;
                                            width: 100% !important;
                                            object-fit: cover;
                                           object-position: center;
                                           transition: transform 0.3s ease-in-out;
                                            aspect-ratio: 16/9;
                                            cursor: pointer;" loading="lazy"
                                    onerror="this.onerror=null; this.src='{{ asset('carNotFound.jpg') }}">
                                    @else
                                    <img id="cardImage" src="{{ asset('carNotFound.jpg') }}"
                                    alt="Car Image"
                                       class=""
                                     style="
                                         height: 90% !important;
                                            width: 100% !important;
                                            object-fit: cover;
                                           object-position: center;
                                           transition: transform 0.3s ease-in-out;
                                            aspect-ratio: 16/9;
                                            cursor: pointer;" loading="lazy"
                                    onerror="this.onerror=null; this.src='{{ asset('carNotFound.jpg') }}">
                                    @endif
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
                                <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank">
                                <button class="btn btn-outline-danger" style="border-radius: 15px;">
                                        <i class="fab fa-whatsapp "  style="color: #198754; "></i> WhatsApp
                                    </button>
                                </a>
                                @if($os == 'Windows' || $os == 'Linux' )
                                <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 15px; margin-left:2px; margin-right:2px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @elseif($os == 'Mac')
                                <a href={{ 'https://faceapp.com?phone=' . urlencode($car->user?->phone) }}>
                                    <button class="btn btn-outline-danger" style="border-radius: 15px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @elseif($os == 'Android' || $os='iOS')
                                <a href="tel:{{ $car->user->phone }}">
                                    <button class="btn btn-outline-danger" style="border-radius: 15px;">
                                        <i class="fa fa-phone"></i> Make Call
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


            <!-- <div class="pagination-links mb-0 d-flex justify-content-center" style="margin: 0;">
                {{ $carlisting->appends(['perPage' => request('perPage')])->links('vendor.pagination.bootstrap-4') }}
            </div> -->
            <div class="">
    <!-- <h2 class="text-center">لسيارات المتحة</h2> -->
    <div class="row" id="car-list">
        @include('cars.load_more') <!-- تحيل الائمة الأساية -->
    </div>
    <div id="loading" class="text-center" style="display: none;">
        <p>Loading..</p>
    </div>
</div>

        </div>
    </div>
</div>


@push('carlistingscript')
{{-- Script related filters on carlisting page --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
ر<!-- jQuery (مطلوب لـ Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



<script>
    $(document).ready(function() {
        // تفعيل select2 على جميع selectات داخل الفورم
        $('#filterForm select').select2({
            // placeholder: "Select an option",
            allowClear: true,
            width: 'resolve'
        });

        // تنفيذ الفلترة عند تغيير أي حقل
        $('#filterForm select').on('change', function () {
            submitFilterForm();
        });
    });

    // دالة إرسال الفورم
    function submitFilterForm() {
        document.getElementById("filterForm").submit();
    }

    // دوال فتح/إغلاق مودال السعر
    function openModal() {
        document.getElementById("priceModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("priceModal").style.display = "none";
    }
</script>

<script>
   let page = 1;
let loading = false;

$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
        if (!loading) {
            loadMoreData();
        }
    }
});

function loadMoreData() {
    loading = true;
    $("#loading").show(); // عرض رساة التحمل

    $.ajax({
        url: '?page=' + (page + 1),
        type: 'GET',
        success: function(data) {
            if (data.trim() === '') {
                $(window).off("scroll");
                
                $("#loading").text("لا يوجد لمزيد من السيارا");
            } else {
                $("#car-list").append(data);
                page++;
            }
        },
        error: function(xhr, status, error) {
            console.error("Error loading more cars:", error);
            $("#loading").text("حدث خطأ، حاول مة أخرى.");
        },
        complete: function() {
            loading = false;
            $("#loading").hide();
        }
    });
}

</script>






<script>
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