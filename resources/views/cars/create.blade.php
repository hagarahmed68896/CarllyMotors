@extends('layouts.app')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">

<style>
#container {
    max-width: 550px;
}

.card {
    border-radius: 10px;
}

.form-check-input {
    border: 2px solid;
    background-color: transparent;
}

.form-check-input:checked {
    background-color: #760e13;
    border-color: #760e13;
}

.form-check-input:focus {
    box-shadow: 0 0 5px rgba(118, 14, 19, 0.5);
}

.form-control {
    border-radius: 10px;
    margin-bottom: 10px;
}

.form-control:focus {
    box-shadow: 0 0 5px #760e13;
    border-color: white;
}

#map {
    width: 100%;
    height: 400px;
    /* ✅ Ensures map is visible */
    min-height: 300px;
    border: 2px solid #ced4da;
    border-radius: 5px;
}

.bootstrap-tagsinput {
    margin: 0;
    width: 100%;
    padding: 0.5rem 0.75rem 0;
    font-size: 1rem;
    line-height: 1.25;
    transition: border-color 0.15s ease-in-out;
    border-radius: 10px;

    &.has-focus {
        box-shadow: 0 0 5px #760e13;
        border-color: white;

    }

    .label-info {
        display: inline-block;
        background-color: #760e13;
        padding: 0 .4em .15em;
        border-radius: .25rem;
        margin-bottom: 0.4em;
        border-radius: 15px;
    }

    input {
        margin-bottom: 0.5em;
    }
}

.bootstrap-tagsinput .tag [data-role="remove"]:after {
    content: '\00d7';
}

button[type='submit']{
    border-radius: 10px;
    background-color: #760e13;
    color:rgb(227, 232, 238);
}

button[type='submit']:hover{
    border-radius: 10px;
    background-color:rgb(99, 11, 15);
    color:white;
}

.fileInput{
    height: 200px; 
    cursor: pointer; 
    background-color: #e9ecef;
    border-radius: 10px;

}

.fileInput:hover{
    background-color: #ced4da;
    border-radius: 10px;
}
</style>

<div id="container" class="container mt-5">
    @php
    $user = auth()->user();
    @endphp
    <!-- Step 2 form fields here -->

    <div class="card" style="">
        <!-- Clickable Image Header -->
        <div class="position-relative d-flex align-items-center justify-content-center fileInput"
            onclick="document.getElementById('imageInput').click()">
            <img id="imagePreview" class="w-100 h-100 object-fit-cover d-none" />
            <span id="placeholderText" class="text-white fw-bold">Click to Upload</span>
        </div>

        <!-- Hidden File Input -->
        <!-- Card Body -->
        <div class="card-body">
            <form action="{{route('cars.store')}}" method="POST" enctype="multipart/form-data" id="myFo">
                @csrf
                <input type="file" name="images[]" id="imageInput" class="d-none" accept="image/*" multiple>
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="row">
                    <div class="mb-1 col-12">
                        <!-- <label for="make" class="form-label">Make</label> -->
                        <select class="form-control form-select" id="brand" name="make" required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand }}">
                                {{ $brand }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-1 col-6">
                        <select class="form-control form-select" id="model" name="model" required>
                            <option value="">Model</option>
                        </select>
                    </div>

                    <div class="mb-1 col-6">
                        <input type="number" class="form-control" placeholder="Year" id="year" name="year" min="1940"
                            max="2025" required>
                    </div>

                    <div class="mb-1 col-12">
                        <select class="form-control form-select" id="bodyType" name="bodyType" required>
                            <option value="">Select Body Type</option>
                            @foreach($bodyTypes as $bodyType)
                            <option value="{{ $bodyType }}">
                                {{ $bodyType }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-1 col-12">
                        <select class="form-control form-select" id="regionalSpecs" name="regionalSpec" required>
                            <option value="">Select Regional Specs</option>
                            @foreach($regionalSpecs as $regionalSpec)
                            <option value="{{ $regionalSpec }}">
                                {{ $regionalSpec }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-1 col-12">
                        <select class="form-control form-select" id="city" name="city" required>
                            <option value="">Select City</option>
                            <option value="Dubai">Dubai</option>
                            <option value="Abu Dhabi">Abu Dhabi</option>
                            <option value="Sharjah">Sharjah</option>
                            <option value="Ras Al Khaimah">Ras Al Khaimah</option>
                            <option value="Fujairah">Fujairah</option>
                            <option value="Ajman">Ajman</option>
                            <option value="Umm Al Quwain">Umm Al Quwain</option>
                            <option value="Al Ain">Al Ain</option>
                        </select>
                    </div>

                    <div class="mb-1 col-12">
                        <input type="text" name="features" class="form-control" placeholder="Features" required>
                    </div>

                    <div class="mb-1 col-12">
                        <input type="text" id="vin" class="form-control" placeholder="Vin number" name="vin_number"
                            required>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6 mb-2">
                            <label class="form-label">Gear</label>
                            <select class="form-control form-select" name="gear" required>
                                <option value="Auto">Auto</option>
                                <option value="Manual">Manual</option>
                            </select>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="form-label">Mileage</label>
                            <input type="number" placeholder="Mileage" class="form-control" name="mileage" required>
                        </div>

                        <div class="col-6 mb-2">
                            <label class="form-label">Color</label>
                            <select class="form-control form-select" name="color" required>
                                @foreach($colors as $color)
                                <option value="{{ $color->uid }}">
                                    {{ $color->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        

                        <div class="col-6 mb-2">
                            <label class="form-label">Warranty</label>
                            <select class="form-control form-select" name="warranty" required>
                                <option value="Under Warranty">Under Warranty</option>
                                <option value="Not Available">Not Available</option>
                            </select>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="form-label">Fuel Type</label>
                            <select class="form-control form-select" name="fuelType">
                                <option>Select</option>
                                <option value="single">Single</option>

                            </select>
                        </div>
                        <div class="col-6 mb-2">
                            <label class="form-label">Seats</label>
                            <select class="form-control form-select" name="seats" required>
                                @for($i=2; $i<=14; $i+=2) <option>{{$i}}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                    <div class="mb-1 col-12" style="padding-bottom:10px;">
                        <input type="text" class="form-control" id="name"
                            name="name" placeholder="name" required>
                    </div>

                    <div class="input-group mt-3">
                        <span class="input-group-text">🇦🇪 +971</span>
                        <input type="tel" class="form-control" placeholder="Phone Number" name="phone" value="{{auth()->user()->phone}}" required>
                    </div>
                    <div class="input-group mt-3">
                        <span class="input-group-text">🇦🇪 +971</span>
                        <input type="tel" class="form-control" placeholder="Phone Number" value="{{auth()->user()->phone}}">
                    </div>

                    <div class="mb-1 mt-3 col-12" style="padding-bottom:10px;">
                        <textarea id="description" class="form-control" placeholder="Description"></textarea>
                    </div>

                    <div class="mb-1 col-12" style="padding-bottom:10px;">
                        <input type="text" class="form-control" id="price" value="{{$user->price}}"
                            name="price" placeholder="price" required>
                    </div>


                    <div class="mb-1 col-12" style="padding-bottom:10px;">
                        <input type="text" class="form-control" id="location" value="{{$user->location}}"
                            name="location" placeholder="Location" required>
                    </div>

                    <!-- Google Maps Location Picker -->
                    <div class="mb-3">
                        <div id="map"></div>
                    </div>

                    <!-- Latitude & Longitude Fields -->
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="latitude" name="latitude">
                    </div>

                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="longitude" name="longitude">
                    </div>

                    <button type="submit" class="btn btn-md" style="border-radius: 10px;border: 2px solid #ced4da;">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>



</div>



<!-- Scripts -->
@push('carlistingscript')
{{-- Script related filters on carlisting page --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmZpIyIU0nsjNEzzOL4VnrH2YclPvBfpo&callback=initMap&libraries=maps,marker&loading=async">
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Google Maps
    let map;
    let marker;

    // Ensure initMap is globally accessible
    window.initMap = async function() {
        try {
            console.log("Initializing Google Maps...");

            // Load Google Maps JavaScript API
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerElement
            } = await google.maps.importLibrary("marker");

            // Default location (Cairo, Egypt)
            const defaultLocation = {
                lat: 30.0444,
                lng: 31.2357
            };

            // Create the map with the correct Map ID
            map = new Map(document.getElementById("map"), {
                center: defaultLocation,
                zoom: 10,
                mapId: "5f199e2b6387d3af"

            });
            // Create an Advanced Marker
            marker = new AdvancedMarkerElement({
                map,
                position: defaultLocation,
                title: "Drag to select location",
                draggable: true // Correct draggable property
            });
            // Get User's Current Location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };

                        console.log("📍 User location found:", userLocation);

                        // Update map and marker position
                        map.setCenter(userLocation);
                        marker.position = userLocation;

                        // Update form fields
                        updateLatLng(userLocation);
                    },
                    (error) => {
                        console.warn("Geolocation failed:", error.message);
                    }
                );
            } else {
                console.warn("Geolocation is not supported by this browser.");
            }

            // Listen for marker position changes
            marker.addEventListener("position_changed", () => {
                updateLatLng(marker.position);
            });

            // Listen for map clicks to move the marker
            map.addListener("click", (event) => {
                marker.position = event.latLng;
                updateLatLng(event.latLng);
            });

        } catch (error) {
            console.error("Google Maps failed to load:", error);
        }
    };

    // ✅ Ensure lat/lng updates correctly
    function updateLatLng(latLng) {
        if (!latLng) return;
        document.getElementById("latitude").value = latLng.lat;
        document.getElementById("longitude").value = latLng.lng;
    }

    // getModels of brand on change
    $(document).on('change', '#brand', function() {
        let brand = $(this).val();
        // console.log(brand);

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
            // Reset the child select box if no item is
            $('#model').empty().append('<option value="">model</option>');
        }
    });


    //   Features input
    $('input[name="features"]').tagsinput({
        trimValue: true,
        confirmKeys: [13, 44, 32],
        focusClass: 'my-focus-class'
    });

    $('.bootstrap-tagsinput input').on('focus', function() {
        $(this).closest('.bootstrap-tagsinput').addClass('has-focus');
    }).on('blur', function() {
        $(this).closest('.bootstrap-tagsinput').removeClass('has-focus');
    });

});


// prevent enter from submitting form
$(document).on('keypress', 'form', function(e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});


// Image Upload
document.getElementById("imageInput").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function() {
            const imagePreview = document.getElementById("imagePreview");
            const placeholderText = document.getElementById("placeholderText");

            imagePreview.src = reader.result;
            imagePreview.classList.remove("d-none");
            placeholderText.classList.add("d-none");
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
@endsection