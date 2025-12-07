@extends('layouts.CarProvider')

@section('content')
  <div class="container-fluid p-0 position-relative mb-2" style="z-index: 2;">
    <img src="{{ asset('3.jpg') }}" alt="Cars" class="w-100 img-fluid object-fit-cover" style="max-height: 550px; object-position: center;">
  </div>
   <div class="container text-center mt-5">
    <h2 class="fw-bold mb-4" style="color: #163155;">My Workshop</h2>
          <div class="custom-container">
               <div class="row g-4">
        @php
           $shareUrl = route('workshops.show.provider', $workshop->id);

       $firstImage = $workshop->images->first();

$image = $firstImage
    ? env('CLOUDFLARE_R2_URL') . $firstImage->image
    : (
        $workshop->workshop_logo
            ? (Str::startsWith($workshop->workshop_logo, ['http://', 'https://'])
                ? $workshop->workshop_logo
                : env('CLOUDFLARE_R2_URL') . $workshop->workshop_logo)
            : asset('workshopNotFound.png')
    );

             $mapUrl = $workshop->latitude && $workshop->longitude
        ? "https://www.google.com/maps?q={$workshop->latitude},{$workshop->longitude}"
        : null;
        @endphp

        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="car-card animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                
                <!-- Workshop Image -->
                <div class="car-image position-relative">
                    <a href="{{ route('workshops.show.provider', $workshop->id) }}">
                        <img src="{{ $image }}"
                             alt="{{ $workshop->workshop_name }}"
                             loading="lazy"
                             onerror="this.src='{{ asset('workshopNotFound.png') }}'"
                             class="img-fluid rounded-4 w-100">
                    </a>

                    <!-- Zoom Button -->
                    <button type="button" 
                            class="btn btn-light position-absolute top-0 end-0 m-2 shadow"
                            style="width: 30px; height: 30px; border-radius: 50%; color:#760e13; display:flex; align-items:center; justify-content:center;"
                            data-bs-toggle="modal" 
                            data-bs-target="#workshopImagesModal{{ $workshop->id }}"
                            onclick="event.stopPropagation();">
                        <i class="fas fa-search-plus"></i>
                    </button>
                </div>

                <!-- Workshop Content -->
                <div class="car-card-body mt-2 text-start">
                    <h5 class="fw-bold text-truncate mb-1" title="{{ $workshop->workshop_name }}" style="color: var(--primary-color);">
                        {{ Str::limit(ucwords(strtolower($workshop->workshop_name)), 25) }}
                    </h5>

                 <p class="text-muted small mb-2">
    <i class="fas fa-map-marker-alt me-1 text-danger"></i>

    @if($mapUrl)
        <a href="{{ $mapUrl }}" target="_blank" class="text-decoration-none text-muted">
            {{ $workshop->branch ?? 'Address not available' }}
        </a>
    @else
        {{ $workshop->branch ?? 'Address not available' }}
    @endif
</p>

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

                </div>
            </div>
        </div>

@php
    $images = \App\Models\Image::where('workshop_provider_id', $workshop->id)->pluck('image');
@endphp

@if($images && count($images) > 0)
<div class="modal fade customWorkshopModal" id="workshopImagesModal{{ $workshop->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content border-0 shadow-none position-relative" style="padding: 20px; background-color: white;">

      <!-- ❌ زر الإغلاق الكبير -->
      <button type="button"
              class="btn-close-custom"
              data-bs-dismiss="modal"
              aria-label="Close">
        &times;
      </button>

      <!-- ✅ Swiper داخل المودال -->
      <div class="modal-body p-0">
        <div class="swiper workshopSwiper-{{ $workshop->id }}">
          <div class="swiper-wrapper">
            @foreach ($images as $img)
              <div class="swiper-slide d-flex justify-content-center align-items-center bg-black">
                <img src="{{ env('CLOUDFLARE_R2_URL') . $img }}"
                     class="img-fluid"
                     style="max-height:85vh; object-fit:contain;"
                     alt="Workshop Image">
              </div>
            @endforeach
          </div>

          <!-- ✅ عناصر التحكم -->
          <div class="swiper-button-next text-white"></div>
          <div class="swiper-button-prev text-white"></div>
          <div class="swiper-pagination"></div>
        </div>
      </div>

    </div>
  </div>
</div>
@endif

<!-- ✅ Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<!-- ✅ Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
/* ✅ خلفية المودال البيضاء */
.customWorkshopModal {
  z-index: 9999 !important;
}

/* ✅ زر الإغلاق الكبير */
.btn-close-custom {
  position: absolute;
  top: 10px;
  right: 20px;
  font-size: 2.3rem;
  color: black;
  background: transparent;
  border: none;
  z-index: 10000;
  cursor: pointer;
  transition: 0.2s ease;
}
.btn-close-custom:hover {
  color: #ff4c4c;
  transform: scale(1.1);
}

/* ✅ الصور */
.workshopSwiper-{{ $workshop->id }} img {
  width: auto;
  height: auto;
  max-width: 100%;
  object-fit: contain;
}

/* ✅ عدم التداخل مع مودالات أخرى */
.modal-backdrop.show {
  opacity: 0.8;
}
</style>

<script>
@if($images && count($images) > 0)
document.addEventListener('shown.bs.modal', function (event) {
  const modal = event.target;
  if (modal.id === 'workshopImagesModal{{ $workshop->id }}') {
    const swiperEl = modal.querySelector('.workshopSwiper-{{ $workshop->id }}');
    if (!swiperEl.swiper) {
      new Swiper(swiperEl, {
        loop: true,
        grabCursor: true,
        centeredSlides: true,
        spaceBetween: 10,
        autoplay: {
          delay: 3500,
          disableOnInteraction: false,
        },
        pagination: {
          el: swiperEl.querySelector('.swiper-pagination'),
          clickable: true,
        },
        navigation: {
          nextEl: swiperEl.querySelector('.swiper-button-next'),
          prevEl: swiperEl.querySelector('.swiper-button-prev'),
        },
      });
    } else {
      swiperEl.swiper.update();
    }
  }
});
@endif
</script>


</div>
            
            </div>
  
  </div>
@endsection