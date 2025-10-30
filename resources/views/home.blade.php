@extends('layouts.app')
@php
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Str;
@endphp

@section('content')
<div id="main-content">
  
   <section class="position-relative" style="background: linear-gradient(90deg, #760e13, #9b2a2f, #c4474c); overflow: hidden; ">
  <div class="container-fluid p-0 position-relative " style="z-index: 2;">
    <img src="{{ asset('1.jpg') }}" alt="Cars" class="w-100 img-fluid object-fit-cover" style="max-height: 550px; object-position: center;">
  </div>

  <!-- Subtle overlay for effect -->
  <div class="position-absolute top-0 start-0 w-100 h-100" 
       style="background: radial-gradient(circle at center, rgba(255,255,255,0.08), transparent 70%); z-index:1;">
  </div>
</section>


<!-- ✅ Services Section -->
<section class="py-5 mt-4 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold mb-4" style="color: #760e13;">Browse from our services</h2>

    <!-- ✅ Scrollable container -->
    <div class="services-scroll">
      <div class="d-flex gap-3 flex-nowrap justify-content-center">

        <!-- Buy Car -->
        <a href="{{ route('cars.index') }}" class="service-card text-decoration-none text-dark flex-shrink-0">
          <div class="card-inner">
            <i class="fas fa-car fa-2x mb-2" style="color:#760e13;"></i>
            <h5 class="fw-bold mb-1 text-truncate">Cars</h5>
            <p class="text-muted small mb-0 text-wrap">Best in class cars</p>
          </div>
        </a>

        <!-- Spare Parts -->
        <a href="{{ route('spareParts.index') }}" class="service-card text-decoration-none text-dark flex-shrink-0">
          <div class="card-inner">
            <i class="fas fa-cog fa-2x mb-2" style="color:#760e13;"></i>
            <h5 class="fw-bold mb-1 text-truncate">Spare Parts</h5>
            <p class="text-muted small mb-0 text-wrap">Find genuine parts easily</p>
          </div>
        </a>

        <!-- Workshops -->
        <a href="{{ route('workshops.index') }}" class="service-card text-decoration-none text-dark flex-shrink-0">
          <div class="card-inner">
            <i class="fas fa-wrench fa-2x mb-2" style="color:#760e13;"></i>
            <h5 class="fw-bold mb-1 text-truncate">Workshops</h5>
            <p class="text-muted small mb-0 text-wrap">Expert car service near you</p>
          </div>
        </a>

      </div>
    </div>
  </div>
</section>

<!-- ✅ Styles -->
<style>
.services-scroll {
  overflow-x: auto;
  padding-bottom: 0.7rem;
  scrollbar-width: thin;
  scrollbar-color: #ccc transparent;
}
.services-scroll::-webkit-scrollbar {
  height: 6px;
}
.services-scroll::-webkit-scrollbar-thumb {
  background-color: #ccc;
  border-radius: 4px;
}
.services-scroll::-webkit-scrollbar-track {
  background: transparent;
}

/* ✅ All cards same size and centered content */
.service-card {
  width: 180px;
  height: 180px;
  flex: 0 0 auto;
  text-align: center;
}
.card-inner {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  padding: 1.2rem 1rem;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  transition: all 0.3s ease;
}
.card-inner:hover {
  box-shadow: 0 6px 20px rgba(0,0,0,0.15);
  transform: translateY(-4px);
}

/* ✅ Text control */
h5, p {
  white-space: normal;
  overflow: hidden;
  text-overflow: ellipsis;
  word-wrap: break-word;
}

/* ✅ Responsive behavior */
@media (max-width: 992px) {
  .service-card {
    width: 160px;
    height: 160px;
  }
  .card-inner h5 { font-size: 1rem; }
  .card-inner p { font-size: 0.8rem; }
}
@media (max-width: 768px) {
  .service-card {
    width: 140px;
    height: 150px;
  }
  .card-inner h5 { font-size: 0.95rem; }
  .card-inner p { font-size: 0.75rem; }
}
@media (max-width: 576px) {
  .services-scroll {
    margin-left: -0.75rem;
    margin-right: -0.75rem;
    padding-left: 0.75rem;
  }
  .service-card {
    width: 130px;
    height: 140px;
  }
  .card-inner h5 { font-size: 0.9rem; }
  .card-inner p { font-size: 0.7rem; }
}
</style>






    <!-- Enhanced Navigation Section -->
    <div class="main-home-filter-sec text-center">
        <div class="text-center my-5">
  <h2 class="animated-square-title">
    Featured <span>CARS</span>
  </h2>
</div>
                   {{-- <h2 class="section-title animate__animated animate__fadeInUp">Featured Cars</h2> --}}
        <!-- Enhanced Car Listings -->
        <div class="custom-container main-car-list-sec">
        <div class="row g-4">
    @forelse ($carlisting as $key => $car)
        @php
            // <-- ensure images for this car are loaded (required for zoom button & modal)
            $images = $car->images()->pluck('image');
        @endphp

        <div class="col-sm-6 col-lg-4 col-xl-3">
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
@php
    $images = $car->images ? $car->images->map(fn($img) => env('CLOUDFLARE_R2_URL') . $img->image)->toArray() : [];
@endphp

                    <!-- 🔍 Zoom Button (only if images exist) -->
               @if($images && count($images) > 0)
<button type="button"
        class="btn btn-light position-absolute top-0 start-0 m-2"
        style="z-index: 1055; width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center;"
        data-bs-toggle="modal"
        data-bs-target="#zoomModal-{{ $key }}">
    <i class="fas fa-search-plus" style="color:#760e13;"></i>
</button>
@endif


                    <!-- Favorite & Share Buttons (unchanged) -->
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

                        <a href="https://wa.me/?text={{ urlencode(
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

                <!-- Enhanced Car Content (unchanged) -->
                <div class="car-card-body">
                    <div class="price-location d-flex align-items-center justify-content-between flex-wrap">
                        <!-- Price -->
                        <span class="price d-flex align-items-center me-3">
                            <img style="width:17px; height:17px; margin-right: 4px;" src="{{ asset('assets/images/UAE_Dirham_Symbol.svg.png') }}">
                            {{ number_format($car->listing_price) }}
                        </span>

                        <!-- Location (will not show when missing/null) -->
                        @if(!empty($car->lat) && !empty($car->lng) && !empty($car->city) && strtolower($car->city) !== 'null')
                            <span class="small text-muted mb-0 mt-0 d-flex align-items-center" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                <a href="https://www.google.com/maps?q={{ $car->lat }},{{ $car->lng }}" 
                                   target="_blank" 
                                   style="color: #760e13; text-decoration: none;">
                                    {{ $car->city }}, UAE
                                </a>
                            </span>
                        @endif
                    </div>

                    <h4 class="text-start mb-2" style="font-size:1.1rem">{{$car->user?->fname}} {{$car->user?->lname}}</h4>

                    <div class="car-details mt-3 text-start">
                        <div class="row g-1">
                            <p class="mb-1"><strong>Make:</strong> <span>{{$car->listing_type}}</span></p>
                            <p class="mb-1"><strong>Year:</strong> <span>{{$car->listing_year}}</span></p>
                            <p class="mb-1"><strong>Model:</strong> <span>{{ $car->listing_model }}</span></p>
                            <p class="mb-0"><strong>Mileage:</strong> <span>{{ $car->mileage ?? '215K' }} km</span></p>
                        </div>
                    </div>

                    <!-- Enhanced Action Buttons (unchanged) -->
                    <div class="d-flex justify-content-between gap-2 flex-wrap text-center mt-2" style="width: 100%;">
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

                        @if($os == 'Android' || $os == 'iOS')
                            <a href="tel:{{ $car->user->phone }}" class="flex-fill text-decoration-none">
                                <button class="btn btn-outline-danger w-100 rounded-4">
                                    <i class="fas fa-phone me-1"></i>
                                </button>
                            </a>
                        @else
                            <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank" class="flex-fill text-decoration-none">
                                <button class="btn btn-outline-danger w-100 rounded-4">
                                    <i class="fas fa-phone me-1"></i>
                                </button>
                            </a>
                        @endif
                    </div>

                    <style>
                        /* Keep buttons side-by-side even on very small screens */
                        .actions a {
                          flex: 1 1 48%; /* each button roughly half width */
                        }

                        .actions button {
                          white-space: nowrap;
                          font-size: 1rem;
                          padding: 0.6rem 0;
                        }

                        /* Adjust spacing for extra small screens */
                        @media (max-width: 400px) {
                          .actions a {
                            flex: 1 1 48%;
                          }
                          .actions button {
                            font-size: 0.9rem;
                          }
                        }
                    </style>

                </div>
            </div>
        </div>

        <!-- ===== Zoom modal (only present if images exist) ===== -->
<!-- ✅ Zoom Modal -->
@if($images && count($images) > 0)
<div class="modal fade customZoomModal" id="zoomModal-{{ $key }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" >
    <div class="modal-content border-0  shadow-none position-relative" style="padding: 20px; background-color: white;">

      <!-- ❌ زر الإغلاق الكبير -->
      <button type="button"
              style="color: black"
              class="btn-close-custom"
              data-bs-dismiss="modal"
              aria-label="Close">
        &times;
      </button>

      <!-- ✅ Swiper Container -->
      <div class="modal-body p-0">
        <div class="swiper zoomSwiper-{{ $key }}">
          <div class="swiper-wrapper">
            @foreach ($images as $image)
              <div class="swiper-slide d-flex justify-content-center align-items-center bg-black">
                <img src="{{ $image }}" 
                     class="img-fluid " 
                     style="max-height:85vh; object-fit:contain;"
                     alt="Car Image">
              </div>
            @endforeach
          </div>

          <!-- ✅ Swiper Controls -->
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
/* ✅ إزالة الطبقة السوداء المزعجة */
.modal-backdrop {
  display: none !important;
}

/* ✅ خلفية المودال */


/* ✅ ترتيب الطبقات */
.customZoomModal {
  z-index: 9999 !important;
}

/* ✅ زر X الكبير */
.btn-close-custom {
  position: absolute;
  top: 15px;
  right: 20px;
  font-size: 2rem;
  color: #fff;
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

/* ✅ صور واضحة */
.zoomSwiper-{{ $key }} img {
  width: auto;
  height: auto;
  max-width: 100%;
  object-fit: contain;
}
</style>

<script>
@if($images && count($images) > 0)
document.addEventListener('shown.bs.modal', function (event) {
  const modal = event.target;
  if (modal.id === 'zoomModal-{{ $key }}') {
    const swiperEl = modal.querySelector('.zoomSwiper-{{ $key }}');
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
            <div class="text-center my-5">
  <h2 class="animated-square-title">
    Featured <span>DEALERS</span>
  </h2>
</div>
            {{-- <h2 class="section-title animate__animated animate__fadeInUp">Featured Dealers</h2> --}}
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
<div class="actions-dealer d-flex justify-content-between align-items-center mt-2">
<a href="https://wa.me/{{ $phone }}?text={{ urlencode(
    'Hello, I’m interested in buying spare parts from your dealership. Could you please share more details about available parts?' . "\n\n" .
    'Dealer Name: ' . $dealer->company_name . "\n" .
    'Address: ' . ($dealer->company_address ?? 'Not specified') . "\n\n" 
) }}"
target="_blank"
class="text-decoration-none flex-grow-1">
    <button class="btn btn-outline-success w-100 action-btn rounded-4">
        <i class="fab fa-whatsapp"></i>
    </button>
</a>


    @if ($os == 'Android' || $os == 'iOS')
        <a href="tel:{{ $phone }}" class="text-decoration-none flex-grow-1">
            <button class="btn btn-outline-danger w-100 action-btn rounded-4">
                <i class="fas fa-phone"></i>
            </button>
        </a>
    @else
        <a href="https://wa.me/{{ $phone }}" target="_blank" class="text-decoration-none flex-grow-1">
            <button class="btn btn-outline-danger w-100 action-btn rounded-4">
                <i class="fas fa-phone"></i>
            </button>
        </a>
    @endif


     @php
    $dealerUrl = route('spareParts.index', [
        'dealer_id'   => $dealer->id,
        'make'        => request('make'),
        'model'       => request('model'),
        'year'        => request('year'),
        'category'    => request('category'),
        'sub-category'=> request('sub-category'),
        'city'        => request('city'),
        'condition'   => request('condition'),
    ]);

    $shareMessage = "Check out my latest find on Carlly! Great deals await. Don't miss out!: " . $dealerUrl;
@endphp

<a href="https://wa.me/?text={{ urlencode($shareMessage) }}" 
   target="_blank" 
   class="action-link">
    <button class="btn btn-outline-info w-100 action-btn rounded-4" title="Share via WhatsApp">
        <i class="fas fa-share-alt"></i>
    </button>
</a>

</div>

<style>
.actions-dealer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 8px;
  width: 100%;
  flex-wrap: nowrap;
}

/* Make all buttons share space equally */
.actions-dealer a {
  flex: 1 1 0;
}

/* Base button style (large screens → smaller buttons) */
.action-btn {
  width: 100%;
  height: 38px;           /* smaller on desktop */
  font-size: 1rem;
  border-radius: 10px;
  transition: all 0.3s ease;
}

/* Medium screens */
@media (max-width: 992px) {
  .action-btn {
    height: 42px;
    font-size: 1.05rem;
  }
}

/* Small screens */
@media (max-width: 576px) {
  .actions-dealer {
    gap: 6px;
  }
  .action-btn {
    height: 40px;
    font-size: 1rem;
  }
}

/* Extra small screens */
@media (max-width: 400px) {
  .action-btn {
    height: 36px;
    font-size: 0.9rem;
  }
}
</style>




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
<style>
@keyframes bgFlow {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.animated-square-title {
  display: inline-block;
  padding: 13px 40px;
  font-size: 1.7rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: #fff;
  border-radius: 12px;
  background: linear-gradient(135deg, #760e13, #c71f2d, #185D31, #0f3c1f);
  background-size: 300% 300%;
  animation: bgFlow 6s ease infinite;
  box-shadow: 0 0 25px rgba(118, 14, 19, 0.3);
  position: relative;
  overflow: hidden;
}

.animated-square-title::before {
  content: "";
  position: absolute;
  top: -3px;
  left: -3px;
  right: -3px;
  bottom: -3px;
  border-radius: 14px;
  background: linear-gradient(90deg, rgba(255,255,255,0.15), transparent, rgba(255,255,255,0.15));
  animation: bgFlow 3s linear infinite;
  z-index: 0;
}

.animated-square-title span {
  color: #ffe600;
  position: relative;
  z-index: 2;
}

@media (max-width: 768px) {
  .animated-square-title {
    font-size: 1.6rem;
    padding: 14px 25px;
  }
}
</style>

<div class="text-center my-5">
  <h2 class="animated-square-title">
    Featured <span>WORKSHOPS</span>
  </h2>
</div>




            <div class="custom-container">
               <div class="row g-4">
    @foreach ($workshops as $key => $workshop)
        @php
            $shareUrl = request()->path() == 'home'
                ? request()->url() . '?workshop_id=' . $workshop->id
                : request()->fullUrl() . '&workshop_id=' . $workshop->id;

            $image = $workshop->workshop_logo
                ? (Str::startsWith($workshop->workshop_logo, ['http://', 'https://'])
                    ? $workshop->workshop_logo
                    : env('CLOUDFLARE_R2_URL') . $workshop->workshop_logo)
                : asset('workshopNotFound.png');
        @endphp

        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="car-card animate__animated animate__fadeInUp" style="animation-delay: {{ $key * 0.1 }}s">
                
                <!-- Workshop Image -->
                <div class="car-image position-relative">
                    <a href="{{ route('workshops.show', $workshop->id) }}">
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
                <div class="car-card-body mt-2">
                    <h5 class="fw-bold text-truncate mb-1" title="{{ $workshop->workshop_name }}" style="color: var(--primary-color);">
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
                    <div class="actions-workshop d-flex gap-2">
                        <a href="https://wa.me/{{ $workshop->user->phone }}?text={{ urlencode(
                            'Hello, I’m interested in your workshop services. Are you still available for maintenance or repair work?' . "\n\n" .
                            'Workshop Name: ' . $workshop->workshop_name . "\n" .
                            'Address: ' . ($workshop->address ?? 'Not specified') . "\n\n" .
                            'View Workshop on Website: ' . $shareUrl
                        ) }}" target="_blank" class="flex-grow-1">
                            <button class="btn btn-outline-success w-100 action-btn rounded-4">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                        </a>

                        <a href="tel:{{ $workshop->user->phone }}" class="flex-grow-1">
                            <button class="btn btn-outline-danger w-100 action-btn rounded-4">
                                <i class="fas fa-phone"></i>
                            </button>
                        </a>

                        <a href="https://wa.me/?text={{ urlencode('Check out this workshop: ' . $shareUrl) }}" 
                           target="_blank" class="flex-grow-1">
                            <button class="btn btn-outline-info w-100 action-btn rounded-4">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </a>
                    </div>
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


    @endforeach
</div>

<!-- Actions CSS -->
<style>
.actions-workshop {
    display: flex;
    justify-content: space-between;
    gap: 6px;
    flex-wrap: nowrap;
}

.actions-workshop a {
    flex: 1;
}

.action-btn {
    width: 100%;
    height: 38px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

/* Medium screens */
@media (max-width: 992px) {
    .action-btn { height: 42px; font-size: 1.05rem; }
}

/* Small screens */
@media (max-width: 576px) {
    .action-btn { height: 40px; font-size: 1rem; }
}
</style>

                
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
                    <a href="{{ route('cars.index', array_merge(request()->query(), ['make' => $brand->name])) }}" class="text-decoration-none">
                        <div class="brand-card text-center p-3 h-100">
                            <div class="mb-2" style="height: 60px; display: flex; align-items: center; justify-content: center;">
                                @php
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
                            <p class="text-muted small mb-0 brand-subtitle">{{ $brand->cars_count ?? 'N/A' }} Cars</p>
                        </div>
                    </a>
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