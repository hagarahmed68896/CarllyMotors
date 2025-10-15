@extends('layouts.app')
@php
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Str;

@endphp
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
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

    /* تخصيص النقاط */
    .carousel-indicators [data-bs-target] {
        background-color: #fff;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-bottom: 4px;
    }
</style>
<style>
    .action-btn {
    border: 2px solid #760e13;
    color: #760e13;
    border-radius: 15px;
    height: 55px;
    width: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    background-color: #fff;
}

.action-btn i {
    font-size: 22px;
}

.action-btn:hover {
    background-color: #760e13;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
}

</style>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

@section('content')
    <!-- home slider -->

    <style>
        .custom-container {
            width: 100%;

        }

        .object-fit-cover {
            object-fit: cover;
            object-position: center;
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
            object-fit: contain;
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

    {{-- <div id="demo" class="carousel slide mt-1" data-bs-ride="carousel" data-bs-interval="2000">
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
    </div> --}}
    <!-- filter -->
    <!-- Start filter home with items -->

  <div class="container-fluid my-5 main-home-filter-sec">
    <div class="row g-4">

        {{-- ================= FILTER SIDEBAR ================= --}}
        @if(request()->path() == 'spareParts')
            <div class="col-lg-3 col-md-4">
                <div class="bg-white border rounded-4 shadow-sm p-4 h-100">
                    <h5 class="fw-bold mb-3 text-center" style="color: #760e13">
                        <i class="fas fa-sliders-h me-2"></i>Filter Spare Parts
                    </h5>

                    <form id="filterForm" method="GET" action="{{ route('filter.spareParts') }}">
                        {{-- Make --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Make</label>
                            <select class="form-select" id="brand" name="make">
                                <option value="">All Makes</option>
                                @foreach($makes as $make)
                                    <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>
                                        {{ $make }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Model --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Model</label>
                            <select class="form-select" id="model" name="model">
                                <option value="">All Models</option>
                            </select>
                        </div>

                        {{-- Year --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Year</label>
                            <select class="form-select" name="year">
                                <option value="">All Years</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- City --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">City</label>
                            <select class="form-select" name="city">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    @if(!empty($city))
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                            {{ $city }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        {{-- Category --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sub-category --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Sub-Category</label>
                            <select class="form-select" id="subCategory" name="subCategory">
                                <option value="">All Sub-Categories</option>
                            </select>
                        </div>

                        {{-- Condition --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-muted">Condition</label>
                            <select class="form-select" name="condition">
                                <option value="">All Conditions</option>
                                <option value="New" {{ request('condition') == 'New' ? 'selected' : '' }}>New</option>
                                <option value="Used" {{ request('condition') == 'Used' ? 'selected' : '' }}>Used</option>
                            </select>
                        </div>

                        {{-- VIN Input --}}
                        <div id="vin-input-container" class="mb-3" style="display:none;">
                            <label class="form-label fw-semibold small text-muted">VIN Number</label>
                            <input type="text" name="vin_number" id="vin-number" class="form-control"
                                   placeholder="Enter VIN Number">
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2 border-top pt-3">
                            <button type="submit" class="btn flex-fill text-white fw-semibold"
                                    style="background-color:#760e13;">
                                Apply Filters
                            </button>
                            <button type="button" onclick="resetFilters()" class="btn btn-outline-secondary flex-fill">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            {{-- ================= CAR SUMMARY ================= --}}
            <div class="col-12">
                <div class="bg-white shadow-sm rounded-4 p-4 text-start mx-auto" style="max-width: 600px;">
                    <h5 class="fw-bold text-center text-danger mb-4">Your Car Details</h5>
                    <div class="row gy-2 small">
                        <div class="col-6 fw-semibold text-muted">Car Type:</div>
                        <div class="col-6 bg-light rounded px-2 py-1">{{ request()->make ?? '--' }}</div>

                        <div class="col-6 fw-semibold text-muted">Car Model:</div>
                        <div class="col-6 bg-light rounded px-2 py-1">{{ request()->model ?? '--' }}</div>

                        <div class="col-6 fw-semibold text-muted">Car Year:</div>
                        <div class="col-6 bg-light rounded px-2 py-1">{{ request()->year ?? '--' }}</div>

                        <div class="col-6 fw-semibold text-muted">Category:</div>
                        <div class="col-6 bg-light rounded px-2 py-1">{{ request()->category ?? '--' }}</div>

                        <div class="col-6 fw-semibold text-muted">Sub-category:</div>
                        <div class="col-6 bg-light rounded px-2 py-1">{{ request()->subCategory ?? '--' }}</div>
                    </div>
                </div>
            </div>
        @endif

        {{-- ================= DEALERS LIST ================= --}}
        <div class="@if(request()->path() == 'spareParts') col-lg-9 col-md-8 @else col-12 @endif">
            <div class="row g-4">
                @foreach ($dealers as $dealer)
                    @php
                        $image = Str::after($dealer->company_img, url('/') . '/');
                        $dealerName = ucfirst(strtolower($dealer->company_name));
                        $dealerName = substr($dealerName, 0, 25);
                        $phone = $dealer->user->phone;
                        $shareUrl = request()->path() == 'spareParts'
                            ? request()->url() . '?shop_id=' . $dealer->id
                            : request()->fullUrl() . '&shop_id=' . $dealer->id;
                        $isMobile = Str::contains(request()->header('User-Agent'), ['Android', 'iPhone', 'iPad']);
                    @endphp

                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                            {{-- Image --}}
                            <div class="bg-light position-relative" style="height: 220px; overflow: hidden;">
                                <img src="{{ config('app.file_base_url') . $image }}" alt="Dealer Image"
                                     class="w-100 h-100 object-fit-cover"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/350x219?text=No+Image';"
                                     loading="lazy">
                            </div>

                            {{-- Content --}}
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h6 class="fw-bold text-truncate mb-0" style="color:#760e13" title="{{ $dealer->company_name }}">
                                        {{ $dealerName }}{{ strlen($dealer->company_name) >= 25 ? '...' : '' }}
                                    </h6>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($dealer->company_address) }}"
                                       target="_blank" class="text-decoration-none small text-muted">
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i> Location
                                    </a>
                                </div>

                                {{-- Actions --}}
                              <div class="actions d-flex justify-content-between align-items-center gap-2 mt-2">
    <a href="https://wa.me/{{ $phone }}" target="_blank" class="btn btn-outline-success">
        <i class="fab fa-whatsapp"></i>
    </a>

    @php
        $isMobile = Str::contains(request()->header('User-Agent'), ['Android', 'iPhone', 'iPad']);
    @endphp

    @if($isMobile)
        <a href="tel:{{ $phone }}" class="btn btn-outline-danger">
            <i class="fas fa-phone"></i>
        </a>
    @else
        <a href="https://wa.me/{{ $phone }}" target="_blank" class="btn btn-outline-danger">
            <i class="fas fa-phone"></i>
        </a>
    @endif

    <a href="https://wa.me/?text={{ urlencode('Check this store: ' . $shareUrl) }}" 
       target="_blank" class="btn btn-outline-primary">
        <i class="fa fa-share"></i>
    </a>
</div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

    </div>
    </div>

    <!-- <style>
      .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 6px 12px;
        font-size: 14px;
      }
      .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px;
      }
    </style> -->


    @push('carlistingscript')
        {{-- Script related filters on spareParts page --}}
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function () {
                // تطبيق Select2 على جميع select داخل #filterForm
                $('#filterForm select').select2({
                    width: 'resolve',
                    minimumResultsForSearch: 0, // يظهر حقل البحث دائمًا
                    dropdownAutoWidth: true
                });
            });
        </script>



        <script>
            $(document).ready(function () {
                function formatCategory(state) {
                    if (!state.id) return state.text; // لعنصر placeholder
                    let image = $(state.element).data('image');
                    let $state = $(`
              <div class="text-center">
                <img src="${image}" style="width: 40px; height: 40px; object-fit: cover;" class="mb-1 rounded-circle" />
                <div style="font-size: 13px;">${state.text}</div>
              </div>
            `);
                    return $state;
                }

                $('#category').select2({
                    templateResult: formatCategory,
                    templateSelection: formatCategory,
                    minimumResultsForSearch: 0, // لإظهار البحث دائمًا
                    width: 'resolve',
                    dropdownAutoWidth: true
                });
            });
        </script>


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

        <!-- ✅ JavaScript placed at the END of body -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const conditionSelect = document.getElementById('condition-select');
                const vinInputContainer = document.getElementById('vin-input-container');
                const vinInput = document.getElementById('vin-number');

                function toggleVINField() {
                    if (conditionSelect.value === 'New') {
                        vinInputContainer.style.display = 'block';
                        vinInput.setAttribute('required', 'required');
                    } else {
                        vinInputContainer.style.display = 'none';
                        vinInput.removeAttribute('required');
                        vinInput.value = '';
                    }
                }

                toggleVINField(); // Run once on page load
                conditionSelect.addEventListener('change', toggleVINField);
            });
        </script>
    @endpush
@endsection