@extends('layouts.app')
@php
use Illuminate\Support\Str;
@endphp

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mycars-header">
    
    <h2 class="fw-bold page-title mb-0">My Cars</h2>

    <a href="{{ route('cars.create') }}" 
       class="btn btn-add-car d-flex align-items-center gap-2">
        <i class="fas fa-plus"></i>
        Add New Car
    </a>

</div>

<style>
    .mycars-header {
    margin-left: 80px;
    margin-right: 80px;
    margin-top: 20px;
}
@media (max-width: 576px) {
    .mycars-header {
        margin-left: 15px;
        margin-right: 15px;
    }
}

/* ===== TITLE STYLE ===== */
.page-title {
    color: #760e13;
    position: relative;
}

.page-title::after {
    content: "";
    display: block;
    width: 45px;
    height: 4px;
    background-color: #760e13;
    margin-top: 6px;
    border-radius: 2px;
}

/* ===== BUTTON ===== */
.btn-add-car {
    background: #760e13;
    color: white !important;
    padding: 10px 22px;
    font-weight: 600;
    border-radius: 10px;
    border: none;
    transition: 0.25s ease;
}

.btn-add-car:hover {
    background: #8a0f17;
    transform: translateY(-2px);
}

/* ===== RESPONSIVE FIXES ===== */
@media (max-width: 576px) {
    .mycars-header {
        flex-direction: column;
        text-align: center;
    }

    .page-title::after {
        margin-left: auto;
        margin-right: auto; /* الخط تحت العنوان في النص */
    }

    .btn-add-car {
        width: 100%;
        justify-content: center;
    }
}
</style>



<div class="custom-container main-car-list-sec" style="margin-top:30px;">
    <div class="row g-4">
        @forelse ($carlisting as $key => $car)
            @php
                $images = $car->images ? $car->images->map(fn($img) => env('CLOUDFLARE_R2_URL') . $img->image)->toArray() : [];
                $phone = preg_replace('/\D/', '', $car->contact_number);
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
    
    {{-- 1. إضافة الكلاس ajax-fav-form --}}
    <form action="{{ route('cars.addTofav', $car->id) }}" method="POST" class="m-0 d-inline ajax-fav-form">
        @csrf
        
        {{-- 2. تغيير type="submit" إلى type="button" وإضافة الكلاس fav-button و data-car-id --}}
        <button type="button" 
                class="btn btn-light btn-sm shadow-sm border-0 d-flex align-items-center justify-content-center fav-button" 
                style="width:32px;height:32px;border-radius:50%;"
                data-car-id="{{ $car->id }}">

            <i class="fas fa-heart" style="color: {{ in_array($car->id, $favCars) ? '#dc3545' : '#6c757d' }}"></i>
        </button>
    </form>
@else
    {{-- هذا الجزء يظل كما هو ليوجه المستخدمين غير المسجلين للدخول --}}
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


                   <div class="car-details mt-3 text-start">
    <div class="row g-2">
        <div class="col-6">
            <p class="mb-1"><strong>Make:</strong> {{ $car->listing_type }}</p>
            <p class="mb-1"><strong>Model:</strong> {{ $car->listing_model }}</p>
        </div>

        <div class="col-6">
            <p class="mb-1"><strong>Year:</strong> {{ $car->listing_year }}</p>
            <p class="mb-1"><strong>Mileage:</strong> {{ $car->features_speed }} km</p>
        </div>
    </div>
</div>


                     <!-- Actions -->
<div class="d-flex align-items-center gap-2 mt-2 flex-nowrap" style="flex-wrap: nowrap !important;">
    <!-- Edit -->
    <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-outline-primary rounded-4 flex-fill text-nowrap">
        <i class="fas fa-edit me-1"></i> Edit
    </a>

    <!-- Delete Button (Triggers Modal) -->
    <button type="button" class="btn btn-outline-danger rounded-4 flex-fill text-nowrap"
        data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-{{ $car->id }}">
        <i class="fas fa-trash-alt me-1"></i> Delete
    </button>
</div>

<!-- Delete Confirmation Modal (Unique per car) -->
<div class="modal fade" id="confirmDeleteModal-{{ $car->id }}" tabindex="-1" aria-labelledby="confirmDeleteLabel-{{ $car->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow">
      <div class="modal-header border-0">
        <h5 class="modal-title text-danger" id="confirmDeleteLabel-{{ $car->id }}">
          <i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p class="mb-0">Are you sure you want to delete this listing? This action cannot be undone.</p>
      </div>

      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Cancel</button>
        <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="m-0">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger rounded-4">
            <i class="fas fa-trash-alt me-1"></i> Delete
          </button>
        </form>
      </div>
    </div>
  </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // تأكد من وجود الـCSRF Token في الـhead: <meta name="csrf-token" content="{{ csrf_token() }}">
    
    document.addEventListener('DOMContentLoaded', function() {
        // نستخدم Event Delegation للتعامل مع أي زر إعجاب يتم النقر عليه في الصفحة
        document.addEventListener('click', function(e) {
            
            const favButton = e.target.closest('.fav-button');
            if (!favButton) return; 

            e.preventDefault(); 
            
            const form = favButton.closest('.ajax-fav-form');
            if (!form) return;

            const carId = favButton.getAttribute('data-car-id');
            const heartIcon = favButton.querySelector('.fas.fa-heart');
            
            // تعطيل الزر
            favButton.disabled = true;

            // 🚀 إرسال طلب AJAX
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ car_id: carId })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); 
            })
            .then(data => {
                
                if (data.success === true) {
                    const isFavorite = data.is_favorite; 
                    
                    // تحديد الألوان المستخدمة في الـBlade:
                    // #dc3545 أو #760e13 للمفضل، #6c757d أو white لغير المفضل
                    // *يفضل أن تضع الألوان التي تستخدمها فعلياً هنا لضمان التناسق في كل الصفحات*
                    const favoriteColor = '#dc3545'; 
                    const defaultColor = '#6c757d'; 
                    
                    // 1. تحديث لون الأيقونة
                    heartIcon.style.color = isFavorite ? favoriteColor : defaultColor;
                    
                    // -----------------------------------------------------------------
                    // 2. المنطق الحصري لصفحة المفضلة: إزالة العنصر من الواجهة (DOM)
                    
                    // ** هام: قم بتعديل هذا المسار ليتطابق مع مسار صفحة المفضلة لديك **
                    const isFavoritesPage = window.location.pathname.includes('/favorites'); 
                    
                    // إذا كان تم إلغاء الإعجاب (!isFavorite) وكنا في صفحة المفضلة
                    if (isFavoritesPage && !isFavorite) {
                        // نبحث عن أقرب عنصر أب يحمل كلاس العمود (col-...) ليتم إزالته بالكامل
                        const carCardWrapper = favButton.closest('.col-sm-6.col-lg-4.col-xl-3'); 
                        
                        if (carCardWrapper) {
                            carCardWrapper.remove(); // إزالة العنصر فوراً
                        }
                    }
                    // -----------------------------------------------------------------
                    
                } else {
                    alert('فشل في عملية الإعجاب. الرجاء المحاولة مرة أخرى.');
                }
            })
            .catch(error => {
                console.error('Favorite Toggle Error:', error);
                alert('حدث خطأ فني أثناء الإرسال.');
            })
            .finally(() => {
                favButton.disabled = false;
            });
        });
    });
</script>
@endsection
