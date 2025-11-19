@extends('layouts.app')

@section('content')
<style>
.login {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    min-height: 50vh;
    background: #f8f9fa;
}

.login-form {
    width: 400px;
    padding: 2.5rem 2rem;
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    background: #fff;
}

.login-form h5 {
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: #760e13;
}

input[type="tel"], #otp {
    border-radius: 15px;
    border: 2px solid #760e13;
    padding: 0.5rem;
    margin-bottom: 1rem;
    width: 100%;
    font-size: 1.2rem;
    text-align: center;
}

input:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(118,14,19,0.3);
}

.btn.bg-carlly {
    background-color: #760e13;
    color: #fff;
    font-weight: 600;
    border-radius: 15px;
    width: 100%;
    padding: 0.5rem;
}

.btn.bg-carlly:hover {
    background-color: #a31218;
}

#otp-container {
    display: none;
    background: #ffffff;
    border: 1px solid #e3e3e3;
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    margin-top: 15px;
    transition: 0.3s ease-in-out;
}

#otp-timer {
    color: #760e13;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.sign-up {
    text-align: center;
    margin-top: 1rem;
    font-size: 0.95rem;
}

.sign-up a {
    color: #760e13;
    font-weight: 500;
    text-decoration: none;
}

.sign-up a:hover {
    text-decoration: underline;
}

#resend-otp:disabled {
    background: #ccc !important;
    border: none;
    color: #666 !important;
}
</style>

<div class="login">
    <div class="login-form card p-4">
        <h5 class="text-center">Login</h5>
        <div id="phone-error" class="text-danger mb-2" style="display:none;"></div>

        <div id="phone-container">
            <div class="input-group mb-4">
                <span class="input-group-text">+971</span>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="5xxxxxxxx" maxlength="9" required>
            </div>
            <div id="recaptcha-container"></div>
            <button type="button" class="btn bg-carlly" onclick="sendOTP()">Send OTP</button>
        </div>

        <div id="otp-container">
            <input type="text" id="otp" maxlength="6" placeholder="Enter 6-digit OTP">
            <p id="otp-timer">OTP expires in <span id="countdown">30</span> seconds</p>
            <button type="button" class="btn bg-carlly text-white mb-2" onclick="verifyOTP()">Verify OTP</button>
            <button type="button" class="btn btn-secondary" id="resend-otp" onclick="sendOTP()" disabled>Resend OTP</button>
        </div>

        <div class="sign-up">
            Don't have an account? <a href="{{ route('register') }}">Create One</a>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth-compat.js"></script>
<script>
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

// ===== GLOBAL INTERVAL =====
let countdownInterval = null;

function isDebugMode() {
    return location.hostname.includes('localhost') || location.hostname.includes('127.0.0.1');
}

function showError(msg) { $('#phone-error').text(msg).show(); }
function hideError() { $('#phone-error').hide().text(''); }

function formatPhoneRaw() {
    let phone = $('#phone').val().trim();
    phone = phone.replace(/[\s\-\(\)]/g, '');
    if (!phone.startsWith('+')) phone = '+971' + phone.replace(/^0+/, '');
    return phone;
}

function setupReCaptcha() {
    if (!recaptchaVerifier) {
        recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', { size: 'invisible' });
        recaptchaVerifier.render().catch(() => {});
    }
}

// ===== SEND OTP =====
function sendOTP() {
    hideError();
    setupReCaptcha();
    let phoneNumber = formatPhoneRaw();
    if (!phoneNumber) { showError("Please enter phone number"); return; }

    // ===== DEV MODE FOR TEACHER =====
    const devPhone = "+971123456789"; // رقمك الشخصي بالصيغة النهائية
    if (phoneNumber === devPhone) {
        const fakeOtp = Math.floor(100000 + Math.random() * 900000).toString();
        console.log("DEV MODE OTP for", phoneNumber, ":", fakeOtp);

        lastConfirmationResult = {
            _isFake: true,
            _fakeOtp: fakeOtp,
            confirm(code) {
                return new Promise((resolve, reject) => {
                    if (code === this._fakeOtp)
                        resolve({ user: { phoneNumber, _isFake: true, getIdToken: () => Promise.resolve('FAKE_ID_TOKEN_FOR_DEV') } });
                    else reject({ message: "Invalid debug OTP" });
                });
            }
        };
        $('#phone-container').hide();
        $('#otp-container').show();
        startCountdown(30);
        return;
    }

    // ===== ORIGINAL DEBUG MODE =====
    if (isDebugMode()) {
        const fakeOtp = Math.floor(100000 + Math.random() * 900000).toString();
        console.log("Debug OTP for", phoneNumber, ":", fakeOtp);

        lastConfirmationResult = {
            _isFake: true,
            _fakeOtp: fakeOtp,
            confirm(code) {
                return new Promise((resolve, reject) => {
                    if (code === this._fakeOtp)
                        resolve({ user: { phoneNumber, _isFake: true, getIdToken: () => Promise.resolve('FAKE_ID_TOKEN_FOR_DEV') } });
                    else reject({ message: "Invalid debug OTP" });
                });
            }
        };
        $('#phone-container').hide();
        $('#otp-container').show();
        startCountdown(30);
        return;
    }

    firebase.auth().signInWithPhoneNumber(phoneNumber, recaptchaVerifier)
        .then(confirmationResult => {
            lastConfirmationResult = confirmationResult;
            $('#phone-container').hide();
            $('#otp-container').show();
            startCountdown(30);
        })
        .catch(err => { console.error(err); showError("Error sending OTP. Try again."); });
}

// ===== VERIFY OTP =====
function verifyOTP() {
    hideError();
    const code = $('#otp').val().trim();
    if (!code) return showError("Enter OTP code");
    if (!lastConfirmationResult) return showError("Please request OTP first");

    lastConfirmationResult.confirm(code)
        .then(result => handleVerifiedFirebaseUser(result.user))
        .catch(err => { console.error(err); showError("Invalid OTP"); });
}

// ===== HANDLE VERIFIED USER =====
function handleVerifiedFirebaseUser(user) {
    const phoneNumber = formatPhoneRaw();
    const token = user._isFake ? 'FAKE_ID_TOKEN_FOR_DEV' : user.getIdToken();

    $.ajax({
        url: "/verify-login-token",
        method: "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { token, phone: phoneNumber },
        xhrFields: { withCredentials: true },
        success: function(res) {
            if (res.success) {
                window.location.href = res.redirect || "/";
            } else {
                showError("Phone not registered");
            }
        },
        error: function(xhr) {
            if (xhr.responseJSON && xhr.responseJSON.error)
                showError(xhr.responseJSON.error);
            else showError("Server verification failed");
        }
    });
}

// ===== OTP TIMER =====
function startCountdown(seconds) {
    const countdownEl = $('#countdown');
    const resendBtn = $('#resend-otp');
    const otpTimerEl = $('#otp-timer');

    $('#otp-container').show();

    // Clear previous interval if exists
    if (countdownInterval) clearInterval(countdownInterval);

    resendBtn.prop('disabled', true);
    countdownEl.text(seconds);
    otpTimerEl.html(`OTP expires in <span id="countdown">${seconds}</span> seconds`);

    countdownInterval = setInterval(() => {
        seconds--;
        if (seconds > 0) {
            $('#countdown').text(seconds);
        } else {
            clearInterval(countdownInterval);
            countdownInterval = null;
            resendBtn.prop('disabled', false);
            otpTimerEl.html('OTP expired');
        }
    }, 1000);
}

</script>




@endsection
