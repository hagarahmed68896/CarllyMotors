@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;

    $images = \App\Models\Image::where('workshop_provider_id', $workshop->id)->pluck('image');
    $mapUrl = $workshop->latitude && $workshop->longitude
        ? "https://www.google.com/maps?q={$workshop->latitude},{$workshop->longitude}"
        : null;
        $defaultImage = asset('carllymotorsmainlogo.png');

@endphp

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<div class="container py-4">

 <!-- 🔹 Workshop Main Image & Zoom -->
    <div class="position-relative d-flex justify-content-center mb-4"
     style="border-radius:16px;">

    <img
        src="{{ $images->count() > 0 ? env('CLOUDFLARE_R2_URL') . $images[0] : $defaultImage }}"
        class="img-fluid rounded shadow-sm"
        style="
            width:100%;
            height:auto;
            max-height:320px;
            object-fit:contain;
            background:#f5f5f5;
        "
        alt="Workshop Image">

    {{-- 🔍 Zoom Button --}}
    @if($images->count() > 0)
        <button type="button"
            class="btn position-absolute"
            style="background:#760e13; color:#fff; top:15px; left:15px; border-radius:12px;"
            data-bs-toggle="modal"
            data-bs-target="#workshopImagesModal{{ $workshop->id }}">
            <i class="fas fa-search-plus"></i>
        </button>
    @endif
</div>


    <!-- ✅ Fixed Modal (with header, background & proper layering) -->
    <div class="modal fade" id="workshopImagesModal{{ $workshop->id }}" tabindex="-1"
         aria-labelledby="workshopImagesModalLabel{{ $workshop->id }}" aria-hidden="true"
         style="z-index:1055;">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content rounded-4 position-relative">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-dark" id="workshopImagesModalLabel{{ $workshop->id }}">
                        {{ $workshop->workshop_name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-0 d-flex justify-content-center align-items-center" 
                     style="max-height: 80vh; overflow: hidden;">
                    <div class="swiper workshopSwiper-{{ $workshop->id }}" style="width:100%; height:100%;">

                        <div class="swiper-wrapper">
                            @foreach($images as $img)
                                <div class="swiper-slide d-flex justify-content-center align-items-center">
                                    <img src="{{ env('CLOUDFLARE_R2_URL') . $img }}" 
                                         class="img-fluid rounded-4" 
                                         alt="Workshop Image" 
                                         style="max-height: 75vh; object-fit: contain;">
                                </div>
                            @endforeach
                        </div>

                        <!-- Navigation -->
                        <div class="swiper-button-next text-white"></div>
                        <div class="swiper-button-prev text-white"></div>

                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Swiper Scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        document.getElementById('workshopImagesModal{{ $workshop->id }}')
            .addEventListener('shown.bs.modal', function () {
                new Swiper('.workshopSwiper-{{ $workshop->id }}', {
                    loop: true,
                    grabCursor: true,
                    centeredSlides: true,
                    spaceBetween: 10,
                    autoplay: {
                        delay: 3500,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.workshopSwiper-{{ $workshop->id }} .swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.workshopSwiper-{{ $workshop->id }} .swiper-button-next',
                        prevEl: '.workshopSwiper-{{ $workshop->id }} .swiper-button-prev',
                    },
                });
            });
    </script>



    <!-- 🔹 Workshop Title -->
    <h4 class="fw-bold text-center mb-3">{{ $workshop->workshop_name }}</h4>

    <!-- 🔹 Workshop Info -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <h6 class="text-muted small mb-1">Branch</h6>
                <p class="fw-semibold mb-0">
                    @if($mapUrl)
                        <a href="{{ $mapUrl }}" target="_blank" class="text-decoration-none text-dark">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $workshop->branch }}
                        </a>
                    @else
                        {{ $workshop->branch ?? '—' }}
                    @endif
                </p>
            </div>

            <div class="col-md-6 mb-3">
                <h6 class="text-muted small mb-1">Full Address</h6>
                <p class="fw-semibold mb-0">{{ $workshop->address ?? '—' }}</p>
            </div>

            <div class="col-md-6 mb-3">
                <h6 class="text-muted small mb-1">Supported Brands</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($brands as $brand)
                        <span class="badge rounded-pill border" style="background:#fff; color:#000;">{{ $brand }}</span>
                    @endforeach
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <h6 class="text-muted small mb-1">Workshop Categories</h6>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($categories as $cat)
                        <span class="badge rounded-pill border" style="background:#fff; color:#000;">{{ $cat }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- 🔹 Working Hours -->
    @if($workshop->days && count($workshop->days) > 0)
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
            <h6 class="text-muted small mb-3">Working Hours</h6>
            @foreach($workshop->days as $day)
                <p class="mb-1 fw-semibold">
                    {{ $day->day }}:
                    {{ $day->from ? \Carbon\Carbon::parse($day->from)->format('h:i A') : '--' }}
                    -
                    {{ $day->to ? \Carbon\Carbon::parse($day->to)->format('h:i A') : '--' }}
                </p>
            @endforeach
        </div>
    @endif

@php
$shareUrl = route('workshops.show', $workshop->id);

    $mapUrl = $workshop->latitude && $workshop->longitude
        ? "https://www.google.com/maps?q={$workshop->latitude},{$workshop->longitude}"
        : null;

    $isMobile = Str::contains(request()->header('User-Agent'), ['Android', 'iPhone', 'iPad']);
@endphp

<!-- 🔹 Action Buttons -->
<div class="d-flex justify-content-center mt-4 flex-wrap gap-2 text-center">
    
    <!-- ✅ WhatsApp -->
    <a href="https://wa.me/{{ $workshop->user->phone }}?text={{ urlencode(
        'السلام عليكم، شفت ورشتكم ' . $workshop->workshop_name . ' في تطبيق Carlly Motors، وعندي شغل ' .
        ($workshop->workshop_categories ?? 'صيانة') . ' بسيارتي. متى أقدر آييبها؟' . "\n\n" .
        'Hello, I saw your ' . $workshop->workshop_name . ' workshop on the Carlly app. I need some ' .
        ($workshop->workshop_categories ?? 'maintenance') . ' work done on my car. When can I bring it in?' . "\n\n" .
        $shareUrl
    ) }}" 
       target="_blank" 
       class="btn btn-success rounded-4 px-4 py-2 d-flex align-items-center justify-content-center"
       style="min-width: 60px;"
       onclick="event.stopPropagation();">
        <i class="fab fa-whatsapp fs-5"></i>
    </a>

    <!-- ✅ Call -->
    @if($isMobile)
        <a href="tel:{{ $workshop->user?->phone }}" 
           class="btn btn-danger rounded-4 px-4 py-2 d-flex align-items-center justify-content-center"
           style="min-width: 60px;">
            <i class="fas fa-phone fs-5"></i>
        </a>
    @else
        <a href="https://wa.me/{{ $workshop->user?->phone }}" 
           target="_blank" 
           class="btn btn-danger rounded-4 px-4 py-2 d-flex align-items-center justify-content-center"
           style="min-width: 60px;">
            <i class="fas fa-phone fs-5"></i>
        </a>
    @endif

    <!-- ✅ Share -->
 <a
href="https://wa.me/?text={{ urlencode(
    'اطّلع على هذه الورشة على موقع Carlly! خدمات مميّزة بانتظارك ' . "\n\n" .
    'Check out my latest find on Carlly! This workshop: ' . $shareUrl
) }}"    target="_blank" 
   class="btn btn-info rounded-4 px-4 py-2 d-flex align-items-center justify-content-center"
   style="min-width: 60px;"
   onclick="event.stopPropagation();">
    <i class="fa fa-share fs-5"></i>
</a>


    <!-- ✅ Map -->
    @if($mapUrl)
        <a href="{{ $mapUrl }}" 
           target="_blank" 
           class="btn btn-secondary rounded-4 px-4 py-2 d-flex align-items-center justify-content-center"
           style="min-width: 60px;"
           onclick="event.stopPropagation();">
            <i class="fas fa-map-marker-alt fs-5"></i>
        </a>
    @endif

</div>

 <!-- 🔹 Related Workshops -->
@if($relatedWorkshops->count() > 0)
    <div class="mt-5">
        <h5 class="fw-bold mb-3 text-center" style="color:#760e13">Related Workshops</h5>

        <div class="row g-4">
            @foreach($relatedWorkshops as $r)
                @php
                    $rImage = \App\Models\Image::where('workshop_provider_id', $r->id)->pluck('image')->first();
                    $imageUrl = $rImage ? env('CLOUDFLARE_R2_URL') . $rImage : asset('workshopNotFound.png');
                @endphp

                <div class="col-sm-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                        <a href="{{ route('workshops.show', $r->id) }}" 
                           class="text-decoration-none text-dark d-block h-100">

                            <!-- 🖼 Full-width, full-top image -->
                            <div class="ratio ratio-16x9">
                                <img src="{{ $imageUrl }}" 
                                     alt="Related Workshop"
                                     class="w-100 h-100 object-fit-cover">
                            </div>

                            <div class="card-body text-center py-3">
                                <h6 class="fw-bold mb-1">{{ $r->workshop_name }}</h6>
                                <p class="text-muted small mb-0">{{ $r->branch ?? '—' }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

</div>
@endsection
