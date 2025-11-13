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
        <h2 class="mb-4 mt-2 text-center fw-bold" style="color:#760e13;">Add Your Car</h2>
        <div class="card">
            <!-- Car Form -->
            <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
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

                    <!-- ✅ Added name so Laravel can receive images[] -->
                    <input type="file" id="imageInput" name="images[]" accept="image/*" multiple hidden>

                    <div id="previewContainer" class="image-grid mt-3"></div>
                </div>

                <!-- Image Modal -->
                <div id="imageModal" class="image-modal">
                    <span class="close">&times;</span>
                    <img id="modalImage" alt="Preview">
                </div>
                <!-- Car Details -->
                <div class="row g-3">
                    <!-- Brand -->
                    <div class="col-md-12">
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

                    <!-- Year -->
                    <div class="col-md-6">
                        <label for="year" class="form-label">Year</label>
                        @php
                        $currentYear = date('Y');
                        $years = range($currentYear, 1990);
                        @endphp
                        <select class="form-select" name="year" id="year" disabled required>
                            <option value="">Select Year</option>
                            @foreach($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
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

                        sort($uaeCities); // ✅ Sort alphabetically
                        @endphp

                        <select class="form-select" name="city" id="city" required>
                            <option value="" {{ empty(request('city')) ? 'selected' : '' }}>Select City</option>
                            @foreach($uaeCities as $city)
                            <option value="{{ $city }}" {{ request('city')==$city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                    <!-- VIN -->
                    <div class="col-md-6">
                        <label for="vin_number" class="form-label">VIN Number</label>
                        <input type="text" name="vin_number" class="form-control" id="vin_number"
                            placeholder="VIN Number" required>
                    </div>

                    <div class="col-12 position-relative">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" name="price" class="form-control pe-5" id="price" placeholder="Enter Price"
                            value="{{ auth()->user()->price }}" required>
                        <img src="{{ asset('assets/images/UAE_Dirham_Symbol.svg.png') }}" alt="AED" width="18"
                            height="18" style="top: 50px;"
                            class="position-absolute end-0 translate-middle-y me-3 opacity-75">
                    </div>

                    <!-- 🚘 Features -->
                    <div class="col-12">
                        <label for="features" class="form-label fw-semibold">Features</label>
                        <div class="input-group feature-input-group shadow-sm rounded-3 overflow-hidden"
                            style="height: 38px;">
                            <input type="text" id="featureInput" class="form-control ps-3 py-1 h-100"
                                placeholder="Add a feature..."
                                style="font-size: 0.95rem; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                            <button type="button" id="addFeatureBtn"
                                class="btn border-0 px-3 h-100 d-flex align-items-center justify-content-center"
                                style="background-color: #f8f9fa; color: #760e13; border-left: 1px solid #ced4da; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <!-- Container for feature tags -->
                        <div id="featureContainer" class="mt-2 d-flex flex-wrap gap-2"></div>

                        <!-- Hidden input to submit features -->
                        <input type="hidden" name="features" id="featuresHidden">
                    </div>

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
                                        data-spec="color" data-value="{{ $color->name }}"
                                        style="border: 1px solid #ccc; cursor: pointer;">
                                        <span style="
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: {{ $color->code }};
            border: 1px solid #aaa;
            flex-shrink: 0;
          "></span>
                                        <span>{{ $color->name }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Script -->
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
  const colorInput = document.getElementById("colorInput");

  // عند الضغط على أي لون
  document.querySelectorAll("#colorModal .color-option").forEach(option => {
    option.addEventListener("click", function() {
      const value = this.dataset.value;

      // حفظ اللون في hidden input
      colorInput.value = value;

      // إبراز اللون المختار
      document.querySelectorAll("#colorModal .color-option").forEach(el => el.classList.remove("selected"));
      this.classList.add("selected");

      // إغلاق المودال
      const modal = bootstrap.Modal.getInstance(document.getElementById("colorModal"));
      modal.hide();
    });
  });

  // عند فتح المودال، إبراز اللون المحفوظ سابقًا
  const colorModalEl = document.getElementById("colorModal");
  colorModalEl.addEventListener('show.bs.modal', () => {
    const savedValue = colorInput.value;
    document.querySelectorAll("#colorModal .color-option").forEach(option => {
      if(option.dataset.value === savedValue){
        option.classList.add("selected");
      } else {
        option.classList.remove("selected");
      }
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


                    <!-- Hidden inputs for specs -->
                    <input type="hidden" name="gear" id="gearInput">
                    <input type="hidden" name="mileage" id="mileageHidden">
                    <input type="hidden" name="color" id="colorInput">
                    <input type="hidden" name="warranty" id="warrantyInput">
                    <input type="hidden" name="fuelType" id="fuelInput">
                    <input type="hidden" name="seats" id="seatsInput">



                    <!-- Name & Phone -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Your Name"
                            value="{{ auth()->user()->fname }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" id="phone" placeholder="Phone"
                            value="{{ auth()->user()->phone }}" required>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description"
                            placeholder="Description"></textarea>
                    </div>



                 <!-- Location Input -->
<div class="col-12">
    <label for="location" class="form-label">Location</label>
<div class="input-group">
    <input type="text" name="location" class="form-control" id="location" placeholder="Select Location" readonly>
    <button type="button" class="btn btn-outline-secondary" id="clearLocationBtn">Clear</button>
</div>

<style>
.input-group .form-control,
.input-group .btn {
    height: 42px; /* Adjust height as needed */
    padding: 0.375rem 0.75rem; /* Optional: match Bootstrap default */
}
</style>

    <!-- Hidden fields for lat & lng -->
    <input type="hidden" name="latitude" id="latitude">
    <input type="hidden" name="longitude" id="longitude">
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

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map, marker;

// Open map when clicking the location input
document.getElementById('location').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('mapModal'));
    modal.show();

    setTimeout(() => { // initialize map after modal is visible
        if (!map) {
            const lat = parseFloat(document.getElementById('latitude').value) || 25.276987;
            const lng = parseFloat(document.getElementById('longitude').value) || 55.296249;

            map = L.map('map').setView([lat, lng], 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            if (lat && lng) {
                marker = L.marker([lat, lng], {draggable:true}).addTo(map);
            }

            // Add click to set marker
            map.on('click', function(e) {
                const {lat, lng} = e.latlng;
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng], {draggable:true}).addTo(map);
                }
            });
        }
    }, 200);
});

// Clear location
document.getElementById('clearLocationBtn').addEventListener('click', function() {
    document.getElementById('location').value = '';
    document.getElementById('latitude').value = '';
    document.getElementById('longitude').value = '';
    if (marker) {
        map.removeLayer(marker);
        marker = null;
    }
});

// Save location
document.getElementById('saveLocationBtn').addEventListener('click', function() {
    if (marker) {
        const pos = marker.getLatLng();
        document.getElementById('latitude').value = pos.lat;
        document.getElementById('longitude').value = pos.lng;

        // Reverse geocoding using Nominatim
        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${pos.lat}&lon=${pos.lng}`)
            .then(response => response.json())
            .then(data => {
                let displayName = '';

                if (data.address) {
                    const { city, town, village, state, country } = data.address;
                    displayName = [city || town || village, state, country].filter(Boolean).join(', ');
                }

                document.getElementById('location').value = displayName || `Lat: ${pos.lat.toFixed(5)}, Lng: ${pos.lng.toFixed(5)}`;
            })
            .catch(err => {
                console.error(err);
                document.getElementById('location').value = `Lat: ${pos.lat.toFixed(5)}, Lng: ${pos.lng.toFixed(5)}`;
            });
    }
    bootstrap.Modal.getInstance(document.getElementById('mapModal')).hide();
});
</script>


                </div>

                <button type="submit" class="btn mt-3">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
  const imageInput = document.getElementById("imageInput");
  const fileInputContainer = document.getElementById("fileInputContainer");
  const previewContainer = document.getElementById("previewContainer");
  const errorMessage = document.getElementById("errorMessage");
  const modal = document.getElementById("imageModal");
  const modalImage = document.getElementById("modalImage");
  const closeModal = document.querySelector("#imageModal .close");

  let uploadedFiles = [];

  // Click upload box → open file dialog
  fileInputContainer.addEventListener("click", () => imageInput.click());

  function updateImageCount() {
    const countEl = document.getElementById("imageCount");
    countEl.textContent = `${uploadedFiles.length} / 8`;
  }

  function updateInputFiles() {
    const dataTransfer = new DataTransfer();
    uploadedFiles.forEach(file => dataTransfer.items.add(file));
    imageInput.files = dataTransfer.files;
  }

  function createThumbnail(file, index) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const wrapper = document.createElement("div");

      const img = document.createElement("img");
      img.src = e.target.result;
      img.setAttribute("data-index", index);

      // 🖼️ Click to open modal
      img.addEventListener("click", () => {
        modal.style.display = "block";
        modalImage.src = img.src;
      });

      const removeBtn = document.createElement("span");
      removeBtn.classList.add("remove-btn");
      removeBtn.textContent = "×";
      removeBtn.addEventListener("click", (ev) => {
        ev.stopPropagation();
        uploadedFiles.splice(index, 1);
        wrapper.remove();
        updateInputFiles();
        updateImageCount();
        errorMessage.textContent = ""; // clear error if any
      });

      wrapper.appendChild(img);
      wrapper.appendChild(removeBtn);
      previewContainer.appendChild(wrapper);
    };
    reader.readAsDataURL(file);
  }

  imageInput.addEventListener("change", function(event) {
    const remaining = 8 - uploadedFiles.length;
    const newFiles = [...event.target.files].slice(0, remaining);

    // Add only allowed number of files
    newFiles.forEach(file => {
      uploadedFiles.push(file);
      createThumbnail(file, uploadedFiles.length - 1);
    });

    // If user tried to upload too many
    if (event.target.files.length > remaining) {
      errorMessage.textContent = "⚠️ You can upload up to 8 images only.";
    } else {
      errorMessage.textContent = "";
    }

    updateInputFiles();
    updateImageCount();
  });

  // 🧭 Close modal
  closeModal.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Close when clicking outside the image
  modal.addEventListener("click", (e) => {
    if (e.target === modal) modal.style.display = "none";
  });

  updateImageCount();
});
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
    $('#brand').on('change', function() {
        var brandName = $(this).val();
        var modelSelect = $('#model');
        var yearSelect = $('#year');

        if (brandName) {
            $.ajax({
                url: "{{ route('getModels') }}",
                type: "GET",
                data: { brand: brandName },
                success: function(response) {
                    // Reset and populate model select
                    modelSelect.empty();
                    modelSelect.append('<option value="">Select Model</option>');
                    $.each(response.models, function(index, model) {
                        modelSelect.append('<option value="'+model+'">'+model+'</option>');
                    });
                    modelSelect.prop('disabled', false); // Enable model
                    yearSelect.prop('disabled', false);  // Enable year
                }
            });
        } else {
            // Disable both fields if no brand selected
            modelSelect.empty().append('<option value="">Select Model</option>').prop('disabled', true);
            yearSelect.prop('disabled', true).val('');
        }
    });
});
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
  const specs = {
    gear: document.getElementById("gearInput"),
    color: document.getElementById("colorInput"),
    warranty: document.getElementById("warrantyInput"),
    fuel: document.getElementById("fuelInput"),
    seats: document.getElementById("seatsInput")
  };

  // Highlight selected option inside modal
  function updateSelection(spec) {
    const selectedValue = specs[spec].value;
    document.querySelectorAll(`#${spec}Modal .spec-option`).forEach(btn => {
      btn.classList.toggle('selected', btn.dataset.value === selectedValue);
    });
  }

  // Restore selection whenever a modal opens
  Object.keys(specs).forEach(spec => {
    const modalEl = document.getElementById(`${spec}Modal`);
    modalEl.addEventListener('show.bs.modal', () => updateSelection(spec));
  });

  // Click on a spec option
  document.querySelectorAll(".spec-option").forEach(btn => {
    btn.addEventListener("click", function() {
      const spec = this.dataset.spec;
      const value = this.dataset.value;

      // Save value to hidden input
      specs[spec].value = value;

      // Update highlight
      updateSelection(spec);

      // Close modal if not mileage
      if(spec !== 'mileage') {
        const modal = bootstrap.Modal.getInstance(this.closest('.modal'));
        if(modal) modal.hide();
      }
    });
  });

  // Mileage modal handling separately
  const mileageInput = document.getElementById("mileageInput");
  const mileageHidden = document.getElementById("mileageHidden");
  const saveMileageBtn = document.getElementById("saveMileageBtn");
  const mileageModalEl = document.getElementById("mileageModal");

  // Restore mileage when modal opens
  mileageModalEl.addEventListener('show.bs.modal', () => {
    mileageInput.value = mileageHidden.value || '';
  });

  // Save mileage
  saveMileageBtn.addEventListener("click", function() {
    mileageHidden.value = mileageInput.value;
    const modal = bootstrap.Modal.getInstance(mileageModalEl);
    modal.hide();
  });
});
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
  const input = document.getElementById("featureInput");
  const addBtn = document.getElementById("addFeatureBtn");
  const container = document.getElementById("featureContainer");
  const hidden = document.getElementById("featuresHidden");
  let features = [];

  const updateHidden = () => hidden.value = features.join(",");

  const createTag = (text) => {
    const tag = document.createElement("span");
    tag.className = "feature-tag";
    tag.innerHTML = `
      ${text} <i class="fas fa-times"></i>
    `;
    tag.querySelector("i").addEventListener("click", () => {
      features = features.filter(f => f !== text);
      tag.remove();
      updateHidden();
    });
    return tag;
  };

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

</div> 
@endsection