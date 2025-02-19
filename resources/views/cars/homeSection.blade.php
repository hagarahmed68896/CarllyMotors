@extends('./home')

@section('css')
@endsection

@section('js')
@endsection

<style>
.main-car-list-sec .badge-featured,
.badge-year {
    background-color: #760e13 !important;
}

.btn-outline-danger {
    /* background-color: #760e13 !important; */
    color: #760e13 !important;
    border-color: #760e13 !important;
}

.btn-outline-danger:hover {
    background-color: #5a0b0f !important;
    border-color: #5a0b0f !important;
    color: #f3f3f3 !important;
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

.carousel-item img {
    border-radius: 15px !important;
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

/* .actions button {
    padding: 10px 15px;
    
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    border: 2px solid transparent;
    transition: 0.3s;
    display: flex;
    align-items: center;
    gap: 5px;
} */

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

.whatsapp-btn:hover,
.call-btn:hover,
.share-btn:hover {
    opacity: 0.8;
}

.actions i {
    font-size: 16px;
}
</style>

@section('page')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<div class="filter-bar mt-4">
    <form class="form-row" id="filterForm" action="{{route('cars.index')}}" method="get">

        <!-- City Dropdown -->
        <div class="col-">
            <select class="form-control" onchange="submitFilterForm()" name="city" style="width:80px;">
                <option value="" selected>City</option>
                @foreach($cities as $city)
                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                    {{ $city }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Make Dropdown -->
        <div class="col-">
            <select class="form-control" id="brand" name="make">
                <option value="" selected>Make</option>
                @foreach($makes as $make)
                <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>
                    {{ $make }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Model Dropdown -->
        <div class="col-">
            <select class="form-control" onchange="submitFilterForm()" id="model" name="model">
                <option value="" selected>Model</option>
            </select>
        </div>

        <!-- Year Dropdown -->
        <div class="col-">
            <select class="form-control" onchange="submitFilterForm()" name="year">
                <option value="" selected>Year</option>
                @foreach($years as $year)
                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Body Type Dropdown -->
        <div class="col-">
            <select class="form-control" onchange="submitFilterForm()" name="body_type">
                <option value="" selected>Body Type</option>
                @foreach($bodyTypes as $bodyType)
                <option value="{{ $bodyType }}" {{ request('body_type') == $bodyType ? 'selected' : '' }}>
                    {{ $bodyType }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- regionalSpecs Dropdown -->
        <div class="col-">
            <select class="form-control" onchange="submitFilterForm()" name="regionalSpecs">
                <option value="" selected>regionalSpecs</option>
                @foreach($regionalSpecs as $regionalSpec)
                <option value="{{ $regionalSpec }}" {{ request('regionalSpec') == $regionalSpec ? 'selected' : '' }}>
                    {{ $regionalSpec }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Price Dropdown -->
        <div class="col-">
            <select class="form-control" onchange="submitFilterForm()" name="price">
                <option value="" selected>Price</option>
                @foreach($prices as $price)
                <option value="{{ $price }}" {{ request('price') == $price ? 'selected' : '' }}>
                    {{ $price }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- condition Dropdown -->
        <div class="col-">
            <select class="form-control" onchange="submitFilterForm()" name="condition">
                <option value="" selected>Condition</option>
                @foreach($conditions as $condition)
                <option value="{{ $condition }}" {{ request('condition') == $condition ? 'selected' : '' }}>
                    {{ $condition }}
                </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

<div class="tab-content" id="bodyTypeTabsContent">
    <div class="container main-car-list-sec">
        <div class="row">
            @foreach ($carlisting as $key => $car)

            <div class="col-sm-3 col-sm-12 col-md-6 col-lg-4 col-xl-4">
                <div class="car-card border-0 shadow" style="border-radius: 12px; overflow: hidden;">
                    <!-- Car Image Section with Consistent Aspect Ratio -->
                    <div class="car-image position-relative" style="
                        width: 100%;
                        height: 220px;
                        background-color: #f0f0f0;
                        border-radius: 10px;
                        overflow: hidden;
                        display: flex;
                        align-items: center;
                        justify-content: center;">

                        <img id="cardImage" src="{{ config('app.file_base_url') . $car->listing_img1 }}" alt="Car Image"
                            style="
                              height: 100%; !important;
                              width: 100%; !important;
                                object-fit: cover;
                                object-position: center;
                                transition: transform 0.3s ease-in-out;
                                aspect-ratio: 16/9;" loading="lazy"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/350x219?text=No+Image';">

                        <!-- Badges -->
                        <div class="badge-year">{{ $car->listing_year }}</div>
                    </div>

                    <!-- Car Content Section -->
                    <div class="car-card-body">
                        <div class="price-location">
                            <span class="price">AED {{$car->listing_price}}</span>
                            <a href="https://www.google.com/maps?q={{$car->user->lat}},{{$car->user->lng}}">
                                <span class="location"><i class="fas fa-map-marker-alt"></i> {{$car->city}}</span>
                            </a>
                        </div>

                        <h4 class="showroom-name">{{$car->user->fname}} {{$car->user->lname}}</h4>

                        <div class="car-details">
                            <p><strong>Make:</strong> <span>{{$car->listing_type}}</span></p>
                            <p><strong>Model:</strong> <span>{{$car->listing_model}}</span></p>
                            <p><strong>Year:</strong> <span>{{$car->listing_year}}</span></p>
                            <p><strong>Mileage:</strong> <span>215000 Kms</span></p>
                        </div>

                        <div class="actions">
                            <a href="https://wa.me/{{ $car->user->phone }}" target="_blank">
                                <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </button>
                            </a>
                            @if($os == 'Windows' || $os == 'Linux' )
                            <a href="https://wa.me/{{ $car->user->phone }}" target="_blank">
                                <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                    <i class="fa fa-phone"></i> Call
                                </button>
                            </a>
                            @elseif($os == 'Mac')
                            <a href={{ 'https://faceapp.com?phone=' . urlencode($car->user->phone) }}>
                                <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                    <i class="fa fa-phone"></i> faceApp
                                </button>
                            </a>
                            @elseif($os == 'Android' || $os='iOS')
                            <a href="tel:{{ $car->user->phone }}">
                                <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                    <i class="fa fa-phone"></i> Make Call
                                </button>
                            </a>
                            @else
                            No OS Detected
                            @endif

                            <a href="{{ route('car.detail', [ Crypt::encrypt($car->id)])  }}">
                                <button class="btn btn-outline-danger" style="border-radius: 25px;">
                                    Details
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mb-0 d-flex justify-content-center" style="margin: 0; float:right">
            <a href="{{route('cars.index')}}" class="btn btn-outline-danger" style="border-radius: 25px;">
                View More
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div>
@push('carlistingscript')
{{-- Script related filters on carlisting page --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
function submitFilterForm() {
    document.getElementById('filterForm').submit();
}

$(document).on('change', '#brand', function() {
    let brand = $(this).val();

    if (brand) {
        $.ajax({
            url: "{{ route('getModels') }}", // Adjust this route as needed
            method: "POST",
            data: {
                brand: brand,
                _token: $('meta[name="csrf-token"]').attr(
                    'content') // CSRF token for security
            },
            success: function(response) {
                // console.log(response);

                // Populate the child select box
                $('#model').empty().append('<option value="">Select Model</option>');

                response.models.forEach(function(model) {
                    let modelName = model ?? 'No Parent';

                    $('#model').append('<option value="' + modelName + '">' +
                        modelName +
                        '</option>');
                });
            },
            error: function(xhr) {
                console.error("Error fetching models:", xhr.responseText);
            }
        });
    } else {
        // Reset the child select box if no item is selected
        $('#model').empty().append('<option value="">model</option>');
    }
});
</script>
@endpush
@endsection