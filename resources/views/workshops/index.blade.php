@extends('layouts.app')

@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
@endphp

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    body {
        background-color: #f8f9fa;
        font-family: "Poppins", sans-serif;
    }

    /* Sidebar */
    .filter-sidebar {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 25px;
        position: sticky;
        top: 90px;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .filter-sidebar h5 {
        font-weight: 700;
        color: #760e13;
        border-bottom: 2px solid #f1f1f1;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .btn-apply {
        background-color: #760e13;
        color: white;
        border: none;
        transition: 0.3s;
    }

    .btn-apply:hover {
        background-color: #5a0b0f;
        color: white;
    }

    /* Workshop Cards */
    .workshop-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .workshop-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .workshop-card img {
        height: 200px;
        object-fit: cover;
    }

    .workshop-card h5 {
        color: #760e13;
        font-weight: 600;
    }

    .workshop-card .text-muted i {
        color: #760e13;
        margin-right: 5px;
    }

    /* Action Buttons */
    .actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 15px;
    }

    .actions .btn {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-outline-danger {
        border-color: #760e13;
        color: #760e13;
    }

    .btn-outline-danger:hover {
        background-color: #760e13;
        color: white;
    }

    .btn-outline-primary {
        border-color: #5a0b0f;
        color: #5a0b0f;
    }

    .btn-outline-primary:hover {
        background-color: #5a0b0f;
        color: #fff;
    }
</style>

@section('content')
<div class="container my-4">
    <div class="row g-4">
         
<!-- Sidebar Filter -->
<aside class="col-lg-3 col-md-4">
  <div class="filter-sidebar p-3 rounded-3 shadow-sm bg-white">
    <h5 class="fw-bold mb-3 text-center" style="color:#760e13">
      <i class="fas fa-sliders-h me-2"></i> Filter Workshops
    </h5>

    <form id="filterForm" method="GET"
          action="{{ request()->routeIs('global.search') ? route('global.search') : route('workshops.index') }}">

   <!-- City -->
<div class="mb-3">
    <label class="form-label fw-semibold small text-muted">City</label>

    @php
        $uaeCities = [
            'Abu Dhabi',
            'Ajman',
            'Al Ain',
            'Dubai',
            'Fujairah',
            'Ras Al Khaimah',
            'Sharjah',
            'Umm Al Quwain',
        ];

        sort($uaeCities); // ترتيب أبجدي
    @endphp

    <select class="form-select" id="city" name="city" required>
        <option value="" {{ empty(request('city')) ? 'selected' : '' }}>
            Select City
        </option>

        @foreach($uaeCities as $city)
            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                {{ $city }}
            </option>
        @endforeach
    </select>
</div>


      <!-- Car Brand -->
      <div class="mb-3">
        <label class="form-label fw-semibold small text-muted">Car Brand</label>
        <select class="form-select" id="brand" name="brand_id" required>
          <option value="">Select Car Brand</option>
          @foreach($brands as $id => $brand)
            <option value="{{ $id }}" {{ request('brand_id') == $id ? 'selected' : '' }}>
              {{ $brand }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Services (Categories) -->
      <div class="mb-4">
        <label class="form-label fw-semibold small text-muted d-block mb-2">Services</label>
        <div class="row g-2">
          @foreach($categories as $category)
            @php
              $img = $category->image
                  ? config('app.file_base_url') . Str::after($category->image, url('/') . '/')
                  : 'https://via.placeholder.com/60';
            @endphp

           <div class="col-4 mb-3">
    <label class="service-option w-100" style="cursor:pointer;">
        <input type="radio" name="category_id" value="{{ $category->id }}" class="d-none"
               {{ request('category_id') == $category->id ? 'checked' : '' }}>
        <div class="border p-2 rounded-3 text-center service-card 
                    {{ request('category_id') == $category->id ? 'selected-service' : '' }}">
            
            <!-- Fixed square icon container -->
            <div style="width: 60px; height: 60px; margin: 0 auto; overflow:hidden; border-radius:8px;">
                <img src="{{ $img }}" 
                     alt="{{ $category->name }}" 
                     style="width: 100%; height: 100%; object-fit: cover;">
            </div>

            <div class="fw-semibold mt-2" style="font-size: 0.9rem; white-space: normal; word-break: break-word;">
                {{ $category->name }}
            </div>
        </div>
    </label>
</div>

          @endforeach
        </div>
      </div>

      <style>
.service-option .service-card {
    width: 100%;
    height: 140px; /* ارتفاع ثابت للكارت */
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    transition: all 0.2s ease-in-out;
}

.service-option .service-card img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

/* اسم الخدمة */
.service-option .service-card .fw-semibold {
    font-size: 0.9rem;
    margin-top: 8px;
    text-align: center;
    white-space: normal;
    word-break: break-word;
}

/* شكل الكارت لما يكون محدد */
.selected-service {
    border: 2px solid #007bff !important;
    background-color: #f0f8ff;
}
      </style>

      <!-- Buttons -->
      <div class="d-flex gap-2 border-top pt-3">
        <button type="submit"
                id="applyBtn"
                class="btn flex-fill rounded-3 text-white"
                style="background-color: #760e13; border-color: #760e13;"
                disabled>
          Apply Filters
        </button>
        <button type="button" onclick="resetFilters()" class="btn btn-light flex-fill border">
          Reset
        </button>
      </div>
    </form>
  </div>
</aside>

<!-- ✅ Styles -->
<style>
  .service-card {
    border: 2px solid #ddd;
    transition: all 0.2s ease-in-out;
  }

  .service-card:hover {
    border-color: #760e13;
    background-color: #fdf4f4;
  }

  .selected-service {
    border: 2px solid #760e13 !important;
    background-color: #f9f3f3 !important;
  }

  #applyBtn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }
</style>

<!-- ✅ Script -->
<script>
  function updateApplyButtonState() {
    const city = document.getElementById('city').value.trim();
    const brand = document.getElementById('brand').value.trim();
    const categoryChecked = document.querySelector('input[name="category_id"]:checked');
    const applyBtn = document.getElementById('applyBtn');

    // Enable only if all three filters filled
    if (city && brand && categoryChecked) {
      applyBtn.removeAttribute('disabled');
    } else {
      applyBtn.setAttribute('disabled', true);
    }
  }

  // monitor all changes
  document.getElementById('city').addEventListener('change', updateApplyButtonState);
  document.getElementById('brand').addEventListener('change', updateApplyButtonState);
  document.querySelectorAll('input[name="category_id"]').forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.service-card').forEach(card => card.classList.remove('selected-service'));
      radio.closest('.service-option').querySelector('.service-card').classList.add('selected-service');
      updateApplyButtonState();
    });
  });

  // ✅ reset filters
  function resetFilters() {
    document.getElementById('city').value = '';
    document.getElementById('brand').value = '';
    document.querySelectorAll('input[name="category_id"]').forEach(radio => radio.checked = false);
    document.querySelectorAll('.service-card').forEach(card => card.classList.remove('selected-service'));
    updateApplyButtonState();
  }

  // initial state on page load
  updateApplyButtonState();
</script>




   <!-- Workshops List -->
<div class="col-lg-9 col-md-8">

@php
    $hasFilters = (request()->filled('city') && request()->filled('brand_id') && request()->filled('category_id'))
                  || request()->filled('workshop_id');
@endphp


  @if(!$hasFilters)
    <!-- 💤 Waiting for Filters Section -->
    <section class="d-flex justify-content-center align-items-center" style="min-height: 300px;">
      <div class="text-center">
        <h5 class="fw-bold mb-2" style="color:#760e13;">Find Your Perfect Workshop</h5>
        <p class="text-muted mb-3">
          Please fill in all filter fields and click <strong>Apply Filters</strong> to begin your search.
        </p>
        <button class="btn btn-outline-danger" disabled>
          <i class="fas fa-sliders-h me-2"></i> Waiting for Filters...
        </button>
      </div>
    </section>
  @else
  <!-- ✅ Workshops Display Section -->
<div class="row g-4">
    @forelse ($workshops as $workshop)
        @php
// الرابط اللي عايزة تشتغل على المتصفح فقط
$shareUrl = route('workshops.show.web', $workshop->id);

          $firstImage = $workshop->images->first();

$image = $firstImage
    ? env('CLOUDFLARE_R2_URL') . $firstImage->image
    : (
        $workshop->workshop_logo
            ? (Str::startsWith($workshop->workshop_logo, ['http://', 'https://'])
                ? $workshop->workshop_logo
                : env('CLOUDFLARE_R2_URL') . $workshop->workshop_logo)
            : asset('carllymotorsmainlogo.png')
    );


            $mapUrl = $workshop->latitude && $workshop->longitude
                ? "https://www.google.com/maps?q={$workshop->latitude},{$workshop->longitude}"
                : null;
        @endphp

      <div class="col-sm-6 col-lg-4">
    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden workshop-card hover-effect position-relative">

        <a href="{{ route('workshops.show', $workshop->id) }}" 
           class="text-decoration-none text-dark d-block">
            <img src="{{ $image }}" 
                 onerror="this.onerror=null; this.src='{{ asset('carllymotorsmainlogo.png') }}';" 
                 class="card-img-top" 
                 alt="Workshop Image" 
                 style="height:200px; object-fit:cover;">
        </a>

      <!-- 🔍 زر الزووم -->
<button type="button" 
        class="btn btn-light position-absolute top-0 end-0 m-2 shadow"
        style="width: 30px; height: 30px; border-radius: 50%; color:#760e13;
         display:flex; align-items:center; justify-content:center;"
        data-bs-toggle="modal" 
        data-bs-target="#workshopImagesModal{{ $workshop->id }}"
        onclick="event.stopPropagation();">
    <i class="fas fa-search-plus"></i>
</button>


        <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title fw-bold text-truncate" title="{{ $workshop->workshop_name }}">
                {{ $workshop->workshop_name }}
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

            <!-- ✅ الأزرار -->
            <div class="d-flex justify-content-between mt-3">
                <a href="https://wa.me/{{ $workshop->user->phone }}?text={{ urlencode(
                    'السلام عليكم، شفت ورشتكم ' . $workshop->workshop_name . ' في تطبيق Carlly Motors، وعندي شغل ' .
                    ($workshop->workshop_categories ?? 'صيانة') . ' بسيارتي. متى أقدر آييبها؟' . "\n\n" .
                    'Hello, I saw your ' . $workshop->workshop_name . ' workshop on the Carlly app. I need some ' .
                    ($workshop->workshop_categories ?? 'maintenance') . ' work done on my car. When can I bring it in?' . "\n\n" .
                    $shareUrl
                ) }}" 
                   target="_blank" 
                   class="btn btn-outline-success flex-fill rounded-4 mx-1"
                   onclick="event.stopPropagation();">
                    <i class="fab fa-whatsapp"></i>
                </a>

                            @php
                                $isMobile = Str::contains(request()->header('User-Agent'), ['Android', 'iPhone', 'iPad']);
                            @endphp

                            @if($isMobile)
                                <a href="tel:{{ $workshop->user?->phone }}" 
                                   class="btn btn-outline-danger flex-fill mx-1 rounded-4">
                                    <i class="fas fa-phone"></i>
                                </a>
                            @else
                                <a href="https://wa.me/{{ $workshop->user?->phone }}" 
                                   target="_blank" 
                                   class="btn btn-outline-danger flex-fill mx-1 rounded-4">
                                    <i class="fas fa-phone"></i>
                                </a>
                            @endif
            <a
href="https://wa.me/?text={{ urlencode(
    'اطّلع على هذه الورشة على موقع Carlly! خدمات مميّزة بانتظارك ' . "\n\n" .
    'Check out my latest find on Carlly! This workshop: ' . $shareUrl
) }}"    target="_blank" 
   class="btn btn-outline-info flex-fill rounded-4 mx-1"
   onclick="event.stopPropagation();">
    <i class="fa fa-share"></i>
</a>

            </div>
        </div>
    </div>
</div>

<!-- ✅ Fully Responsive Image Modal -->
@php
    $images = \App\Models\Image::where('workshop_provider_id', $workshop->id)->pluck('image');
@endphp

@if($images && count($images) > 0)
<div class="modal fade" id="workshopImagesModal{{ $workshop->id }}" tabindex="-1" aria-labelledby="workshopImagesModalLabel{{ $workshop->id }}" aria-hidden="true" style="z-index:1055;">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 position-relative">

            <div class="modal-header">
                <h5 class="modal-title" id="workshopImagesModalLabel{{ $workshop->id }}">
                    {{ $workshop->workshop_name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color:#5a0b0f;"></button>
            </div>

            <div class="modal-body p-0 d-flex justify-content-center align-items-center" 
                 style="max-height: 80vh; overflow: hidden;">
                <div class="swiper workshopSwiper-{{ $workshop->id }}" style="width:100%; height:100%;">

                    <div class="swiper-wrapper">
                        @foreach($images as $img)
                        <div class="swiper-slide d-flex justify-content-center align-items-center">
                            <img src="{{ env('CLOUDFLARE_R2_URL') . $img }}" class="img-fluid rounded-4" 
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script>
    var workshopModal{{ $workshop->id }} = document.getElementById('workshopImagesModal{{ $workshop->id }}');
    workshopModal{{ $workshop->id }}.addEventListener('shown.bs.modal', function () {
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
@endif






    @empty
        <p class="text-center text-muted mt-4">No workshops found.</p>
    @endforelse
</div>

<!-- ✅ Optional CSS -->
<style>
  .workshop-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .workshop-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
  }
</style>


    {{-- Pagination --}}
    @includeWhen($workshops instanceof \Illuminate\Pagination\LengthAwarePaginator, 'partials.pagination', ['workshops' => $workshops])
  @endif
</div>



    </div>
</div>

<script>
function resetFilters() {
  const url = new URL(window.location.href);
  url.search = ''; // يحذف كل الاستعلامات
  window.location.href = url.toString();
}
</script>

@endsection
