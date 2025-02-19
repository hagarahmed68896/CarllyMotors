@extends('layouts.app')
@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

@endphp
@section('content')
<!-- map-view-grid carousuol-->
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            {{-- //Filter view --}}
            <div class="grid-view-filter py-3">
                <div class="container d-flex align-items-center justify-content-between under-view-filter-sec">
                  <!-- Title -->
                  <h4 class="mb-0">Used cars for sale</h4>

                  <!-- Controls -->
                  <div class="d-flex align-items-center">
                    <!-- View Toggle Buttons -->
                    <div class="btn-group mr-3" role="group">
                        <a href="{{route('listing.grid')}}" class="btn"><i class="fas fa-th"></i></a>
                        <a href="{{route('carlisting')}}" class="btn"><i class="fas fa-bars"></i></a>
                    </div>
                    <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center justify-content-between mb-3">

                    <!-- Sort Dropdown -->
                    {{-- <div class="form-group position-relative mr-3" style="margin: 0;">
                      <label for="sortSelect" class="sr-only">Sort by</label>
                      <select class="form-control custom-select with-dropdown-icon" id="sortSelect">
                          <option selected="">Sort by (Default)</option>
                          <option value="lowToHigh">Price: Low to High</option>
                          <option value="highToLow">Price: High to Low</option>
                          <option value="newest">Newest First</option>
                      </select>
                      <i class="fas fa-chevron-down dropdown-icon"></i>
                  </div> --}}
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


                    <!-- Filter Button -->
                    <button type="button" class="btn btn-orange">
                      <i class="fas fa-sliders-h"></i> Filter
                    </button>
                  </div>
                </div>
            </div>
            {{--Carousal View --}}
            <div class="map-view-grid-carousul">
                <div class="container">
                    <div class="row">
                        @if ($carlisting->isNotEmpty())
                            @foreach ($carlisting as $car)
                                @php
                                    $user = $car->user;
                                @endphp
                                <!-- Ensuring each carousel is 4 columns wide in the grid -->
                                <div class="col-md-4 mb-4"> <!-- col-md-4 to fit 3 items per row -->
                                    <div class="card shadow-sm">
                                        <div class="card-header position-relative p-0">
                                            <div class="badge badge-warning position-absolute" style="top: 10px; left: 10px; z-index: 1;">Featured</div>
                                            <div class="badge badge-orange position-absolute" style="top: 10px; right: 10px; z-index: 1;">{{ $car->listing_year }}</div>
                                            <div id="carouselExample" class="carousel slide" data-ride="carousel"> <!-- Unique carousel ID for each loop -->
                                                <div class="carousel-inner">
                                                    @foreach([$car->listing_img1, $car->listing_img2, $car->listing_img3, $car->listing_img4, $car->listing_img5] as $index => $image)
                                                        @if($image)
                                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                                <div class="badge-images">
                                                                    <img src="{{config('app.file_base_url') . $image }}" alt="Car Image" class="img-fluid">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <a class="carousel-control-prev" href="#carousel{{ $loop->index }}" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carousel{{ $loop->index }}" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted mb-1">{{ $car->cities }}</p>
                                            <h5 class="card-title mb-1">{{ $car->listing_title }}</h5>
                                            <p class="middle-carmeter-list" style="font-size: 12px; color: #000;">
                                                <i class="fas fa-tachometer-alt"></i> {{ $car->features_speed }}kms |
                                                <i class="fas fa-gas-pump"></i> {{ $car->features_fuel_type }} |
                                                <i class="fas fa-cogs"></i> {{ $car->features_gear }}
                                            </p>
                                            <h6 class="text-orange font-weight-bold">${{ $car->listing_price }}</h6>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between bg-white">
                                            <div class="d-flex align-items-center">
                                                <span class="rounded-circle bg-light" style="width: 30px; height: 30px;"></span>
                                                @if(isset($car->user))
                                                <span class="ml-2">{{ $user->fname }} {{ $user->lname }}</span>
                                                @else
                                                <span class="ml-2">User not Found.</span>
                                                @endif
                                            </div>
                                            <a href="{{ route('car.detail', [Crypt::encrypt($car->id)]) }}" class="btn btn-outline-primary btn-sm">View car</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Close off the col-md-4 block for each item in the grid -->
                            @endforeach
                        @else
                            <div class="col-12">
                                <p class="text-center">No cars found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pagination-links mb-0 d-flex justify-content-center" style="margin: 0;">
        {{ $carlisting->appends(['perPage' => request('8')])->links('pagination::bootstrap-4') }}
    </div>

</div>
<!-- end carousul-->
@endsection


