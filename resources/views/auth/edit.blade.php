@extends('layouts.app')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
#container {
    max-width: 550px;
}

.step-container {
    position: relative;
    text-align: center;
    transform: translateY(-43%);
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

.step-circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #fff;
    border: 2px solid #760e13;
    line-height: 30px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    cursor: pointer;
    /* Added cursor pointer */
}

.step-line {
    position: absolute;
    top: 16px;
    left: 50px;
    width: calc(100% - 100px);
    height: 2px;
    background-color: #760e13;
    z-index: -1;
}


#multi-step-form {
    overflow-x: hidden;
}

.thankyou-wrapper {
    width: 100%;
    height: auto;
    margin: auto;
    background: #ffffff;
    padding: 10px 0px 50px;
}

.thankyou-wrapper h1 {
    font: 100px Arial, Helvetica, sans-serif;
    text-align: center;
    color: #333333;
    padding: 0px 10px 10px;
}

.thankyou-wrapper p {
    font: 26px Arial, Helvetica, sans-serif;
    text-align: center;
    color: #333333;
    padding: 5px 10px 10px;
}

.thankyou-wrapper a {
    font: 26px Arial, Helvetica, sans-serif;
    text-align: center;
    color: #760e13;
    padding: 5px 10px 10px;
}

#map {
    width: 100%;
    height: 400px;
    /* ✅ Ensures map is visible */
    min-height: 300px;
    border: 2px solid #760e13;
    border-radius: 5px;
}
</style>

<div id="container" class="container mt-5">

    <div id="multi-step-form">
        <div class="step step-2">
            <!-- Step 2 form fields here -->
            <form action="{{route('users.update', auth()->user()->id)}}" method="POST" enctype="multipart/form-data" id="myFo">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-1 col-6">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" value="{{$user->fname != 'user' ? $user->fname : ''}}" name="fname" required>
                    </div>

                    <div class="mb-1 col-6">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" value="{{$user->fname != 'user' ? $user->lname : ''}}" name="lname" required>
                    </div>

                    <div class="mb-1 col-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="number" class="form-control" id="phone" value="{{$user->fname != 'user' ? $user->phone : ''}}" name="phone" required>
                    </div>

                    <div class="mb-1 col-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{$user->fname != 'user' ? $user->email : ''}}" autocomplete="off" required>
                    </div>

                    <div class="mb-1 col-6">
                        <label for="city" class="form-label">City</label>
                        <input type="city" class="form-control" id="city" name="city" value="{{$user->city}}" autocomplete="off" required>
                    </div>

                    <div class="mb-1 col-6">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    
                    <div class="mb-1 col-12" style="padding-bottom:10px;">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" value="{{$user->location}}" name="location" required>
                    </div>

                    <!-- Google Maps Location Picker -->
                    <div class="mb-3">
                        <div id="map"></div>
                    </div>

                    <!-- Latitude & Longitude Fields -->
                    <div class="mb-3">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" readonly required>
                    </div>

                    <div class="mb-3">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" readonly required>
                    </div>


                </div>
                <button type="submit" class="btn btn-sm  next-step"
                    style="float:right; background-color: #760e13; color:white;">Submit</button>
            </form>
        </div>
    </div>
</div>



<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmZpIyIU0nsjNEzzOL4VnrH2YclPvBfpo&callback=initMap&libraries=maps,marker&loading=async">
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>

$(document).ready(function() {
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
});
</script>
@endsection