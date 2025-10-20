@extends('layouts.app')
@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

$currentMake = request('make'); // Get the currently selected make for highlighting
@endphp




@section('content')

<style>
  /* Make all filter buttons uniform with selects */
.filter-bar-top .btn-outline-secondary {
  border-radius: 8px;
  font-size: 0.95rem;
  padding: 0.6rem 0.8rem;
  border: 1px solid #ccc;
  background-color: #f8f9fa;
  color: #4a4a4a;
  height: 42px; /* Same height as selects */
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 130px; /* Keeps consistent width for all buttons */
  transition: all 0.3s ease;
}

/* Hover effect — slightly darker background, text remains dark */
.filter-bar-top .btn-outline-secondary:hover {
  background-color: #e9ecef;
  color: #000;
  border-color: #aaa;
}

/* Make selects match button style for perfect alignment */
.filter-bar-top .form-select,
.filter-bar-top .form-control {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 0.6rem 0.8rem;
  font-size: 0.95rem;
  height: 42px;
  color: #4a4a4a;
}

/* Adjust spacing for smaller screens */
@media (max-width: 991px) {
  .filter-bar-top {
    padding: 0.8rem 1rem;
  }
  .filter-form-grid {
    gap: 0.75rem;
  }
  .filter-bar-top .btn-outline-secondary,
  .filter-bar-top .form-select {
    min-width: 110px;
    font-size: 0.9rem;
  }
}

  .modal-backdrop {
      z-index: 1050 !important;

  background-color: transparent !important;
}
.modal {
  z-index: 1055 !important;
}



.brand-pill {
  white-space: nowrap;
  cursor: pointer;
  font-size: 0.9rem;
  padding: 0.5rem 1rem;
  border-radius: 50px;
  border: 1px solid #ccc;
  color: #4a4a4a;
  background-color: #f8f9fa;
  text-decoration: none;
  transition: all 0.2s;
}
.brand-pill:hover {
  background-color: #e9ecef;
  color: #000;
  border-color: #aaa;
}
.brand-pill.active {
  background-color: #dc3545;
  color: #fff;
  border-color: #dc3545;
  font-weight: 600;
}

/* 🔹 الفلتر الرئيسي */
.filter-bar-top {
  background-color: #fff;
  border: 1px solid #e5e5e5;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  border-radius: 12px;
  padding: 1rem 1.5rem;
  margin: 1.5rem auto;
  max-width: 1300px;
  overflow-x: auto;
  scrollbar-width: thin;
}
.filter-bar-top::-webkit-scrollbar {
  height: 6px;
}
.filter-bar-top::-webkit-scrollbar-thumb {
  background-color: #ccc;
  border-radius: 4px;
}

/* keep filters in one line */
.filter-form-grid {
  display: flex;
  gap: 1rem;
  align-items: center;
  flex-wrap: nowrap;
  min-width: max-content;
}

/* fields */
.filter-bar-top .form-select,
.filter-bar-top .form-control,
.filter-bar-top .btn {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 0.6rem 0.8rem;
  font-size: 0.95rem;
}

/* buttons */
.btn-outline-secondary {
  border-radius: 8px;
  font-size: 0.95rem;
  transition: 0.3s;
  width: 100%;
}
.btn-outline-secondary:hover {
  background-color: #f8f9fa;
}

/* Modal styling */
.modal-content {
  border-radius: 12px;
  border: none;
  box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}
.modal-header {
  border-bottom: 1px solid #eee;
}
.modal-footer {
  border-top: 1px solid #eee;
}
.modal-body {
  padding: 1.5rem;
}

@media (max-width: 991px) {
  .filter-bar-top {
    padding: 0.8rem 1rem;
  }
  .filter-form-grid {
    gap: 0.75rem;
  }
}
</style>

<div class="container-fluid" style="padding-top: 0.7rem; background-color: #fff; position: sticky; top: 70px; z-index: 1000;">
  <div class="filter-bar-top">
    <form id="topFilterForm" method="GET" action="{{ route('cars.index') }}" class="filter-form-grid">

      <!-- 🏙️ City -->
      <select class="form-select" name="city" onchange="submitTopFilter()">
        <option value="" disabled {{ empty(request('city')) ? 'selected' : '' }}>City</option>
        @foreach($cities as $city)
          @if(!empty($city))
            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
              {{ $city }}
            </option>
          @endif
        @endforeach
      </select>

      <!-- 🚗 Make -->
      <select class="form-select" name="make" onchange="submitTopFilter()">
        <option value="">Make</option>
        @foreach($makes as $make)
          <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
        @endforeach
      </select>

      <!-- 💰 Price Modal -->
      <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#priceModal">
        Price Range
      </button>

      <!-- 📅 Year -->
      <select class="form-select" name="year" onchange="submitTopFilter()">
        <option value="">Year</option>
        @foreach($years as $year)
          <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
        @endforeach
      </select>

      <!-- 🛞 Mileage Modal -->
      <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#mileageModal">
        Mileage
      </button>

      <!-- ⚙️ More Filters Modal -->
      <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#filtersModal">
        More Filters
      </button>
    </form>
  </div>
</div>

<!-- 💰 Price Modal -->
<div class="modal fade" id="priceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Price Range (AED)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex gap-2 mb-3">
          <input type="number" class="form-control" name="priceFrom" form="topFilterForm" placeholder="Min" value="{{ request('priceFrom') }}">
          <input type="number" class="form-control" name="priceTo" form="topFilterForm" placeholder="Max" value="{{ request('priceTo') }}">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" form="topFilterForm" class="btn btn-danger w-100">Apply Price</button>
      </div>
    </div>
  </div>
</div>

<!-- 🛞 Mileage Modal -->
<div class="modal fade" id="mileageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Mileage (KM)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex gap-2 mb-3">
          <input type="number" class="form-control" name="mileageFrom" form="topFilterForm" placeholder="Min" value="{{ request('mileageFrom') }}">
          <input type="number" class="form-control" name="mileageTo" form="topFilterForm" placeholder="Max" value="{{ request('mileageTo') }}">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" form="topFilterForm" class="btn btn-danger w-100">Apply Mileage</button>
      </div>
    </div>
  </div>
</div>

<!-- ⚙️ More Filters Modal -->
<div class="modal fade" id="filtersModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Additional Filters</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input 
          type="text" 
          class="form-control mb-3" 
          name="keywords" 
          form="topFilterForm" 
          placeholder="Keywords" 
          value="{{ request('keywords') }}"
        >
        <select class="form-select" name="specs" form="topFilterForm">
          <option value="">Regional Specs</option>
          @foreach($regionalSpecs as $regionalSpec)
            <option value="{{ $regionalSpec }}" {{ request('specs') == $regionalSpec ? 'selected' : '' }}>
              {{ $regionalSpec }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <button type="submit" form="topFilterForm" class="btn btn-danger w-100">Apply Filters</button>
      </div>
    </div>
  </div>
</div>

<script>
function submitTopFilter() {
  document.getElementById('topFilterForm').submit();
}
</script>


<script>
function submitTopFilter() {
    document.getElementById('topFilterForm').submit();
}
</script>



<div class="container-xl">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="listing-header mb-0">Cars for sale in Dubai • {{ number_format($carlisting->total()) }} Ads</h1>
    </div>

<div class="d-flex flex-wrap gap-2 mb-4" id="brandPillsContainer">
    @foreach ($brands as $index => $brand)
        <a href="{{ route('cars.index', array_merge(request()->query(), ['make' => $brand->name])) }}"
           class="brand-pill {{ $brand->name == $currentMake ? 'active' : '' }}"
           @if($index >= 10) style="display: none;" @endif>
            {{ $brand->name }} ({{ $brand->cars_count ?? 0 }})
        </a>
    @endforeach

    @if(count($brands) > 10)
        <a href="javascript:void(0);" id="viewMoreBrands" 
           class="brand-pill bg-light text-dark border-0 fw-semibold">
           View More
        </a>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('viewMoreBrands');
        if (btn) {
            btn.addEventListener('click', function() {
                const container = document.getElementById('brandPillsContainer');
                container.querySelectorAll('a').forEach((a, index) => {
                    if(index >= 10) a.style.display = 'inline-flex';
                });
                btn.style.display = 'none'; // hide the button after clicking
            });
        }
    });
</script>



<div class="container py-4">
  <div class="row  g-4 mb-4" id="car-list">
    @forelse ($carlisting as $key => $car)
      @php
          $images = $car->images->map(fn($img) => env('FILE_BASE_URL') . $img->image)->toArray();
      @endphp

      <div class="col-12 col-md-10 col-lg-9">
        <a href="{{ route('car.detail', $car->id) }}" class="text-decoration-none text-dark">
          <div class="car-card shadow-sm rounded-4 overflow-hidden hover-card d-flex flex-column flex-lg-row">

              {{-- 🖼️ الصورة --}}
            <div class="car-carousel-container position-relative flex-shrink-0" style="min-height: 230px;">
              
              {{-- ❤️ Favorite & Share Buttons --}}
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

              {{-- Carousel --}}
              <div id="carCarousel-{{ $key }}" class="carousel slide h-100" data-bs-ride="carousel">
                <div class="carousel-inner h-100 ratio ratio-16x9 ratio-lg-unset">
                  @if($images && count($images) > 0)
                    @foreach ($images as $index => $image)
                      <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <img src="{{ $image }}" class="d-block w-100 h-100" alt="Car Image" style="object-fit: cover;">
                      </div>
                    @endforeach
                  @else
                    <div class="carousel-item active">
                      <img src="{{ asset('carNotFound.jpg') }}" class="d-block w-100 h-100" alt="Car Not Found" style="object-fit: cover;">
                    </div>
                  @endif
                </div>

                {{-- Controls --}}
                <button class="carousel-control-prev" type="button" data-bs-target="#carCarousel-{{ $key }}" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carCarousel-{{ $key }}" data-bs-slide="next">
                  <span class="carousel-control-next-icon"></span>
                </button>
              </div>
            </div>

            {{-- التفاصيل --}}
            <div class="car-details p-3 d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                  <span class="car-price fw-bold h5">
                    <img src="{{ asset('assets/images/UAE_Dirham_Symbol.svg.png') }}" width="14" height="14" class="me-1">
                    {{ number_format($car->listing_price) }}
                  </span>
                </div>

                @if($car->listing_type || $car->listing_model || $car->listing_title)
                  <h6 class="fw-bold text-truncate mb-2">
                    {{ $car->listing_type ? $car->listing_type . ' • ' : '' }}
                    {{ $car->listing_model ? $car->listing_model . ' • ' : '' }}
                    {{ $car->listing_title ? Str::limit($car->listing_title, 40) : '' }}
                  </h6>
                @endif

                @if($car->car_type || $car->feautures_gear || $car->features_fuel_type)
                  <p class="text-muted mb-2 small">
                    {{ $car->car_type ? $car->car_type . ' | ' : '' }}
                    {{ $car->feautures_gear ? $car->feautures_gear . ' | ' : '' }}
                    {{ $car->features_fuel_type ?? '' }}
                  </p>
                @endif

                <ul class="list-unstyled d-flex flex-wrap small text-muted mb-2">
                  @if($car->listing_year)
                    <li class="me-3"><i class="fas fa-calendar-alt me-1"></i>{{ $car->listing_year }}</li>
                  @endif
                  @if($car->mileage)
                    <li class="me-3"><i class="fas fa-tachometer-alt me-1"></i>{{ number_format($car->mileage) }} km</li>
                  @endif
                  @if($car->steering_side)
                    <li class="me-3"><i class="fas fa-steering-wheel me-1"></i>{{ $car->steering_side }}</li>
                  @endif
                  @if($car->regional_specs)
                    <li><i class="fas fa-globe-asia me-1"></i>{{ $car->regional_specs }}</li>
                  @endif
                </ul>
              </div>

              <p class="small text-muted mb-0">
                <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $car->city ?? 'Dubai' }}, UAE
              </p>
            </div>

          </div>
        </a>
      </div>
    @empty
      <p class="text-center text-muted mt-4">No cars found matching your criteria.</p>
    @endforelse
  </div>
</div>

<style>
.car-card {
  background-color: #fff;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 16px;
}

.hover-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.car-carousel-container {
  width: 100%;
}

@media (min-width: 992px) {
  .car-card {
    flex-direction: row;
    height: 240px;
  }
  .car-carousel-container {
    width: 45%;
    height: 100%;
  }
  .car-carousel-container img {
    height: 100%;
    object-fit: cover;
  }
  .car-details {
    width: 55%;
    padding: 1.2rem 1.5rem;
  }
}

@media (max-width: 991px) {
  .car-card {
    flex-direction: column;
  }
  .car-carousel-container {
    width: 100%;
  }
  .car-details {
    padding: 1rem;
  }
}
</style>








    <div class="d-flex justify-content-center mt-4">
        {{ $carlisting->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
</div>

<div class="modal " id="moreFiltersModal" tabindex="-1" aria-labelledby="moreFiltersModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="modalFilterForm" method="GET" action="{{ route('cars.index') }}">
        <div class="modal-header">
          <h5 class="modal-title" id="moreFiltersModalLabel">Additional Filters</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex flex-column gap-3">
            <div>
                <label class="form-label fw-semibold small text-muted">Regional Specs</label>
                <select class="form-select rounded-3" name="regionalSpec">
                    <option value="">All Specs</option>
                    @foreach($regionalSpecs as $regionalSpec)
                        <option value="{{ $regionalSpec }}" {{ request('regionalSpec') == $regionalSpec ? 'selected' : '' }}>{{ $regionalSpec }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label fw-semibold small text-muted">Car Type</label>
                <select class="form-select rounded-3" name="car_type">
                    <option value="">All Types</option>
                    <option value="UsedOrNew" {{ request('car_type')=='UsedOrNew'?'selected':'' }}>Used/New</option>
                    <option value="Imported" {{ request('car_type')=='Imported'?'selected':'' }}>Imported</option>
                    <option value="Auction" {{ request('car_type')=='Auction'?'selected':'' }}>Auction</option>
                </select>
            </div>
             <div>
                <label class="form-label fw-semibold small text-muted">Body Type</label>
                <select class="form-select rounded-3" name="body_type">
                    <option value="">All Body Types</option>
                    @foreach($bodyTypes as $bodyType)
                        <option value="{{ $bodyType }}" {{ request('body_type') == $bodyType ? 'selected' : '' }}>{{ $bodyType }}</option>
                    @endforeach
                </select>
            </div>
             <div>
                <label class="form-label fw-semibold small text-muted">Keywords</label>
                <input type="text" class="form-control rounded-3" name="q" placeholder="Enter keywords..." value="{{ request('q') }}">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Apply Filters</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    function submitTopFilter() {
        document.getElementById('topFilterForm').submit();
    }

    function resetFilters() {
        window.location.href = "{{ route('cars.index') }}";
    }

    // Function to merge all filter fields into the modal form before submission
    document.getElementById('modalFilterForm').addEventListener('submit', function(e) {
        // Get values from the top filter bar
        const topForm = document.getElementById('topFilterForm');
        const topFilters = new FormData(topForm);
        const modalForm = e.target;

        // Append top filter values to the modal form (to keep all filters)
        for (let [key, value] of topFilters.entries()) {
            if (value && modalForm.querySelector(`[name="${key}"]`) === null) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = key;
                hiddenInput.value = value;
                modalForm.appendChild(hiddenInput);
            }
        }
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection