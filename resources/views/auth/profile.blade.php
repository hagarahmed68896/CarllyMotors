@extends('layouts.app')

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
        background: linear-gradient(135deg, #760e13, #a01b20);
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
        color: #760e13;
        margin-bottom: 25px;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px 14px;
        border: 1px solid #ccc;
    }

    .form-control:focus {
        border-color: #760e13;
        box-shadow: 0 0 0 0.2rem rgba(118, 14, 19, 0.15);
    }

    #map {
        width: 100%;
        height: 350px;
        border-radius: 10px;
        border: 2px solid #760e13;
        margin-top: 10px;
    }

    .btn-submit {
        background: linear-gradient(135deg, #760e13, #a01b20);
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
    {{ (!empty($user->fname) && $user->fname !== 'user') ? trim($user->fname . ' ' . ($user->lname ?? '')) : 'New User' }}
  </h4>

  @if(!empty($user->userType))
      <p><i class="fas fa-user"></i> {{ $user->userType }}</p>
  @endif



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
  color: #760e13;
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

        <form action="{{ route('users.update', auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
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

                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input type="text" name="city" value="{{ $user->city }}" class="form-control" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Location</label>
                    <input type="text" id="location" name="location" value="{{ $user->location }}" class="form-control" readonly required placeholder="Select a location on the map">
                </div>

                <div class="col-12">
                    <div id="map"></div>
                </div>

                <!-- Hidden Lat & Lng -->
                <input type="hidden" id="latitude" name="latitude" value="{{ $user->latitude }}">
                <input type="hidden" id="longitude" name="longitude" value="{{ $user->longitude }}">
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
        <button id="saveImage" class="btn  w-100" style="background-color: #760e13; color: #fff;">
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
    const lat = parseFloat(@json($user->latitude ?? 25.276987));
    const lng = parseFloat(@json($user->longitude ?? 55.296249));
    const mapOptions = {
        center: { lat, lng },
        zoom: 10,
    };

    const map = new google.maps.Map(document.getElementById("map"), mapOptions);
    const marker = new google.maps.Marker({
        position: { lat, lng },
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

            // ✅ نبني العنوان المختصر
            let shortAddress = [neighborhood, city, country].filter(Boolean).join(", ");

            // ✅ في حالة مفيش بيانات كافية، نستخدم آخر جزئين من العنوان الكامل
            if (!shortAddress) {
                shortAddress = results[0].formatted_address.split(',').slice(-3).join(', ');
            }

            document.getElementById("location").value = shortAddress;
        }
    });
}


    google.maps.event.addListener(marker, 'dragend', function (event) {
        const latLng = event.latLng;
        document.getElementById("latitude").value = latLng.lat().toFixed(6);
        document.getElementById("longitude").value = latLng.lng().toFixed(6);
        updateAddress(latLng);
    });

    map.addListener("click", (event) => {
        const latLng = event.latLng;
        marker.setPosition(latLng);
        document.getElementById("latitude").value = latLng.lat().toFixed(6);
        document.getElementById("longitude").value = latLng.lng().toFixed(6);
        updateAddress(latLng);
    });
}
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
  const imageInput = document.getElementById('imageInput');
  const previewImage = document.getElementById('previewImage');
  const profileImage = document.getElementById('profileImage');
  const removeBtn = document.getElementById('removeImage');
  const saveBtn = document.getElementById('saveImage');
  const userId = "{{ auth()->user()->id }}";
  let newImageFile = null;

  imageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(event) {
        previewImage.src = event.target.result;
      };
      reader.readAsDataURL(file);
      newImageFile = file;
    }
  });

  removeBtn.addEventListener('click', function() {
    previewImage.src = "{{ asset('user-201.png') }}";
    newImageFile = null;
    imageInput.value = '';
  });

  saveBtn.addEventListener('click', function() {
    if (!newImageFile) {
      alert("يرجى اختيار صورة أولاً");
      return;
    }

    const formData = new FormData();
    formData.append('image', newImageFile);
    formData.append('_token', '{{ csrf_token() }}');

    fetch(`/users/${userId}/update-image`, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        profileImage.src = data.image + '?t=' + new Date().getTime();

        const modal = bootstrap.Modal.getInstance(document.getElementById('editImageModal'));
        if (modal) modal.hide();
      } else {
        alert(data.error || "حدث خطأ أثناء رفع الصورة");
      }
    })
    .catch(error => {
      console.error(error);
      alert("حدث خطأ في الاتصال بالسيرفر");
    });
  });
});

</script>


@endsection
