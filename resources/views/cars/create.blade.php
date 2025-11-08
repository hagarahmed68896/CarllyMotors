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
    height: 200px; 
    cursor: pointer; 
    background-color: #f5f5f5;
    border: 2px dashed #ccc;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: #999;
    transition: background-color 0.2s, border-color 0.2s;
    position: relative;
    overflow: hidden;
}

#car-create-page .fileInput:hover {
    background-color: #e9ecef;
    border-color: #760e13;
}

#car-create-page .fileInput img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
    display: block;
    z-index: 1;
}

#car-create-page .fileInput span {
    position: relative;
    z-index: 2;
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
</style>

<div id="car-create-page">
<div id="container">
    <div class="card">

        <!-- Image Upload -->
        <div class="fileInput" onclick="document.getElementById('imageInput').click()">
            <img id="imagePreview" class="d-none" />
            <span id="placeholderText">Click to Upload Images</span>
        </div>

        <input type="file" id="imageInput" name="images[]" class="d-none" multiple accept="image/*">

        <!-- Car Form -->
        <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

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
                    <select class="form-select" name="model" id="model" required>
                        <option value="">Select Model</option>
                    </select>
                </div>

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

                <!-- Features -->
                <div class="col-12">
                    <label for="features" class="form-label">Features</label>
                    <input type="text" name="features" class="form-control" id="features" placeholder="Features" required data-role="tagsinput">
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

                <!-- Price -->
                <div class="col-12">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" name="price" class="form-control" id="price" placeholder="Price" value="{{ auth()->user()->price }}" required>
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

<!-- Scripts -->
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<script>
    // Image preview
    document.querySelector("#car-create-page #imageInput").addEventListener("change", function(event){
        const file = event.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(){
                const preview = document.querySelector("#car-create-page #imagePreview");
                preview.src = reader.result;
                preview.classList.remove("d-none");
                document.querySelector("#car-create-page #placeholderText").style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    // Load models based on brand
    $('#car-create-page #brand').on('change', function(){
        let brand = $(this).val();
        $('#car-create-page #model').empty().append('<option value="">Select Model</option>');

        if(brand){
            $.ajax({
                url: "{{ route('getModels') }}",
                method: "POST",
                data: { brand: brand, _token: '{{ csrf_token() }}' },
                success: function(response){
                    response.models.forEach(function(model){
                        $('#car-create-page #model').append('<option value="'+model+'">'+model+'</option>');
                    });
                }
            });
        }
    });

    // Initialize tags input
    $('#car-create-page input[name="features"]').tagsinput({
        trimValue: true,
        confirmKeys: [13,44,32]
    });
</script>
@endpush

</div> <!-- end car-create-page -->
@endsection
