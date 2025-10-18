@extends('layouts.app')
@php
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Str;
@endphp

@section('content')
<div id="main-content">
    <!-- Enhanced Carousel Banner -->
    {{-- <div id="demo" class="carousel slide animate__animated animate__fadeIn" data-bs-ride="carousel" data-bs-interval="4000">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{asset('1.jpg')}}" alt="Featured Car 1" loading="eager">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('2.jpg')}}" alt="Featured Car 2" loading="lazy">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('3.jpg')}}" alt="Featured Car 3" loading="lazy">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{asset('4.jpg')}}" alt="Featured Car 4" loading="lazy">
            </div>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div> --}}
   <section class="position-relative" style="background: linear-gradient(90deg, #760e13, #9b2a2f, #c4474c); overflow: hidden; ">
  <div class="container-fluid p-0 position-relative " style="z-index: 2;">
    <img src="{{ asset('1.jpg') }}" alt="Cars" class="w-100 img-fluid object-fit-cover" style="max-height: 550px; object-position: center;">
  </div>

  <!-- Subtle overlay for effect -->
  <div class="position-absolute top-0 start-0 w-100 h-100" 
       style="background: radial-gradient(circle at center, rgba(255,255,255,0.08), transparent 70%); z-index:1;">
  </div>
</section>


<!-- قسم الخدمات -->
<section class="py-5 mt-4 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold mb-3" style="color: #760e13;">Browse from our services</h2>

    <div class="row g-4 justify-content-center">
      <!-- Buy Car -->
  <div class="col-6 col-sm-4 col-md-4 col-lg-2">
        <a href="{{route('cars.index')}}" class="text-decoration-none text-dark">
          <div class="p-4 bg-white rounded-4 shadow-sm hover-shadow transition">
            <i class="fas fa-car fa-2x mb-3" style="color:#760e13;"></i>
            <h5 class="fw-bold">Cars</h5>
            <p class="text-muted small mb-4">Best in class cars</p>
          </div>
        </a>
      </div>

      <!--  Spare Parts -->
  <div class="col-6 col-sm-4 col-md-4 col-lg-2">
        <a href="{{route('spareParts.index')}}" class="text-decoration-none text-dark">
          <div class="p-4 bg-white rounded-4 shadow-sm hover-shadow transition">
          <i class="fas fa-cog fa-2x mb-3" style="color:#760e13;"></i>
            <h5 class="fw-bold">Spare Parts </h5>
        <p class="text-muted small mb-0">Find genuine car parts easily</p>
          </div>
        </a>
      </div>

      <!-- Workshops -->
  <div class="col-6 col-sm-4 col-md-4 col-lg-2">
        <a href="{{route('workshops.index')}}" class="text-decoration-none text-dark">
          <div class="p-4 bg-white rounded-4 shadow-sm hover-shadow transition">
           <i class="fas fa-wrench fa-2x mb-3" style="color:#760e13;"></i> 
           <h5 class="fw-bold">Workshops</h5>
        <p class="text-muted small mb-0">Get expert car service near you</p>
          </div>
        </a>
      </div>



    </div>
  </div>
</section>

<style>
.hover-shadow:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.transition {
  transition: all 0.3s ease;
}
</style>


    <!-- Enhanced Navigation Section -->
    <div class="main-home-filter-sec text-center">
                   <h2 class="section-title animate__animated animate__fadeInUp">Featured Cars</h2>


        <!-- Enhanced Desktop Filter Bar -->
     <!-- FILTER BUTTON WITH CLICK DROPDOWN -->
{{-- <div class="dropdown text-center my-3" data-bs-auto-close="outside" id="filterDropdownWrapper">
  <!-- Filter Button -->
  <button 
    class="btn btn-outline-dark dropdown-toggle px-4 py-2 rounded-pill" 
    type="button" 
    id="filterDropdown" 
    data-bs-toggle="dropdown" 
    aria-expanded="false"
  >
    <i class="fas fa-sliders-h me-2"></i> Filters
  </button>

  <!-- Dropdown Menu -->
  <div 
    class="dropdown-menu dropdown-menu-end p-4 shadow-lg border-0 rounded-4" 
    aria-labelledby="filterDropdown" 
    style="min-width: 800px; max-width: 95vw;"
    id="filterDropdownMenu"
  >
    <form id="filterForm" action="{{ route('cars.index') }}" method="get">
      <div class="row g-3">

        <!-- Car Type -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Car Type</label>
          <select class="form-select" name="car_type">
            <option value="UsedOrNew" {{ request('car_type') == 'UsedOrNew' ? 'selected' : '' }}>Used/New</option>
            <option value="Imported" {{ request('car_type') == 'Imported' ? 'selected' : '' }}>Imported</option>
            <option value="Auction" {{ request('car_type') == 'Auction' ? 'selected' : '' }}>Auction</option>
          </select>
        </div>

        <!-- City -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">City</label>
          <select class="form-select" name="city">
            <option value="">All Cities</option>
            @foreach($cities as $city)
              <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
            @endforeach
          </select>
        </div>

        <!-- Make -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Make</label>
          <select class="form-select" name="make">
            <option value="">All Makes</option>
            @foreach($makes as $make)
              <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
            @endforeach
          </select>
        </div>

        <!-- Model -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Model</label>
          <select class="form-select" name="model">
            <option value="">All Models</option>
            @foreach($models as $model)
              <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>{{ $model }}</option>
            @endforeach
          </select>
        </div>

        <!-- Year -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Year</label>
          <select class="form-select" name="year">
            <option value="">All Years</option>
            @foreach($years as $year)
              <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endforeach
          </select>
        </div>

        <!-- Body Type -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Body Type</label>
          <select class="form-select" name="body_type">
            <option value="">All Body Types</option>
            @foreach($bodyTypes as $bodyType)
              <option value="{{ $bodyType }}" {{ request('body_type') == $bodyType ? 'selected' : '' }}>{{ $bodyType }}</option>
            @endforeach
          </select>
        </div>

        <!-- Regional Specs -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Regional Specs</label>
          <select class="form-select" name="regionalSpecs">
            <option value="">All Specs</option>
            @foreach($regionalSpecs as $regionalSpec)
              <option value="{{ $regionalSpec }}" {{ request('regionalSpec') == $regionalSpec ? 'selected' : '' }}>
                {{ $regionalSpec }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Price -->
        <div class="col-md-4">
          <label class="form-label fw-semibold">Price Range</label>
          <button type="button" class="btn btn-outline-secondary w-100" onclick="openModal()">
            <i class="fas fa-dollar-sign me-2"></i> Select Price
          </button>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="text-end mt-4">
        <button type="submit" class="btn btn-primary px-4 me-2">Apply</button>
        <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary px-4">Reset</a>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // 🟢 Prevent dropdown from closing when interacting inside
  const dropdownMenu = document.getElementById('filterDropdownMenu');
  dropdownMenu.addEventListener('click', function (e) {
    e.stopPropagation();
  });

  // 🟢 Prevent it from opening on hover (if any theme forces it)
  const style = document.createElement('style');
  style.textContent = `
    .dropdown:hover .dropdown-menu.show {
      display: none !important;
    }
  `;
  document.head.appendChild(style);
});
</script> --}}



        <!-- Enhanced Mobile Filter Bar -->
        {{-- <div class="filter-bar-mobile d-lg-none animate__animated animate__fadeInUp">
            <form id="filterFormMobile" action="{{ route('cars.index') }}" method="get" 
                  class="d-flex overflow-auto gap-3 pb-2" style="scroll-snap-type: x mandatory;">
                
                <!-- Car Type Mobile -->
                <div class="filter-item" style="min-width: 140px; scroll-snap-align: start;">
                    <select class="form-control" name="car_type" onchange="submitFilterForm()">
                        <option value="UsedOrNew" {{ request('car_type') == 'UsedOrNew' ? 'selected' : '' }}>Used/New</option>
                        <option value="Imported" {{ request('car_type') == 'Imported' ? 'selected' : '' }}>Imported</option>
                        <option value="Auction" {{ request('car_type') == 'Auction' ? 'selected' : '' }}>Auction</option>
                    </select>
                </div>

                <!-- City Mobile -->
                <div class="filter-item" style="min-width: 120px; scroll-snap-align: start;">
                    <select class="form-control" name="city">
                        <option value="">City</option>
                        @foreach($cities as $city)
                            @if(!$city) @continue @endif
                            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Make Mobile -->
                <div class="filter-item" style="min-width: 120px; scroll-snap-align: start;">
                    <select class="form-control" name="make" id="brandMobile" onchange="submitFilterForm()">
                        <option value="">Make</option>
                        @foreach($makes as $make)
                            <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Model Mobile -->
                <div class="filter-item" style="min-width: 120px; scroll-snap-align: start;">
                    <select class="form-control" name="model" id="modelMobile" onchange="submitFilterForm()">
                        <option value="">Model</option>
                        @foreach($models as $model)
                            <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>{{ $model }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Year Mobile -->
                <div class="filter-item" style="min-width: 100px; scroll-snap-align: start;">
                    <select class="form-control" name="year" onchange="submitFilterForm()">
                        <option value="">Year</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Mobile -->
                <div class="filter-item" style="min-width: 100px; scroll-snap-align: start;">
                    <button type="button" class="btn btn-outline-danger w-100" onclick="openModal()" style="height: 44px;">
                        <i class="fas fa-dollar-sign"></i>
                    </button>
                </div>
            </form>
        </div> --}}

        <!-- Enhanced Price Modal -->
        {{-- <div id="priceModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()" aria-label="Close">&times;</span>
                <h3 style="color: var(--primary-color); font-weight: 700; margin-bottom: 1.5rem;">
                    <i class="fas fa-dollar-sign me-2"></i>Price Range
                </h3>
                <div class="price-range">
                    <input type="number" id="minPrice" name="priceFrom" min="{{$minPrice ?? 0}}" max="{{$maxPrice ?? 1000000}}" 
                           value="{{$minPrice ?? 0}}" placeholder="Min Price" aria-label="Minimum Price">
                    <span style="font-weight: 600; color: #6c757d;">to</span>
                    <input type="number" id="maxPrice" name="priceTo" min="{{$minPrice ?? 0}}" max="{{$maxPrice ?? 1000000}}" 
                           value="{{$maxPrice ?? 1000000}}" placeholder="Max Price" aria-label="Maximum Price">
                </div>
                <button class="filter-btn" onclick="submitFilterForm()">
                    <i class="fas fa-search me-2"></i>Apply Filter
                </button>
            </div>
        </div> --}}

        <!-- Enhanced Car Listings -->
        <div class="custom-container main-car-list-sec">
            <div class="row g-4">
                @forelse ($carlisting as $key => $car)
<div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                        <div class="car-card animate__animated animate__fadeInUp" style="animation-delay: {{ $key * 0.1 }}s">
                            <!-- Enhanced Car Image -->
                            <div class="car-image">
                                @if($car->image != null)
                                    <a href="{{ route('car.detail', $car->id) }}" aria-label="View details for {{$car->listing_type}} {{$car->listing_model}}">
                                        <img src="{{ env("CLOUDFLARE_R2_URL") . $car->image->image}}" 
                                             alt="{{$car->listing_type}} {{$car->listing_model}}" 
                                             loading="lazy"
                                             onerror="this.src='{{ asset('carNotFound.jpg') }}'">
                                    </a>
                                @else
                                    <a href="{{ route('car.detail', $car->id) }}" aria-label="View details for {{$car->listing_type}} {{$car->listing_model}}">
                                        <img src="{{ asset('carNotFound.jpg') }}" 
                                             alt="{{$car->listing_type}} {{$car->listing_model}}" 
                                             loading="lazy">
                                    </a>
                                @endif

                                <!-- Enhanced Action Icons -->
                                <div class="year-badge">{{ $car->listing_year }}</div>
                                
                              <!-- Favorite & Share Buttons -->
    <div class="position-absolute top-0 end-0 m-2 d-flex gap-2" style="z-index: 10;">
        @if(auth()->check())
            @php $favCars = auth()->user()->favCars()->pluck('id')->toArray(); @endphp
            <form action="{{ route('cars.addTofav', $car->id) }}" method="post" class="m-0">
                @csrf
                <button title="Add to favorites" 
                        class="btn btn-light btn-sm shadow-sm border-0 d-flex align-items-center justify-content-center"
                        type="submit" 
                        aria-label="Add to favorites"
                        style="width: 32px; height: 32px; border-radius: 50%;">
                    <i class="fas fa-heart" style="color: {{ in_array($car->id, $favCars) ? '#dc3545' : '#6c757d' }}"></i>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" 
               title="Login to add to favorites" 
               class="btn btn-light btn-sm shadow-sm border-0 d-flex align-items-center justify-content-center"
               aria-label="Login to add to favorites"
               style="width: 32px; height: 32px; border-radius: 50%;">
                <i class="fas fa-heart" style="color: #6c757d;"></i>
            </a>
        @endif

        <a href="https://wa.me/?text={{ urlencode('Check out this car: ' . route('car.detail', $car->id)) }}" 
           target="_blank" 
           title="Share via WhatsApp"
           aria-label="Share via WhatsApp"
           class="btn btn-light btn-sm shadow-sm border-0 d-flex align-items-center justify-content-center"
           style="width: 32px; height: 32px; border-radius: 50%;">
            <i class="fas fa-share-alt" style="color: #25d366;"></i>
        </a>
    </div>
                            </div>

                            <!-- Enhanced Car Content -->
                            <div class="car-card-body">
                                <div class="price-location">
                                    <span class="price">
                                       <img style="width:17px; height: 17px;" src="{{ asset('assets/images/UAE_Dirham_Symbol.svg.png') }}">

                                         {{number_format($car->listing_price)}}</span>
                              @if($car->user?->lat && $car->user?->lng && !empty($car->city) && strtolower($car->city) !== 'null')
    <a href="https://www.google.com/maps?q={{ $car->user->lat }},{{ $car->user->lng }}" 
       class="location" 
       target="_blank"
       aria-label="View location on map">
        <i class="fas fa-map-marker-alt"></i> {{ $car->city }}
    </a>
@endif

                                </div>
                                
<h4 class="text-start mb-2" style="font-size:1.1rem">{{$car->user?->fname}} {{$car->user?->lname}}</h4>

                                <!-- Enhanced Car Details -->
         <div class="car-details mt-3 text-start">
  <div class="row g-1">
    <p class="mb-1"><strong>Make:</strong> <span>{{$car->listing_type}}</span></p>
    <p class="mb-1"><strong>Year:</strong> <span>{{$car->listing_year}}</span></p>
    <p class="mb-1"><strong>Model:</strong> <span>{{ $car->listing_model }}</span></p>
    <p class="mb-0"><strong>Mileage:</strong> <span>{{ $car->mileage ?? '215K' }} km</span></p>
  </div>
</div>



                                <!-- Enhanced Action Buttons -->
                                <div class="actions">
                                    <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank" class="flex-fill">
                                        <button class="btn btn-outline-success w-100">
                                            <i class="fab fa-whatsapp me-1"></i>
                                        </button>
                                    </a>
                                    
                                    @if($os == 'Android' || $os == 'iOS')
                                        <a href="tel:{{ $car->user->phone }}" class="flex-fill">
                                            <button class="btn btn-outline-danger w-100">
                                                <i class="fas fa-phone me-1"></i>
                                            </button>
                                        </a>
                                    @else
                                        <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank" class="flex-fill">
                                            <button class="btn btn-outline-danger w-100">
                                                <i class="fas fa-phone me-1"></i>
                                            </button>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-car fa-3x text-muted mb-3"></i>
                        <h3 class="text-muted">No cars available</h3>
                        <p class="text-muted">Check back later for new listings</p>
                    </div>
                @endforelse
            </div>
            
            <!-- View More Button -->
            @if($carlisting && count($carlisting) > 0)
                <div class="text-center mt-4">
                    <a href="{{route('cars.index')}}" class="btn btn-outline-danger btn-lg">
                        Show More Cars
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Dealers Section -->
    @if(isset($dealers) && count($dealers) > 0)
        <div class="main-home-filter-sec">
            <h2 class="section-title animate__animated animate__fadeInUp">Featured Dealers</h2>
            <div class="custom-container">
                <div class="row g-4">
                    @foreach ($dealers as $key => $dealer)
                        @php
                            $image = Str::after($dealer->company_img, url('/') . '/');
                            $dealerName = ucfirst(strtolower($dealer->company_name));
                            $dealerName = Str::limit($dealerName, 25);
                            $phone = $dealer->user->phone;
                            $shareUrl = request()->path() == 'home'
                                ? request()->url() . '?dealer_id=' . $dealer->id
                                : request()->fullUrl() . '&dealer_id=' . $dealer->id;
                        @endphp

                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="car-card animate__animated animate__fadeInUp" style="animation-delay: {{ $key * 0.1 }}s">
                                <!-- Dealer Image -->
                                <div class="car-image">
                                    <img src="{{ config('app.file_base_url') . $image }}" 
                                         alt="{{ $dealer->company_name }}" 
                                         loading="lazy"
                                         onerror="this.src='https://via.placeholder.com/350x220/f8f9fa/6c757d?text=No+Image'">
                                </div>

                                <!-- Dealer Content -->
                                <div class="car-card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="fw-bold text-truncate" style="color: var(--primary-color);" title="{{ $dealer->company_name }}">
                                            {{ $dealerName }}
                                        </h5>
                                        @if($dealer->company_address)
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($dealer->company_address) }}" 
                                               class="text-muted small text-decoration-none" 
                                               target="_blank"
                                               aria-label="View location on map">
                                                <i class="fas fa-map-marker-alt me-1"></i>{{ $dealer->user->city ?? 'Location' }}
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Dealer Actions -->
                                    <div class="actions">
                                        <a href="https://wa.me/{{ $phone }}" target="_blank" class="flex-fill">
                                            <button class="btn btn-outline-success w-100">
                                                <i class="fab fa-whatsapp me-1"></i>
                                            </button>
                                        </a>

                                        @if ($os == 'Android' || $os == 'iOS')
                                            <a href="tel:{{ $phone }}" class="flex-fill">
                                                <button class="btn btn-outline-danger w-100">
                                                    <i class="fas fa-phone me-1"></i>
                                                </button>
                                            </a>
                                        @else
                                            <a href="https://wa.me/{{ $phone }}" target="_blank" class="flex-fill">
                                                <button class="btn btn-outline-danger w-100">
                                                    <i class="fas fa-phone me-1"></i>
                                                </button>
                                            </a>
                                        @endif

                                        <a href="https://wa.me/?text={{ urlencode('Check out this dealer: ' . $shareUrl) }}" 
                                           target="_blank" class="flex-fill">
                                            <button class="btn btn-outline-info w-100">
                                                <i class="fas fa-share-alt me-1"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{route('spareParts.index')}}" class="btn btn-outline-danger btn-lg">
                       Show More Dealers
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Enhanced Workshops Section -->
    @if(isset($workshops) && count($workshops) > 0)
        <div class="main-home-filter-sec">
            <h2 class="section-title animate__animated animate__fadeInUp">Featured Workshops</h2>
            <div class="custom-container">
                <div class="row g-4">
                    @foreach ($workshops as $key => $workshop)
                        @php
                            $shareUrl = request()->path() == 'home'
                                ? request()->url() . '?workshop_id=' . $workshop->id
                                : request()->fullUrl() . '&workshop_id=' . $workshop->id;
                        @endphp
                        
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="car-card animate__animated animate__fadeInUp" style="animation-delay: {{ $key * 0.1 }}s">
                                <!-- Workshop Image -->
                                <div class="car-image">
                                  @php
    $image = $workshop->workshop_logo
        ? env('CLOUDFLARE_R2_URL') . $workshop->workshop_logo
        : asset('workshopNotFound.png');
@endphp

<img src="{{ $image }}"
     alt="{{ $workshop->workshop_name }}"
     loading="lazy"
     onerror="this.src='{{ asset('workshopNotFound.png') }}'">

                                </div>

                                <!-- Workshop Content -->
                                <div class="car-card-body">
                                    <h5 class="fw-bold text-truncate mb-3" style="color: var(--primary-color);" title="{{ $workshop->workshop_name }}">
                                        {{ Str::limit(ucwords(strtolower($workshop->workshop_name)), 25) }}
                                    </h5>

                                    @if($workshop->address)
                                        <p class="text-muted mb-2 text-truncate" title="{{ $workshop->address }}">
                                            <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-color);"></i>
                                            {{ $workshop->address }}
                                        </p>
                                    @endif

                                    <!-- Working Hours -->
                                    @if($workshop->days && $workshop->days->count() > 0)
                                        <div class="mb-3">
                                            <p class="text-muted mb-1">
                                                <i class="fas fa-clock me-2" style="color: var(--primary-color);"></i>
                                                {{ $workshop->days[0]->day }}: {{ $workshop->days[0]->from }} - {{ $workshop->days[0]->to }}
                                            </p>
                                            
                                            @if(count($workshop->days) > 1)
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                            id="dropdownDays{{ $workshop->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-clock me-1"></i>More Hours
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownDays{{ $workshop->id }}">
                                                        @foreach($workshop->days as $dayKey => $day)
                                                            @if($dayKey == 0) @continue @endif
                                                            <li class="dropdown-item-text">
                                                                <small class="text-muted">
                                                                    {{ $day->day }}: {{ $day->from }} - {{ $day->to }}
                                                                </small>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-muted mb-3">
                                            <i class="fas fa-clock me-2" style="color: var(--primary-color);"></i>
                                            Hours not available
                                        </p>
                                    @endif

                                    <!-- Workshop Actions -->
                                    <div class="actions">
                                        <a href="https://wa.me/{{ $workshop->user->phone }}" target="_blank" class="flex-fill">
                                            <button class="btn btn-outline-success w-100 mb-2">
                                                <i class="fab fa-whatsapp me-1"></i>
                                            </button>
                                        </a>

                                        <a href="tel:{{ $workshop->user->phone }}" class="flex-fill">
                                            <button class="btn btn-outline-danger w-100 mb-2">
                                                <i class="fas fa-phone me-1"></i>
                                            </button>
                                        </a>

                                        <a href="https://wa.me/?text={{ urlencode('Check out this workshop: ' . $shareUrl) }}" 
                                           target="_blank" class="flex-fill">
                                            <button class="btn btn-outline-info w-100">
                                                <i class="fas fa-share-alt me-1"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{route('workshops.index')}}" class="btn btn-outline-danger btn-lg">
                        Show More Workshops
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Enhanced Call-to-Action Section -->
    <div class="container py-5">
        <h2 class="section-title">Search for your favorite car or sell your car on AutoDecar</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="look text-center p-4 h-100">
                    <div class="mb-3" style="color: var(--primary-color);">
                        <i class="fas fa-search fa-3x"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Are you looking for a car?</h5>
                    <p class="text-muted mb-4">Save time and effort as you no longer need to visit multiple stores to find the right car.</p>
                    <a href="{{route('cars.index')}}">
                        <button class="btn btn-outline-danger btn-lg">
                            Find Cars
                        </button>
                    </a>
                </div>
            </div>
            
            <div class="col-md-4 d-flex align-items-center justify-content-center">
                <img class="img-fluid w-100 animate__animated animate__pulse animate__infinite" 
                     style="max-height: 300px; object-fit: contain;"
                     src="https://www.car-mart.com/wp-content/uploads/2024/06/red-chevy-sedan.png" 
                     alt="Featured Car"
                     loading="lazy">
            </div>
            
            <div class="col-md-4">
                <div class="look text-center p-4 h-100">
                    <div class="mb-3" style="color: var(--primary-color);">
                        <i class="fas fa-handshake fa-3x"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Do you want to sell a car?</h5>
                    <p class="text-muted mb-4">Find your perfect car match and sell your car quickly with our user-friendly online service.</p>
                    <button class="btn btn-outline-danger btn-lg">
                         Sell a Car
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Popular Brands Section -->
@if(isset($brands) && count($brands) > 0)
    <div class="container py-5">
        <h2 class="section-title">Popular Brands</h2>
        <div class="row g-4">
            @foreach ($brands->reject(fn($brand) => !in_array($brand->name, [
                'BMW', 'Chevrolet', 'Ford', 'Hyundai', 'Jeep', 'Kia', 
                'Land Rover', 'Lexus', 'Mercedes', 'Mitsubishi', 'Nissan', 'Toyota'
            ]))->take(12) as $brand)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="brand-card text-center p-3 h-100">
                        <div class="mb-2" style="height: 60px; display: flex; align-items: center; justify-content: center;">
                            @php
                                // نخزن أسماء الصور حسب الماركة
                                $logos = [
                                    'BMW' => 'bmw-svgrepo-com.svg',
                                    'Chevrolet' => 'chevrolet-svgrepo-com.svg',
                                    'Ford' => 'ford-svgrepo-com.svg',
                                    'Hyundai' => 'hyundai-svgrepo-com.svg',
                                    'Jeep' => 'jeep-alt-svgrepo-com.svg',
                                    'Kia' => 'kia-svgrepo-com.svg',
                                    'Land Rover' => 'land-rover-svgrepo-com.svg',
                                    'Lexus' => 'lexus-svgrepo-com.svg',
                                    'Mercedes' => 'mercedes-benz-svgrepo-com.svg',
                                    'Mitsubishi' => 'mitsubishi-svgrepo-com.svg',
                                    'Nissan' => 'nissan-svgrepo-com.svg',
                                    'Toyota' => 'toyota-svgrepo-com.svg',
                                ];

                                $fileName = $logos[$brand->name] ?? null;
                            @endphp

                            @if($fileName && file_exists(public_path('images/brands/' . $fileName)))
                                <img src="{{ asset('images/brands/' . $fileName) }}" 
                                     alt="{{ $brand->name }}" 
                                     class="img-fluid" 
                                     style="max-height: 60px;">
                            @else
                                <i class="fas fa-car fa-2x" style="color: var(--primary-color);"></i>
                            @endif
                        </div>
                        {{-- <p class="fw-bold mb-1 ">{{ $brand->name }}</p> --}}
                        <p class="text-muted small mb-0 brand-subtitle">{{ $brand->cars_count ?? 'N/A' }} Cars</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

    <!-- Enhanced App Download Section -->
    <div class="container py-5">
        <div class="row g-4">
            <!-- Providers App -->
            <div class="col-lg-6">
                <div class="custom-card p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-wrapper me-3">
                            <i class="fas fa-user-cog fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Providers App</h5>
                            <p class="mb-0 opacity-75">Connect with customers and manage your services efficiently.</p>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="https://apps.apple.com/us/app/carlly-provider/id6478307755" target="_blank" rel="noopener">
                            <img class="store-badge" src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="Download on App Store" style="height: 50px;">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.carllymotors.carllyprovider" target="_blank" rel="noopener">
                            <img class="store-badge" src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Get it on Google Play" style="height: 50px;">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Customers App -->
            <div class="col-lg-6">
                <div class="p-4 h-100" style="background: linear-gradient(135deg, #198754, #157347); color: white; border-radius: var(--border-radius); box-shadow: var(--shadow);">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3" style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 50%; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-car fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Customers App</h5>
                            <p class="mb-0 opacity-75">Access car buying, selling, and maintenance services effortlessly.</p>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="https://apps.apple.com/us/app/carlly-motors/id6478306259" target="_blank" rel="noopener">
                            <img class="store-badge" src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="Download on App Store" style="height: 50px;">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.carllymotors.carllyuser" target="_blank" rel="noopener">
                            <img class="store-badge" src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Get it on Google Play" style="height: 50px;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('carlistingscript')
    <!-- External Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for desktop filters
            $('#filterForm select').select2({
                allowClear: true,
                width: '100%',
                theme: 'default',
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });

            // Initialize Select2 for mobile filters
            $('#filterFormMobile select').select2({
                width: 'resolve',
                minimumResultsForSearch: 10,
                dropdownAutoWidth: true
            });

            // Auto-submit on change
            $('#filterForm select, #filterFormMobile select').on('change', function() {
                if ($(this).closest('#filterForm').length) {
                    submitFilterForm();
                } else {
                    submitFilterFormMobile();
                }
            });

            // Handle brand/model dependency for both desktop and mobile
            $('#brand, #brandMobile').on('change', function() {
                const brand = $(this).val();
                const isDesktop = $(this).attr('id') === 'brand';
                const modelSelector = isDesktop ? '#model' : '#modelMobile';
                
                if (brand) {
                    fetchModels(brand, modelSelector);
                } else {
                    resetModels(modelSelector);
                }
            });

            // Smooth scroll for navigation
            $('a[href^="#"]').on('click', function(event) {
                const target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });

            // Add loading states to forms
            $('form').on('submit', function() {
                $(this).addClass('loading');
                $(this).find('button[type="submit"]').prop('disabled', true);
            });

            // Lazy loading implementation
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }

            // Error handling for images
            $('img').on('error', function() {
                if ($(this).attr('src') !== '{{ asset("carNotFound.jpg") }}') {
                    $(this).attr('src', '{{ asset("carNotFound.jpg") }}');
                    $(this).attr('alt', 'Image not available');
                }
            });
        });

        // Filter form submission functions
        function submitFilterForm() {
            const form = document.getElementById('filterForm');
            if (form) {
                // Get price values from modal if they exist
                const minPrice = document.getElementById('minPrice')?.value;
                const maxPrice = document.getElementById('maxPrice')?.value;
                
                if (minPrice) {
                    const minInput = document.createElement('input');
                    minInput.type = 'hidden';
                    minInput.name = 'priceFrom';
                    minInput.value = minPrice;
                    form.appendChild(minInput);
                }
                
                if (maxPrice) {
                    const maxInput = document.createElement('input');
                    maxInput.type = 'hidden';
                    maxInput.name = 'priceTo';
                    maxInput.value = maxPrice;
                    form.appendChild(maxInput);
                }
                
                form.classList.add('loading');
                form.submit();
            }
        }

        function submitFilterFormMobile() {
            const form = document.getElementById('filterFormMobile');
            if (form) {
                form.classList.add('loading');
                form.submit();
            }
        }

        // Enhanced modal functions
        function openModal() {
            const modal = document.getElementById("priceModal");
            if (modal) {
                modal.style.display = "block";
                document.body.style.overflow = "hidden";
                
                // Focus on first input for accessibility
                setTimeout(() => {
                    const minPriceInput = document.getElementById('minPrice');
                    if (minPriceInput) {
                        minPriceInput.focus();
                    }
                }, 100);
            }
        }

        function closeModal() {
            const modal = document.getElementById("priceModal");
            if (modal) {
                modal.style.display = "none";
                document.body.style.overflow = "auto";
            }
        }

        // Close modal on outside click
        window.onclick = function(event) {
            const modal = document.getElementById("priceModal");
            if (event.target === modal) {
                closeModal();
            }
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Fetch models based on selected brand
        function fetchModels(brand, modelSelector) {
            $.ajax({
                url: "{{ route('getModels') }}",
                method: "POST",
                data: {
                    brand: brand,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $(modelSelector).prop('disabled', true);
                    $(modelSelector).html('<option value="">Loading...</option>');
                },
                success: function(response) {
                    $(modelSelector).empty().append('<option value="">Select Model</option>');
                    
                    if (response.models && response.models.length > 0) {
                        response.models.forEach(function(model) {
                            $(modelSelector).append(`<option value="${model}">${model}</option>`);
                        });
                    } else {
                        $(modelSelector).append('<option value="">No models available</option>');
                    }
                    
                    $(modelSelector).prop('disabled', false);
                    
                    // Refresh Select2 if it's initialized
                    if ($(modelSelector).hasClass('select2-hidden-accessible')) {
                        $(modelSelector).trigger('change.select2');
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching models:", xhr.responseText);
                    $(modelSelector).empty().append('<option value="">Error loading models</option>');
                    $(modelSelector).prop('disabled', false);
                    
                    // Show user-friendly error message
                    if (window.showToast) {
                        window.showToast('Error loading models. Please try again.', 'error');
                    }
                }
            });
        }

        function resetModels(modelSelector) {
            $(modelSelector).empty().append('<option value="">Model</option>');
            $(modelSelector).prop('disabled', false);
        }

        // Enhanced copy URL function with better error handling
        function copyUrl(carUrl) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(carUrl).then(() => {
                    if (window.showToast) {
                        window.showToast('URL copied successfully!', 'success');
                    }
                }).catch(err => {
                    console.error('Failed to copy URL: ', err);
                    fallbackCopyTextToClipboard(carUrl);
                });
            } else {
                fallbackCopyTextToClipboard(carUrl);
            }
        }

        function fallbackCopyTextToClipboard(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                document.execCommand('copy');
                if (window.showToast) {
                    window.showToast('URL copied successfully!', 'success');
                }
            } catch (err) {
                console.error('Fallback: Unable to copy', err);
                if (window.showToast) {
                    window.showToast('Failed to copy URL', 'error');
                }
            }
            
            document.body.removeChild(textArea);
        }

        // Analytics tracking (if needed)
        function trackEvent(category, action, label) {
            if (typeof gtag !== 'undefined') {
                gtag('event', action, {
                    event_category: category,
                    event_label: label
                });
            }
        }

        // Track filter usage
        $('#filterForm select, #filterFormMobile select').on('change', function() {
            const filterType = $(this).attr('name');
            const filterValue = $(this).val();
            trackEvent('Filter', 'Change', `${filterType}: ${filterValue}`);
        });

        // Track car card interactions
        $('.car-card a').on('click', function() {
            trackEvent('Car Card', 'Click', 'View Details');
        });

        // Performance monitoring
        window.addEventListener('load', function() {
            const loadTime = window.performance.timing.domContentLoadedEventEnd - window.performance.timing.navigationStart;
            console.log('Page load time:', loadTime + 'ms');
            
            // Track performance if analytics is available
            if (typeof gtag !== 'undefined') {
                gtag('event', 'timing_complete', {
                    name: 'load',
                    value: loadTime
                });
            }
        });
    </script>
@endpush
@endsection