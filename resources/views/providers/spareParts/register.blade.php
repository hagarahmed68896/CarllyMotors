@extends('layouts.CarProvider')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
#container {
    max-width: 500px;
    margin: 60px auto;
}
.card-step {
    background-color: #fff;
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.step {
    display: none;
}
.step.step-1 {
    display: block;
}

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
    border: 2px solid #163155;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}
.step-circle.active, .step-circle:hover {
    background-color: #163155;
    color: #fff;
}
.step-line {
    position: absolute;
    top: 16px;
    left: 50px;
    width: calc(100% - 100px);
    height: 3px;
    background-color: #163155;
    z-index: -1;
}
.progress {
    height: 5px;
    border-radius: 10px;
    background-color: #eee;
}
.progress-bar {
    background-color: #163155;
    transition: width 0.4s ease;
}
input[type="text"], .form-control {
    border-radius: 15px;
    border: 2px solid #163155;
    padding: 0.6rem 0.75rem;
}
input[type="text"]:focus {
    box-shadow: 0 0 8px rgba(118,14,19,0.3);
    outline: none;
}
button.btn-secondary, button.btn-primary {
    border-radius: 15px;
    padding: 0.5rem 1rem;
}
#otp-timer {
    font-size: 0.9rem;
    color: #163155;
    margin-bottom: 0.5rem;
}
@media (max-width: 576px) {
    #container { margin: 30px auto; padding: 0 1rem; }
}
</style>

<div id="container">
    <div class="progress mb-4">
        <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <div class="step-container d-flex justify-content-between position-relative">
        <div class="step-circle active">1</div>
        <div class="step-circle">2</div>
        <div class="step-circle">3</div>
        <div class="step-line"></div>
    </div>

    <div class="card-step">
        <div id="multi-step-form">
            
            <!-- ✅ STEP 1 — Phone Input -->
       <!-- STEP 1 — User Info + Phone Input -->
<div class="step step-1 text-center">
    <h3 class="mb-4" style="color:#163155;">SpareParts Dealer Register</h3>
    
    <div class="mb-2 text-start">
        <label for="fname" class="form-label fw-bold">First Name</label>
        <input type="text" id="fname" class="form-control" placeholder="Enter your first name" required>
    </div>

    <div class="mb-2 text-start">
        <label for="lname" class="form-label fw-bold">Last Name</label>
        <input type="text" id="lname" class="form-control" placeholder="Enter your last name" required>
    </div>

       <div class="mb-2 text-start">
        <label for="cname" class="form-label fw-bold">Company Name</label>
        <input type="text" id="cname" class="form-control" placeholder="Enter your Company" required>
    </div>

    <div class="mb-2 text-start">
        <label for="email" class="form-label fw-bold">Email Address</label>
        <input type="email" id="email" class="form-control" placeholder="Enter your email" required>
    </div>

    <div class="mb-3 text-start">
        <label for="phone" class="form-label fw-bold">Phone Number</label>
        <div class="input-group">
            <span class="input-group-text">+971</span>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="5xxxxxxxx" maxlength="9" required>
        </div>
    </div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const phoneInput = document.getElementById("phone");

    // منع كتابة 0 كأول رقم
    phoneInput.addEventListener("keypress", function (e) {
        if (this.value.length === 0 && e.key === "0") {
            e.preventDefault();
        }
    });

    // إزالة أي 0 في البداية لو المستخدم لزق رقم
    phoneInput.addEventListener("input", function () {
        if (this.value.startsWith("0")) {
            this.value = this.value.replace(/^0+/, "");
        }
    });
});

</script>
    <div id="recaptcha-container"></div>
<div id="otpError" style="display:none;" class="alert alert-danger mt-2"></div>

<button type="button" 
        class="btn rounded-4 w-100 mb-2" 
        style="background-color: #163155; color: white;" 
        onclick="sendOTP()"
        id="otpButton">
    <span class="spinner-border spinner-border-sm me-2" 
          role="status" 
          aria-hidden="true" 
          id="otpSpinner" 
          style="display: none;"></span>
    <span id="otpButtonText">Send OTP</span>
</button>
<div class="login-link mt-3 text-center">
    Already have an account? 
    <a href="{{ route('providers.spareparts.login') }}">Login</a>
</div>

<style>
.login-link a {
    color: #163155;
    font-weight: 500;
    text-decoration: none;
}

.login-link a:hover {
    text-decoration: underline;
}
</style>
</div>



            <!-- ✅ STEP 2 — OTP Input -->
            <div class="step step-2 text-center">
                <h3 class="mb-3" style="color:#163155;">Verify Code</h3>
                <p id="otp-timer">OTP expires in <span id="countdown">30</span> seconds</p>
                <input type="text" id="otp" class="form-control mb-3" placeholder="Enter OTP">
                <div id="otpError" class="text-danger mt-2 mb-2" style="display:none;"></div>

                <button type="button" class="btn  w-100 rounded-4 mb-2" style="background-color: #163155; color: white;" onclick="verifyOTP()">Verify OTP</button>
                <button type="button" class="btn rounded-4 btn-secondary w-100" id="resend-otp" onclick="sendOTP()" disabled>Resend OTP</button>
            </div>

            <!-- ✅ STEP 3 — Verified Message -->
            <div class="step step-3 text-center">
                <h3 style="color:#163155;">Phone Verified ✅</h3>
                <p>You are successfully verified. Redirecting...</p>
            </div>
        </div>
    </div>
</div>

{{-- keep all your Firebase + JS exactly same --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth-compat.js"></script>


<script>
/* global firebase, $, window */

// ============================
//  Firebase Config
// ============================
const firebaseConfig = {
    apiKey: "AIzaSyDV5bqNaUUDmB3SBawLc7HXBI2WvAcOvV8",
    authDomain: "carlly-de5a1.firebaseapp.com",
    projectId: "carlly-de5a1",
    storageBucket: "carlly-de5a1.appspot.com",
    messagingSenderId: "336138983965",
    appId: "1:336138983965:web:edd47ae145c033f05a44f4",
    measurementId: "G-416GMZTRZT"
};

firebase.initializeApp(firebaseConfig);

let recaptchaVerifier;
let lastConfirmationResult = null;

// ============================
// Debug Mode Helper
// ============================
function isDebugMode() {
  const checkbox = document.querySelector('#use-debug');
  return (checkbox && checkbox.checked) ||
         location.hostname.includes("localhost") ||
         location.hostname.includes("127.0.0.1");
}

// ============================
// Setup Invisible reCAPTCHA
// ============================
function setupReCaptcha() {
  if (!recaptchaVerifier) {
    recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
      size: 'invisible',
      callback: () => console.log("reCAPTCHA verified")
    });
    recaptchaVerifier.render().catch(() => {});
  }
}
/**
 * تفعيل حالة التحميل للزرار
 */
function setLoadingState(isLoading) {
    const button = document.getElementById('otpButton');
    const spinner = document.getElementById('otpSpinner');
    const buttonText = document.getElementById('otpButtonText');

    if (isLoading) {
        button.disabled = true;
        spinner.style.display = 'inline-block';
        buttonText.textContent = 'Sending...';
    } else {
        button.disabled = false;
        spinner.style.display = 'none';
        buttonText.textContent = 'Send OTP'; // أو أي نص آخر تريده بعد الانتهاء
    }
}
// ============================
// Send OTP
// ============================
function sendOTP() {
// ⭐ تفعيل حالة التحميل قبل بدء العملية ⭐
    setLoadingState(true);
  setupReCaptcha();

  let phoneNumber = $("#phone").val().trim();

  if (!phoneNumber) {
    setLoadingState(false);
    alert("Please enter phone number");
    return;
  }

  if (!phoneNumber.startsWith('+')) {
    phoneNumber = '+971' + phoneNumber.replace(/^0+/, '');
  }

  console.log("📞 Full phone:", phoneNumber);

  // ===============================
  // ⭐ TEST NUMBERS ALWAYS ALLOWED  
  // ===============================
  const testPhones = {
      "+971522222222": "123456",
      "+971566666666": "654321"
  };

  if (testPhones[phoneNumber]) {
      console.log("🧪 TEST PHONE USED:", phoneNumber);

      lastConfirmationResult = {
          _isFake: true,
          _fakeOtp: testPhones[phoneNumber],
          confirm(code) {
              return new Promise((resolve, reject) => {
                  if (code === this._fakeOtp) {
                      resolve({
                          user: {
                              getIdToken: () => Promise.resolve("FAKE_TEST_TOKEN"),
                              phoneNumber,
                              uid: "TEST_UID_" + Math.random().toString(36).substring(2, 8)
                          }
                      });
                  } else {
                      reject({ message: "Invalid test code" });
                  }
              });
          }
      };

      startCountdown(30);
      showStep(2);
      setLoadingState(false);
      return;
  }

  // ===============================
  // ⭐ DEBUG MODE → FAKE OTP  
  // ===============================
// ===============================
// ⭐ DEBUG MODE → FAKE OTP + REAL TOKEN  
// ===============================
if (isDebugMode()) {

    const fakeOtp = Math.floor(100000 + Math.random() * 900000).toString();
    console.log("🧪 Debug OTP:", fakeOtp);

    // نعمل تسجيل دخول مجهول للحصول على توكن Firebase حقيقي
    firebase.auth().signInAnonymously().then(result => {
        result.user.getIdToken(true).then(realToken => {

            lastConfirmationResult = {
                _isFake: true,
                _fakeOtp: fakeOtp,
                _realToken: realToken,
                phoneNumber,
                confirm(code) {
                    return new Promise((resolve, reject) => {
                        if (code === fakeOtp) {
                            resolve({
                                user: {
                                    phoneNumber,
                                    uid: result.user.uid,
                                    getIdToken: () => Promise.resolve(realToken)
                                }
                            });
                        } else {
                            reject({ message: "Invalid debug code" });
                        }
                    });
                }
            };

            startCountdown(30);
            showStep(2);
            setLoadingState(false);
        });
    });

    return;
}


  // ===============================
  // ⭐ REAL OTP (Production)  
  // ===============================
  firebase.auth().signInWithPhoneNumber(phoneNumber, recaptchaVerifier)
    .then((confirmationResult) => {
        lastConfirmationResult = confirmationResult;
        console.log("📨 OTP sent:", confirmationResult);

        startCountdown(30);
        showStep(2);
    })
   .catch((err) => {
    console.error("❌ OTP Error:", err);
    showFirebaseError(err);
    try { grecaptcha.reset(); } catch(e){}
})
    .finally(() => {
        // ⭐ إيقاف حالة التحميل بعد انتهاء العملية ⭐
        setLoadingState(false);
    });

}

// ============================
// Verify OTP
// ============================
function verifyOTP() {
    const code = $("#otp").val().trim();

    if (!code) {
        alert("Please enter OTP");
        return;
    }

    if (!lastConfirmationResult) {
        alert("No OTP request found");
        return;
    }

    // Fake mode
    if (lastConfirmationResult._isFake) {
        lastConfirmationResult.confirm(code)
            .then(res => handleVerifiedFirebaseUser(res.user))
            .catch(err => alert(err.message));
        return;
    }

    // REAL mode (fixed)
    const credential = firebase.auth.PhoneAuthProvider.credential(
        lastConfirmationResult.verificationId,
        code
    );

    firebase.auth().signInWithCredential(credential)
        .then(result => handleVerifiedFirebaseUser(result.user))
        .catch(err => {
            console.error(err);
            showFirebaseError(err);
        });
}

// ============================
// After verification → send token to backend
// ============================
function handleVerifiedFirebaseUser(user) {

  user.getIdToken().then(idToken => {

    return $.ajax({
      url: "/verify-token-spareparts",
      method: "POST",
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
      data: {
        token: idToken,
        phone: user.phoneNumber,
        fname: $("#fname").val(),
        lname: $("#lname").val(),
        email: $("#email").val(),
        company_name: $("#cname").val()
      }
    });

  }).then(response => {

    if (response.success) {
      showStep(3);
      window.location.href = response.redirect;
    } else {
      $("#otpError").text(response.error).show();
    }

  }).catch(err => {
    console.error(err);
    $("#otpError").text("Server error").show();
  });
}

// ============================
// Countdown Timer
// ============================
function startCountdown(s) {
  $("#resend-otp").prop("disabled", true);
  $("#countdown").text(s);

  const timer = setInterval(() => {
    s--;
    if (s > 0) $("#countdown").text(s);
    else {
      clearInterval(timer);
      $("#countdown").text("Expired!");
      $("#resend-otp").prop("disabled", false);
    }
  }, 1000);
}

// ============================
// Show Step UI
// ============================
function showStep(n) {
  $(".step").hide();
  $(`.step-${n}`).show();

  const circles = document.querySelectorAll(".step-circle");
  circles.forEach((c, i) => {
    if (i < n) c.classList.add("active");
    else c.classList.remove("active");
  });

  const progress = ((n - 1) / (circles.length - 1)) * 100;
  $(".progress-bar").css("width", progress + "%");
}
function showFirebaseError(error) {
    let message = "Something went wrong. Please try again.";

    switch (error.code) {
        case "auth/invalid-phone-number":
            message = "The phone number is invalid. Please enter a correct mobile number.";
            break;

        case "auth/missing-phone-number":
            message = "Please enter a phone number first.";
            break;

        case "auth/too-many-requests":
            message = "Too many attempts. Please wait and try again.";
            break;

        case "auth/quota-exceeded":
            message = "SMS quota exceeded for today. Try again later.";
            break;

        case "auth/captcha-check-failed":
            message = "reCAPTCHA verification failed. Refresh the page and try again.";
            break;

        case "auth/invalid-verification-code":
            message = "Incorrect code. Please enter the correct OTP.";
            break;

        case "auth/session-expired":
            message = "The OTP code expired. Request a new one.";
            break;

        default:
            message = error.message || "Unexpected error.";
    }

    const box = document.getElementById("otpError");
    box.innerText = message;
    box.style.display = "block";
}

</script>


@endsection
