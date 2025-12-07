@extends('layouts.CarProvider')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background-color: #f8f9fa;
    }

    .profile-wrapper {
        max-width: 1350px;
        margin: 40px auto;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .profile-left {
        background: linear-gradient(135deg, #163155, #a01b20);
        color: #fff;
        padding: 40px 25px;
        text-align: center;
        position: relative;
    }

    .profile-left .profile-img-container {
        position: relative;
        display: inline-block;
    }

    .profile-left img {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        border: 3px solid #fff;
        margin-bottom: 20px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .profile-left img:hover {
        transform: scale(1.05);
    }

    .edit-icon {
        position: absolute;
        bottom: 15px;
        right: 10px;
        background: #fff;
        border: none;
        border-radius: 50%;
        padding: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .edit-icon:hover {
        background: #f2f2f2;
        transform: scale(1.1);
    }

    .profile-left h4 {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .profile-left p {
        font-size: 0.95em;
        margin-bottom: 6px;
        opacity: 0.9;
    }

    .profile-right {
        padding: 40px;
    }

    .profile-right h2 {
        font-weight: 700;
        color: #163155;
        margin-bottom: 25px;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 14px;
        border: 1px solid #ccc;
    }

    .form-control:focus {
        border-color: #163155;
        box-shadow: 0 0 0 0.2rem rgba(118, 14, 19, 0.15);
    }

    #map {
        width: 100%;
        height: 350px;
        border-radius: 10px;
        border: 2px solid #163155;
        margin-top: 10px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #163155, #a01b20);
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #8c181c, #b82227);
    }

    /* Modal styling */
    .modal-content {
        border-radius: 20px;
        border: none;
    }

    .modal-body img {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ddd;
        margin-bottom: 15px;
    }

    @media (max-width: 992px) {
        .profile-wrapper {
            flex-direction: column;
        }

        .profile-left {
            border-radius: 0;
        }
    }
</style>

<div class="profile-wrapper row g-0">
  <!-- 🧭 Left profile -->
<div class="col-lg-4 profile-left d-flex flex-column align-items-center justify-content-center">

 <div class="profile-img-container position-relative">
@php
    $imagePath = $user->image && file_exists(public_path($user->image))
        ? asset($user->image)
        : asset('user-201.png');
@endphp


<div class="profile-img-container position-relative">
    <img id="profileImage"
     src="{{ $user->image ? asset($user->image) : asset('user-201.png') }}"
     alt="Profile"
     class="profile-img rounded-circle shadow-sm"
     onerror="this.onerror=null;this.src='{{ asset('user-201.png') }}';">


    <button class="edit-icon" data-bs-toggle="modal" data-bs-target="#editImageModal">
        <i class="bi bi-pencil-fill"></i>
    </button>
</div>

    <button class="edit-icon" data-bs-toggle="modal" data-bs-target="#editImageModal">
      <i class="bi bi-pencil-fill"></i>
    </button>
  </div> 

<h4 class="mt-3">
    {{ auth()->user()->dealer->company_name 
       ?? auth()->user()->company->name 
       ?? 'New Delar' }}
</h4>


  @if(!empty($user->email))
      <p><i class="fas fa-envelope"></i> {{ $user->email }}</p>
  @endif

  @if(!empty($user->phone))
      <p><i class="fas fa-phone"></i> {{ $user->phone }}</p>
  @endif
    @if(!empty($user->city))
      <p><i class="fas fa-map-marker-alt"></i> {{ $user->city }}</p>
  @endif
<form id="deleteProfileForm" action="{{ route('delete.profile', $user->id) }}" method="POST">
    @csrf
    @method('DELETE')
    
    <button type="button" 
            class="btn btn-danger mt-4"
            data-bs-toggle="modal" 
            data-bs-target="#confirmDeleteModal">
        <i class="fas fa-trash"></i> Delete Profile
    </button>
</form>
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="confirmDeleteModalLabel">Confirm Profile Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
         <div class="modal-body text-dark"> <p>
        <i class="fas fa-exclamation-triangle text-danger me-2"></i>
        Are you absolutely sure you want to delete your profile?
    </p>
    <p class="fw-bold text-danger">This action cannot be undone and all your data will be permanently lost.</p>
</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">
                    Yes, Delete Profile
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmButton = document.getElementById('confirmDeleteButton');
        const deleteForm = document.getElementById('deleteProfileForm');

        if (confirmButton && deleteForm) {
            confirmButton.addEventListener('click', function() {
                // Submit the hidden form when the modal's confirm button is clicked
                deleteForm.submit();
            });
        }
    });
</script>
</div>

<style>
/* ✅ Container: perfect circle + soft shadow */
.profile-img-container {
  /* width: 160px;
  height: 160px; */
  border-radius: 50%;
  position: relative;
  background-color: transparent;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: box-shadow 0.3s ease;
}



/* ✅ Image fills the circle perfectly */
.profile-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%; /* ensures clean circle */
  background-color: #f3f3f3;
}

/* ✅ Placeholder image handling */
.profile-img[src*="user.png"] {
  object-fit: contain;
  background-color: #f8f8f8;
  opacity: 0.9;
}

/* ✅ Floating Pencil Button */
.edit-icon {
  position: absolute;
  bottom: 6px;
  right: 6px;
  background-color: #fff;
  color: #163155;
  border: none;
  border-radius: 50%;
  width: 38px;
  height: 38px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
  cursor: pointer;
  transition: all 0.25s ease-in-out;
  z-index: 2; /* ✅ keeps it visible even with overflow hidden */
}

.edit-icon:hover {
  background-color: #a3121b;
  color: #fff;
  transform: scale(1.1);
}

.edit-icon i {
  font-size: 17px;
}
</style>



    <!-- 📝 Right form -->
    <div class="col-lg-8 profile-right">
        <h2>Edit Profile</h2>

        <form action="{{ route('provider.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" name="fname" value="{{ $user->fname != 'user' ? $user->fname : '' }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lname" value="{{ $user->lname }}" class="form-control">
                </div>

    <div class="col-md-12">
    <label for="company_name" class="form-label">Company Name</label>
    <input 
        type="text" 
        name="company_name"
        id="company_name" 
        class="form-control" 
        value="{{ auth()->user()->dealer->company_name ?? '' }}" 
    >
</div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <div class="input-group">
                        <span class="input-group-text">+971</span>
                        <input type="tel" name="phone" pattern="[0-9]{9}" maxlength="9"
                               value="{{ $user->phone ? substr($user->phone, -9) : '' }}" class="form-control" required>
                    </div>
                    <small class="text-muted">Enter 9 digits (UAE format)</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                </div>

               <input type="hidden" id="city" name="city" value="{{ $user->city }}">


                <div class="col-12">
                    <label class="form-label">Location</label>
                    <input type="text" id="location" name="location" value="{{ $user->location }}" class="form-control" readonly required placeholder="Select a location on the map">
                </div>

                <div class="col-12">
                    <div id="map"></div>
                </div>

                <!-- Hidden Lat & Lng -->
<input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $user->lat) }}">
<input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $user->lng) }}">

            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- 🖋 Edit Image Modal -->
<div class="modal fade" id="editImageModal" tabindex="-1" aria-labelledby="editImageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-semibold">Edit Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
<img id="previewImage"
     src="{{ $user->image ? asset($user->image) : asset('user-201.png') }}"
     onerror="this.onerror=null;this.src='{{ asset('user-201.png') }}';"
     alt="Preview"
     class="profile-img">

<input type="file" id="imageInput" name="image" accept="image/*" class="form-control mb-3 mt-3">
        <button id="removeImage" class="btn btn-outline-danger w-100 mb-2">
          <i class="bi bi-trash3 me-1"></i> Remove Image
        </button>
        <div id="imageError" class="alert alert-danger d-none"></div>

        <button id="saveImage" class="btn  w-100" style="background-color: #163155; color: #fff;">
          <i class="bi bi-check2-circle me-1"></i> Save Changes
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmZpIyIU0nsjNEzzOL4VnrH2YclPvBfpo&callback=initMap">
</script>

<script>
function initMap() {
    // 1. قراءة القيم من حقول الإدخال المخفية، أو استخدام إحداثيات دبي كافتراضي
    const defaultLat = 25.276987; // إحداثيات افتراضية لدبي
    const defaultLng = 55.296249; // إحداثيات افتراضية لدبي

    // قراءة القيم المحفوظة. إذا كانت فارغة أو غير صالحة، استخدم الافتراضية.
    const savedLat = parseFloat(document.getElementById("latitude").value) || defaultLat;
    const savedLng = parseFloat(document.getElementById("longitude").value) || defaultLng;
    const initialLocation = { lat: savedLat, lng: savedLng };

    const map = new google.maps.Map(document.getElementById("map"), {
        center: initialLocation, // استخدم الموقع المحفوظ أو الافتراضي كمركز
        zoom: 10,
    });

    const marker = new google.maps.Marker({
        position: initialLocation, // استخدم الموقع المحفوظ أو الافتراضي كمركز للمؤشر
        map: map,
        draggable: true,
    });

    const geocoder = new google.maps.Geocoder();

 function updateAddress(latLng) {
    geocoder.geocode({ location: latLng }, (results, status) => {
        if (status === "OK" && results[0]) {
            let neighborhood = "";
            let city = "";
            let country = "";

            results[0].address_components.forEach(component => {
                if (component.types.includes("sublocality") || component.types.includes("neighborhood")) {
                    neighborhood = component.long_name;
                }
                if (component.types.includes("locality")) {
                    city = component.long_name;
                }
                if (component.types.includes("country")) {
                    country = component.long_name;
                }
            });

            let shortAddress = [neighborhood, city, country].filter(Boolean).join(", ");

            if (!shortAddress) {
                shortAddress = results[0].formatted_address.split(',').slice(-3).join(', ');
            }

            document.getElementById("location").value = shortAddress;

            // 🔥 أهم حاجة — حفظ المدينة تلقائيًا
            document.getElementById("city").value = city;

        } else {
            document.getElementById("location").value =
                `Coordinates: ${latLng.lat().toFixed(4)}, ${latLng.lng().toFixed(4)}`;
        }
    });
}

    function updateLatLngInputs(latLng) {
        // تحديث قيم خط الطول والعرض المخفية بدقة 6 أرقام عشرية للحفظ
        document.getElementById("latitude").value = latLng.lat().toFixed(6);
        document.getElementById("longitude").value = latLng.lng().toFixed(6);
    }

    // 2. تحديث عند سحب المؤشر (Drag)
    marker.addListener("dragend", (event) => {
        updateLatLngInputs(event.latLng);
        updateAddress(event.latLng);
    });

    // 3. تحديث عند الضغط على الخريطة (Click)
    map.addListener("click", (event) => {
        marker.setPosition(event.latLng);
        updateLatLngInputs(event.latLng);
        updateAddress(event.latLng);
    });

    // 4. التشغيل عند تحميل الصفحة لأول مرة (لجلب العنوان الأول)
    updateAddress(initialLocation);
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

  const imageInput = document.getElementById('imageInput');
  const previewImage = document.getElementById('previewImage');
  const profileImage = document.getElementById('profileImage');
  const removeBtn = document.getElementById('removeImage');
  const saveBtn = document.getElementById('saveImage');
  const errorDiv = document.getElementById('imageError');

  const id = "{{ auth()->user()->id }}";

  let newImageFile = null;
  let removeImageFlag = false;

  // عند اختيار صورة جديدة
  imageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];

    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        previewImage.src = event.target.result;
      };
      reader.readAsDataURL(file);

      newImageFile = file;
      removeImageFlag = false; // لأنه مش حذف
      errorDiv.classList.add("d-none");
    }
  });


  // عند الضغط على زر الحذف
  removeBtn.addEventListener('click', function() {
    previewImage.src = "{{ asset('user-201.png') }}";
    newImageFile = null;
    imageInput.value = '';
    removeImageFlag = true;
    errorDiv.classList.add("d-none");
  });


  // عند الحفظ
  saveBtn.addEventListener('click', function() {

    // لو لا رفع صورة جديدة ولا حذف -> خطأ
    if (!newImageFile && !removeImageFlag) {
      errorDiv.textContent = "Please select an image to upload ";
      errorDiv.classList.remove("d-none");
      return;
    }

    const formData = new FormData();

    if (newImageFile) {
      formData.append('image', newImageFile);
    }

    formData.append('remove_image', removeImageFlag ? 1 : 0);
    formData.append('_token', '{{ csrf_token() }}');

    fetch(`/provider/${id}/update-image`, {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {

        profileImage.src = data.image + "?t=" + Date.now();
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('editImageModal'));
        if (modal) modal.hide();

      } else {
        errorDiv.textContent = data.error || "حدث خطأ أثناء حفظ الصورة";
        errorDiv.classList.remove("d-none");
      }
    })
    .catch(err => {
      errorDiv.textContent = "حدث خطأ في الاتصال بالسيرفر";
      errorDiv.classList.remove("d-none");
      console.error(err);
    });
  });

});
</script>



@endsection
