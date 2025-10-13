<style>
/* Price Input Fields */
.price-range {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 16px;
    font-weight: bold;
    margin-top: 10%;

}

input[type="number"] {}

/* Range Slider Wrapper */
.range-slider {
    position: relative;
    width: 100%;
    margin: 20px 0;
    height: 6px;
    background: #e3c5b5;
    /* Light brown background */
    border-radius: 5px;
}

/* Range Inputs */
.range-slider input[type="range"] {
    position: absolute;
    width: 100%;
    appearance: none;
    background: transparent;
    pointer-events: none;
    /* Makes the background clickable */
}

/* Styling the Track */
.range-slider input[type="range"]::-webkit-slider-runnable-track {
    height: 6px;
    background: transparent;
    border-radius: 5px;
}

/* Styling the Thumbs */
.range-slider input[type="range"]::-webkit-slider-thumb {
    appearance: none;
    width: 20px;
    height: 20px;
    background: #7b4b40;
    border-radius: 50%;
    cursor: pointer;
    pointer-events: auto;
    /* Allows interaction */
    margin-top: -7px;
    /* Adjust thumb position */
}

/* Filter Button */
.filter-btn {
    width: 100% !important;
    padding: 12px !important;
    background: #9b3128 !important;
    color: white !important;
    font-size: 16px !important;
    font-weight: bold !important;
    border: none !important;
    border-radius: 8px !important;
    cursor: pointer !important;
    margin-top: 20px !important;
}

.filter-btn:hover {
    background: #80251e;
}

.close {
    cursor: pointer;
}

.button-like-select {
    background-color: #80251e;

    /* Adjust padding */
    border: 1px solid #ccc !important;

}

/* Optional: Hover effect similar to select */
.button-like-select:hover {
    background-color: #f0f0f0 !important;
}

/* Optional: Active effect */
.button-like-select:active {
    background-color: #e0e0e0 !important;

}

.main-home-filter-sec {
    margin-top: 11px !important;
    z-index: 1;
    position: relative;
}

.main-car-list-sec .badge-featured,
.badge-year {
    background-color: #760e13 !important;
}


.car-card-body {
    background-color: #f3f3f3;
    border-radius: 15px;
    padding: 15px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
    color: #4a4a4a;
    /* border-top: 5px solid #760e13; */

}

.price-location {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
}

.price {
    color: #760e13;
    font-size: 22px;
}

.location {
    color: #4a4a4a;
    font-size: 16px;
    display: flex;
    align-items: center;
}

.location i {
    margin-right: 5px;
    color: #760e13;
}

.showroom-name {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 12px;
    color: #333;
}

.car-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 5px;
    font-size: 14px;

    color: #6b6b6b;
}

.car-details p {
    margin: 5px 0;
}

.car-details strong {
    color: #4a4a4a;
    font-weight: bold;
}

.actions {
    display: flex;
    justify-content: space-around;
    margin-top: 15px;
}

.call-btn {
    background-color: #760e13;
    color: white;
    border-color: #760e13;
}

.share-btn {
    background-color: #f3f3f3;
    color: #760e13;
    border-color: #760e13;
}

.actions i {
    font-size: 16px;
}

</style>


    


<div class="tab-content" id="bodyTypeTabsContent">
<div class=" main-car-list-sec">
            <div class="row">
                @foreach ($carlisting as $key => $car)

                <div class="col-sm-3 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="car-card border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                        <!-- Car Image Section with Consistent Aspect Ratio -->
                        <!-- Car Image Section with Consistent Aspect Ratio -->
<div class="car-image position-relative" style="
    width: 100%;
    height: 220px;
    background-color: #f0f0f0;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
">

    <a href="{{ route('car.detail', $car->id) }}" style="width: 100%; height: 100%; display: block;">
        <img id="cardImage" src="{{ config('app.file_base_url') . $car->listing_img1 }}"
            alt="Car Image"
            style="
                height: 100% !important;
                width: 100% !important;
                object-fit: cover;
                object-position: center;
                transition: transform 0.3s ease-in-out;
                aspect-ratio: 16/9;
                cursor: pointer;
            " loading="lazy"
            onerror="this.onerror=null; this.src='https://via.placeholder.com/350x219?text=No+Image';">
    </a>

    
    <div style="
        position: absolute;
        top: 10px;
        right: 10px;
        display: flex;
        gap: 8px;
        z-index: 10;
    ">
      <!-- زر المفضلة -->
<div class="icon-group">
    @if(auth()->check())
        @php
            $favCars = auth()->user()->favCars()->pluck('id')->toArray();
        @endphp
        <form action="{{ route('cars.addTofav', $car->id) }}" method="post">
            @csrf
            <button title="Add to fav" class="btn btn-sm" type="submit">
                <i class="fas fa-heart fs-4" style="color: {{ in_array($car->id, $favCars) ? '#760e13' : 'gray' }}"></i>
            </button>
        </form>
    @else
        <a href="{{ route('login') }}" title="Login to add to fav" class="btn btn-sm">
            <i class="fas fa-heart fs-4" style="color: gray"></i>
        </a>
    @endif
</div>

          
        <a href=" https://wa.me/?text={{ urlencode('Hello, i recommend you to check this car ' . route('car.detail', $car->id)) }}"
                                    target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 15px;">
                                        <i class="fa fa-share"></i>
                                        
                                    </button>
                                </a>
                                <div class="" style="
            background: #760e13;
            border: none;
            color: #fff;
            border-radius: 30%;
            padding: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            cursor: pointer;
        ">{{ $car->listing_year }}</div>
    </div>

    <!-- السنة -->
</div>


                        <!-- Car Content Section -->
                        <div class="car-card-body">

                            <div class="price-location">
                                <span class="price ">AED {{$car->listing_price}}</span>
                                @if($car->user?->lat && $car->user?->lng)
                                <a href="https://www.google.com/maps?q={{$car->user->lat}},{{$car->user->lng}}">
                                    <span class="location"><i class="fas fa-map-marker-alt"></i> {{$car->city}}</span>
                                </a>
                                @endif
                            </div>
                            <h4 class="showroom-name" style="text-align: start !important;">{{$car->user?->fname}} {{$car->user?->lname}}</h4>


                            <!-- <div class="car-details">
                                <p><strong>Make:</strong> <span>{{$car->listing_type}}</span></p>
                                <p><strong>Model:</strong> <span>{{$car->listing_model}}</span></p>
                                <p><strong>Year:</strong> <span>{{$car->listing_year}}</span></p>
                                <p><strong>Mileage:</strong> <span>215000 Kms</span></p>
                            </div> -->

                            <!-- <div class="car-details" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px 20px;">
    <div>
        <p><strong>Make:</strong> <span>{{$car->listing_type}}</span></p>
    </div>
    <div>
        <p><strong>Year:</strong> <span>{{$car->listing_year}}</span></p>
    </div>
    <div>
        <p><strong>Model:</strong> <span>{{$car->listing_model}}</span></p>
    </div>
    <div>
        <p><strong>Mileage:</strong> <span>21..Kms</span></p>
    </div>
</div> -->

<div class="car-details container">
    <div class="row mb-2">
        <div class="col-6">
            <p><strong>Make:</strong> <span>{{$car->listing_type}}</span></p>
        </div>
        <div class="col-6">
            <p><strong>Year:</strong> <span>{{$car->listing_year}}</span></p>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <p><strong>Model:</strong> <span>{{$car->listing_model}}</span></p>
        </div>
        <div class="col-6">
            <p><strong>Mileage:</strong> <span>215Kms</span></p>
        </div>
    </div>
</div>



                            <div class="actions">
                                <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank">
                                <button class="btn btn-outline-danger" style="border-radius: 15px;">
                                        <i class="fab fa-whatsapp "  style="color: #198754; "></i> WhatsApp
                                    </button>
                                </a>
                                @if($os == 'Windows' || $os == 'Linux' )
                                <a href="https://wa.me/{{ $car->user?->phone }}" target="_blank">
                                    <button class="btn btn-outline-danger" style="border-radius: 15px; margin-left:2px; margin-right:2px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @elseif($os == 'Mac')
                                <a href={{ 'https://faceapp.com?phone=' . urlencode($car->user?->phone) }}>
                                    <button class="btn btn-outline-danger" style="border-radius: 15px;">
                                        <i class="fa fa-phone"></i> Call
                                    </button>
                                </a>
                                @elseif($os == 'Android' || $os='iOS')
                                <a href="tel:{{ $car->user->phone }}">
                                    <button class="btn btn-outline-danger" style="border-radius: 15px;">
                                        <i class="fa fa-phone"></i> Make Call
                                    </button>
                                </a>
                                @else
                                No OS Detected
                                @endif

                                
                            </div>
                        </div>
                    </div>
                    
                </div>


                @endforeach
</div>

