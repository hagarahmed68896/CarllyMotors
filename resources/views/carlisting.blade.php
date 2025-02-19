@extends('layouts.app')
@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

@endphp
@section('content')

<!-- breadcrumd-listting -->
<div class="container-fluid border-line-list-car">
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrums-list-car">
                <li>
                    <a style="color: #760e13;" href="">Home > </a>
                </li>
                <li class="used-car-text">
                    Used cars for sale
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Header Section -->
<div class="header-section">
    <h2>10,000+ Get The Best Deals On Used Cars</h2>
    <p>Explore our selection of high-quality, pre-owned vehicles. Our inventory includes top brands like Toyota,
        Mercedes, Honda, and more.</p>
</div>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-md-3">
            <div class="filter-sidebar">
                <h5>Filters and Sort</h5>
                <hr>
                <form id="filterForm" method="GET" action="{{ route('filter.cars') }}">
                    <!-- Make -->
                    <div class="form-group">
                        <label>Make</label>
                        <select class="form-control" name="make" id="make" onchange="submitFilterForm()">
                            <option value="">Select Make</option>
                            @foreach($makes as $make)
                                <option value="{{$make}}" {{ request('make') == $make ? 'selected' : '' }}>{{$make}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Model -->
                    <div class="form-group">
                        <label>Model</label>
                        <select class="form-control" name="model" id="model" onchange="submitFilterForm()">
                            <option value="">Select Model</option>
                            @foreach($models as $model)
                                <option value="{{$model}}" {{ request('model') == $model ? 'selected' : '' }}>{{$model}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="form-group">
                        <label for="priceRange">Price: <span id="priceValue">{{ request('price', $minPrice) }}</span></label>
                        <input
                            type="range"
                            class="form-control-range"
                            id="priceRange"
                            min="{{ $minPrice }}"
                            max="{{ $maxPrice }}"
                            value="{{ request('price', $minPrice) }}"
                            name="price"
                            oninput="updatePriceValue(this.value); submitFilterForm()">
                    </div>
                    <!-- <input type="hidden" id="priceHidden" name="price" value=""> -->

                    <!-- Fuel Type -->
                    <div class="form-group">
                        <label>Fuel Type</label>
                        <select class="form-control" name="fuel_type" id="fuel_type" onchange="submitFilterForm()">
                            <option value="">Select Fuel Type</option>
                            @foreach($fueltypes as $fueltype)
                                <option value="{{ $fueltype }}" {{ request('fuel_type') == $fueltype ? 'selected' : '' }}>{{ $fueltype }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Transmission -->
                    <div class="form-group">
                        <label>Transmission</label>
                        <select class="form-control" name="transmission" id="transmission" onchange="submitFilterForm()">
                            <option value="">Select Transmission</option>
                            @foreach($gears as $gear)
                                <option value="{{$gear}}" {{ request('transmission') == $gear ? 'selected' : '' }}>{{$gear}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Driver Type -->
                    <div class="form-group">
                        <label>Driver Type</label>
                        <select class="form-control" name="driver_type" id="driver_type" onchange="submitFilterForm()">
                            <option value="" {{ request('driver_type') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                            <option value="" {{ request('driver_type') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        </select>
                    </div>

                    <!-- Door -->
                    <div class="form-group">
                        <label>Door</label>
                        <select class="form-control" name="door" id="door" onchange="submitFilterForm()">
                            <option value="">Select Door</option>
                            @foreach($doors as $door)
                                <option value="{{ $door }}" {{ request('door') == $door ? 'selected' : '' }}>{{$door}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cylinder -->
                    <div class="form-group">
                        <label>Cylinder</label>
                        <select class="form-control" name="cylinder" id="cylinder" onchange="submitFilterForm()">
                            <option value="">Select Cylinders</option>
                            @foreach($cylinders as $cylinder)
                                <option value="{{$cylinder}}" {{ request('cylinder') == $cylinder ? 'selected' : '' }}>{{$cylinder}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Color -->
                    <div class="form-group">
                        <label>Color</label>
                        <select class="form-control" name="color" id="color" onchange="submitFilterForm()">
                            <option value="">Select Color</option>
                            @foreach($colors as $color)
                                <option value="{{$color}}" {{ request('color') == $color ? 'selected' : '' }}>{{$color}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year -->
                    <div class="form-group">
                        <label for="yearRange">
                            Year: <span id="yearValue">{{ request('year', $minYear) }}</span>
                        </label>
                        <input
                            type="range"
                            class="form-control-range"
                            id="yearRange"
                            min="{{ $minYear }}"
                            max="{{ $maxYear }}"
                            value="{{ request('year', $minYear) }}"
                            name="year"
                            oninput="updateYearValue(this.value); submitFilterForm()">
                    </div>
                    <!-- <input type="hidden" id="yearHidden" name="year" value=""> -->

                    <!-- Distance -->
                    <div class="form-group">
                        <label for="distanceRange">
                            Distance: <span id="distanceValue">{{ request('distance') }}</span>kms
                        </label>
                        <input
                            type="range"
                            class="form-control-range"
                            id="distanceRange"
                            value="{{ request('distance') }}"
                            name="distance"
                            oninput="updateDistanceValue(this.value); submitFilterForm()">
                    </div>
                    <input type="hidden" id="distanceHidden" name="distance" value="">
                </form>
            </div>
        </div>
        <!-- Car Listings -->
        <div class="col-md-9">
            <div class="row">
                <!-- Car Item filters-->
                <div class="col-md-12">
                    <div class="filter-bar d-flex flex-wrap">
                        <div class="results-count">Showing {{ $carlisting->firstItem() }}-{{ $carlisting->lastItem() }} of {{ $carlisting->total() }} results</div>
                        <div class="d-flex ml-auto">
                            <!-- View Toggle Buttons -->
                            <div class="view-buttons">
                                <a href="{{route('listing.grid')}}" class="btn"><i class="fas fa-th"></i></a>
                                <a href="{{route('carlisting')}}" class="btn"><i class="fas fa-bars"></i></a>
                            </div>

                             <!-- Show Per Page Dropdown -->
                            <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center justify-content-between mb-3">
                                <!-- Show Per Page Dropdown -->
                                <div class="d-flex align-items-center ml-3">
                                    <label for="perPage" class="mr-2">Show:</label>
                                    <select name="perPage" id="perPage" class="custom-select" style="width: auto;" onchange="this.form.submit()">
                                        <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                                        <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center ml-3">
                                    <label for="sortBy" class="mr-2">Sort by:</label>
                                    <select name="sortBy" id="sortBy" class="custom-select" style="width: auto;" onchange="this.form.submit()">
                                        <option value="default" {{ request('sortBy') == 'default' ? 'selected' : '' }}>Sort by (Default)</option>
                                        <option value="Price: Low to High" {{ request('sortBy') == 'Price: Low to High' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="Price: High to Low" {{ request('sortBy') == 'Price: High to Low' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="Newest" {{ request('sortBy') == 'Newest' ? 'selected' : '' }}>Newest</option>
                                        <option value="Oldest" {{ request('sortBy') == 'Oldest' ? 'selected' : '' }}>Oldest</option>
                                    </select>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- Car Item listing -->
                @if ($carlisting->isNotEmpty())
                    @foreach ($carlisting as $car)
                        @php
                            $user = $car->user;
                        @endphp
                        <div class="col-md-12">
                            <div class="car-list-sec">
                                <div class="row">
                                     <div class="col-md-5 pr-0">
                                        <div class="car-card border-0 p-3" >
                                            <div id="carouselExample" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach([$car->listing_img1, $car->listing_img2, $car->listing_img3, $car->listing_img4, $car->listing_img5] as $index => $image)
                                                        @if($image)
                                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                <div class="badge-featured">Featured</div>
                                                                <div class="badge-images">
                                                                    <img src="{{ config('app.file_base_url') . $image }}" alt="Car Image">
                                                                </div>
                                                                <div class="badge-year">{{ $car->listing_year }}</div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExample" role="button"
                                                    data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExample" role="button"
                                                    data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 pl-0">
                                        <span class="featured">{{$car->cities}}</span>
                                        <h5 class="car-listing-title">{{$car->listing_title}}</h5>
                                        <p>{{$car->features_speed}}kms | {{$car->features_fuel_type}} | {{$car->features_gear}}</p>
                                        <p class="price">${{$car->listing_price}}</p>
                                        <a href=" {{ route('car.detail', [Crypt::encrypt($car->id)]) }}" class="btn btn-view">View Details</a>
                                    </div>
                                    <div class="col-md-3 pl-0 ">
                                        <div class="chat-card shadow-none border-0">
                                            <div class="row">
                                                <div class="col-sm-4 pr-0 border-0">
                                                    @if (isset($car->user))
                                                        <img src="{{ config('app.file_base_url'). $user->image }}" alt="User Profile">
                                                    @else
                                                        <img src="https://www.shutterstock.com/image-vector/user-profile-icon-vector-avatar-600nw-2220431045.jpg" alt="Default User Profile">
                                                    @endif
                                                </div>
                                                <div class="col-sm-8 text-left border-0">
                                                    @if (isset($car->user))
                                                        <h6>{{ $user->fname }} {{ $user->lname }}</h6>
                                                        <p>{{ $user->created_at }}</p>
                                                    @else
                                                        <h6>User not available</h6>
                                                    @endif
                                                </div>
                                            </div>
                                            <button class="btn chat-btn border-0"><i class="far fa-comment-dots"></i>
                                                Chat</button>
                                            <p>View 20 variants matching your search criteria</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <p class="text-center">No cars found.</p>
                    </div>
                @endif

            </div>
            <div class="pagination-links mb-0 d-flex justify-content-center" style="margin: 0;">
                {{ $carlisting->appends(['perPage' => request('8')])->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@push('carlistingscript')
    {{-- Script related filters on carlisting page --}}
    <script>
        function submitFilterForm() {
            document.getElementById('filterForm').submit();
        }
        //Update the Year value display
        function updateYearValue(value) {
        let yearValue = document.getElementById('yearValue');
        let yearHidden = document.getElementById('yearHidden');

        if (value === "" || value == {{ $minYear }}) {
            yearValue.innerText = "Any";
            yearHidden.value = "";  // Ensure NULL is sent if not selected
        } else {
            yearValue.innerText = value;
            yearHidden.value = value;
        }}

        // Update the distance value display

        // Update the price value display
        function updatePriceValue(value) {
        let priceValue = document.getElementById('priceValue');
        let priceHidden = document.getElementById('priceHidden');

        if (value === "" || value == {{ $minPrice }}) {
            priceValue.innerText = "Any";
            priceHidden.value = "";  // Ensuring NULL is sent if not selected
        } else {
            priceValue.innerText = value;
            priceHidden.value = value;
        }
    }
    </script>
@endpush
@endsection
