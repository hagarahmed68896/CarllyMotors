@extends('layouts.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
  <!-- Scripts -->
    <!-- Swiper + Sortable (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
    #car-create-page #container {
        margin: 0 6%;
    }

    #car-create-page .card {
        border-radius: 15px;
        margin: 30px auto;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
        background-color: rgba(0, 0, 0, 0.8);
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
<style>
    .upload-section {
        width: 100%;
    }

    .fileInput {
        border: 2px dashed #ccc;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        cursor: pointer;
        background-color: #fafafa;
        transition: all 0.3s ease;
    }

    .fileInput:hover {
        border-color: #888;
        background-color: #f0f0f0;
    }

    .fileInput i {
        display: block;
        margin-bottom: 8px;
        font-size: 28px;
    }

    /* Grid layout */
    .image-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 10px;
        margin-top: 15px;
    }

    .image-grid div {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
    }

    .image-grid img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.2s ease;
        cursor: pointer;
    }

    .image-grid img:hover {
        transform: scale(1.05);
    }

    .image-grid span.remove-btn {
        position: absolute;
        top: 4px;
        right: 4px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        cursor: pointer;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        /* adjust if needed */
    }


    /* Modal styling */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.9);
    }

    .image-modal img {
        margin: auto;
        display: block;
        max-width: 90%;
        max-height: 80%;
        border-radius: 10px;
    }

    .image-modal .close {
        position: absolute;
        top: 15px;
        right: 25px;
        color: #fff;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
    }
</style>
<style>
    /* Highlight selected spec option */
    .spec-option.selected {
        border: 2px solid #760e13;
        background-color: #f8eaea;
    }
</style>
{{-- <style>
    /* Compact Input Style */
    .feature-input-group {
        background: #fff;
        transition: box-shadow 0.2s ease;
    }

    .feature-input-group:focus-within {
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.15);
    }

    /* Feature Tags */
    .feature-tag {
        background: #f2eeee;
        border: 1px solid #5a0b0f;
        border-radius: 20px;
        padding: 4px 10px;
        display: inline-flex;
        align-items: center;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .feature-tag:hover {
        background: #f2eaea;
        transform: translateY(-1px);
    }

    /* Remove Icon */
    .feature-tag i {
        margin-left: 6px;
        cursor: pointer;
        font-size: 0.8rem;
        color: #6c757d;
        transition: color 0.2s;
    }

    .feature-tag i:hover {
        color: #dc3545;
    }
</style> --}}
<style>
    .spec-icon {
        width: 70px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .spec-icon:hover {
        transform: translateY(-3px);
    }

    .spec-icon i {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 12px;
        width: 50px;
        height: 50px;
        line-height: 26px;
    }
</style>
<style>
    /* Highlight selected option */
    .spec-option.selected {
        background-color: #f8eaea;
        border-left: 4px solid #760e13;
        font-weight: 500;
        color: #760e13;
        cursor: pointer;
    }

    /* Add pointer cursor for all options */
    .spec-option {
        cursor: pointer;
    }
</style>
<style>
                        /* إبراز اللون المختار */
                        .color-option.selected {
                            border-color: #760e13;
                            background-color: #f8f0f0;
                        }
</style>
<div id="car-create-page">
    <div id="container">
        <h2 class="mb-4 mt-2 text-center fw-bold" style="color:#760e13;">Edit Your Car</h2>
        <div class="card">
     <!-- Car Edit Form -->
<form id="carForm" enctype="multipart/form-data" class="mt-4">
    @csrf
    @method('PUT') <!-- Important for Laravel route -->
    
<div id="formErrors" class="alert alert-danger d-none"></div>

    <input type="hidden" name="user_id" value="{{ $car->user_id }}">

<!-- Image Upload -->
<div class="upload-section w-100">
    <div class="fileInput w-100 text-center py-4 border rounded-3" id="fileInputContainer"
        style="cursor: pointer; border: 2px dashed #ced4da;">
        <i class="fas fa-camera fa-2x text-secondary"></i>
        <span id="placeholderText" class="text-muted fw-semibold d-block mt-2">Add Image</span>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-2">
        <span id="imageCount" class="text-muted small">0 / 8</span>
        <span id="errorMessage" class="text-danger small fw-semibold"></span>
    </div>

    <input type="file" id="imageInput" name="images[]" accept="image/*" multiple hidden>

    <div id="previewContainer" class="image-grid mt-3 d-flex flex-wrap">
        @php
            $images = $car->images ? $car->images->map(fn($img) => env('CLOUDFLARE_R2_URL') . $img->image)->toArray() : [];
        @endphp

        @foreach($images as $index => $img)
            <div class="existing-image position-relative me-2 mb-2" style="cursor:pointer;">
                <img src="{{ $img }}" alt="Car Image"
                    style="width:100px; height:100px; object-fit:cover;" class="rounded viewable-image">
                <input type="hidden" name="existing_images[]" value="{{ $car->images[$index]->id }}">
                <span class="remove-btn remove-existing" data-id="{{ $car->images[$index]->id }}">×</span>
            </div>
        @endforeach
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="image-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
    background-color: rgba(0,0,0,0.8); justify-content:center; align-items:center; z-index:9999;">
    <span class="close" style="position:absolute; top:10px; right:20px; color:white; font-size:2rem; cursor:pointer;">&times;</span>
    <img id="modalImage" alt="Preview" style="max-width:90%; max-height:90%; border-radius:8px;">
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const imageInput = document.getElementById("imageInput");
    const fileInputContainer = document.getElementById("fileInputContainer");
    const previewContainer = document.getElementById("previewContainer");
    const errorMessage = document.getElementById("errorMessage");
    const imageCount = document.getElementById("imageCount");

    const imageModal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    const modalClose = imageModal.querySelector(".close");

    let uploadedFiles = [];

    // CSS class for first image cover
    const coverClass = "first-cover";

    // فتح نافذة اختيار الصور عند الضغط على الصندوق
    fileInputContainer.addEventListener("click", () => imageInput.click());

    function updateImageCount() {
        const existingImages = document.querySelectorAll('.existing-image, .new-image').length;
        imageCount.textContent = `${existingImages} / 8`;
        markFirstAsCover();
    }

    // Mark first image as cover visually
    function markFirstAsCover() {
        const allImages = previewContainer.querySelectorAll('.existing-image, .new-image');
        allImages.forEach(div => div.classList.remove(coverClass));
        if(allImages.length > 0) allImages[0].classList.add(coverClass);
    }

    function createThumbnail(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const wrapper = document.createElement("div");
            wrapper.className = "new-image position-relative me-2 mb-2";
            wrapper.style.cursor = "pointer";

            const img = document.createElement("img");
            img.src = e.target.result;
            img.style.width = "100px";
            img.style.height = "100px";
            img.style.objectFit = "cover";
            img.classList.add("rounded", "viewable-image");

            // Open modal on click
            img.addEventListener("click", () => {
                modalImage.src = e.target.result;
                imageModal.style.display = "flex";
            });

            // Remove button
            const removeBtn = document.createElement("span");
            removeBtn.classList.add("remove-btn");
            removeBtn.textContent = "×";
            removeBtn.style.cssText = "position:absolute; top:2px; right:3px; cursor:pointer;";
            removeBtn.addEventListener("click", (ev) => {
                ev.stopPropagation();
                const index = uploadedFiles.indexOf(file);
                if(index > -1) uploadedFiles.splice(index,1);
                wrapper.remove();
                updateImageCount();
                updateInputFiles();
            });

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            previewContainer.appendChild(wrapper);

            updateImageCount();
        };
        reader.readAsDataURL(file);
    }

    function updateInputFiles() {
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    }

    // Handle new uploads
    imageInput.addEventListener("change", function(event) {
        const remaining = 8 - (uploadedFiles.length + document.querySelectorAll('.existing-image').length);
        const newFiles = [...event.target.files].slice(0, remaining);

        newFiles.forEach(file => {
            uploadedFiles.push(file);
            createThumbnail(file);
        });

        if(event.target.files.length > remaining) {
            errorMessage.textContent = "⚠️ You can upload up to 8 images only.";
        } else {
            errorMessage.textContent = "";
        }

        updateInputFiles();
    });

    // Remove existing images
    document.querySelectorAll(".remove-existing").forEach(btn => {
        btn.addEventListener("click", function() {
            btn.closest('.existing-image').remove();
            updateImageCount();
        });
    });

    // Open modal for existing images
    document.querySelectorAll(".viewable-image").forEach(img => {
        img.addEventListener("click", () => {
            modalImage.src = img.src;
            imageModal.style.display = "flex";
        });
    });

    // Close modal
    modalClose.addEventListener("click", () => imageModal.style.display = "none");
    imageModal.addEventListener("click", (e) => {
        if(e.target === imageModal) imageModal.style.display = "none";
    });

    // Initial setup
    updateImageCount();
});
</script>

<style>
/* First image as cover */
.first-cover {
    border: 3px solid #0d6efd;
    position: relative;
}

.first-cover::after {
    content: "Cover";
    position: absolute;
    bottom: 5px;
    left: 5px;
    background: #0d6efd;
    color: white;
    font-size: 0.75rem;
    padding: 2px 4px;
    border-radius: 3px;
}
</style>






    <!-- Car Details -->
    <div class="row g-3">
        <!-- Brand -->
        <div class="col-md-12">
            <label for="brand" class="form-label">Brand</label>
       <select name="make" id="brand" class="form-select" required>
    <option value="">Select Brand</option>
@foreach($brands as $brand)
    <option value="{{ $brand }}" {{ strtolower(trim($car->listing_type)) == strtolower(trim($brand)) ? 'selected' : '' }}>
        {{ $brand }}
    </option>
@endforeach

@if($car->listing_type && !in_array($car->listing_type, $brands))
    <option value="{{ $car->listing_type }}" selected>{{ $car->listing_type }} (Old)</option>
@endif


    @if($car->make && !in_array($car->make, $brands))
        <option value="{{ $car->make }}" selected>{{ $car->make }} (Old)</option>
    @endif
</select>

        </div>

        <!-- Model -->
<div class="col-md-6">
    <label for="model" class="form-label">Model</label>
    <select class="form-select" name="model" id="model" required disabled>
        {{-- هنا نكتفي بخيار واحد فارغ أو بقيمة placeholder حتى يقوم AJAX بتحميل الخيارات --}}
        <option value="">Select Model</option>
    </select>
</div>

        <!-- Year -->
<div class="col-md-6">
    <label for="year" class="form-label">Year</label>
    @php
        $currentYear = date('Y') + 1; // السنة القادمة
        $years = range($currentYear, 1990);
    @endphp

    <select class="form-select" name="year" id="year" required>
        <option value="">Select Year</option>

        @foreach($years as $year)
            <option value="{{ $year }}" {{ $car->listing_year == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endforeach

    </select>
</div>


        <!-- Body Type -->
        <div class="col-md-6">
            <label for="bodyType" class="form-label">Body Type</label>
          <select class="form-select" name="bodyType" id="bodyType" required>
    <option value="">Select Body Type</option>
@foreach($bodyTypes as $bodyType)
    <option value="{{ $bodyType }}" {{ trim($car->body_type) == trim($bodyType) ? 'selected' : '' }}>
        {{ $bodyType }}
    </option>
@endforeach

@if(!in_array($car->body_type, $bodyTypesArray) && $car->body_type)
    <option value="{{ $car->body_type }}" selected>{{ $car->body_type }} (Old)</option>
@endif

</select>

        </div>

        <!-- Regional Spec -->
        <div class="col-md-6">
            <label for="regionalSpec" class="form-label">Regional Specification</label>
            <select class="form-select" name="regionalSpec" id="regionalSpec" required>
                <option value="">Select Regional Spec</option>
           @foreach($regionalSpecs as $regionalSpec)
    <option value="{{ $regionalSpec }}" {{ trim($car->regional_specs) == trim($regionalSpec) ? 'selected' : '' }}>
        {{ $regionalSpec }}
    </option>
@endforeach

            </select>
        </div>

        <!-- 🏙️ City -->
        <div class="col-md-6">
            <label for="city" class="form-label">City</label>
            @php
                $uaeCities = [
                    'Dubai',
                    'Abu Dhabi',
                    'Sharjah',
                    'Ras Al Khaimah',
                    'Fujairah',
                    'Ajman',
                    'Umm Al Quwain',
                    'Al Ain',
                ];
                sort($uaeCities);
            @endphp
            <select class="form-select" name="city" id="city" required>
                <option value="">Select City</option>
                @foreach($uaeCities as $city)
                <option value="{{ $city }}" {{ $car->city == $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>
        </div>

        <!-- VIN -->
        <div class="col-md-6">
            <label for="vin_number" class="form-label">VIN Number</label>
            <input type="text" name="vin_number" class="form-control" id="vin_number"
                placeholder="VIN Number" value="{{ $car->vin_number }}" >
        </div>

<!-- Price -->
<div class="col-12 position-relative">
    <label for="price" class="form-label">Price</label>
    <input type="text" name="price" class="form-control pe-5" id="price"
           placeholder="Enter Price" value="{{ old('price', $car->listing_price ?? '') }}" required>
    <img src="{{ asset('assets/images/UAE_Dirham_Symbol.svg.png') }}" alt="AED"
         width="18" height="18" style="top: 50px;"
         class="position-absolute end-0 translate-middle-y me-3 opacity-75">
</div>


<!-- 🚘 Features -->
<div class="col-12">
  <label for="features" class="form-label fw-semibold">Features</label>

  <div class="input-group feature-input-group shadow-sm rounded-3 overflow-hidden" style="height: 38px;">
    <input type="text" id="featureInput" class="form-control ps-3 py-1 h-100"
      placeholder="Add a feature..."
      style="font-size: 0.95rem; border-top-right-radius: 0; border-bottom-right-radius: 0;">
    <button type="button" id="addFeatureBtn"
      class="btn border-0 px-3 h-100 d-flex align-items-center justify-content-center"
      style="background-color: #f8f9fa; color: #760e13; border-left: 1px solid #ced4da;">
      <i class="fas fa-plus"></i>
    </button>
  </div>

  <!-- Container for feature tags -->
  <div id="featureContainer" class="mt-2 d-flex flex-wrap gap-2"></div>

  <!-- Hidden input -->
  @php
    $featuresValue = $car->features_others ?? '[]';
    if (is_array($featuresValue)) {
        $featuresValue = json_encode($featuresValue);
    }
  @endphp

  <input type="hidden" name="features" id="featuresHidden"
         value='{!! $featuresValue !!}'>
</div>

<!-- ===================== FEATURES SCRIPT ===================== -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const input = document.getElementById("featureInput");
  const addBtn = document.getElementById("addFeatureBtn");
  const container = document.getElementById("featureContainer");
  const hidden = document.getElementById("featuresHidden");

  let features = [];

  // 🟢 Parse old features correctly
  try {
    features = JSON.parse(hidden.value);
    if (!Array.isArray(features)) throw new Error();
  } catch {
    features = hidden.value.split(',').map(f => f.trim()).filter(f => f);
  }

  const updateHidden = () => {
    hidden.value = JSON.stringify(features);
  };

  const createTag = (text) => {
    const tag = document.createElement("span");
    tag.className = "feature-tag";
    tag.innerHTML = `
      ${text}
      <i class="fas fa-times remove-feature"></i>
    `;
    tag.querySelector(".remove-feature").addEventListener("click", () => {
      features = features.filter(f => f !== text);
      tag.remove();
      updateHidden();
    });
    return tag;
  };

  // 🟢 Display existing features
  features.forEach(f => {
    if (f) container.appendChild(createTag(f));
  });
  updateHidden();

  // 🟢 Add new feature
  const addFeature = () => {
    const value = input.value.trim();
    if (!value || features.includes(value)) return;
    features.push(value);
    container.appendChild(createTag(value));
    updateHidden();
    input.value = "";
  };

  addBtn.addEventListener("click", addFeature);
  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      addFeature();
    }
  });
});
</script>

<!-- ===================== FEATURES STYLE ===================== -->
<style>
  /* Compact Input Style */
  .feature-input-group {
      background: #fff;
      transition: box-shadow 0.2s ease;
  }

  .feature-input-group:focus-within {
      box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.15);
  }

  /* Feature Tags */
  .feature-tag {
      background: #f2eeee;
      border: 1px solid #5a0b0f;
      border-radius: 20px;
      padding: 4px 10px;
      display: inline-flex;
      align-items: center;
      font-size: 0.85rem;
      font-weight: 500;
      transition: all 0.2s ease;
  }

  .feature-tag:hover {
      background: #f2eaea;
      transform: translateY(-1px);
  }

  /* Remove Icon */
  .feature-tag i {
      margin-left: 6px;
      cursor: pointer;
      font-size: 0.8rem;
      color: #6c757d;
      transition: color 0.2s;
  }

  .feature-tag i:hover {
      color: #dc3545;
  }
</style>



       
                    <!-- 🚗 Specifications -->
                    <div class="col-12 mt-3">
                        <label class="form-label fw-semibold">Specifications</label>
                        <div class="d-flex flex-wrap gap-3">
                            <!-- Gear -->
                            <div class="spec-icon text-center" data-bs-toggle="modal" data-bs-target="#gearModal">
                                <i class="fas fa-cogs fa-2x text-primary"></i>
                                <div class="small mt-1">Gear</div>
                            </div>
                            <!-- Mileage -->
                            <div class="spec-icon text-center" data-bs-toggle="modal" data-bs-target="#mileageModal">
                                <i class="fas fa-tachometer-alt fa-2x text-success"></i>
                                <div class="small mt-1">Mileage</div>
                            </div>
                            <!-- Color -->
                            <div class="spec-icon text-center" data-bs-toggle="modal" data-bs-target="#colorModal">
                                <i class="fas fa-palette fa-2x text-warning"></i>
                                <div class="small mt-1">Color</div>
                            </div>
                            <!-- Warranty -->
                            <div class="spec-icon text-center" data-bs-toggle="modal" data-bs-target="#warrantyModal">
                                <i class="fas fa-shield-alt fa-2x text-info"></i>
                                <div class="small mt-1">Warranty</div>
                            </div>
                            <!-- Fuel Type -->
                            <div class="spec-icon text-center" data-bs-toggle="modal" data-bs-target="#fuelModal">
                                <i class="fas fa-gas-pump fa-2x text-danger"></i>
                                <div class="small mt-1">Fuel</div>
                            </div>
                            <!-- Seats -->
                            <div class="spec-icon text-center" data-bs-toggle="modal" data-bs-target="#seatsModal">
                                <i class="fas fa-chair fa-2x text-secondary"></i>
                                <div class="small mt-1">Seats</div>
                            </div>
                            <!-- Doors -->
<div class="spec-icon text-center" data-bs-toggle="modal" data-bs-target="#doorsModal">
    <i class="fas fa-door-closed fa-2x text-dark"></i>
    <div class="small mt-1">Doors</div>
</div>

                            @if(session('spec_error'))
<div class="alert alert-danger mt-2">
    {{ session('spec_error') }}
</div>
@endif
                        </div>
                    </div>

                    <!-- Modals -->
                    <!-- Gear Modal -->
                    <div class="modal fade" id="gearModal" tabindex="-1" aria-labelledby="gearModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="gearModalLabel">Select Gear</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item spec-option" data-spec="gear" data-value="Auto">Auto
                                        </li>
                                        <li class="list-group-item spec-option" data-spec="gear" data-value="Manual">
                                            Manual</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Mileage Modal -->
                    <div class="modal fade" id="mileageModal" tabindex="-1" aria-labelledby="mileageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mileageModalLabel">Enter Mileage</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="number" id="mileageInput" class="form-control"
                                        placeholder="Mileage in KM">
                                    <button type="button" style="background-color: #760e13; color: white;"
                                        class="btn mt-2" id="saveMileageBtn">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden input -->
                    {{-- <input type="hidden" name="color" id="colorInput"> --}}

                    <!-- Color Modal -->
                    <div class="modal fade" id="colorModal" tabindex="-1" aria-labelledby="colorModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="colorModalLabel">Select Color</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body d-flex flex-column gap-2">
                                    @foreach($colors as $color)
                         <div class="color-option spec-option d-flex align-items-center gap-2 p-2 rounded"
     data-spec="color" 
     data-value="{{ $color->uid }}" 
     data-text="{{ $color->name }}"   
     style="border: 1px solid #ccc; cursor: pointer;">
    <span style="width: 20px; height: 20px; border-radius: 50%; background-color: {{ $color->code }}; border: 1px solid #aaa;"></span>
    <span>{{ $color->name }}</span>
</div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Script -->
               <script>
document.addEventListener("DOMContentLoaded", function () {
    const colorInput = document.getElementById("colorInput");
    const colorLabel = document.getElementById("colorLabel");

    // عند فتح الصفحة، عرض الاسم المخزن تحت الأيقونة
    if (colorInput.value) {
        const selectedOption = document.querySelector(`#colorModal .color-option[data-value="${colorInput.value}"]`);
        if (selectedOption) {
            selectedOption.classList.add("selected");
            colorLabel.innerText = selectedOption.dataset.text; // عرض الاسم
        }
    }

    // عند اختيار اللون
    document.querySelectorAll("#colorModal .color-option").forEach(option => {
        option.addEventListener("click", function () {
            const uid  = this.dataset.value;
            const name = this.dataset.text;

            // خزّن الـ ID في الهيدن
            colorInput.value = uid;

            // عرض الاسم تحت الأيقونة
            colorLabel.innerText = name;

            // فعّل اختيار اللون الحالي
            document.querySelectorAll("#colorModal .color-option")
                .forEach(el => el.classList.remove("selected"));
            this.classList.add("selected");

            // اقفل المودال
            const modal = bootstrap.Modal.getInstance(document.getElementById("colorModal"));
            modal.hide();
        });
    });
});
</script>


                    <!-- Warranty Modal -->
                    <div class="modal fade" id="warrantyModal" tabindex="-1" aria-labelledby="warrantyModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="warrantyModalLabel">Select Warranty</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item spec-option" data-spec="warranty"
                                            data-value="Under Warranty" style="cursor:pointer;">
                                            Under Warranty
                                        </li>
                                        <li class="list-group-item spec-option" data-spec="warranty"
                                            data-value="Not Available" style="cursor:pointer;">
                                            Not Available
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Fuel Modal -->
                    <div class="modal fade" id="fuelModal" tabindex="-1" aria-labelledby="fuelModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="fuelModalLabel">Select Fuel Type</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item spec-option" data-spec="fuel" data-value="Single"
                                            style="cursor:pointer;">
                                            Single
                                        </li>
                                        <li class="list-group-item spec-option" data-spec="fuel" data-value="Hybrid"
                                            style="cursor:pointer;">
                                            Hybrid
                                        </li>
                                        <li class="list-group-item spec-option" data-spec="fuel" data-value="Electric"
                                            style="cursor:pointer;">
                                            Electric
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Seats Modal -->
                    <div class="modal fade" id="seatsModal" tabindex="-1" aria-labelledby="seatsModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="seatsModalLabel">Select Number of Seats</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-0" style="max-height: 300px; overflow-y: auto;">
                                    <ul class="list-group list-group-flush">
                                        @for($i = 1; $i <= 14; $i++) <li class="list-group-item spec-option"
                                            data-spec="seats" data-value="{{ $i }}" style="cursor:pointer;">
                                            {{ $i }}
                                            </li>
                                            @endfor
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
<!-- Doors Modal -->
<div class="modal fade" id="doorsModal" tabindex="-1" aria-labelledby="doorsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doorsModalLabel">Select Number of Doors</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0" style="max-height: 300px; overflow-y: auto;">
                <ul class="list-group list-group-flush">
                    @for($i = 1; $i <= 6; $i++)
                        <li class="list-group-item spec-option" data-spec="doors" data-value="{{ $i }}" style="cursor:pointer;">
                            {{ $i }}
                        </li>
                    @endfor
                </ul>
            </div>
        </div>
    </div>
</div>


             <!-- Hidden inputs for specs (edit mode) -->
<!-- Hidden Inputs -->
<input type="hidden" name="gear" id="gearInput" value="{{ old('gear', $car->features_gear ?? '') }}">
<input type="hidden" name="mileage" id="mileageHidden" value="{{ old('mileage', $car->features_speed ?? '') }}">
<input type="hidden" name="color" id="colorInput" value="{{ old('color', $car->car_color ?? '') }}">
<input type="hidden" name="warranty" id="warrantyInput" value="{{ old('warranty', $car->features_climate_zone ?? '') }}">
<input type="hidden" name="fuelType" id="fuelInput" value="{{ old('fuelType', $car->features_fuel_type ?? '') }}">
<input type="hidden" name="seats" id="seatsInput" value="{{ old('seats', $car->features_seats ?? '') }}">
<input type="hidden" name="door" id="doorsInput" value="{{ old('door', $car->features_door ?? '') }}">

<script>
document.addEventListener("DOMContentLoaded", function () {
    const specs = {
        gear: document.getElementById("gearInput"),
        color: document.getElementById("colorInput"),
        warranty: document.getElementById("warrantyInput"),
        fuel: document.getElementById("fuelInput"),
        seats: document.getElementById("seatsInput"),
        doors: document.getElementById("doorsInput"),  

    };
    const mileageHidden = document.getElementById("mileageHidden");

    const oldValues = {
        gear: @json(old('gear', $car->features_gear ?? '')),
        color: @json(old('color', $car->car_color ?? '')),
        warranty: @json(old('warranty', $car->features_climate_zone ?? '')),
        fuel: @json(old('fuelType', $car->features_fuel_type ?? '')),
        seats: @json(old('seats', $car->features_seats ?? '')),
        mileage: @json(old('mileage', $car->features_speed ?? '')),
        doors: @json(old('door', $car->features_door ?? '')),  

    };

    // Assign saved values
    for (const key in specs) specs[key].value = oldValues[key] || '';
    mileageHidden.value = oldValues.mileage || '';

    function updateSelection(spec) {
        const value = spec === 'mileage' ? mileageHidden.value : specs[spec]?.value;
        document.querySelectorAll(`#${spec}Modal .spec-option`).forEach(btn => {
            btn.classList.toggle("selected", btn.dataset.value == value);
        });
    }

    function updateIconLabels() {
        const labels = {
            gear: "Gear",
            mileage: "Mileage",
            color: "Color",
            warranty: "Warranty",
            fuel: "Fuel",
            seats: "Seats",
            doors: "Doors",
        };
        Object.keys(labels).forEach(spec => {
            let value = spec === "mileage" ? mileageHidden.value : specs[spec]?.value;
            if(spec === 'color') {
                // اللون: اعرض الاسم بدل الـ ID
                const selectedOption = document.querySelector(`#colorModal .color-option[data-value="${value}"]`);
                if(selectedOption) value = selectedOption.dataset.text;
            }
            const iconLabel = document.querySelector(`.spec-icon[data-bs-target="#${spec}Modal"] .small`);
            if (iconLabel) iconLabel.textContent = value || labels[spec];
        });
    }

    // Apply selection once DOM ready
    setTimeout(() => {
        Object.keys(specs).forEach(spec => updateSelection(spec));
        updateSelection("mileage");
        updateIconLabels();
    }, 100);

    // When opening a modal
    Object.keys(specs).forEach(spec => {
        const modalEl = document.getElementById(`${spec}Modal`);
        if (modalEl) {
            modalEl.addEventListener("show.bs.modal", () => updateSelection(spec));
        }
    });
    document.getElementById("mileageModal").addEventListener("show.bs.modal", () => {
        document.getElementById("mileageInput").value = mileageHidden.value;
    });

    // Option click
    document.querySelectorAll(".spec-option").forEach(btn => {
        btn.addEventListener("click", function () {
            const spec = this.dataset.spec;
            const value = this.dataset.value;
            if (spec === "mileage") return;
            if (specs[spec]) specs[spec].value = value;
            updateSelection(spec);
            updateIconLabels();
            const modal = bootstrap.Modal.getInstance(this.closest(".modal"));
            if (modal) modal.hide();
        });
    });

    // Mileage save
    document.getElementById("saveMileageBtn").addEventListener("click", () => {
        const mileageInput = document.getElementById("mileageInput");
        mileageHidden.value = mileageInput.value;
        updateSelection("mileage");
        updateIconLabels();
        const modal = bootstrap.Modal.getInstance(document.getElementById("mileageModal"));
        if (modal) modal.hide();
    });
});
</script>


<!-- Name & Phone -->
<!-- Name Input (readonly) -->
<div class="col-md-12">
    <label for="name" class="form-label">Name</label>
    <input type="text" 
           name="name" 
           class="form-control" 
           id="name"
           placeholder="Name"
           value="" 
           readonly
           required>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const brandSelect = document.getElementById('brand');
    const modelSelect = document.getElementById('model');
    const nameInput = document.getElementById('name');

    function updateName() {
        const brand = brandSelect.value || '';
        const model = modelSelect.value || '';
        if (brand && model) {
            nameInput.value = `${brand} ${model}`;
        } else if (brand) {
            nameInput.value = brand;
        } else {
            nameInput.value = '';
        }
    }

    // Event listeners
    brandSelect.addEventListener('change', function() {
        // If your model select is populated dynamically based on brand,
        // make sure to call updateName after it's populated
        // Example: populateModelOptions(brandSelect.value, updateName);
        updateName();
    });
    modelSelect.addEventListener('change', updateName);

    // For edit page: wait until model value is set
    const checkModelReady = setInterval(function() {
        if (modelSelect.value) {
            updateName();
            clearInterval(checkModelReady);
        }
    }, 50);

    // Call updateName in case both selects already have values (edit page)
    updateName();
});
</script>





<div class="col-md-6">
    <label class="form-label">Contact Number</label>
    <div class="input-group">
        <span class="input-group-text">+971</span>
        <input 
            type="tel" 
            name="contact_number" 
            class="form-control" 
            placeholder="Enter Phone number"
            maxlength="9"
            value="{{ old('contact_number', str_replace('+971', '', $car->contact_number)) }}"
        >
    </div>
</div>

<div class="col-md-6 mt-3">
    <label class="form-label">WhatsApp Number</label>
    <div class="input-group">
        <span class="input-group-text">+971</span>
        <input 
            type="tel" 
            name="wa_number" 
            class="form-control" 
            placeholder="Enter WhatsApp number"
            maxlength="9"
            value="{{ old('wa_number', str_replace('+971', '', $car->wa_number)) }}"
        >
    </div>
</div>

<style>
.input-group .input-group-text,
.input-group .form-control {
    border-radius: 0;
    height: 42px;
}

.input-group .input-group-text:first-child {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    border-right: none;
}

.input-group .form-control {
    border-left: none;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const phoneInputs = document.querySelectorAll('input[name="contact_number"], input[name="wa_number"]');

    phoneInputs.forEach(input => {

        input.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');

            if (this.value.length > 9) {
                this.value = this.value.slice(0, 9);
            }
        });

    });
});
</script>

<!-- Description -->
<div class="col-12">
    <label for="description" class="form-label">Description</label>
    <textarea name="description" class="form-control" id="description" placeholder="Description">{{ old('description', $car->listing_desc ?? '') }}</textarea>
</div>






<!-- Location Input -->
<div class="col-12">
    <label for="location" class="form-label">Location</label>
    <div class="input-group">
        <input type="text" name="location" class="form-control" id="location" 
               placeholder="Select Location" readonly
               value="{{ old('location', $car->location_name ?? '') }}" required>
        <button type="button" class="btn btn-outline-secondary" id="clearLocationBtn">Clear</button>
    </div>

    <style>
        .input-group .form-control,
        .input-group .btn {
            height: 42px;
            padding: 0.375rem 0.75rem;
        }
    </style>

    <!-- Hidden fields for lat & lng -->
    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $car->lat ?? '') }}">
    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $car->lng ?? '') }}">
</div>

<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mapModalLabel">Pick Location</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" style="height: 400px;">
        <div id="map" style="height: 100%; width: 100%;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="saveLocationBtn">Save Location</button>
      </div>
    </div>
  </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map, marker;
const locationInput = document.getElementById('location');
const latInput = document.getElementById('latitude');
const lngInput = document.getElementById('longitude');

// 🟢 Populate input on page load if empty
document.addEventListener('DOMContentLoaded', function() {
    const lat = parseFloat(latInput.value);
    const lng = parseFloat(lngInput.value);

    if (!locationInput.value && !isNaN(lat) && !isNaN(lng)) {
        // Reverse geocode to get location name
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                if (data.address) {
                    const { city, town, village, state, country } = data.address;
                    locationInput.value = [city || town || village, state, country].filter(Boolean).join(', ');
                } else {
                    locationInput.value = `Lat: ${lat.toFixed(5)}, Lng: ${lng.toFixed(5)}`;
                }
            })
            .catch(() => {
                locationInput.value = `Lat: ${lat.toFixed(5)}, Lng: ${lng.toFixed(5)}`;
            });
    }
});

// Open map on input click
locationInput.addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('mapModal'));
    modal.show();

    setTimeout(() => {
        let lat = parseFloat(latInput.value) || 25.276987;
        let lng = parseFloat(lngInput.value) || 55.296249;

        if (!map) {
            map = L.map('map').setView([lat, lng], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Add marker if old coordinates exist
            if (!isNaN(latInput.value) && !isNaN(lngInput.value)) {
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            }

            map.on('click', function(e) {
                const { lat, lng } = e.latlng;
                if (marker) marker.setLatLng([lat, lng]);
                else marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            });
        } else {
            if (marker) map.setView(marker.getLatLng(), 10);
        }
    }, 200);
});

// Clear location
document.getElementById('clearLocationBtn').addEventListener('click', function() {
    locationInput.value = '';
    latInput.value = '';
    lngInput.value = '';
    if (marker) {
        map.removeLayer(marker);
        marker = null;
    }
});

// Save location
document.getElementById('saveLocationBtn').addEventListener('click', function() {
    if (marker) {
        const pos = marker.getLatLng();
        latInput.value = pos.lat;
        lngInput.value = pos.lng;

        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${pos.lat}&lon=${pos.lng}`)
            .then(res => res.json())
            .then(data => {
                if (data.address) {
                    const { city, town, village, state, country } = data.address;
                    locationInput.value = [city || town || village, state, country].filter(Boolean).join(', ');
                } else {
                    locationInput.value = `Lat: ${pos.lat.toFixed(5)}, Lng: ${pos.lng.toFixed(5)}`;
                }
            })
            .catch(() => {
                locationInput.value = `Lat: ${pos.lat.toFixed(5)}, Lng: ${pos.lng.toFixed(5)}`;
            });
    }
    bootstrap.Modal.getInstance(document.getElementById('mapModal')).hide();
});
</script>



    </div>

    <button type="submit" class="btn mt-3">Update</button>
</form>

        </div>
    </div>

<!-- ===================== BRAND / MODEL SCRIPT ===================== -->
<script>
$(document).ready(function() {
    const brandSelect = $('#brand');
    const modelSelect = $('#model');
    const yearSelect = $('#year');
    
    // 🚨 القيم الحالية للسيارة في وضع التعديل (يجب أن تكون موجودة في Blade)
    const existingBrand = "{{ $car->listing_type ?? '' }}"; 
    const existingModel = "{{ $car->listing_model ?? '' }}";
    const existingYear = "{{ $car->listing_year ?? '' }}"; // القيمة المحفوظة للسنة

    // ✅ دالة تحميل الموديلات (تعمل عند تغيير الماركة أو تحميل الصفحة)
    brandSelect.on('change', function() {
        const brandName = $(this).val();
        
        // 1. مسح وإعادة تعيين حقل الموديل
        modelSelect.empty().append('<option value="">Select Model</option>');
        
        // 2. 💡 نقطة الحل: منع مسح قيمة السنة إذا كنا في وضع التعديل (existingBrand) 
        // ولم يتم اختيار ماركة جديدة يدوياً.
        if (brandName !== existingBrand) {
            yearSelect.val(''); // يتم المسح فقط عند اختيار ماركة مختلفة
        }
        
        if (brandName) {
            $.ajax({
                url: "{{ route('getModels') }}",
                type: "GET",
                data: { brand: brandName },
                success: function(response) {
                    
                    // 3. ملء قائمة الموديلات الجديدة
                    $.each(response.models, function(index, model) {
                        modelSelect.append('<option value="'+model+'">'+model+'</option>');
                    });
                    
                    // 4. تهيئة الموديل القديم بعد تحميل الخيارات
                    if (existingModel && brandName === existingBrand) {
                        modelSelect.val(existingModel);
                    }

                    // 5. 💡 نقطة الحل 2: إعادة تعيين قيمة السنة القديمة (للتأكيد بعد أي مسح محتمل)
                    if (existingYear && brandName === existingBrand) {
                        yearSelect.val(existingYear);
                    }
                    
                    modelSelect.prop('disabled', false);
                    yearSelect.prop('disabled', false);
                },
                error: function() {
                    console.error("Failed to load models.");
                    modelSelect.prop('disabled', true);
                }
            });
        } else {
            // حالة عدم اختيار ماركة
            modelSelect.prop('disabled', true);
            yearSelect.prop('disabled', true);
        }
    });

    // ✅ تهيئة الصفحة عند التحميل
    if (existingBrand) {
        // تعيين قيمة البراند
        brandSelect.val(existingBrand); 
        
        // تشغيل حدث الـ'change' مباشرة لجلب الموديلات
        // (وهنا يتم تشغيل المنطق أعلاه مع الحفاظ على السنة)
        brandSelect.trigger('change');
    }
});
</script>
<script>
document.getElementById('carForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);
    const errorsDiv = document.getElementById('formErrors');

    // Reset error box
    errorsDiv.classList.add('d-none');
    errorsDiv.innerHTML = '';

    fetch("{{ route('cars.update', $car->id) }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {

            // Build error messages inside red box
            let html = '<ul class="mb-0">';
            for (let key in data.errors) {
                html += `<li>${data.errors[key]}</li>`;
            }
            html += '</ul>';

            // Show the danger alert box
            errorsDiv.innerHTML = html;
            errorsDiv.classList.remove('d-none');

            // Scroll so user sees the errors
            window.scrollTo({ top: 0, behavior: 'smooth' });

        } else {
            // Redirect on success
            window.location.href = `/car/${data.car_id}`;
        }
    })
    .catch(err => {
        console.error(err);

        errorsDiv.innerHTML = '<p>Something went wrong. Please try again.</p>';
        errorsDiv.classList.remove('d-none');

        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});
</script>



<!-- ===================== FEATURES SCRIPT ===================== -->
{{-- <script>
document.addEventListener("DOMContentLoaded", function() {
  const input = document.getElementById("featureInput");
  const addBtn = document.getElementById("addFeatureBtn");
  const container = document.getElementById("featureContainer");
  const hidden = document.getElementById("featuresHidden");

  // 🟢 تحميل الـ features القديمة
  let features = @json(explode(',', $car->features ?? ''));
  const updateHidden = () => hidden.value = features.join(",");

  const createTag = (text) => {
    const tag = document.createElement("span");
    tag.className = "feature-tag";
    tag.innerHTML = `${text} <i class="fas fa-times"></i>`;
    tag.querySelector("i").addEventListener("click", () => {
      features = features.filter(f => f !== text);
      tag.remove();
      updateHidden();
    });
    return tag;
  };

  // 🟢 عرض الميزات الموجودة
  features.forEach(f => container.appendChild(createTag(f)));
  updateHidden();

  const addFeature = () => {
    const value = input.value.trim();
    if (!value || features.includes(value)) return;
    features.push(value);
    container.appendChild(createTag(value));
    updateHidden();
    input.value = "";
  };

  addBtn.addEventListener("click", addFeature);
  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      addFeature();
    }
  });
});
</script> --}}


</div> 
@endsection