@extends('layouts.app')
@php
use Illuminate\Support\Str;
@endphp

@section('content')

<div class="custom-container main-car-list-sec" style="margin-top:30px;">
<h2 class="mb-4 text-center fw-bold position-relative"
    style="color:#760e13; margin-top:30px;">
   Favorites
</h2>

<style>
h2.text-center::after {
    content: "";
    display: block;
    width: 40px;
    height: 5px;
    background-color: #760e13;
    margin: 10px auto 0;
    border-radius: 2px;
}
</style>
    <div class="row g-4">
        @forelse ($carlisting as $key => $car)
            @php
                $images = $car->images ? $car->images->map(fn($img) => env('CLOUDFLARE_R2_URL') . $img->image)->toArray() : [];
                $phone = preg_replace('/\D/', '', $car->user?->phone);
                $userAgent = request()->header('User-Agent');
                $isMobile = Str::contains($userAgent, ['Android', 'iPhone', 'iPad']);
            @endphp

            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="car-card animate__animated animate__fadeInUp" style="animation-delay: {{ $key * 0.1 }}s">
                    
                    <!-- Car Image Section -->
                    <div class="car-image position-relative" style="height:220px; overflow:hidden; border-radius:10px; display:flex; align-items:center; justify-content:center; background:#f0f0f0;">
                        <a href="{{ route('car.detail', $car->id) }}">
                            <img src="{{ $images[0] ?? asset('carNotFound.jpg') }}"
                                 alt="{{$car->listing_type}} {{$car->listing_model}}"
                                 loading="lazy"
                                 style="width:100%; height:100%; object-fit:cover; object-position:center;"
                                 onerror="this.src='{{ asset('carNotFound.jpg') }}'">
                        </a>

                        <!-- Zoom Button -->
                        @if(count($images) > 0)
                        <button type="button"
                                class="btn btn-light position-absolute top-0 start-0 m-2"
                                style="z-index: 1055; width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center;"
                                data-bs-toggle="modal"
                                data-bs-target="#zoomModal-{{ $key }}">
                            <i class="fas fa-search-plus text-danger"></i>
                        </button>
                        @endif

                        <!-- Favorite & Share -->
                        <div class="position-absolute top-0 end-0 m-2 d-flex gap-2" style="z-index:10;">
                            @if(auth()->check())
                                @php $favCars = auth()->user()->favCars()->pluck('id')->toArray(); @endphp
                                <form action="{{ route('cars.addTofav', $car->id) }}" method="post" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-sm shadow-sm border-0 d-flex align-items-center justify-content-center" style="width:32px;height:32px;border-radius:50%;">
                                        <i class="fas fa-heart" style="color: {{ in_array($car->id, $favCars) ? '#dc3545' : '#6c757d' }}"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-light btn-sm shadow-sm border-0 d-flex align-items-center justify-content-center" style="width:32px;height:32px;border-radius:50%;">
                                    <i class="fas fa-heart text-secondary"></i>
                                </a>
                            @endif

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

                    <!-- Car Info -->
                    <div class="car-card-body mt-2">
                        <div class="price-location d-flex align-items-center justify-content-between flex-wrap">
                            <span class="price d-flex align-items-center me-3">
                                <img src="{{ asset('assets/images/UAE_Dirham_Symbol.svg.png') }}" style="width:17px;height:17px;margin-right:4px;">
                                {{ number_format($car->listing_price) }}
                            </span>
                        @if(!empty($car->lat) && !empty($car->lng) && !empty($car->city) && strtolower($car->city) !== 'null')
    <span class="small text-muted mb-0 mt-0 d-flex align-items-center">
        <i class="fas fa-map-marker-alt text-danger me-1"></i>
        <a href="https://www.google.com/maps?q={{ $car->lat }},{{ $car->lng }}" target="_blank" class="text-decoration-none" style="color:#760e13;">
            {{ $car->city }}, UAE
        </a>
    </span>
@endif

                        </div>

                        <h4 class="text-start mb-2" style="font-size:1.1rem">{{$car->user?->fname}} {{$car->user?->lname}}</h4>

                        <div class="car-details mt-2 text-start">
                            <p class="mb-1"><strong>Make:</strong> {{$car->listing_type}}</p>
                            <p class="mb-1"><strong>Year:</strong> {{$car->listing_year}}</p>
                            <p class="mb-1"><strong>Model:</strong> {{$car->listing_model}}</p>
                            <p class="mb-0"><strong>Mileage:</strong> {{$car->features_speed }} km</p>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between gap-2 flex-wrap mt-2">
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

                            @if(!empty($phone))
                            <a href="{{ $isMobile ? 'tel:' . $phone : 'https://wa.me/' . $phone }}" target="{{ $isMobile ? '_self' : '_blank' }}" class="btn btn-outline-danger flex-fill rounded-4">
                                <i class="fa fa-phone"></i> 
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Zoom Modal -->
                @if(count($images) > 0)
                <div class="modal fade customZoomModal" id="zoomModal-{{ $key }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content border-0 shadow-none position-relative p-3 bg-white">
                            <button type="button" class="btn-close-custom" data-bs-dismiss="modal">&times;</button>
                            <div class="modal-body p-0">
                                <div class="swiper zoomSwiper-{{ $key }}">
                                    <div class="swiper-wrapper">
                                        @foreach ($images as $image)
                                            <div class="swiper-slide d-flex justify-content-center align-items-center bg-black">
                                                <img src="{{ $image }}" class="img-fluid" style="max-height:85vh; object-fit:contain;" alt="Car Image">
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

            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-car fa-3x text-muted mb-3"></i>
                <h3 class="text-muted">No cars available</h3>
                <p class="text-muted">Check back later for new listings</p>
            </div>
        @endforelse
    </div>


</div>

<!-- Swiper JS & CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<style>
.customZoomModal { z-index:9999 !important; }
.btn-close-custom {
    position:absolute; top:15px; right:20px; font-size:2rem; color:#fff; background:transparent; border:none; cursor:pointer;
}
.btn-close-custom:hover { color:#ff4c4c; transform:scale(1.1); }
.modal-backdrop { display:none !important; }
</style>

<script>
document.addEventListener('shown.bs.modal', function(event){
    const modal = event.target;
    const key = modal.id.split('-')[1];
    const swiperEl = modal.querySelector('.zoomSwiper-'+key);
    if(swiperEl && !swiperEl.swiper){
        new Swiper(swiperEl, {
            loop:true,
            grabCursor:true,
            centeredSlides:true,
            spaceBetween:10,
            autoplay:{delay:3500, disableOnInteraction:false},
            pagination:{el:swiperEl.querySelector('.swiper-pagination'), clickable:true},
            navigation:{nextEl:swiperEl.querySelector('.swiper-button-next'), prevEl:swiperEl.querySelector('.swiper-button-prev')}
        });
    }
});
</script>

@endsection
