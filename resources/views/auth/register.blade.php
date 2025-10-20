@extends('layouts.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* Container */
#container {
    max-width: 500px;
    margin: 60px auto;
}

/* Card */
.card-step {
    background-color: #fff;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Step Circles */
.step-container {
    position: relative;
    text-align: center;
    margin-bottom: 2rem;
}
.step-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background-color: #fff;
    border: 2px solid #760e13;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}
.step-circle.active, .step-circle:hover {
    background-color: #760e13;
    color: #fff;
}

/* Step line */
.step-line {
    position: absolute;
    top: 16px;
    left: 50px;
    width: calc(100% - 100px);
    height: 3px;
    background-color: #760e13;
    z-index: -1;
}

/* Progress bar */
.progress {
    height: 5px;
    border-radius: 10px;
    background-color: #eee;
}
.progress-bar {
    background-color: #760e13;
}

/* Form Inputs */
input[type="text"], .form-control {
    border-radius: 15px;
    border: 2px solid #760e13;
    padding: 0.6rem 0.75rem;
}
input[type="text"]:focus {
    box-shadow: 0 0 8px rgba(118,14,19,0.3);
    outline: none;
}

/* Buttons */
button.btn-secondary, button.btn-primary {
    border-radius: 15px;
    padding: 0.5rem 1rem;
}

/* OTP timer */
#otp-timer {
    font-size: 0.9rem;
    color: #760e13;
    margin-bottom: 0.5rem;
}

/* Responsive */
@media (max-width: 576px) {
    #container {
        margin: 30px auto;
        padding: 0 1rem;
    }
}
</style>

<div id="container">
    <!-- Progress Bar -->
    <div class="progress mb-4">
        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <!-- Step Circles -->
    <div class="step-container d-flex justify-content-between position-relative">
        <div class="step-circle active" onclick="displayStep(1)">1</div>
        <div class="step-circle" onclick="displayStep(2)">2</div>
        <div class="step-circle" onclick="displayStep(3)">3</div>
        <div class="step-line"></div>
    </div>

    <!-- Form Card -->
    <div class="card-step">
        <div id="multi-step-form">
            <!-- Step 1 -->
            <div class="step step-1">
                <h3 class="text-center mb-4" style="color:#760e13;">Verify Phone Number</h3>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" class="form-control mb-2" id="phone" name="phone" placeholder="Enter phone">
                    <button type="button" class="btn btn-secondary btn-sm float-end mb-2" onclick="sendOTP()">Send OTP</button>
                    <div id="recaptcha-container"></div>
                    <p id="otp-timer">OTP expires in <span id="countdown">60</span> seconds</p>
                    <button type="button" class="btn btn-secondary btn-sm w-100 mb-2" id="resend-otp" onclick="sendOTP()" disabled>Resend OTP</button>
                    <input type="text" id="otp" class="form-control mb-2" placeholder="Enter OTP">
                    <button type="button" class="btn btn-secondary btn-sm float-end mb-4" onclick="verifyOTP()">Verify OTP</button>
                </div>
            </div>

            <!-- Step 2 Placeholder -->
            <div class="step step-2">
                <h3 class="text-center mb-4" style="color:#760e13;">Step 2 Title</h3>
                <p class="text-center">Content for step 2 goes here.</p>
            </div>

            <!-- Step 3 Placeholder -->
            <div class="step step-3">
                <h3 class="text-center mb-4" style="color:#760e13;">Step 3 Title</h3>
                <p class="text-center">Content for step 3 goes here.</p>
            </div>
        </div>
    </div>
</div>

<!-- Scripts (Firebase + jQuery) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth-compat.js"></script>

<!-- Keep all your existing JS logic unchanged -->
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
let recaptchaVerifier; // خليها global فوق الكود

function setupReCaptcha() {
    if (!recaptchaVerifier) {
        recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
            size: 'invisible',
            callback: function(response) {
                console.log('reCAPTCHA verified ✅');
            }
        });
        recaptchaVerifier.render();
    } else {
        console.log("reCAPTCHA already rendered, skipping...");
    }
}


function sendOTP() {
    setupReCaptcha();
    const phoneNumber = document.getElementById("phone").value;

    firebase.auth().signInWithPhoneNumber(phoneNumber, recaptchaVerifier)
        .then((confirmationResult) => {
            window.confirmationResult = confirmationResult;
            console.log("✅ OTP sent successfully to:", phoneNumber);
            console.log("ℹ️ confirmationResult object:", confirmationResult);
            alert("OTP sent successfully!");

            // 🔥 لو بتجربي محليًا، ممكن تولدي كود وهمي للطباعة
            const fakeOtp = Math.floor(100000 + Math.random() * 900000);
            console.log("🧪 (Demo) Fake OTP for testing:", fakeOtp);

            startCountdown(60);
        })
        .catch((error) => {
            console.error("❌ Error sending OTP:", error);
            alert(error.message);
            grecaptcha.reset();
        });
}


function startCountdown(seconds) {
    let countdownElement = document.getElementById("countdown");
    let resendButton = document.getElementById("resend-otp");
    resendButton.disabled = true;
    let interval = setInterval(() => {
        if (seconds > 0) { countdownElement.innerText = seconds; seconds--; } 
        else { clearInterval(interval); resendButton.disabled = false; countdownElement.innerText = "Expired!"; }
    }, 1000);
}

function verifyOTP() {
    const otp = document.getElementById("otp").value;
    window.confirmationResult.confirm(otp)
        .then((result) => { alert("Phone number verified!"); })
        .catch((error) => { if(error.code==="auth/code-expired") { alert("OTP expired."); document.getElementById("resend-otp").disabled=false; } else { alert(error.message); } });
}

// Multi-step wizard
var currentStep = 1;
function displayStep(stepNumber) {
    if(stepNumber>=1 && stepNumber<=3){
        $(".step-"+currentStep).hide();
        $(".step-"+stepNumber).show();
        $(".step-circle").removeClass("active");
        $(".step-circle:nth-child("+stepNumber+")").addClass("active");
        currentStep=stepNumber;
        $(".progress-bar").css("width", ((currentStep-1)/2)*100+"%");
    }
}
$(document).ready(function(){ $('#multi-step-form').find('.step').slice(1).hide(); displayStep(1); });
</script>
@endsection
