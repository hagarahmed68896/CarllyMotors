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

{{-- <div id="demo" class=" carousel slide mt-1" data-bs-ride="carousel" data-bs-interval="2000">
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
</div> --}}
<!-- filter -->

<div style="margin-left: 70px; margin-right:70px">
  <div class="row px-6 py-5">
    <!-- 🧭 Sidebar Filters -->
    <aside class="col-lg-3 col-md-4 mb-4">
      <div class="bg-white shadow-sm rounded-4 p-4 sticky-top" style="top: 90px; max-height: calc(100vh - 120px); overflow-y: auto;">
         <h5 class="fw-bold mb-3 text-center" style="color: #760e13">
                        <i class="fas fa-sliders-h me-2"></i>Filter Cars
                    </h5>

        <form id="filterForm" method="GET" action="{{ route('cars.index') }}" class="d-flex flex-column gap-3">

          <!-- Car Type -->
          <div>
            <label class="form-label fw-semibold small text-muted">Car Type</label>
            <select class="form-select rounded-3" name="car_type" onchange="submitFilterForm()">
              <option value="">All Types</option>
              <option value="UsedOrNew" {{request('car_type')=='UsedOrNew'?'selected':''}}>Used/New</option>
              <option value="Imported" {{request('car_type')=='Imported'?'selected':''}}>Imported</option>
              <option value="Auction" {{request('car_type')=='Auction'?'selected':''}}>Auction</option>
            </select>
          </div>

          <!-- City -->
          <div>
            <label class="form-label fw-semibold small text-muted">City</label>
            <select class="form-select rounded-3" name="city" onchange="submitFilterForm()">
              <option value="">All Cities</option>
              @foreach($cities as $city)
                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
              @endforeach
            </select>
          </div>

          <!-- Make -->
          <div>
            <label class="form-label fw-semibold small text-muted">Make</label>
            <select class="form-select rounded-3" id="brand" name="make" onchange="submitFilterForm()">
              <option value="">All Makes</option>
              @foreach($makes as $make)
                <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
              @endforeach
            </select>
          </div>

          <!-- Model -->
          <div>
            <label class="form-label fw-semibold small text-muted">Model</label>
            <select class="form-select rounded-3" id="model" name="model" onchange="submitFilterForm()">
              <option value="">All Models</option>
            </select>
          </div>

          <!-- Year -->
          <div>
            <label class="form-label fw-semibold small text-muted">Year</label>
            <select class="form-select rounded-3" name="year" onchange="submitFilterForm()">
              <option value="">All Years</option>
              @foreach($years as $year)
                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
              @endforeach
            </select>
          </div>

          <!-- Body Type -->
          <div>
            <label class="form-label fw-semibold small text-muted">Body Type</label>
            <select class="form-select rounded-3" name="body_type" onchange="submitFilterForm()">
              <option value="">All Body Types</option>
              @foreach($bodyTypes as $bodyType)
                <option value="{{ $bodyType }}" {{ request('body_type') == $bodyType ? 'selected' : '' }}>{{ $bodyType }}</option>
              @endforeach
            </select>
          </div>

          <!-- Regional Specs -->
          <div>
            <label class="form-label fw-semibold small text-muted">Regional Specs</label>
            <select class="form-select rounded-3" name="regionalSpecs" onchange="submitFilterForm()">
              <option value="">All Specs</option>
              @foreach($regionalSpecs as $regionalSpec)
                <option value="{{ $regionalSpec }}" {{ request('regionalSpecs') == $regionalSpec ? 'selected' : '' }}>{{ $regionalSpec }}</option>
              @endforeach
            </select>
          </div>

          <!-- Price Range -->
          <div class="border-top pt-3 mt-2">
            <label class="form-label fw-semibold small text-muted">Price Range (AED)</label>
            <div class="d-flex align-items-center gap-2 mb-2">
              <input type="number" class="form-control rounded-3" name="priceFrom" placeholder="Min"
                min="{{ $minPrice }}" max="{{ $maxPrice }}"
                value="{{ request('priceFrom', $minPrice) }}">
              <span class="fw-bold">–</span>
              <input type="number" class="form-control rounded-3" name="priceTo" placeholder="Max"
                min="{{ $minPrice }}" max="{{ $maxPrice }}"
                value="{{ request('priceTo', $maxPrice) }}">
            </div>
<button type="submit" class="btn btn-sm btn-outline-dark w-100 rounded-3 apply-btn">
  Apply
</button>

<style>
.apply-btn {
  transition: all 0.3s ease;
  border-color: #760e13;
  color: #760e13;
}

.apply-btn:hover {
  background-color: #760e13;
  color: #fff;
  border-color: #760e13;
}
</style>
          </div>

          <!-- Buttons -->
          <div class="d-flex gap-2 mt-3">
<button type="submit" class="btn flex-fill rounded-3 text-white" style="background-color: #760e13; border-color: #760e13;">
  Apply Filters
</button>
            <button type="button" onclick="resetFilters()" class="btn btn-light flex-fill rounded-3 border">Reset</button>
          </div>
        </form>
      </div>
    </aside>

  <!-- 🚘 Main Car Listings -->
<div class="col-lg-9 col-md-8">
  <div class="row g-4" id="car-list">
    @foreach ($carlisting as $key => $car)
<div class="col-sm-6 col-md-4 col-lg-4">
        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
          <!-- Image Section -->
          <div class="position-relative" style="height: 200px;">
            @php
              $imageSrc = isset($car->images[0]->image)
                ? env("CLOUDFLARE_R2_URL") . $car->images[0]->image
                : asset('carNotFound.jpg');
            @endphp
            <a href="{{ route('car.detail', $car->id) }}">
              <img src="{{ $imageSrc }}" class="card-img-top h-100 w-100" style="object-fit: cover" alt="{{ $car->listing_model }}" onerror="this.src='{{ asset('carNotFound.jpg') }}'">
            </a>

            <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-3 py-1 rounded-pill">{{ $car->listing_year }}</span>

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

          <!-- Content Section -->
          <div class="card-body d-flex flex-column justify-content-between">
            <div>
              <div class="d-flex justify-content-between mb-2">
                <h5 class="mb-0 fw-bold text-dark">
                  <img src="{{ asset('assets/images/UAE_Dirham_Symbol.svg.png') }}" alt="Price" width="14" height="14" class="me-1">
                  {{ number_format($car->listing_price) }}
                </h5>
                @if($car->user?->lat && $car->user?->lng)
                  <a href="https://www.google.com/maps?q={{ $car->user->lat }},{{ $car->user->lng }}" target="_blank" class="text-muted small text-decoration-none">
                    <i class="fas fa-map-marker-alt text-danger me-1"></i>{{ $car->city }}
                  </a>
                @endif
              </div>

              <h6 class="fw-semibold mb-2 text-truncate" title="{{ $car->user?->fname }} {{ $car->user?->lname }}">
                {{ $car->user?->fname }} {{ $car->user?->lname }}
              </h6>

              <ul class="list-unstyled small text-muted mb-3">
                <li><strong>Type:</strong> {{ $car->listing_type }}</li>
                <li><strong>Model:</strong> {{ $car->listing_model }}</li>
                <li><strong>Year:</strong> {{ $car->listing_year }}</li>
                <li><strong>Mileage:</strong> {{ $car->mileage ?? 'N/A' }} km</li>
              </ul>
            </div>

            <div class="d-flex gap-2">
              <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank" class="btn btn-outline-success flex-fill rounded-3">
                <i class="fab fa-whatsapp"></i>
              </a>
              <a href="tel:{{ $car->user?->phone }}" class="btn btn-outline-danger flex-fill rounded-3">
                <i class="fa fa-phone"></i>
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


<script>
function resetFilters() {
    // امسح كل الحقول في الفورم
    const form = document.getElementById('filterForm');
    form.reset();

    // أرجع المستخدم إلى الصفحة الأصلية بدون أي فلاتر
    window.location.href = "{{ route('cars.index') }}";
}
</script>




@endsection