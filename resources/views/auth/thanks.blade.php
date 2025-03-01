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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
var currentStep = 3;
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