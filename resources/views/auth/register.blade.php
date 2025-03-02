@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
    <div class="progress px-1" style="height: 3px;">
        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
            aria-valuemax="100"></div>
    </div>
    <div class="step-container d-flex justify-content-between">
        <div class="step-circle" onclick="displayStep(1)">1</div>

    </div>

    <div id="multi-step-form">
        <div class="step step-1">
            <!-- Step 1 form fields here -->
            <h3>Verify Phone Number</h3>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone">
                <button tybe="button" class="btn btn-sm btn-secondary " style="float:right" onclick="sendOTP()">Send
                    OTP</button>

                <div id="recaptcha-container"></div>
                <p id="otp-timer">OTP expires in <span id="countdown">60</span> seconds</p>
                <button tybe="button" class="btn btn-sm btn-secondary" id="resend-otp" onclick="sendOTP()"
                    disabled>Resend
                    OTP</button>

                <input type="text" id="otp" class="form-control" placeholder="Enter OTP">
                <button tybe="button" class="btn btn-sm btn-secondary" style="float:right" onclick="verifyOTP()">Verify
                    OTP</button>

                <div id="recaptcha-container"></div>
            </div>

        </div>
    </div>
</div>



<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth-compat.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
let verifiedPhoneNumber = null; // Global variable to store verified number


function verifyOTP() {
    const otp = document.getElementById("otp").value;
    const phoneNumber = document.getElementById("phone").value;

    window.confirmationResult.confirm(otp)
        .then((result) => {
            alert("Phone number verified!");

            // Retrieve Firebase authentication token
            firebase.auth().currentUser.getIdToken(true)
                .then((token) => {
                    sendTokenToServer(token); // Send token to Laravel backend
                })
                .catch((error) => {
                    console.error("Error getting token:", error);
                });
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
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ token: token })
    })
    .then(response => response.json()) // Ensure the response is JSON
    .then(data => {
        if (data.success) {
            window.location.href = '/';
        } else {
            alert("Authentication failed: " + data.error);
        }
    })
    .catch(error => {
        console.error("Error sending token:", error);
    });
}




// Wizard Form
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

});
</script>
@endsection