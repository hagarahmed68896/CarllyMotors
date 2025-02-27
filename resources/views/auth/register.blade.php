
<html>

<head>
    <title>Laravel Phone Number Authentication using Firebase - raviyatechnical</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

    <div>
        <input type="text" id="phone" placeholder="Enter phone number">
        <button onclick="sendOTP()">Send OTP</button>
        <div id="recaptcha-container"></div>
        <p id="otp-timer">OTP expires in <span id="countdown">60</span> seconds</p>
        <button id="resend-otp" onclick="sendOTP()" disabled>Resend OTP</button>

        <input type="text" id="otp" placeholder="Enter OTP">
        <button onclick="verifyOTP()">Verify OTP</button>

        <div id="recaptcha-container"></div>
    </div>

    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth-compat.js"></script>

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
    </script>



</body>

</html>