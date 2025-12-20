@extends('layouts.CarProvider')

@section('content')

<div class="container mt-5 rounded-4" style="background-color: #fff; padding: 30px;">
    <h2 class="fw-bold mb-4" style="color: #163155;">Add New Part</h2>
    <form id="createPartForm" method="POST" action="{{ route('spareparts.store') }}" enctype="multipart/form-data">
        @csrf
@if ($errors->any())
    <div class="alert alert-danger mb-4">
        <h5 class="fw-bold">Please correct the following errors:</h5>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        {{-- 1. Car Brand (Select-One) --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Car Brand</label>
            <select class="form-select rounded-4" id="brand" name="brand" >
                @foreach($sortedMakes as $make)
                @php $normalizedMake = strtolower(trim($make)); @endphp
            <option value="{{ $normalizedMake }}" {{ old('brand') == $normalizedMake ? 'selected' : '' }}> 
                    {{ $make }}
                </option>
                @endforeach
            </select>
        </div>

{{-- 2. Model Dropdown --}}
<div class="mb-3">
    <label class="form-label fw-semibold small text-muted">Model</label>
    <div class="dropdown custom-choices-dropdown" id="modelDropdown">
        <div class="custom-choices-inner dropdown-toggle" id="modelDropdownButton" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            <span class="placeholder-text">Select Model(s)</span>
        </div>
        <div class="dropdown-menu shadow rounded-4 p-2" style="width: 100%;">
            <div class="px-2 pb-2 border-bottom mb-2">
                <input type="text" class="form-control form-control-sm dropdown-search" placeholder="Search models...">
            </div>
            <div class="checkbox-list p-2" id="model-checkbox-container" style="max-height: 250px; overflow-y: auto;">
                {{-- يتم تعبئته عبر الجافا سكريبت --}}
            </div>
        </div>
    </div>
</div>

{{-- 3. Year Dropdown --}}
<div class="mb-3">
    <label class="form-label fw-semibold small text-muted">Year</label>
    <div class="dropdown custom-choices-dropdown" id="yearDropdown">
        <div class="custom-choices-inner dropdown-toggle is-disabled" id="yearDropdownButton" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            <span class="placeholder-text">Select Year(s)</span>
        </div>
        <div class="dropdown-menu shadow rounded-4 p-2" style="width: 100%;">
            <div class="px-2 pb-2 border-bottom mb-2">
                <input type="text" class="form-control form-control-sm dropdown-search" placeholder="Search years...">
            </div>
            <div class="checkbox-list p-2" id="year-checkbox-container" style="max-height: 250px; overflow-y: auto;">
                {{-- يتم تعبئته عبر الجافا سكريبت --}}
            </div>
        </div>
    </div>
</div>

        {{-- Links and Scripts --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<style>
    /* محاكاة شكل Choices.js */
.custom-choices-inner {
    display: flex;
    align-items: center;
    min-height: 48px;
    padding: 8px 15px;
    background: #fff;
    border: 1px solid #ced4da;
    border-radius: 12px;
    cursor: pointer;
    position: relative;
    transition: all 0.2s;
}

.custom-choices-inner::after {
    content: "";
    width: 0; height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 5px solid #163155;
    position: absolute;
    right: 15px;
}

.custom-choices-inner.show, .custom-choices-inner:focus {
    border-color: #163155;
    box-shadow: 0 0 0 0.25rem rgba(22, 49, 85, 0.25);
}

/* حالة التعطيل */
.custom-choices-inner.is-disabled {
    background-color: #f8f9fa;
    cursor: not-allowed;
    opacity: 0.7;
    pointer-events: none;
}

.dropdown-search {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 8px;
}

.dropdown-search:focus {
    border-color: #163155;
    box-shadow: none;
}

.checkbox-list .form-check:hover {
    background-color: #f8f9fa;
    border-radius: 6px;
}
/* 1. إخفاء القائمة تماماً حتى لو تم تمرير الماوس فوق الحاوية */
.custom-choices-dropdown:hover > .dropdown-menu {
    display: none !important;
}

/* 2. إظهار القائمة فقط عندما يضيف Bootstrap كلاس show (الذي يضاف عند الضغط فقط) */
.custom-choices-dropdown > .dropdown-menu.show {
    display: block !important;
}

/* 3. تعديل بسيط لزر السنة المعطل للتأكد من أنه لا يستجيب للماوس */
.custom-choices-inner.is-disabled {
    pointer-events: none !important;
    user-select: none;
}
</style>
<style>
/* ============================================================= */
/* ===============   Choices.js Custom Styling   =============== */
/* ============================================================= */

/*
* التحسين: جعل حقل الإدخال (الزرار) في الأعلى (Order: 1) والتاغز في الأسفل (Order: 2)
*/
.choices__inner {
    display: flex !important;
    flex-wrap: wrap !important;
    /* نجعل الاتجاه عموديًا لضمان ظهور العناصر تحت بعضها */
    flex-direction: column !important; 
    align-items: flex-start !important;
    padding: 8px 10px !important;
    gap: 6px !important;
    min-height: 48px;
    border-radius: 12px !important;
    border: 1px solid #ced4da !important;
    background: #fff !important;
    /* إضافة انتقال سلس لتأثير الحدود */
    transition: border-color 0.2s, box-shadow 0.2s;
}

/* حالة التركيز/الفتح */
.choices.is-focused .choices__inner,
.choices.is-open .choices__inner {
    border-color: #163155 !important; 
    box-shadow: 0 0 0 0.25rem rgba(22, 49, 85, 0.25) !important;
}


/* الـ search input يظهر في سطر مستقل في الأعلى */
.choices__input {
    flex: 1 0 100% !important; 
    margin-top: 4px !important;
    border: none !important;
    outline: none !important;
    padding: 6px 4px !important;
    font-size: 0.9rem !important;
    width: 100% !important;
    background-color: #fff !important;
    order: 1 !important; /* وضع حقل الإدخال في الترتيب الأول (في الأعلى) */
}

/* Placeholder فوق */
.choices__placeholder {
    /* يجب أن يكون له ترتيب أقل من الـ Input ليظهر فوقه */
    order: 0 !important; 
    opacity: 0.6 !important;
    font-size: 0.95rem;
}

/* شكل التاجز (الاختيارات المتعددة) */
.choices__list--multiple .choices__item {
    background-color: #163155 !important;
    border: 1px solid #163155 !important;
    color: #fff !important;
    font-size: 0.85rem;
    padding: 4px 10px !important;
    border-radius: 0.6rem;
    margin: 2px !important;
    /* إضافة ظل خفيف للتاغز */
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

/* قائمة التاجز نفسها - تأتي ثانيًا (في الأسفل) */
.choices__list--multiple {
    width: 100% !important;
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 6px !important;
    order: 2 !important; /* وضع التاغز في الترتيب الثاني (في الأسفل) */
}

/* زر حذف التاج */
.choices__list--multiple .choices__item[data-deletable] .choices__button {
    color: #fff !important;
    opacity: 0.8 !important;
    margin-left: 6px !important;
    border-left: 1px solid rgba(255,255,255,0.4);
    /* تحسين شكل زر الحذف عند التحويم */
    transition: opacity 0.2s;
}

.choices__list--multiple .choices__item[data-deletable] .choices__button:hover {
    opacity: 1 !important;
}

/* القائمة المنسدلة */
.choices__list--dropdown {
    border-radius: 12px !important;
    border: 1px solid #dee2e6 !important;
    background-color: #fff !important;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
    padding: 6px 0 !important;
    z-index: 9999 !important;
}

.choices__list--dropdown .choices__item {
    padding: 10px 14px !important;
    font-size: 0.95rem !important;
    /* إضافة انتقال سلس لحالة المؤشر */
    transition: background-color 0.2s, color 0.2s;
}

/* حالة الاختيار النشط/المؤشر عليه - تم تحسينها */
.choices__list--dropdown .choices__item--selectable.is-highlighted {
    background-color: #163155 !important; 
    color: #fff !important;
}

/* السهم - لحقل Select-One */
.choices[data-type*=select-one]::after {
    border-color: #163155 transparent transparent transparent !important;
    right: 14px;
    top: 50%;
    margin-top: -3px;
}

/* لـ Multi-Selects لا نحتاج سهم Choices.js */
.choices[data-type*=select-multiple]::after {
    content: none !important;
}


/* ============================================================= */
/* ==================     Categories Icons     ================= */
/* ============================================================= */

/* Make all category cards same size */
.category-icon {
    width: 95px;                 /* ثابت */
    height: 120px;               /* ثابت */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding: 10px;
    border-radius: 12px;
    border: 1px solid #e3e3e3;
    background: #fff;
    transition: 0.2s;
    cursor: pointer;
}

/* Fix image size */
.category-icon img {
    width: 55px;
    height: 55px;
    object-fit: cover;
    border-radius: 10px;
}

/* Fix name style */
.category-icon div {
    margin-top: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-align: center;
    line-height: 1.2;
    max-width: 100%;
    white-space: normal;       /* allow wrapping */
    overflow: visible;         /* show all text */
    text-overflow: unset;      /* remove ellipsis */
    word-wrap: break-word;     /* break long words if needed */
}


/* Selected style */
.category-icon.selected {
    border: 2px solid #163155 !important;
    background-color: #e6e9f1 !important;
}

/* Hover effect */
.category-icon:hover {
    background-color: #f8f9fa;
}

/* ============================================================= */
/* =========== FINAL FIX: Ensure Brand/Model/Year Height Consistency ========== */
/* ============================================================= */

/* 1. ضبط الارتفاع الأدنى للحاوية الرئيسية (هذا موجود بالفعل لكن نؤكد عليه) */
.choices__inner {
    min-height: 48px !important; /* تأكيد أن الحد الأدنى 48 بكسل */
}


/* 2. ضبط ارتفاع الـ Placeholder ليتطابق في Select-One و Multi-Select */
/*
 * في Select-One، الـ Placeholder يظهر داخل الـ .choices__inner مباشرةً.
 * في Multi-Select، الـ Placeholder يظهر داخل الـ .choices__input
 */
.choices__placeholder {
    /* ضبط ارتفاع السطر ليناسب الـ 48 بكسل مع البادينج 8px */
    line-height: 32px !important; /* (48px - 8px - 8px = 32px) */
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-top: -4px; /* لإلغاء أي تأثير هامش داخلي */
}


/* 3. ضمان أن حقل الإدخال الداخلي (الذي يظهر فيه الـ Placeholder في Multi-Select) يأخذ الارتفاع المطلوب */
.choices__input {
    /* الارتفاع المطلوب للعنصر النصي ليتناسب مع padding 8px top/bottom */
    min-height: 32px !important; /* يجب أن يكون هذا الارتفاع هو (الارتفاع الكلي 48 - 8 - 8) */
    padding: 0 4px !important; /* إزالة الـ padding العمودي ليتناسب مع الـ line-height */
    margin-top: 0 !important;
}

/* 4. إزالة أي ارتفاع إضافي غير مرغوب فيه في قائمة التاجز عندما تكون فارغة */
.choices__list--multiple {
    /* نضمن أن القائمة الفارغة لا تضيف ارتفاعاً */
    min-height: 0 !important; 
    padding: 0 !important;
}

</style>



        {{-- City and other fields (باقي الحقول لم يتم تغييرها) --}}
<div class="mb-3">
    <label class="form-label fw-semibold small text-muted">City</label>
    @php
     $uaeCities = [
    'Abu Dhabi',
    'Ajman',
    'Al Ain',
    'Dubai',
    'Fujairah',
    'Ras Al Khaimah',
    'Sharjah',
    'Umm Al Quwain',
];

        sort($uaeCities);
    @endphp

    <select class="form-select rounded-4" id="citySelect" name="city">
        <option value="">Select City</option>
        {{-- تأكد من استخدام المتغير الصحيح هنا (سواء uaeCities أو cities القادمة من الـ Controller) --}}
        @foreach($cities as $city)
            <option value="{{ $city }}" {{ old('city') == $city ? 'selected' : '' }}>
                {{ $city }}
            </option>
        @endforeach
    </select>
</div>


        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Sparepart Type</label>

            <div class="d-flex gap-3 mt-1">

                <div class="condition-btn {{ old('part_type') == 'New' ? 'selected' : '' }}" data-value="New">New</div>
                <div class="condition-btn {{ old('part_type') == 'Used' ? 'selected' : '' }}" data-value="Used">Used</div>

            </div>

<input type="hidden" name="part_type" id="conditionInput" value="{{ old('part_type') }}">        </div>

        <style>
            .condition-btn {
                padding: 10px 20px;
                border: 1px solid #163155;
                border-radius: 12px;
                cursor: pointer;
                transition: 0.25s;
                font-weight: 600;
                color: #163155;
                user-select: none;
            }

            .condition-btn.selected {
                background: #163155;
                color: #fff;
            }
        </style>

        <script>
            document.querySelectorAll('.condition-btn').forEach(btn => {
    btn.addEventListener('click', function () {

        // Remove selection from others
        document.querySelectorAll('.condition-btn')
            .forEach(b => b.classList.remove('selected'));

        // Add selected style
        this.classList.add('selected');

        // Set input value
        document.getElementById('conditionInput').value = this.dataset.value;

        // Show/hide VIN
        if (this.dataset.value === 'New') {
            document.getElementById('vinWrapper').style.display = 'block';
        } else {
            document.getElementById('vinWrapper').style.display = 'none';
        }
    });
});
        </script>


        <div class="mb-3" id="vinWrapper" style="display:none;">
            <label class="form-label fw-semibold small text-muted">VIN Number</label>
            <input type="text" name="vin_number" class="form-control rounded-4" placeholder="Enter VIN Number">
        </div>


        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Category</label>

            <div class="d-flex flex-wrap justify-content-start gap-3">
                @foreach($mainCategories as $category)
                @php
                $img = $category->image
                ? config('app.file_base_url') . Str::after($category->image, url('/') . '/')
                : 'https://via.placeholder.com/60';
                @endphp
                <div class="text-center category-icon {{ old('category') == $category->id ? 'selected' : '' }}" flex-shrink-0" data-id="{{ $category->id }}"
                    data-name="{{ $category->name }}" data-subs='@json($category->subcategories)'>
                    <img src="{{ $img }}" class="rounded mb-1" width="60" height="60">
                    <div style="font-size:0.75rem;">{{ $category->name }}</div>
                </div>
                @endforeach
            </div>

<input type="hidden" name="category" id="categoryInput" value="{{ old('category') }}">
        </div>

        {{-- <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Subcategory</label>
            <select class="form-select rounded-4" id="subcategorySelect" name="subcategory" required>
                <option value="">Select Subcategory</option>
            </select>
        </div> --}}
{{-- 4. Location & Map Section --}}


   <button type="submit" class="btn text-white fw-semibold" style="background:#163155;">
            Add
    </button>
    </form>

</div>
@if(session('showLocationModal'))

<!-- Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="locationModalLabel">Add Your Shop Location</h5>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold small text-muted">Location</label>

                    <div class="input-group mb-2">
                        <span class="input-group-text bg-white border-end-0 rounded-start-4">
                            <i class="bi bi-geo-alt"></i>
                        </span>
                        <input type="text"
                               id="location"
                               name="location"
                               class="form-control border-start-0 rounded-end-4"
                               readonly
                               required
                               placeholder="Select a location on the map">
                    </div>

                    <div id="map"
                         style="height: 350px; width: 100%; border-radius: 15px; border: 1px solid #ced4da;">
                    </div>
                </div>

                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveLocationBtn">
                    Save Location
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Google Maps -->
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmZpIyIU0nsjNEzzOL4VnrH2YclPvBfpo&callback=initMap">
</script>

<script>
// تعريف المتغيرات في النطاق العام لسهولة الوصول إليها
let map;
let marker;
let geocoder;

function initMap() {
    // 1. تحديد الإحداثيات الافتراضية (دبي كمثال أو القاهرة حسب رغبتك)
    const defaultLat = 25.276987; 
    const defaultLng = 55.296249;

    // 2. قراءة القيم المحفوظة من الحقول إن وجدت
    const savedLat = parseFloat(document.getElementById("latitude").value) || defaultLat;
    const savedLng = parseFloat(document.getElementById("longitude").value) || defaultLng;
    const initialLocation = { lat: savedLat, lng: savedLng };

    // 3. تهيئة الخريطة
    map = new google.maps.Map(document.getElementById('map'), {
        center: initialLocation,
        zoom: 12
    });

    // 4. تهيئة المؤشر (Marker)
    marker = new google.maps.Marker({
        position: initialLocation,
        map: map,
        draggable: true // السماح بسحب المؤشر
    });

    geocoder = new google.maps.Geocoder();

    // دالة لتحديث العنوان (نصي) بناءً على الإحداثيات
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

                // دمج المكونات في نص واحد قصير
                let shortAddress = [neighborhood, city, country].filter(Boolean).join(", ");

                if (!shortAddress) {
                    shortAddress = results[0].formatted_address.split(',').slice(-3).join(', ');
                }

                document.getElementById("location").value = shortAddress;
            } else {
                document.getElementById("location").value = 
                    latLng.lat().toFixed(6) + ", " + latLng.lng().toFixed(6);
            }
        });
    }

    // دالة لتحديث قيم خطوط الطول والعرض في الـ Inputs المخفية
    function updateLatLngInputs(latLng) {
        document.getElementById("latitude").value = latLng.lat().toFixed(6);
        document.getElementById("longitude").value = latLng.lng().toFixed(6);
    }

    // حدث عند الضغط على الخريطة
    map.addListener('click', function (e) {
        marker.setPosition(e.latLng);
        updateLatLngInputs(e.latLng);
        updateAddress(e.latLng);
    });

    // حدث عند سحب المؤشر
    marker.addListener("dragend", (e) => {
        updateLatLngInputs(e.latLng);
        updateAddress(e.latLng);
    });

    // تشغيل جلب العنوان لأول مرة بناءً على الموقع الابتدائي
    updateAddress(initialLocation);
}

document.addEventListener('DOMContentLoaded', function () {
    // تهيئة المودال
    const modalEl = document.getElementById('locationModal');
    const locationModal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false
    });

    // حل مشكلة ظهور الماب بشكل ناقص أو رمادي عند فتح المودال
    modalEl.addEventListener('shown.bs.modal', function () {
        if (map) {
            google.maps.event.trigger(map, 'resize');
            // إعادة التمركز بناءً على القيم الحالية في الحقول
            const currentLat = parseFloat(document.getElementById("latitude").value) || 25.276987;
            const currentLng = parseFloat(document.getElementById("longitude").value) || 55.296249;
            map.setCenter({ lat: currentLat, lng: currentLng });
        }
    });

    // إظهار المودال تلقائياً
    locationModal.show();

    // حدث الضغط على زر الحفظ
    document.getElementById('saveLocationBtn').addEventListener('click', function () {
        const latVal = document.getElementById('latitude').value;
        const lngVal = document.getElementById('longitude').value;
        const locVal = document.getElementById('location').value;

        if (!latVal || !lngVal) {
            alert('Please select a location on the map.');
            return;
        }

        // إرسال البيانات للخادم
 // ... داخل حدث الضغط على saveLocationBtn ...
fetch("{{ route('dealer.update.location') }}", {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    body: JSON.stringify({
        latitude: latVal,
        longitude: lngVal,
        location: locVal
    })
})
.then(res => res.json())
.then(res => {
    if (res.success) {
        // 1. إخفاء المودال
        locationModal.hide();

        // 2. بدلاً من location.reload()، نقوم بإرسال فورم "إضافة قطعة الغيار" تلقائياً
        // هذا سيجعل الكود يذهب للـ store مرة أخرى، وهذه المرة سيجد العنوان موجوداً ويحفظ البارت
        document.getElementById('createPartForm').submit(); 
    } else {
        alert('Something went wrong, try again.');
    }
})
        .catch(err => {
            console.error(err);
            alert('Error communicating with server.');
        });
    });
});
</script>

@endif


<style>
    /* تغيير لون المربع عند الاختيار */
    .custom-choices-dropdown .form-check-input:checked {
        background-color: #163155 !important;
        border-color: #163155 !important;
        box-shadow: none; /* إزالة التوهج الأزرق */
    }

    /* تغيير لون حدود المربع عند التركيز عليه */
    .custom-choices-dropdown .form-check-input:focus {
        border-color: #163155;
        box-shadow: 0 0 0 0.25rem rgba(22, 49, 85, 0.25);
    }
    /* 🔥 FIX MODAL LAYER ISSUE */
    .modal { z-index: 1055 !important; }
    .modal-backdrop { z-index: 1050 !important; }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const brandModels = @json($brandModels ?? []);
    const allYears = @json($years ?? []);
    const oldBrand = @json(old('brand'));
    const oldModels = @json(old('model', []));
    const oldYears = @json(old('year', []));

    // تهيئة البراند والمدينة
    const brandSelect = new Choices('#brand', { searchEnabled: true, shouldSort: false, itemSelectText: '' });
    const citySelect = new Choices('#citySelect', { searchEnabled: true, shouldSort: false, itemSelectText: '' });

    const modelBtn = document.getElementById('modelDropdownButton');
    const modelContainer = document.getElementById('model-checkbox-container');
    const yearBtn = document.getElementById('yearDropdownButton');
    const yearContainer = document.getElementById('year-checkbox-container');

    // دالة البحث الداخلي
    function setupSearch(dropdownId) {
        const input = document.querySelector(`#${dropdownId} .dropdown-search`);
        input.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            const items = document.querySelectorAll(`#${dropdownId} .form-check`);
            items.forEach(item => {
                const text = item.innerText.toLowerCase();
                item.style.display = text.includes(filter) ? "" : "none";
            });
        });
    }

    setupSearch('modelDropdown');
    setupSearch('yearDropdown');

 function updateButtonLabel(button, container, defaultText) {
    const checkedCount = container.querySelectorAll('.item-checkbox:checked').length;
    const placeholder = button.querySelector('.placeholder-text');
    
    // اللون الذي تريده عند الاختيار (نفس لون التصميم)
    const activeColor = "#163155"; 

    if (checkedCount > 0) {
        placeholder.innerText = checkedCount + " Selected";
        placeholder.classList.add('fw-bold');
        
        // تغيير اللون برمجياً بدلاً من text-primary
        placeholder.style.color = activeColor; 
    } else {
        placeholder.innerText = defaultText;
        placeholder.classList.remove('fw-bold');
        
        // إعادة اللون للوضع الطبيعي (رمادي أو شفاف حسب رغبتك)
        placeholder.style.color = ""; 
    }
}

 function createCheckboxHTML(name, value, label, isChecked = false, isAll = false) {
    const cleanId = `chk_${name}_${value.toString().replace(/[^a-z0-9]/gi, '_')}`;
    const highlightColor = "#163155";

    return `
        <div class="form-check p-2 mb-0" style="padding-left: 2.5rem !important;">
            <input class="form-check-input ${isAll ? 'select-all-trigger' : 'item-checkbox'}" 
                    type="checkbox" name="${name}[]" 
                    value="${value}" id="${cleanId}" 
                    ${isChecked ? 'checked' : ''}
                    style="cursor:pointer;">
            <label class="form-check-label d-block w-100 ${isAll ? 'fw-bold' : 'small'}" 
                    for="${cleanId}" 
                    style="cursor:pointer; ${isAll ? 'color:' + highlightColor + ';' : ''}">
                ${label}
            </label>
        </div>`;
}

    function bindCheckboxLogic(container, type, button, defaultText) {
        const allBtn = container.querySelector('.select-all-trigger');
        const items = container.querySelectorAll('.item-checkbox');

        const handleChange = () => {
            updateButtonLabel(button, container, defaultText);
            if (type === 'model') toggleYearState();
        };

        if (allBtn) {
            allBtn.addEventListener('change', function() {
                items.forEach(cb => { if(cb.parentElement.style.display !== 'none') cb.checked = allBtn.checked; });
                handleChange();
            });
        }

        items.forEach(cb => {
            cb.addEventListener('change', function() {
                if (!this.checked && allBtn) allBtn.checked = false;
                handleChange();
            });
        });
    }

    function toggleYearState() {
        const anyModelSelected = modelContainer.querySelectorAll('.item-checkbox:checked').length > 0;
        if (anyModelSelected) {
            yearBtn.classList.remove('is-disabled');
            if (yearContainer.innerHTML.trim() === "") fillYearCheckboxes(oldYears);
        } else {
            yearBtn.classList.add('is-disabled');
            yearContainer.querySelectorAll('input').forEach(i => i.checked = false);
            updateButtonLabel(yearBtn, yearContainer, 'Select Year(s)');
        }
    }

    function fillModelCheckboxes(brandName, selectedItems = []) {
        let brand = brandName ? brandName.toLowerCase().trim() : '';
        modelContainer.innerHTML = '';
        
        if (brand && brandModels[brand]) {
            let html = createCheckboxHTML('model', 'select_all_models', 'Select All', selectedItems.includes('select_all_models'), true);
            brandModels[brand].forEach(m => {
                html += createCheckboxHTML('model', m, m, selectedItems.includes(m.toString()));
            });
            modelContainer.innerHTML = html;
            bindCheckboxLogic(modelContainer, 'model', modelBtn, 'Select Model(s)');
            updateButtonLabel(modelBtn, modelContainer, 'Select Model(s)');
            toggleYearState();
        }
    }

    function fillYearCheckboxes(selectedItems = []) {
        yearContainer.innerHTML = '';
        let html = createCheckboxHTML('year', 'select_all_years', 'Select All', selectedItems.includes('select_all_years'), true);
        allYears.forEach(y => {
            html += createCheckboxHTML('year', y.toString(), y.toString(), selectedItems.includes(y.toString()));
        });
        yearContainer.innerHTML = html;
        bindCheckboxLogic(yearContainer, 'year', yearBtn, 'Select Year(s)');
        updateButtonLabel(yearBtn, yearContainer, 'Select Year(s)');
    }

    brandSelect.passedElement.element.addEventListener('change', function () {
        fillModelCheckboxes(this.value);
    });

    // تحميل البيانات القديمة
    const initialBrand = oldBrand || document.getElementById('brand').value;
    if (initialBrand) {
        fillModelCheckboxes(initialBrand, oldModels);
        if (oldModels.length > 0) fillYearCheckboxes(oldYears);
    }

    // تفعيل اختيار الأقسام (Category Selection)
const categoryInput = document.getElementById('categoryInput');
const categoryIcons = document.querySelectorAll('.category-icon');

categoryIcons.forEach(icon => {
    icon.addEventListener('click', function() {
        // 1. إزالة كلاس selected من الجميع
        categoryIcons.forEach(i => i.classList.remove('selected'));
        
        // 2. إضافة كلاس selected للعنصر الذي تم الضغط عليه
        this.classList.add('selected');
        
        // 3. تحديث قيمة الـ Hidden Input بمعرف القسم (ID)
        const categoryId = this.getAttribute('data-id');
        categoryInput.value = categoryId;
        
        console.log("Selected Category ID:", categoryId); // للتأكد في الكونسول
    });
});
});

</script>
@endsection