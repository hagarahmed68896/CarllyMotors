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
    height: 400px; /* ✅ Ensures map is visible */
    min-height: 300px;
    border: 2px solid #760e13;
    border-radius: 5px;
}

</style>

<div id="container" class="container mt-5">
    <div class="progress px-1" style="height: 3px;">
        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
            aria-valuemax="100"></div>
    </div>
    <div class="step-container d-flex justify-content-between">
        <div class="step-circle" onclick="displayStep(1)">1</div>
        <div class="step-circle" onclick="displayStep(2)">2</div>
        <div class="step-circle" onclick="displayStep(3)">3</div>
    </div>

    <div id="multi-step-form">
        <div class="step step-1">
            <!-- Step 1 form fields here -->
            <h3>Verify Phone Number</h3>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="number" class="form-control" id="phone" name="phone">
                <button class="btn btn-sm btn-secondary " style="float:right" onclick="sendOTP()">Send OTP</button>

                <div id="recaptcha-container"></div>
                <p id="otp-timer">OTP expires in <span id="countdown">60</span> seconds</p>
                <button class="btn btn-sm btn-secondary" id="resend-otp" onclick="sendOTP()" disabled>Resend
                    OTP</button>

                <input type="text" id="otp" class="form-control" placeholder="Enter OTP">
                <button class="btn btn-sm btn-secondary" style="float:right" onclick="verifyOTP()">Verify OTP</button>

                <div id="recaptcha-container"></div>
            </div><br>
            <button type="button" class="btn btn-sm  next-step"
                style="float:right; background-color: #760e13; color:white;">Next</button>
        </div>

        <div class="step step-2">
            <!-- Step 2 form fields here -->
            <h3>Sign Up</h3>
            <form>
                <div class="row">
                    <div class="mb-1 col-6">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>

                    <div class="mb-1 col-6">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                    </div>

                    <div class="mb-1 col-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="number" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="mb-1 col-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" autocomplete="off" required>
                    </div>

                    <div class="mb-1 col-6">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <div class="mb-1 col-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" autocomplete="new-password"
                            name="password" required>
                    </div>
                    <div class="mb-1 col-12">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>

                    <div class="mb-1 col-6">
                        <label class="form-label">User Type</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="userType" id="user" value="user" checked>
                            <label class="form-check-label" for="user">User</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="userType" id="dealer" value="dealer">
                            <label class="form-check-label" for="dealer">Dealer</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="userType" id="shop_dealer"
                                value="shop_dealer">
                            <label class="form-check-label" for="shop_dealer">Shop Dealer</label>
                        </div>
                    </div>

                    <!-- Google Maps Location Picker -->
                    <div class="mb-3">
                        <label class="form-label">Pick Location</label>
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
        <div class="step step-3">
            <!-- Step 3 form fields here -->

            <div class="mb-3">
                <section class="login-main-wrapper">
                    <div class="main-container">
                        <div class="login-process">
                            <div class="login-main-container">
                                <div class="thankyou-wrapper">
                                    <h1>Thanks</h1>
                                    <p>Welcome To Carlly Motors</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>



<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth-compat.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmZpIyIU0nsjNEzzOL4VnrH2YclPvBfpo&callback=initMap&libraries=maps,marker&loading=async"></script>

<script>
const firebaseConfig = {
    apiKey: "{{ env('FIREBASE_API_KEY') }}",
    authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
    projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
    storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
    messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
    appId: "{{ env('FIREBASE_APP_ID') }}",
    measurementId: "{{ env('FIREBASE_MEASUREMENT_ID') }}"
};

firebase.initializeApp(firebaseConfig);

let recaptchaVerifier;

function setupReCaptcha() {
    if (typeof recaptchaVerifier !== "undefined") {
        document.getElementById("recaptcha-container").innerHTML = ""; // Remove previous reCAPTCHA
    }

    recaptchaVerifier = new firebase.auth.RecaptchaVerifier("recaptcha-container", {
        size: "invisible", // or "normal" for a visible reCAPTCHA
        callback: function(response) {
            console.log("reCAPTCHA solved:", response);
        },
        "expired-callback": function() {
            alert("reCAPTCHA expired, please refresh and try again.");
        }
    });

    recaptchaVerifier.render().then(function(widgetId) {
        window.recaptchaWidgetId = widgetId;
    });
}

function sendOTP() {
    setupReCaptcha(); // Ensure reCAPTCHA is properly set up

    const phoneNumber = document.getElementById("phone").value;

    firebase.auth().signInWithPhoneNumber(phoneNumber, recaptchaVerifier)
        .then((confirmationResult) => {
            window.confirmationResult = confirmationResult;
            alert("OTP sent successfully!");

            // Start the countdown timer
            startCountdown(60);
        })
        .catch((error) => {
            console.log(error);
            alert(error.message);
            grecaptcha.reset(); // Reset reCAPTCHA in case of error
        });
}

function startCountdown(seconds) {
    let countdownElement = document.getElementById("countdown");
    let resendButton = document.getElementById("resend-otp");
    resendButton.disabled = true;

    let interval = setInterval(() => {
        if (seconds > 0) {
            countdownElement.innerText = seconds;
            seconds--;
        } else {
            clearInterval(interval);
            resendButton.disabled = false; // Enable resend button after timer ends
            countdownElement.innerText = "Expired!";
        }
    }, 1000);
}

function verifyOTP() {
    const otp = document.getElementById("otp").value;

    window.confirmationResult.confirm(otp)
        .then((result) => {
            alert("Phone number verified!");
        })
        .catch((error) => {
            if (error.code === "auth/code-expired") {
                alert("Your OTP has expired. Please request a new one.");
                document.getElementById("resend-otp").disabled = false; // Enable Resend button
            } else {
                alert(error.message);
            }
        });
}


function sendTokenToServer(token) {
    fetch("/verify-token", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                token: token
            })
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = "/dashboard";
            } else {
                alert("Authentication failed");
            }
        });
}

var currentStep = 1;
var updateProgressBar;

function displayStep(stepNumber) {
    if (stepNumber >= 1 && stepNumber <= 3) {
        $(".step-" + currentStep).hide();
        $(".step-" + stepNumber).show();
        currentStep = stepNumber;
        updateProgressBar();
    }
}

$(document).ready(function() {
    $('#multi-step-form').find('.step').slice(1).hide();

    $(".next-step").click(function() {
        if (currentStep < 3) {
            $(".step-" + currentStep).addClass("animate__animated animate__fadeOutLeft");
            currentStep++;
            setTimeout(function() {
                $(".step").removeClass("animate__animated animate__fadeOutLeft").hide();
                $(".step-" + currentStep).show().addClass(
                    "animate__animated animate__fadeInRight");
                updateProgressBar();
            }, 500);
        }
    });

    $(".prev-step").click(function() {
        if (currentStep > 1) {
            $(".step-" + currentStep).addClass("animate__animated animate__fadeOutRight");
            currentStep--;
            setTimeout(function() {
                $(".step").removeClass("animate__animated animate__fadeOutRight").hide();
                $(".step-" + currentStep).show().addClass(
                    "animate__animated animate__fadeInLeft");
                updateProgressBar();
            }, 500);
        }
    });

    updateProgressBar = function() {
        var progressPercentage = ((currentStep - 1) / 2) * 100;
        $(".progress-bar").css("width", progressPercentage + "%");
        $(".progress-bar").css("background-color", '#760e13');
    }

    let map;
    let marker;

    // Ensure initMap is globally accessible
    window.initMap = async function () {
        try {
            console.log("Initializing Google Maps...");

            // Load Google Maps JavaScript API
            const { Map } = await google.maps.importLibrary("maps");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

            // Default location (Cairo, Egypt)
            const defaultLocation = { lat: 30.0444, lng: 31.2357 };

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