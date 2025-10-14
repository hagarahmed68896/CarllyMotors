<style>
.car-card {
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: #fff;
    margin-bottom: 25px;
}

.car-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.car-image {
    position: relative;
    width: 100%;
    height: 220px;
    overflow: hidden;
    background: #f8f8f8;
}

.car-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.car-image:hover img {
    transform: scale(1.05);
}

/* Top-right icon area */
.car-image .icon-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    display: flex;
    gap: 6px;
    z-index: 10;
}

.icon-actions button,
.icon-actions a {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    transition: background 0.3s;
}

.icon-actions i {
    font-size: 16px;
}

.icon-actions button:hover,
.icon-actions a:hover {
    background: #fff;
}

/* Year badge */
.car-year-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #760e13;
    color: #fff;
    font-weight: bold;
    padding: 4px 10px;
    border-radius: 10px;
    font-size: 14px;
}

/* Content */
.car-card-body {
    background: #f9f9f9;
    border-radius: 0 0 12px 12px;
    padding: 15px;
}

.price-location {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: bold;
    margin-bottom: 8px;
}

.price {
    color: #760e13;
    font-size: 18px;
}

.location {
    color: #444;
    font-size: 14px;
}

.location i {
    color: #760e13;
    margin-right: 4px;
}

.showroom-name {
    font-weight: bold;
    font-size: 16px;
    color: #222;
    margin-bottom: 10px;
    text-align: left;
}

.car-details {
    font-size: 14px;
    color: #555;
    text-align: left;
    margin-bottom: 12px;
}

.car-details p {
    margin: 3px 0;
}

/* Buttons */
.actions {
    display: flex;
    justify-content: space-between;
    gap: 8px;
}

.actions .btn {
    flex: 1;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    background: transparent;
    border-width: 2px;
    transition: 0.3s;
}

.actions .btn-outline-success {
    border-color: #198754;
    color: #198754;
}

.actions .btn-outline-success:hover {
    background: #198754;
    color: #fff;
}

.actions .btn-outline-danger {
    border-color: #760e13;
    color: #760e13;
}

.actions .btn-outline-danger:hover {
    background: #760e13;
    color: #fff;
}

</style>

{{-- <div class="tab-content" id="bodyTypeTabsContent">
    <div class="main-car-list-sec">
        <div class="row"> --}}
              @foreach ($carlisting as $key => $car)
<div class="col-sm-6 col-md-4 col-lg-4">
        <div class="car-card shadow-sm border-0 h-100" style="border-radius: 12px; overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease;">
            
       <!-- Image Section -->
<div class="position-relative" style="width: 100%; height: 200px; background-color: #f9f9f9; overflow: hidden; border-radius: 10px;">
    <a href="{{ route('car.detail', $car->id) }}" class="d-block h-100 w-100">
        @php
            $imageSrc = isset($car->images[0]->image)
                ? env("CLOUDFLARE_R2_URL") . $car->images[0]->image
                : asset('carNotFound.jpg');
        @endphp

        <img src="{{ $imageSrc }}"
             alt="{{ $car->listing_model }}"
             class="img-fluid"
             style="height: 100%; width: 100%; object-fit: cover; object-position: center; transition: transform 0.3s ease;"
             loading="lazy"
             onerror="this.src='{{ asset('carNotFound.jpg') }}'">
    </a>

    <!-- Year Badge -->
    <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-3 py-1" style="border-radius: 10px;">
        {{ $car->listing_year }}
    </span>

    <!-- Favorite & Share Buttons -->
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
            <div class="p-3 d-flex flex-column justify-content-between" style="min-height: 230px;">
                <div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold ">
                            <img src="{{ asset('assets/images/UAE_Dirham_Symbol.svg.png') }}" 
                                 alt="Price" width="14" height="14" class="me-1">
                            {{ number_format($car->listing_price) }}
                        </span>

                        @if($car->user?->lat && $car->user?->lng)
                            <a href="https://www.google.com/maps?q={{ $car->user->lat }},{{ $car->user->lng }}" 
                               target="_blank" class="text-muted small text-decoration-none">
                                <i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $car->city }}
                            </a>
                        @endif
                    </div>

                  <h5 class="text-dark fw-semibold mb-2 text-truncate text-start" 
    title="{{ $car->user?->fname }} {{ $car->user?->lname }}">
    {{ $car->user?->fname }} {{ $car->user?->lname }}
</h5>

<ul class="list-unstyled mb-3 small text-muted text-start">
    <li><strong>Make:</strong> {{ $car->listing_type }}</li>
    <li><strong>Model:</strong> {{ $car->listing_model }}</li>
    <li><strong>Year:</strong> {{ $car->listing_year }}</li>
    <li><strong>Mileage:</strong> {{ $car->mileage ?? '215K' }} km</li>
</ul>

                </div>

                <!-- Action Buttons -->
              <div class="d-flex justify-content-between">
    <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank" 
       class="btn btn-outline-success flex-fill me-2" 
       style="border-radius: 10px;">
        <i class="fab fa-whatsapp"></i>
    </a>

    <a href="tel:{{ $car->user?->phone }}" 
       class="btn btn-outline-danger flex-fill me-2" 
       style="border-radius: 10px;">
        <i class="fa fa-phone"></i>
    </a>

    {{-- <a href="https://wa.me/?text={{ urlencode('Check out this car: ' . route('car.detail', $car->id)) }}" 
       target="_blank" 
       class="btn btn-outline-primary flex-fill" 
       style="border-radius: 10px;">
        <i class="fa fa-share"></i>
    </a> --}}
</div>

            </div>
        </div>
    </div>
@endforeach
        {{-- </div>
    </div>
</div> --}}
