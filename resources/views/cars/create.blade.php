@extends('layouts.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">

<style>
#car-create-page #container {
    margin:0 6%;
}

#car-create-page .card {
    border-radius: 15px;
    margin: 30px auto;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

#car-create-page .fileInput {
    min-height: 200px; 
    cursor: pointer; 
    background-color: #f5f5f5;
    border: 2px dashed #ccc;
    border-radius: 10px;
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    padding: 10px;
    gap: 10px;
    position: relative;
    overflow: hidden;
}

#car-create-page .fileInput:hover {
    background-color: #e9ecef;
    border-color: #760e13;
}

#car-create-page .fileInput img {
    cursor: pointer;
}

#car-create-page .form-control,
#car-create-page .form-select {
    border-radius: 10px;
    margin-bottom: 12px;
    box-shadow: none;
    border: 1px solid #ccc;
}

#car-create-page .form-control:focus,
#car-create-page .form-select:focus {
    border-color: #760e13;
    box-shadow: 0 0 5px rgba(118, 14, 19, 0.3);
}

#car-create-page .bootstrap-tagsinput {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border-radius: 10px;
}

#car-create-page .bootstrap-tagsinput .tag {
    background-color: #760e13;
    border-radius: 15px;
    padding: 0.2em 0.6em;
    margin-right: 0.3em;
}

#car-create-page button[type='submit'] {
    border-radius: 10px;
    background-color: #760e13;
    color: #fff;
    width: 100%;
    padding: 10px;
    font-weight: 600;
}

#car-create-page button[type='submit']:hover {
    background-color: #990f1c;
}

/* Modal for Image Preview */
#imageModal {
    display: none;
    position: fixed;
    z-index: 9999;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.8);
}

#imageModal img {
    margin: auto;
    display: block;
    max-width: 90%;
    max-height: 80%;
    border-radius: 10px;
}

#imageModal span.close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}
</style>

<div id="car-create-page">
<div id="container">
    <div class="card">

  
        <!-- Car Form -->
        <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf

            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
      <!-- Image Upload -->
        <div class="fileInput" id="fileInputContainer">
            <span id="placeholderText">Click to Upload Images</span>
        </div>
        <input type="file" id="imageInput" name="images[]" class="d-none" multiple accept="image/*">

            <div class="row g-3">
           <!-- Brand -->
<div class="col-md-6">
    <label for="brand" class="form-label">Brand</label>
    <select class="form-select" name="make" id="brand" required>
        <option value="">Select Brand</option>
        @foreach($brands as $brand)
            <option value="{{ $brand }}">{{ $brand }}</option>
        @endforeach
    </select>
</div>

<!-- Model -->
<div class="col-md-6">
    <label for="model" class="form-label">Model</label>
    <select class="form-select" name="model" id="model" disabled required>
        <option value="">Select Model</option>
    </select>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#brand').on('change', function() {
        var brandName = $(this).val();
        var modelSelect = $('#model');

        if(brandName) {
            $.ajax({
                url: "{{ route('getModels') }}",
                type: "GET",
                data: { brand: brandName },
                success: function(response) {
                    modelSelect.empty(); // فرّغ القديم
                    modelSelect.append('<option value="">Select Model</option>');
                    $.each(response.models, function(index, model) {
                        modelSelect.append('<option value="'+model+'">'+model+'</option>');
                    });
                    modelSelect.prop('disabled', false); // فعل الـ input
                }
            });
        } else {
            modelSelect.empty();
            modelSelect.append('<option value="">Select Model</option>');
            modelSelect.prop('disabled', true); // رجعها مقفولة
        }
    });
});
</script>


                <!-- Year -->
                <div class="col-md-6">
                    <label for="year" class="form-label">Year</label>
                    <input type="number" name="year" class="form-control" id="year" placeholder="Year" min="1940" max="2025" required>
                </div>

                <!-- Body Type -->
                <div class="col-md-6">
                    <label for="bodyType" class="form-label">Body Type</label>
                    <select class="form-select" name="bodyType" id="bodyType" required>
                        <option value="">Select Body Type</option>
                        @foreach($bodyTypes as $bodyType)
                            <option value="{{ $bodyType }}">{{ $bodyType }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Regional Spec -->
                <div class="col-md-6">
                    <label for="regionalSpec" class="form-label">Regional Specification</label>
                    <select class="form-select" name="regionalSpec" id="regionalSpec" required>
                        <option value="">Select Regional Spec</option>
                        @foreach($regionalSpecs as $regionalSpec)
                            <option value="{{ $regionalSpec }}">{{ $regionalSpec }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Color -->
                <div class="col-md-6">
                    <label for="color" class="form-label">Color</label>
                    <select class="form-select" name="color" id="color" required>
                        <option value="">Select Color</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->uid }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Gear -->
                <div class="col-md-6">
                    <label for="gear" class="form-label">Gear</label>
                    <select class="form-select" name="gear" id="gear" required>
                        <option value="Auto">Auto</option>
                        <option value="Manual">Manual</option>
                    </select>
                </div>

                <!-- Mileage -->
                <div class="col-md-6">
                    <label for="mileage" class="form-label">Mileage</label>
                    <input type="number" name="mileage" class="form-control" id="mileage" placeholder="Mileage" required>
                </div>

                <!-- Warranty -->
                <div class="col-md-6">
                    <label for="warranty" class="form-label">Warranty</label>
                    <select class="form-select" name="warranty" id="warranty" required>
                        <option value="Under Warranty">Under Warranty</option>
                        <option value="Not Available">Not Available</option>
                    </select>
                </div>

                <!-- Fuel Type -->
                <div class="col-md-6">
                    <label for="fuelType" class="form-label">Fuel Type</label>
                    <select class="form-select" name="fuelType" id="fuelType" required>
                        <option value="">Select Fuel Type</option>
                        <option value="Single">Single</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Electric">Electric</option>
                    </select>
                </div>
       <!-- ✅ Seats -->
                <div class="col-md-6">
                    <label for="seats" class="form-label">Seats</label>
                    <input type="number" name="seats" class="form-control" id="seats" placeholder="Number of Seats" min="1" required>
                </div>

                 <!-- Price -->
                <div class="col-md-6">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" class="form-control" id="price" placeholder="Price" value="{{ auth()->user()->price }}" required>
                </div>
                <!-- Features -->
                <div class="col-12">
                    <label for="features" class="form-label">Features</label>
                    <input type="text" name="features" class="form-control" id="features" placeholder="Features" data-role="tagsinput">
                </div>

                <!-- VIN -->
                <div class="col-12">
                    <label for="vin_number" class="form-label">VIN Number</label>
                    <input type="text" name="vin_number" class="form-control" id="vin_number" placeholder="VIN Number" required>
                </div>

                <!-- Name & Phone -->
                <div class="col-md-6">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" value="{{ auth()->user()->fname }}" required>
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" name="phone" class="form-control" id="phone" placeholder="Phone" value="{{ auth()->user()->phone }}" required>
                </div>

                <!-- Description -->
                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Description"></textarea>
                </div>

            

                <!-- Location -->
                <div class="col-12">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" id="location" placeholder="Location" value="{{ auth()->user()->location }}" required>
                </div>
            </div>

            <button type="submit" class="btn mt-3">Submit</button>
        </form>
    </div>
</div>

<!-- Modal for Image Preview -->
<div id="imageModal">
    <span class="close">&times;</span>
    <img id="modalImage" src="">
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const imageInput = document.getElementById("imageInput");
    const fileInputContainer = document.getElementById("fileInputContainer");
    let uploadedFiles = [];

    fileInputContainer.addEventListener("click", () => imageInput.click());

    function createThumbnail(file, index) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement("div");
            wrapper.style.position = "relative";
            wrapper.style.display = "inline-block";
            wrapper.style.margin = "5px";

            const img = document.createElement("img");
            img.src = e.target.result;
            img.style.width = "100px";
            img.style.height = "100px";
            img.style.objectFit = "cover";
            img.style.borderRadius = "10px";

            // Click to enlarge
            img.addEventListener("click", () => {
                document.getElementById("modalImage").src = img.src;
                document.getElementById("imageModal").style.display = "block";
            });

            const removeBtn = document.createElement("span");
            removeBtn.innerHTML = "×";
            removeBtn.style.position = "absolute";
            removeBtn.style.top = "0";
            removeBtn.style.right = "0";
            removeBtn.style.background = "rgba(0,0,0,0.6)";
            removeBtn.style.color = "#fff";
            removeBtn.style.width = "20px";
            removeBtn.style.height = "20px";
            removeBtn.style.textAlign = "center";
            removeBtn.style.cursor = "pointer";
            removeBtn.style.borderRadius = "50%";
            removeBtn.style.fontWeight = "bold";
            removeBtn.addEventListener("click", () => {
                uploadedFiles.splice(index, 1);
                wrapper.remove();
                updateInputFiles();
            });

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            fileInputContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    }

    function updateInputFiles() {
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    }

    imageInput.addEventListener("change", function(event) {
        const placeholder = document.getElementById("placeholderText");
        if (placeholder) placeholder.remove();

        [...event.target.files].forEach(file => {
            uploadedFiles.push(file);
            createThumbnail(file, uploadedFiles.length - 1);
        });

        updateInputFiles();
    });

    // Modal close
    document.querySelector("#imageModal .close").addEventListener("click", () => {
        document.getElementById("imageModal").style.display = "none";
    });

    // Make thumbnails sortable
    new Sortable(fileInputContainer, {
        animation: 150
    });
});
</script>

</div> <!-- end car-create-page -->
@endsection
