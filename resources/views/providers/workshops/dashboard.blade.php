@extends('layouts.CarProvider')

@section('content')
<div style="width: 100%; margin: 0; padding: 0;">
    <img src="{{ asset('31.jpg') }}"
         style="display: block; width: 100%; height: auto; max-height: 400px; object-fit: cover;">
</div>



   <div class="container text-center mt-4">
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
            : asset('carllymotorsmainlogo.png')
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
                             onerror="this.src='{{ asset('carllymotorsmainlogo.png') }}'"
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



<!-- Location Modal -->
<!-- Added z-index to ensure it is above obscure overlays -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" style="z-index: 10055;"> 
    <div class="modal-dialog modal-dialog-centered modal-lg" style="z-index: 10056;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="locationModalLabel">Select Your Workshop Location</h5>
                <!-- Close button only if location is already set (optional, logic handled in JS) -->
                @if($workshop->latitude && $workshop->longitude)
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                @endif
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Please drag the marker to your precise workshop location.</p>
                <div id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>
                <input type="hidden" id="latitude" name="latitude" value="{{ $workshop->latitude }}">
                <input type="hidden" id="longitude" name="longitude" value="{{ $workshop->longitude }}">
                <input type="hidden" id="address_details" name="address_details">
                <input type="hidden" id="city_name" name="city_name">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveLocation()">Save Location</button>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    let map;
    let marker;

    document.addEventListener('DOMContentLoaded', function() {
        // Check if location is missing
        const hasLocation = {{ $workshop->latitude && $workshop->longitude ? 'true' : 'false' }};
        
        if (!hasLocation) {
            var locationModal = new bootstrap.Modal(document.getElementById('locationModal'));
            locationModal.show();
        }

        // Initialize map when modal is shown
        const modalEl = document.getElementById('locationModal');
        modalEl.addEventListener('shown.bs.modal', function () {
            initMap();
        });
    });

    function initMap() {
        if (map) {
            map.invalidateSize();
            return;
        }

        // Default to Dubai if no location
        const defaultLat = 25.2048;
        const defaultLng = 55.2708;
        
        const currentLat = parseFloat(document.getElementById('latitude').value) || defaultLat;
        const currentLng = parseFloat(document.getElementById('longitude').value) || defaultLng;

        map = L.map('map').setView([currentLat, currentLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        marker = L.marker([currentLat, currentLng], {
            draggable: true
        }).addTo(map);

        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            updateInputs(position.lat, position.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat, e.latlng.lng);
        });
    }

    let debounceTimer;

    function updateInputs(lat, lng) {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        
        // Debounce the reverse geocoding request
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            getAddress(lat, lng);
        }, 1000); // Wait 1 second after drag ends
    }

    function getAddress(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.display_name) {
                    document.getElementById('address_details').value = data.display_name;
                    
                    // Extract city/town/village
                    let city = data.address.city || data.address.town || data.address.village || data.address.county || data.address.state || '';
                    document.getElementById('city_name').value = city;
                    
                    console.log("Address found: " + data.display_name);
                    console.log("City found: " + city);
                }
            })
            .catch(error => console.error('Error getting address:', error));
    }

    function saveLocation() {
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;
        const details = document.getElementById('address_details').value;
        const city = document.getElementById('city_name').value;

        if (!lat || !lng) {
            alert('Please select a location on the map.');
            return;
        }

        fetch('{{ route("workshops.updateLocation") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                lat: lat,
                lng: lng,
                details: details,
                city: city
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modalEl = document.getElementById('locationModal');
                const modalInstance = bootstrap.Modal.getInstance(modalEl);
                modalInstance.hide();
                
                // alert('Location updated successfully!'); // Removed alert as requested
                location.reload();
            } else {
                alert('Error saving location: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving location.');
        });
    }

    // Function to open modal manually
    function openLocationModal() {
        var locationModal = new bootstrap.Modal(document.getElementById('locationModal'));
        locationModal.show();
    }
</script>

</div>
            
            </div>
  
  </div>
@endsection