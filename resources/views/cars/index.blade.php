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
<style>
 .car-type-btn {
    background-color: #fff;
    color: #760e13;
    border: 1px solid #760e13;
    border-radius: 25px;
    padding: 0.35rem 1rem;      /* uniform padding */
    font-weight: 600;
    white-space: nowrap;        /* prevent text wrapping */
    flex-shrink: 0;             /* prevent shrinking */
    transition: all 0.2s;
    height: 40px;               /* fixed height for all buttons */
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    font-size: 0.9rem;          /* adjust font size for small screens */
}

.car-type-btn:hover {
    background-color: #760e13;
    color: #fff;
}

.car-type-btn.active {
    background-color: #760e13;
    color: #fff;
}


</style>
<div class="container-fluid" style="padding-top: 0.7rem; background-color: #fff; position: sticky; top: 70px; z-index: 1000;">
      <!-- Car Type Buttons -->
<div class="d-flex flex-nowrap justify-content-center gap-2 mb-2 overflow-auto py-1">
    <!-- Used / New -->
    <a href="{{ route('cars.index', array_merge(request()->except('car_type'), ['car_type' => 'UsedOrNew'])) }}"
       class="btn car-type-btn {{ request('car_type') === null || request('car_type') === 'UsedOrNew' ? 'active' : '' }}">
       Used / New
    </a>

    <!-- Imported -->
    <a href="{{ route('cars.index', array_merge(request()->except('car_type'), ['car_type' => 'Imported'])) }}"
       class="btn car-type-btn {{ request('car_type') === 'Imported' ? 'active' : '' }}">
       Imported
    </a>

    <!-- Auction -->
    <a href="{{ route('cars.index', array_merge(request()->except('car_type'), ['car_type' => 'Auction'])) }}"
       class="btn car-type-btn {{ request('car_type') === 'Auction' ? 'active' : '' }}">
       Auction
    </a>
</div>


  <div class="filter-bar-top">
    <form id="topFilterForm" method="GET" action="{{ route('cars.index') }}" class="filter-form-grid">

<!-- 🏙️ City -->
<select class="form-select" name="city" onchange="submitTopFilter()">
    <option value="" {{ empty(request('city')) ? 'selected' : '' }}>All Cities</option>

    @php
        $uaeCities = [
           'Dubai',
          'Abu Dhabi',
          'Sharjah',
          'Ras Al Khaimah',
          'Fujairah',
          'Ajman',
          'Umm Al Quwain',
          'Al Ain',
        ];

        sort($uaeCities); // ✅ ترتيب المدن أبجديًا
    @endphp

    @foreach($uaeCities as $city)
        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
            {{ $city }}
        </option>
    @endforeach
</select>

   <!-- 🚗 Car Brand -->
<select class="form-select" id="makeSelect" name="make">
    <option value="">Car Brand</option>
    @foreach(collect($makes)->filter()->sort()->values() as $make)
        <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>
            {{ $make }}
        </option>
    @endforeach
</select>

<!-- 🧠 مكتبة Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#makeSelect').select2({
        placeholder: "Search brand...",
        allowClear: true,
        width: '100%'
    });

    // 🟢 لما المستخدم يختار ماركة، نفّذ الفلترة
    $('#makeSelect').on('change', function() {
        submitTopFilter();
    });
});
</script>


      <!-- 💰 Price Modal -->
      <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#priceModal">
        Price Range
      </button>

      <!-- 📅 Year -->
@php
    $currentYear = date('Y') + 1; // السنة القادمة
    // توليد السنين من السنة القادمة إلى 1990
    $years = range($currentYear, 1990);
@endphp

<select class="form-select" name="year" onchange="submitTopFilter()">
    <option value="">Year</option>
    @foreach($years as $year)
        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
            {{ $year }}
        </option>
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


<div class="container-xl">
    <div class="d-flex align-items-center justify-content-between mb-4">
@php
    $selectedCity = request('city') ?: 'UAE';
@endphp

<h1 class="listing-header mb-0">
    Cars for sale in {{ $selectedCity }} 
</h1>
    </div>

<div class="d-flex flex-wrap gap-2 mb-4" id="brandPillsContainer">
    @foreach ($brands as $index => $brand)
        <a href="{{ route('cars.index', array_merge(request()->query(), ['make' => $brand->name])) }}"
           class="brand-pill {{ $brand->name == $currentMake ? 'active' : '' }}"
           @if($index >= 10) style="display: none;" @endif>
            {{ $brand->name }} 
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
  <div class="row g-4 mb-4" id="car-list">
    @forelse ($carlisting as $key => $car)
      @php
          $images = $car->images->map(fn($img) => env('FILE_BASE_URL') . $img->image)->toArray();
      @endphp

      <div class="col-12 p-0 col-md-10 col-lg-9">
        <div id="car-{{ $car->id }}" class="car-card shadow-sm rounded-4 overflow-hidden hover-card d-flex flex-column flex-lg-row">
 
          {{-- 🖼️ الصورة clickable --}}
         <div class="car-carousel-container position-relative flex-shrink-0">
  <a href="{{ route('car.detail', $car->id) }}" class="d-block w-100 h-100">
    <div class="swiper carSwiper-{{ $key }} rounded-3">
      <div class="swiper-wrapper">
        @if($images && count($images) > 0)
          @foreach ($images as $image)
            <div class="swiper-slide">
              <img src="{{ $image }}" alt="Car Image">
            </div>
          @endforeach
        @else
          <div class="swiper-slide">
            <img src="{{ asset('carNotFound.jpg') }}" alt="Car Not Found">
          </div>
        @endif
      </div>

      <!-- Navigation arrows -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>

      <!-- Pagination -->
      <div class="swiper-pagination"></div>
    </div>
  </a>
<!-- 🔍 Zoom Button -->
  @if($images && count($images) > 0)
        <!-- 🔍 Zoom Button -->
        <button type="button"
                class="btn btn-light position-absolute top-0 start-0 m-2"
                style="width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; z-index: 10;"
                data-bs-toggle="modal"
                data-bs-target="#zoomModal-{{ $key }}">
            <i class="fas fa-search-plus" style="color:#760e13;"></i>
        </button>
    @endif

  <!-- ❤️ Favorite & Share Buttons -->
  <div class="position-absolute top-0 end-0 m-2 d-flex gap-2" style="z-index: 10;">
@php
    $favCars = auth()->check() ? auth()->user()->favCars()->pluck('id')->toArray() : [];
    $isFav = in_array($car->id, $favCars);
@endphp

{{-- ... داخل الحلقة @forelse ... --}}

<form action="{{ route('cars.addTofav', $car->id) }}" method="POST" class="d-inline ajax-fav-form">
    @csrf
    
    {{-- 💡 تأكد أن type="button" هنا لمنع الـSubmit العادي --}}
    <button type="button" 
            class="btn btn-light btn-sm shadow-sm border-0 d-flex align-items-center justify-content-center fav-button" 
            style="width:32px; height:32px; border-radius:50%;"
            data-car-id="{{ $car->id }}">
        {{-- 💡 يجب أن يكون الـIcon داخل الزر ويحمل Class محدد بالـID --}}
        <i class="fas fa-heart fav-icon-{{ $car->id }}" 
           style="color: {{ $isFav ? '#dc3545' : '#6c757d' }}"></i>
    </button>
</form>

{{-- <a id="car-{{ $car->id }}"></a> --}}







  <a href="https://wa.me/?text={{ urlencode(
    'اطّلع على هذه السيارة على موقع Carlly! عروض مميّزة بانتظارك' . "\n\n" .
    'Check out my latest find on Carlly! Great deals await. Don’t miss out!' . "\n" .
    route('car.detail', $car->id)
) }}"
target="_blank"
title="Share via WhatsApp"
class="btn btn-light btn-sm shadow-sm border-0 d-flex align-items-center justify-content-center"
style="width: 32px; height: 32px; border-radius: 50%;">
    <i class="fas fa-share-alt" style="color: #25d366;"></i>
</a>

  </div>
</div>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
.carSwiper-{{ $key }} {
  width: 100%;
  aspect-ratio: 16 / 9;
  overflow: hidden;
}

.carSwiper-{{ $key }} img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  border-radius: 10px;
}

/* ✅ Swiper Arrows */
.swiper-button-next,
.swiper-button-prev {
  color: #fff;
  text-shadow: 0 0 5px rgba(0,0,0,0.6);
  transform: scale(0.7); /* 👈 يقلل الحجم العام للسهم */
}

/* أو ممكن بدلها تستخدم الطريقة الدقيقة دي لتغيير حجم الأيقونة فقط */
.swiper-button-next::after,
.swiper-button-prev::after {
  font-size: 20px; /* 👈 الحجم الافتراضي عادة 44px — فده أصغر */
}

/* ✅ Pagination Bullets */
.swiper-pagination-bullet {
  background: #fff;
  opacity: 0.8;
}
.swiper-pagination-bullet-active {
  background: #760e13;
  opacity: 1;
}
</style>


<script>
document.addEventListener("DOMContentLoaded", function() {
  new Swiper('.carSwiper-{{ $key }}', {
    loop: true,
    grabCursor: true,
    centeredSlides: true,
    spaceBetween: 10,
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.carSwiper-{{ $key }} .swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.carSwiper-{{ $key }} .swiper-button-next',
      prevEl: '.carSwiper-{{ $key }} .swiper-button-prev',
    },
  });
});
</script>


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

<p class="small text-muted mb-0 mt-2">
    <i class="fas fa-map-marker-alt text-danger me-1"></i>
    @if($car->lat && $car->lng)
        <a href="https://www.google.com/maps?q={{ $car->lat }},{{ $car->lng }}" 
          target="_blank"  style="color: #760e13; text-decoration: none;">
            {{ $car->city ?? 'Dubai' }}, UAE
        </a>
    @else
        {{ $car->city ?? 'Dubai' }}, UAE
    @endif
</p>


         {{-- Enhanced Action Buttons --}}
<div class="action d-flex gap-2 mt-2">
 <a href="https://wa.me/{{ $car->user?->phone }}?text={{ urlencode(
    "Carlly Motors\n\n" .
    "مرحبًا، أتواصل معك للاستفسار عن السيارة المعروضة للبيع، " . $car->listing_type . " " . $car->listing_model . "، في Carlly Motors. هل لا تزال متوفرة؟\n\n" .
    "Hello, We are contacting you about the car for sale, " . $car->listing_type . " " . $car->listing_model . ", at Carlly Motors. Is it available?\n\n" .
    "Car Model : " . $car->listing_model . "\n" .
    "Car Type : " . $car->listing_type . "\n" .
    "Year Of Manufacture : " . $car->listing_year . "\n" .
    "Car Price : " . number_format($car->listing_price) . " AED\n" .
    "Car URL : " . route('car.detail', $car->id)
) }}"
target="_blank"
class="flex-fill text-decoration-none">
    <button class="btn btn-outline-success w-100 rounded-4">
        <i class="fab fa-whatsapp me-1"></i> 
    </button>
</a>



  @php
    $isMobile = Str::contains(request()->header('User-Agent'), ['Android', 'iPhone', 'iPad']);
    $phone = $car->user?->phone;
@endphp

@if(!empty($phone))
    @if($isMobile)
        <a href="tel:{{ $phone }}" class="btn btn-outline-danger flex-fill rounded-4">
            <i class="fa fa-phone"></i>
        </a>
    @else
        <a href="https://wa.me/{{ $phone }}" target="_blank" class="btn btn-outline-danger flex-fill rounded-4">
            <i class="fa fa-phone"></i>
        </a>
    @endif
@endif

</div>

          </div>

        </div>

        <!-- 🔍 Zoom Modal -->
@if($images && count($images) > 0)
<div class="modal fade" id="zoomModal-{{ $key }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content  border-0 position-relative">

      <!-- 🔒 Close Button -->
      <button type="button" 
      class="btn-close btn-close-black position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>

      <div class="modal-body p-0">
        <div class="swiper zoomSwiper-{{ $key }}">
          <div class="swiper-wrapper">
            @foreach ($images as $image)
              <div class="swiper-slide">
                <img src="{{ $image }}" class="img-fluid rounded-4" alt="Car Image">
              </div>
            @endforeach
          </div>
          <div class="swiper-button-next text-white"></div>
          <div class="swiper-button-prev text-white"></div>
          <div class="swiper-pagination"></div>
        </div>
      </div>

    </div>
  </div>
</div>

@endif
<script>
  @if($images && count($images) > 0)
new Swiper('.zoomSwiper-{{ $key }}', {
  loop: true,
  grabCursor: true,
  centeredSlides: true,
  spaceBetween: 10,
  autoplay: {
    delay: 3500,
    disableOnInteraction: false,
  },
  pagination: {
    el: '.zoomSwiper-{{ $key }} .swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.zoomSwiper-{{ $key }} .swiper-button-next',
    prevEl: '.zoomSwiper-{{ $key }} .swiper-button-prev',
  },
});
@endif
</script>
<style>
  .zoomSwiper-{{ $key }} img {
  width: 100%;
  height: auto;
  object-fit: contain; /* تظهر الصورة كاملة وواضحة */
  
}
.modal-content {
  /* background-color: rgba(0,0,0,0.5);  */
  border: none;
}
</style>
      </div>

    @empty
      <p class="text-center text-muted mt-4">No cars found matching your criteria.</p>
    @endforelse
  </div>
</div>

<style>
/* ================= Car Card Base ================= */
.car-card {
  background-color: #fff;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 16px;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.hover-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

/* Carousel */
/* Carousel container */
.car-carousel-container {
  width: 100%;
  border-radius: 16px;
  overflow: hidden;
  background-color: #f5f5f5;
  position: relative; /* مهم جداً */
}

/* الصور داخل carousel */
.carousel-img {
  width: 100%;
  height: 200px; /* ارتفاع ثابت على الموبايل */
  object-fit: cover; /* الصورة تغطي المساحة بالكامل */
  display: block;
}

/* Desktop */
@media (min-width: 992px) {
  .car-carousel-container {
    width: 45%;
    height: 100%; /* يملأ ارتفاع البطاقة */
  }
  .carousel-img {
    height: 100%;
  }
}

/* Mobile */
@media (max-width: 991px) {
  .car-carousel-container {
    width: 100%;
    height: 200px; /* ارتفاع ثابت للصور على الموبايل */
    margin-bottom: 1rem;
  }
  .carousel-img {
    height: 100%;
  }
}


/* Details */
.car-details {
  padding: 1rem;
}

/* Action Buttons */
.action {
    display: flex;
    gap: 0.5rem; /* spacing between buttons */
}

.action a {
    flex: 1; /* make buttons equal width */
}

.action button {
    white-space: nowrap;
    font-size: 0.9rem;
    padding: 0.5rem 0;
}


/* Desktop */
@media (min-width: 992px) {
  .car-card {
    flex-direction: row;
    height: 240px;
  }
  /* .car-carousel-container {
    width: 45%;
    height: 100%;
  } */
  .car-details {
    width: 55%;
    padding: 1.2rem 1.5rem;
  }
}

/* Mobile */
@media (max-width: 991px) {
  .car-card {
    flex-direction: column;
    height: auto;
  }
  /* .car-carousel-container {
    width: 100%;
    height: auto;
    margin-bottom: 1rem;
  } */
  .car-details {
    padding: 1rem;
  }
}


</style>









<div class="container py-4">

    @if($carlisting->count() > 0)
        <div class="row g-4 mb-4" id="car-list-load-more">
            @include('cars.load_more', ['carlisting' => $carlisting])
        </div>
    @endif

</div>



<!-- سبينر التحميل -->
<div id="load-more-loader" class="text-center py-4" style="display: none;">
  <div class="spinner-border text-danger" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>
</div>

<!-- العنصر الوهمي للـ Infinite Scroll -->
<div id="infinite-scroll-trigger"></div>


<script>
let page = 1;
let loading = false;
let lastPage = {{ $carlisting->lastPage() }};
let reachedEnd = false;

function getQueryString() {
    const params = new URLSearchParams(window.location.search);
    return params.toString() ? '&' + params.toString() : '';
}

function loadMoreCars() {
    if (loading || reachedEnd) return;
    loading = true;
    document.getElementById('load-more-loader').style.display = 'block';

    fetch(`?page=${page + 1}${getQueryString()}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(res => res.text())
    .then(data => {
        if (!data.trim()) {
            reachedEnd = true;
            observer.disconnect();
            return;
        }
        document.querySelector('#car-list-load-more').insertAdjacentHTML('beforeend', data);
        page++;
        loading = false;
        document.getElementById('load-more-loader').style.display = 'none';

        if(page >= lastPage) {
            reachedEnd = true;
            observer.disconnect();
        }
    })
    .catch(err => {
        console.error(err);
        loading = false;
        document.getElementById('load-more-loader').style.display = 'none';
    });
}

const trigger = document.getElementById('infinite-scroll-trigger');
const observer = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting && !loading && !reachedEnd) {
        loadMoreCars();
    }
}, { rootMargin: '400px' });

observer.observe(trigger);
</script>










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
{{-- <script>
function performScroll() {
    const fragment = window.location.hash; // #car-123
    
    if (fragment) {
        const el = document.querySelector(fragment); 
        
        if (el) {
            // 🎯 وجدنا العنصر: قم بعمل Scroll فورا
            const headerOffset = 100; // قيمة الأوفسيت
            const offsetPosition = el.offsetTop - headerOffset;

            window.scrollTo({
                top: offsetPosition,
                behavior: "smooth"
            });
            
            // إزالة الهاش من الـURL بعد الـScroll
            history.replaceState(null, null, window.location.pathname + window.location.search);
            
            console.log('Scroll successful to:', fragment);
            return true;
        }
    }
    return false;
}

document.addEventListener("DOMContentLoaded", function() {
    
    // إذا لم يكن هناك هاش في الرابط، توقف.
    if (!window.location.hash) {
        return;
    }
    
    // 1. محاولة الـScroll فوراً
    if (performScroll()) {
        return;
    }

    // 2. إذا فشلت المحاولة الأولى، ابدأ التكرار (لانتظار محتوى الـLoad More)
    let attempts = 0;
    const maxAttempts = 50; // 5 ثواني كحد أقصى للبحث
    
    const scrollInterval = setInterval(() => {
        
        // 🚨 المحاولة الأساسية:
        if (performScroll()) {
            clearInterval(scrollInterval);
            return;
        }

        attempts++;
        
        // إذا فشلنا بعد عدد كبير من المحاولات، توقف
        if (attempts >= maxAttempts) {
            clearInterval(scrollInterval);
            console.log('Scroll failed after maximum attempts.');
        }

    }, 100); // حاول كل 100 ملي ثانية
});
</script> --}}
<script>
// ----------------------------------------------------------------------
// دالة handleFavoriteAction (تبقى كما هي، وهي صحيحة)
// ----------------------------------------------------------------------
function handleFavoriteAction(formElement, buttonElement) {
    buttonElement.disabled = true;

    const carId = buttonElement.dataset.carId;
    const actionUrl = formElement.action;
    // ملاحظة: هذا السطر يجب أن يكون ناجحاً لجميع الفورمات، بما في ذلك المحملة عبر AJAX
    const csrfToken = formElement.querySelector('input[name="_token"]').value; 
    
const favIcon = buttonElement.querySelector('.fas.fa-heart');
    // 1. إرسال طلب AJAX (POST)
    fetch(actionUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({})
    })
    .then(response => {
        // ... (معالجة الأخطاء) ...
        return response.json();
    })
    .then(data => {
        if (data.success) {
            
            // 2. تحديث الـIcon
            if (favIcon) {
                favIcon.style.color = data.is_favorite ? '#dc3545' : '#6c757d';
            }
            
            // 3. منطق الـScroll (يحدث فقط عند الإضافة)
            if (data.is_favorite) { 
                const targetElement = document.getElementById(`car-${carId}`);
                if (targetElement) {
                    const offsetPosition = targetElement.offsetTop - 230;
                    window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
                    
                    history.pushState(null, null, window.location.pathname + window.location.search + `#car-${carId}`);
                    setTimeout(() => {
                        history.replaceState(null, null, window.location.pathname + window.location.search);
                    }, 1000);
                }
            } else {
                history.replaceState(null, null, window.location.pathname + window.location.search);
            }
        } else {
            console.error('AJAX request failed:', data);
        }
    })
    .catch(error => {
        console.error('Error during AJAX call:', error);
    })
    .finally(() => {
        buttonElement.disabled = false;
    });
}

// ----------------------------------------------------------------------
// مُعالِج الحدث الموحد (Event Delegation)
// ----------------------------------------------------------------------

// 🚨 هذا هو المُعالِج الوحيد الذي يجب استخدامه.
// يقوم بتعويض كل من 'submit' و 'click' ويعمل على كل المحتوى المحمل عبر AJAX.
document.addEventListener('click', function(e) {
    const button = e.target.closest('.fav-button');
    
    if (button) {
        // منع أي سلوك افتراضي (مهم جداً!)
        e.preventDefault(); 
        
        const form = button.closest('.ajax-fav-form');
        
        if (form) {
            handleFavoriteAction(form, button);
        }
    }
});
</script>
@endsection