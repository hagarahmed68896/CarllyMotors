@forelse ($carlisting as $key => $car)
    @php
        // تأكد أن $favCars يتم تمريرها إلى هذا الجزء الجزئي أو قم بجلبها هنا إذا كانت غير متوفرة
        // إذا كنت تجلبها في الكنترولر وتمررها للصفحة الرئيسية، تأكد من تمريرها إلى الـLoad More أيضاً
        $favCars = auth()->check() ? auth()->user()->favCars()->pluck('id')->toArray() : [];
        $images = $car->images->map(fn($img) => env('FILE_BASE_URL') . $img->image)->toArray();
    @endphp

    <div class="col-12 p-0 col-md-10 col-lg-9 mb-4">
        <div id="car-{{ $car->id }}" class="car-card shadow-sm rounded-4 overflow-hidden hover-card d-flex flex-column flex-lg-row">

            {{-- 🖼️ الصورة clickable --}}
            <div class="car-carousel-container position-relative flex-shrink-0">
                <a href="{{ route('car.detail', $car->id) }}" class="d-block w-100 h-100">
                    <div class="swiper carSwiper-{{ $car->id }} rounded-3">
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

                        {{-- Navigation arrows --}}
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>

                        {{-- Pagination --}}
                        <div class="swiper-pagination"></div>
                    </div>
                </a>

                {{-- Zoom Button --}}
                @if($images && count($images) > 0)
                    <button type="button"
                            class="btn btn-light position-absolute top-0 start-0 m-2"
                            style="width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; z-index: 10;"
                            data-bs-toggle="modal"
                            data-bs-target="#zoomModal-{{ $car->id }}">
                        <i class="fas fa-search-plus" style="color:#760e13;"></i>
                    </button>
                @endif

                {{-- Favorite & Share --}}
                <div class="position-absolute top-0 end-0 m-2 d-flex gap-2" style="z-index: 10;">
                    @if(auth()->check())
                        
                        {{-- 🏆 فورم الـFAV الصحيح (AJAX) --}}
                        <form action="{{ route('cars.addTofav', $car->id) }}" method="POST" class="d-inline ajax-fav-form">
                            @csrf
                            
                            {{-- يجب أن يكون type="button" ويحتوي على الكلاس fav-button --}}
                            <button type="button" 
                                    class="btn btn-light btn-sm shadow-sm border-0 d-flex align-items-center justify-content-center fav-button" 
                                    style="width:32px; height:32px; border-radius:50%;"
                                    data-car-id="{{ $car->id }}">

                                @php $isFav = in_array($car->id, $favCars ?? []); @endphp 
                                <i class="fas fa-heart" 
                                   style="color: {{ $isFav ? '#dc3545' : '#6c757d' }}"></i>
                            </button>
                        </form>
                        
                    @else
                        {{-- (رابط تسجيل الدخول للزوار) --}}
                        <a href="{{ route('login') }}" class="btn btn-light btn-sm shadow-sm border-0 d-flex align-items-center justify-content-center" style="width:32px; height:32px; border-radius:50%;">
                            <i class="fas fa-heart" style="color:#6c757d;"></i>
                        </a>
                    @endif

                    <a href="https://wa.me/?text={{ urlencode('Check out this car: ' . route('car.detail', $car->id)) }}"
                        target="_blank"
                        class="btn btn-light btn-sm shadow-sm border-0 d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px; border-radius: 50%;">
                        <i class="fas fa-share-alt" style="color: #25d366;"></i>
                    </a>
                </div>
            </div>

            {{-- تفاصيل السيارة --}}
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

                {{-- الموقع --}}
                <p class="small text-muted mb-0 mt-2">
                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                    @if($car->lat && $car->lng)
                        <a href="https://www.google.com/maps?q={{ $car->lat }},{{ $car->lng }}" target="_blank" style="color:#760e13; text-decoration:none;">
                            {{ $car->city ?? 'Dubai' }}, UAE
                        </a>
                    @else
                        {{ $car->city ?? 'Dubai' }}, UAE
                    @endif
                </p>

                {{-- Action Buttons --}}
                <div class="action d-flex gap-2 mt-2">
                    <a href="https://wa.me/{{ $car->user?->phone }}?text={{ urlencode('Interested in this car: ' . $car->listing_type . ' ' . $car->listing_model) }}"
                        target="_blank"
                        class="flex-fill text-decoration-none">
                        <button class="btn btn-outline-success w-100 rounded-4">
                            <i class="fab fa-whatsapp me-1"></i>
                        </button>
                    </a>
                </div>
            </div>
        </div>

        {{-- Zoom Modal --}}
        @if($images && count($images) > 0)
            <div class="modal fade" id="zoomModal-{{ $car->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content border-0 position-relative">
                        <button type="button" class="btn-close btn-close-black position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body p-0">
                            <div class="swiper zoomSwiper-{{ $car->id }}">
                                <div class="swiper-wrapper">
                                    @foreach($images as $image)
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

    </div>
@empty
    <p class="text-center text-muted w-100">No more cars to load.</p>
@endforelse