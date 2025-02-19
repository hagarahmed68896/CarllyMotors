@extends('layouts.app')
@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

@endphp
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- breadcrumd-listting -->
<div class="container-fluid border-line-list-car">
    <div class="row">
        <div class="col-sm-12">
            <ul class="breadcrums-list-car">
                <li>
                    <a href="{{route('home')}}" style="color: #760e13;" href="">Home > </a>
                </li>
                <li class="used-car-text">
                    Spare Parts for sale
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Header Section -->
<div class="header-section">
    <h2>10,000+ Get The Best Deals On Spare Parts</h2>
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
                <form id="filterForm" method="GET" action="{{ route('filter.spareParts') }}">
                    <!-- Make -->
                    <div class="form-group">
                        <label>Make</label>
                        <select class="form-control" name="make" id="make" onchange="submitFilterForm()">
                            <option value="">Select Make</option>
                            @foreach($makes as $make)
                            <option value="{{$make}}" {{ request('make') == $make ? 'selected' : '' }}>{{$make}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Model -->
                    <div class="form-group">
                        <label>Model</label>
                        <select class="form-control" name="model" id="model" onchange="submitFilterForm()">
                            <option value="">Select Model</option>
                            @foreach($models as $model)
                            @if($model == '' || $model == null)
                            @continue
                            @endif
                            <option value="{{$model}}" {{ request('model') == $model ? 'selected' : '' }}>
                                {{$model}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Brand</label>
                        <select class="form-control" name="brand" id="brand" onchange="submitFilterForm()">
                            <option value="">Select brand</option>
                            @foreach($brands as $brand)
                            @if($brand == '' || $brand == null)
                            @continue
                            @endif
                            <option value="{{$brand}}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                {{$brand}}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label>category</label>
                        <select class="form-control" name="category" id="category" onchange="submitFilterForm()">
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                            @if($category == '' || $category == null)
                            @continue
                            @endif
                            <option value="{{$category}}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{$category}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>price</label>
                        <select class="form-control" name="price" id="price" onchange="submitFilterForm()">
                            <option value="">Select price</option>
                            @foreach($prices as $price)
                            @if($price == '' || $price == null)
                            @continue
                            @endif
                            <option value="{{$price}}" {{ request('price') == $price ? 'selected' : '' }}>
                                {{$price}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>City</label>
                        <select class="form-control" name="city" id="city" onchange="submitFilterForm()">
                            <option value="">Select city</option>
                            @foreach($cities as $city)
                            @if($city == '' || $city == null)
                            @continue
                            @endif
                            <option value="{{$city}}" {{ request('city') == $city ? 'selected' : '' }}>
                                {{$city}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Year -->
                    <div class="form-group">
                        <label>year</label>
                        <select class="form-control" name="year" id="year" onchange="submitFilterForm()">
                            <option value="">Select year</option>
                            @foreach($years as $year)
                            <option value="{{$year}}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{$year}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- car_model -->
                    <div class="form-group">
                        <label>Car Models</label>
                        <select class="form-control" name="car_model" id="car_model" onchange="submitFilterForm()">
                            <option value="">Select Car Model</option>
                            @foreach($car_models as $car_model)
                            <option value="{{$car_model}}" {{ request('car_model') == $car_model ? 'selected' : '' }}>
                                {{$car_model}}
                            </option>
                            @endforeach
                        </select>
                    </diV>
                </form>
            </div>
        </div>
        <!-- Car Listings -->
        <div class="col-md-9">
            <div class="row">
                <!-- Car Item filters-->
                <div class="col-md-12">
                    <div class="filter-bar d-flex flex-wrap">
                        <div class="results-count">Showing {{ $spareParts->firstItem() }}-{{ $spareParts->lastItem() }}
                            of {{ $spareParts->total() }} results</div>
                        <div class="d-flex ml-auto">
                            <!-- View Toggle Buttons -->
                            {{--<div class="view-buttons">
                                <a href="{{route('listing.grid')}}" class="btn"><i class="fas fa-th"></i></a>
                            <a href="{{route('spareParts')}}" class="btn"><i class="fas fa-bars"></i></a>
                        </div>--}}

                        <!-- Show Per Page Dropdown -->
                        <form method="GET" action="{{ url()->current() }}"
                            class="d-flex align-items-center justify-content-between mb-3 mr-5">
                            <!-- Show Per Page Dropdown -->
                            <div class="d-flex align-items-center ml-3">
                                <label for="perPage" class="mr-2"></label>
                                <select name="perPage" id="perPage" class="custom-select" style="width: auto;"
                                    onchange="this.form.submit()">
                                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('perPage') == 20 ? 'selected' : '' }}>20</option>
                                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div class="d-flex align-items-center ml-3">
                                <label for="sortBy" class="mr-3"></label>
                                <select name="sortBy" id="sortBy" class="custom-select" style="width: auto;"
                                    onchange="this.form.submit()">
                                    <option value="default" {{ request('sortBy') == 'default' ? 'selected' : '' }}>Sort
                                        by (Default)</option>
                                    <option value="Price: Low to High"
                                        {{ request('sortBy') == 'Price: Low to High' ? 'selected' : '' }}>Price: Low to
                                        High</option>
                                    <option value="Price: High to Low"
                                        {{ request('sortBy') == 'Price: High to Low' ? 'selected' : '' }}>Price: High to
                                        Low</option>
                                    <option value="Newest" {{ request('sortBy') == 'Newest' ? 'selected' : '' }}>Newest
                                    </option>
                                    <option value="Oldest" {{ request('sortBy') == 'Oldest' ? 'selected' : '' }}>Oldest
                                    </option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Car Item listing -->
            @forelse($spareParts as $part)
            @php
            $user = $part->user;
            @endphp
            <div class="col-md-12">
                <div class="car-list-sec">
                    <div class="row">
                        <div class="col-md-5 pr-0">
                            <div class="car-card border-0 p-3">
                                <div id="carouselExample" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        @php
                                        $images = array_filter($part->images()->pluck('image')->toArray()); // Remove
                                        null
                                        @endphp
                                        @foreach($images as $index => $image)
                                        @php
                                        $image = Str::after($image, url('/').'/');
                                        @endphp
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <div class="badge-featured">Featured</div>
                                            <div class="badge-images">
                                                <img src="{{ config('app.file_base_url') . $image }}" alt="part Image">
                                            </div>
                                            <div class="badge-year">{{ $part->brand }}</div>
                                        </div>
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
                        <div class="col-md-3 ml-3 pl-0">
                            <span class="featured">
                                <a data-bs-toggle="modal" data-bs-target="#carModels">Car-models</a> |
                                <a data-bs-toggle="modal" data-bs-target="#yearsModal">Years</a>
                            </span>

                            <!-- Car Models Modal -->
                            <div class="modal fade" id="carModels" tabindex="-1" aria-labelledby="carModelsLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="carModelsLabel">Car Models</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @php
                                            $decoded = json_decode($part->car_model, true);
                                            $carModels = is_array($decoded) ? $decoded : json_decode($decoded, true);

                                            @endphp
                                            @foreach($carModels as $model)
                                            <ul>
                                                <li>{{ $model }}</li>
                                            </ul>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- years Modal -->
                            <div class="modal fade" id="yearsModal" tabindex="-1" aria-labelledby="yearsModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="yearsModalLabel">Years</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <ul>
                                                @foreach(json_decode($part->year, true) as $year)
                                                <li>{{ $year }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <h5 class="car-listing-title">{{$part->title}}</h5>
                            <p>{{$part->model}} | {{$part->part_type}} | {{$part->category->name}}</p>
                            <p class="price">AED {{$part->price}}</p>
                            <a href=" {{ route('spareParts.show', $part->id)  }}" class="btn btn-view">View
                                Details</a>
                        </div>
                        <div class="col-md-3 pl-0 ">
                            <div class="chat-card shadow-none border-0">
                                <div class="row">
                                    <div class="col-sm-4 pr-0 border-0">
                                        {{--@if (isset($part->user))
                                                        <img src="{{ config('app.file_base_url'). $user->image }}"
                                        alt="User Profile">
                                        @else--}}
                                        <img src="https://i.pinimg.com/736x/59/ce/78/59ce78d39fee53f1156c8d36a4eb9acb.jpg"
                                            alt="Default User Profile">
                                        {{--@endif--}}
                                    </div>
                                    <div class="col-sm-8 text-left border-0">
                                        @if(isset($part->user))
                                        <h6>{{ $user->fname }} {{ $user->lname }}</h6>
                                        <p>{{ $user->created_at }}</p>
                                        @else
                                        <h6>User not available</h6>
                                        @endif
                                    </div>
                                </div>
                                <a href="https://wa.me/{{ $part->user->phone }}" target="_blank">
                                    <button class="btn chat-btn border-0"><i class="far fa-comment-dots"></i>
                                        WhatsApp</button>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-center">No cars found.</p>
            </div>
            @endforelse

        </div>
        <div class="pagination-links mb-0 d-flex justify-content-center" style="margin: 0;">
            {{ $spareParts->appends(['perPage' => request('perPage')])->links('pagination::bootstrap-4') }}

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
</script>
@endpush
@endsection