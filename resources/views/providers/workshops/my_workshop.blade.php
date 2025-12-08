@extends('layouts.CarProvider')

@section('content')

<div class="py-4 " style="background-color: #fff; padding-right:80px; padding-left:80px;">

    <h3 class="mb-4 fw-bold">My Workshop</h3>

<form action="{{ route('workshops.update', $workshop->id) }}" 
      method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>
        <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <div class="row">

     <!-- ====================== Upload Images ====================== -->
<!-- Image Upload -->
<div class="upload-section w-100">
    <div class="fileInput w-100 text-center py-4 border rounded-3" id="fileInputContainer"
        style="cursor: pointer; border: 2px dashed #ced4da;">
        <i class="fas fa-camera fa-2x text-secondary"></i>
        <span id="placeholderText" class="text-muted fw-semibold d-block mt-2">Add Image</span>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-2">
        <span id="imageCount" class="text-muted small">0 / 5</span>
        <span id="errorMessage" class="text-danger small fw-semibold"></span>
    </div>

    <input type="file" id="imageInput" name="images[]" accept="image/*" multiple hidden>

    <div id="previewContainer" class="image-grid mt-3 d-flex flex-wrap">
        @php
            $images = $workshop->images ? $workshop->images->map(fn($img) => env('CLOUDFLARE_R2_URL') . $img->image)->toArray() : [];
        @endphp

    @foreach($images as $index => $img)
    <div class="existing-image position-relative me-2 mb-2" style="width:100px; height:100px; cursor:pointer;">
        <img src="{{ $img }}" alt="Workshop Image"
             style="width:100%; height:100%; object-fit:cover; border-radius:8px;"
             class="viewable-image">

        <!-- Improved X button -->
        <button type="button" class="remove-btn" data-id="{{ $workshop->images[$index]->id }}">
            ×
        </button>

        <input type="hidden" name="existing_images[]" value="{{ $workshop->images[$index]->id }}">
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
        imageCount.textContent = `${existingImages} / 5`;
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
        const remaining = 5 - (uploadedFiles.length + document.querySelectorAll('.existing-image').length);
        const newFiles = [...event.target.files].slice(0, remaining);

        newFiles.forEach(file => {
            uploadedFiles.push(file);
            createThumbnail(file);
        });

        if(event.target.files.length > remaining) {
            errorMessage.textContent = "⚠️ You can upload up to 5 images only.";
        } else {
            errorMessage.textContent = "";
        }

        updateInputFiles();
    });

    // Remove existing images
    document.querySelectorAll(".remove-btn").forEach(btn => {
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
.remove-btn {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 20px;
    height: 20px;
    background: rgba(0,0,0,0.6);
    color: #fff;
    border: none;
    border-radius: 50%;
    font-size: 14px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 2;
    transition: background 0.2s ease;
}

.remove-btn:hover {
    background: rgba(255,0,0,0.8);
}

</style>




            <!-- ====================== Car Brands ====================== -->
<div class="col-12 mb-4">
    <label class="form-label fw-semibold">Car Brand</label>

    <div class="dropdown-container">
        <input type="text" id="brandSearch" placeholder="Select brands..." readonly class="form-control">

        <div id="brandDropdown" class="dropdown-list">

            <div class="dropdown-actions p-2 d-flex gap-2 border-bottom">
                <button type="button" id="selectAllBrands" class="btn border-radius w-50" 
                    style="color: #163155; border:1px solid #163155; border-radius: 12px;">Select All</button>

                <button type="button" id="clearBrands" class="btn btn-outline-danger border-radius w-50">
                    Clear All
                </button>
            </div>

            {{-- ⭐ هنا نعرض كل البراندات --}}
            @foreach($brands as $brand)
                <div class="dropdown-item" 
                     data-value="{{ $brand->id }}"
                     data-name="{{ $brand->name }}">
                    <span>{{ $brand->name }}</span>
                    <span class="check-mark">✔</span>
                </div>
            @endforeach

        </div>
    </div>

    {{-- ⭐ هنا تظهر البراندات المختارة كـ Tags --}}
    <div id="selectedBrandsContainer" class="mt-2 d-flex flex-wrap gap-2"></div>

    {{-- ⭐ هنا نخزن الـ IDs --}}
    <div id="brandHiddenInputs"></div>
</div>


<style>
.dropdown-container { position: relative; width: 100%; }
#brandSearch { cursor: pointer; }

.dropdown-list {
    position: absolute;
    top: 100%; left: 0;
    width: 100%; max-height: 200px; /* يمكن زيادة هذا إذا كنت تريد مساحة أكبر للأزرار */
    overflow-y: auto; border: 1px solid #ccc;
    border-radius: 6px; background: #fff; display: none; z-index: 10;
}

/* تحديث CSS لتطبيق تنسيق البوتستراب d-flex, gap-2, p-2, border-bottom على الـ div الجديد */
.dropdown-actions {
    /* لضمان أن الأزرار تبقى في الأعلى ولا تتحرك عند التمرير */
    position: sticky;
    top: 0;
    background: #fff; /* تأكد من أن الخلفية بيضاء لإخفاء العناصر التي تمر من تحتها */
    z-index: 11;
}

.dropdown-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 12px;
    cursor: pointer;
}

.dropdown-item.selected { background-color: #cce0ff; }
.dropdown-item:hover { background-color: #e8f0ff; color: #163155; }

.check-mark { display: none; color: #0d6efd; font-weight: bold; }
.dropdown-item.selected .check-mark { display: inline; }

.brand-tag {
    background-color: #e8f0ff; color: #163155;
    padding: 4px 10px; border-radius: 12px;
    font-size: 0.85rem; display: flex;
    align-items: center; gap: 4px;
}
.brand-tag button {
    background: none; border: none;
    color: #163155; font-weight: bold;
    cursor: pointer;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const brandSearch = document.getElementById("brandSearch");
    const brandDropdown = document.getElementById("brandDropdown");
    const selectedContainer = document.getElementById("selectedBrandsContainer");
    const hiddenInputsContainer = document.getElementById("brandHiddenInputs");

    // مُعرفات الأزرار لم تتغير، لذا لا تحتاج لتغييرها في JS.
    const btnSelectAll = document.getElementById("selectAllBrands");
    const btnClear = document.getElementById("clearBrands");

    // Brands from backend
    let selectedBrands = @json($selectedBrands ?? []);

    // **التغيير هنا**: يجب أن نستخدم مُحدد (Selector) أدق للحصول على العناصر القابلة للاختيار فقط،
    // واستبعاد الـ div الخاص بالأزرار (#brandDropdown يحتوي الآن على div الأزرار بالإضافة للعناصر).
    const allBrandsItems = brandDropdown.querySelectorAll(".dropdown-item");

    // All brands list (id + name)
    const allBrands = [...allBrandsItems].map(item => ({
        id: item.dataset.value,
        name: item.querySelector("span").innerText
    }));

    // ================================
    // Render Selected Brands
    // ================================
    function updateSelected() {
        selectedContainer.innerHTML = '';
        hiddenInputsContainer.innerHTML = '';

        selectedBrands.forEach(brand => {
            const tag = document.createElement("div");
            tag.classList.add("brand-tag");
            tag.innerHTML = `${brand.name} <button type="button" data-id="${brand.id}">&times;</button>`;
            selectedContainer.appendChild(tag);

            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "brands[]";
            input.value = brand.id;
            hiddenInputsContainer.appendChild(input);
        });

        // Remove individual brand
        selectedContainer.querySelectorAll("button").forEach(btn => {
            btn.addEventListener("click", function() {
                const id = this.dataset.id;
                selectedBrands = selectedBrands.filter(b => b.id != id);
                updateSelected();
                updateDropdownSelection();
            });
        });
    }

    function updateDropdownSelection() {
        // **التغيير هنا**: استخدام allBrandsItems بدلاً من brandDropdown.querySelectorAll(".dropdown-item")
        // لضمان أننا نتحقق من حالة العناصر القابلة للاختيار فقط
        allBrandsItems.forEach(item => {
            const id = item.dataset.value;
            item.classList.toggle('selected', selectedBrands.some(b => b.id == id));
        });
    }

    updateSelected();
    updateDropdownSelection();

    // ================================
    // Dropdown toggle
    // ================================
    brandSearch.addEventListener("click", () => {
        brandDropdown.style.display =
            brandDropdown.style.display === 'block' ? 'none' : 'block';
    });

    // ================================
    // Click dropdown item (toggle)
    // ================================
    // **التغيير هنا**: استخدام allBrandsItems
    allBrandsItems.forEach(item => {
        item.addEventListener("click", () => {
            const id = item.dataset.value;
            const name = item.querySelector("span").innerText;

            const exists = selectedBrands.find(b => b.id == id);
            if (exists) {
                selectedBrands = selectedBrands.filter(b => b.id != id);
            } else {
                selectedBrands.push({id, name});
            }

            updateSelected();
            updateDropdownSelection();
        });
    });

    // ================================
    // Select All button
    // ================================
    btnSelectAll.addEventListener("click", () => {
        selectedBrands = allBrands.map(b => ({id: b.id, name: b.name}));
        updateSelected();
        updateDropdownSelection();
    });

    // ================================
    // Clear All button
    // ================================
    btnClear.addEventListener("click", () => {
        selectedBrands = [];
        updateSelected();
        updateDropdownSelection();
    });

    // ================================
    // Close dropdown on outside click
    // ================================
    document.addEventListener("click", function(e) {
        if (!brandSearch.contains(e.target) && !brandDropdown.contains(e.target)) {
            brandDropdown.style.display = 'none';
        }
    });
});
</script>



            <!-- ====================== Basic Information ====================== -->
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Workshop Name</label>
                <input type="text" name="workshop_name" class="form-control" placeholder="Enter Workshop Name"
                       value="{{ $workshop->workshop_name }}" required readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Owner</label>
                <input type="text" name="owner" class="form-control" placeholder="Enter Owner Name"
                       value="{{ $workshop->owner }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Employee Number</label>
                <input type="number" name="employee" class="form-control" placeholder="Enter Employee Number"
                       value="{{ $workshop->employee }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tax Number</label>
                <input type="text" name="tax_number" class="form-control" placeholder="Enter Tax Number"
                       value="{{ $workshop->tax_number }}">
            </div>

    <div class="col-md-6 mb-3">
    <label class="form-label fw-semibold">WhatsApp Number</label>
    <div class="input-group">
        <span class="input-group-text">+971</span>
        <input 
            required
            type="tel" 
            name="whatsapp_number" 
            class="form-control" 
            placeholder="Enter WhatsApp number" 
            maxlength="9"
            value="{{ old('whatsapp_number', isset($workshop) ? str_replace('+971', '', $workshop->whatsapp_number) : '') }}"
        >
    </div>
</div>

{{-- ====================================================== --}}

<style>
/* Style remains the same */
.custom-modal {
    display: none;
    position: fixed;
    z-index: 1050;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}
.custom-modal-content {
    background: #fff;
    margin: 10% auto;
    padding: 20px;
    border-radius: 12px;
    width: 350px;
}
.day-btn{
    border:2px solid #163155;
}
.day-btn.active, .day-btn:hover {
    background-color: #163155;
    color: #fff;
}
.day-btn small {
    font-size: 12px;
    color: #f2eeee;
}
/* إضافة لون زر الحذف */
.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
}
</style>
<!-- Working Days -->
<div class="col-md-12 mb-4">
    <label class="form-label fw-semibold">Working Days & Hours</label>

    <div class="d-flex flex-wrap gap-2 mt-2">
        @php
            $days = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];
            // ✅ FIX 7: استخدام المتغير $saved_days_for_js الذي تم تجهيزه في الكنترولر
            $saved_days = $saved_days_for_js ?? []; 
        @endphp

        @foreach($days as $day)
            <button type="button"
                class="btn day-btn {{ isset($saved_days[$day]) && !empty($saved_days[$day]['from']) ? 'active' : '' }}"
                data-day="{{ $day }}">
                {{ $day }}
                @if(isset($saved_days[$day]) && !empty($saved_days[$day]['from']))
                    <br>
                    <small>{{ $saved_days[$day]['from'] }} - {{ $saved_days[$day]['to'] }}</small>
                @endif
            </button>
        @endforeach
    </div>

    <!-- ✅ FIX 8: تمرير الـ $saved_days المعدل إلى حقل الإدخال المخفي -->
<input type="hidden" name="working_days" id="workingDaysInput" value='{{ json_encode($saved_days_for_js ?? []) }}'>
</div>


<!-- Custom Modal (تم إضافة زر مسح الساعات) -->
<div id="customTimeModal" class="custom-modal">
    <div class="custom-modal-content">
        <span class="custom-modal-close">&times;</span>
        <h5 class="fw-bold mb-3 text-center">Select Working Hours</h5>

        <div class="mb-3">
            <label class="fw-semibold">From:</label>
            <input type="text" id="fromTime" class="form-control" placeholder="Select From Time" readonly>
        </div>

        <div class="mb-3">
            <label class="fw-semibold">To:</label>
            <input type="text" id="toTime" class="form-control" placeholder="Select To Time" readonly>
        </div>

        <button type="button" style="background-color: #163155; color: #fff;" class="btn w-100" id="saveTimeBtn">Save</button>
        
        <!-- ✅ FIX 9: إضافة زر لمسح الساعات ليوم معين -->
        <button type="button" class="btn btn-danger w-100 mt-2" id="clearTimeBtn">Clear Hours</button> 
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {

    let selectedDay = null;
    const workingDaysInput = document.getElementById("workingDaysInput");
    
    // 1. قراءة القيمة الأولية من الحقل المخفي
    let workingDaysRaw = workingDaysInput ? workingDaysInput.value : '[]';

    let workingDays = {};
    
    // 2. تصحيح التهيئة: التأكد من أن workingDays هو كائن (Object) وليس مصفوفة (Array) فارغة
    try {
        let parsed = JSON.parse(workingDaysRaw);
        
        // التحقق: إذا كانت القيمة كائن وليست مصفوفة، نستخدمها.
        if (parsed && typeof parsed === 'object' && !Array.isArray(parsed)) {
            workingDays = parsed;
        } else if (Array.isArray(parsed) && parsed.length === 0) {
            // إذا كانت مصفوفة فارغة '[]'، نعتبرها كائن فارغ.
            workingDays = {};
        }
    } catch (e) {
        // في حال فشل الـ parse (مثلاً، إذا كانت القيمة فارغة تمامًا)
        workingDays = {};
    }

    const modal = document.getElementById("customTimeModal");
    const closeModalBtn = modal.querySelector(".custom-modal-close");

    const fromInput = document.getElementById("fromTime");
    const toInput = document.getElementById("toTime");

    let fromPicker, toPicker;

    // 3. دالة تحديث الحقل المخفي
    function updateHiddenInput() {
        if (workingDaysInput) {
            workingDaysInput.value = JSON.stringify(workingDays);
            // يمكنك إضافة console.log للتحقق هنا:
            // console.log("Hidden Input Updated:", workingDaysInput.value);
        }
    }

    function openModal() {
        modal.style.display = "block";

        if (fromPicker) fromPicker.destroy();
        if (toPicker) toPicker.destroy();

        // يجب أن تكون flatpickr متاحة هنا (تم تضمينها في نهاية ملف الـ blade)
        fromPicker = flatpickr(fromInput, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K"
        });

        toPicker = flatpickr(toInput, {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K"
        });

        // تعبئة البيانات الموجودة مسبقًا
        if (workingDays[selectedDay]) {
            fromPicker.setDate(workingDays[selectedDay].from);
            toPicker.setDate(workingDays[selectedDay].to);
        } else {
            fromInput.value = "";
            toInput.value = "";
        }
    }

    function closeModal() {
        modal.style.display = "none";
    }

    // فتح الـ Modal عند الضغط على زر اليوم
    document.querySelectorAll(".day-btn").forEach(btn => {
        btn.addEventListener("click", function() {
            selectedDay = this.dataset.day;
            openModal();
        });
    });

    closeModalBtn.onclick = closeModal;

    // حفظ الساعات
    document.getElementById("saveTimeBtn").addEventListener("click", function() {

        let from = fromInput.value.trim();
        let to = toInput.value.trim();

        if (!from || !to) return;

        workingDays[selectedDay] = { from, to };
        updateHiddenInput(); // تحديث الحقل المخفي

        let btn = document.querySelector(`button[data-day="${selectedDay}"]`);
        btn.innerHTML = `${selectedDay}<br><small>${from} - ${to}</small>`;
        btn.classList.add("active");

        closeModal();
    });

    // مسح الساعات
    document.getElementById("clearTimeBtn").addEventListener("click", function() {

        delete workingDays[selectedDay];
        updateHiddenInput(); // تحديث الحقل المخفي بعد المسح

        let btn = document.querySelector(`button[data-day="${selectedDay}"]`);
        btn.innerHTML = selectedDay;
        btn.classList.remove("active");

        closeModal();
    });

});
</script>




<!-- ====================== Workshop Categories ====================== -->
<div class="col-12 mb-4">
    <label class="form-label fw-semibold">Workshop Categories</label>

    @php
        // جلب الـ IDs المحفوظة من العلاقة many-to-many مباشرة
        $saved = $workshop->categories()->pluck('workshop_categories.id')->toArray();
    @endphp

    <div class="d-flex flex-wrap gap-3 icon-card-container">
        @foreach($categories as $category)
            @php
                $img = $category->image
                    ? config('app.file_base_url') . Str::after($category->image, url('/') . '/')
                    : 'https://via.placeholder.com/60';
            @endphp

            <label class="service-option-large" style="cursor:pointer;">
                <input type="checkbox" 
                       name="workshop_categories[]" 
                       value="{{ $category->id }}"
                       class="d-none"
                       {{ in_array($category->id, $saved) ? 'checked' : '' }}>

                <div class="icon-card text-center border rounded-3 
                             {{ in_array($category->id, $saved) ? 'selected-service' : '' }}">

                    <div class="large-icon-wrapper mx-auto mb-2">
                        <img src="{{ $img }}" 
                             alt="{{ $category->name }}" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    <div class="fw-semibold card-text-category">
                        {{ $category->name }}
                    </div>
                </div>
            </label>
        @endforeach
    </div>
</div>

<style>
/* ------------------------------------------- */
/* توحيد حجم البطاقة والأيقونة (نمط الصورة المرفقة) */
/* ------------------------------------------- */

/* حجم الأيقونة الموحد (70x70) - للشاشات الكبيرة والمتوسطة */
.large-icon-wrapper {
    width: 70px; 
    height: 70px; 
    overflow: hidden; 
    border-radius: 8px;
    background-color: transparent;
}

/* تنسيق البطاقة المربعة (130x130) - للشاشات الكبيرة والمتوسطة */
.icon-card {
    width: 130px; 
    height: 130px;
    display: flex; 
    flex-direction: column;
    justify-content: center; 
    align-items: center; 
    cursor: pointer;
    transition: all 0.2s; 
    padding: 10px;
    background-color: #f8f9fa; 
}

.card-text-category {
    font-size: 0.9rem;
    line-height: 1.2;
    padding-top: 5px;
    white-space: normal; 
    word-break: break-word;
}

.selected-service {
    border: 2px solid #163155 !important;
    background-color: #e8f0ff !important;
    box-shadow: 0 0 6px rgba(0, 123, 255, 0.4);
}

/* ======================================== */
/* 🎯 التعديل النهائي لضمان عمودين على الشاشات الصغيرة جداً (< 576px) */
/* ======================================== */
@media (max-width: 575.98px) {
    /* تقليص حجم البطاقة إلى 100x100 بكسل */
    .icon-card {
        width: 100px; 
        height: 100px;
        padding: 5px; /* تقليل الحشو الداخلي لأقصى حد */
    }
    
    /* تقليص حجم الأيقونة إلى 50x50 بكسل */
    .large-icon-wrapper {
        width: 50px; 
        height: 50px; 
    }
    
    .card-text-category {
        font-size: 0.75rem; /* تقليل حجم النص */
    }
    
    .icon-card-container {
        /* استخدام justify-content: space-between لتوزيع البطاقات على كامل العرض المتاح */
        justify-content: space-between !important; 
        gap: 0.2rem !important; /* تقليل التباعد بين البطاقات */
        padding: 0 5px; /* إضافة حشو بسيط للحاوية الأم */
    }
}

/* ------------------------------------------- */
/* ضمان عدم تأثير قواعد الشاشات الكبيرة السابقة */
/* ------------------------------------------- */
@media (min-width: 992px) {
    .icon-card {
        transform: none !important; 
        padding: 10px; 
    }
    
    .large-icon-wrapper {
        width: 70px !important;
        height: 70px !important;
    }
    
    .card-text-category {
        font-size: 0.9rem !important;
    }
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("input[type='checkbox'][name='workshop_categories[]']").forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {

            // الوصول للكارت اللي جوّا الليبل
            let card = this.closest("label").querySelector(".icon-card");

            if (this.checked) {
                card.classList.add("selected-service");
            } else {
                card.classList.remove("selected-service");
            }
        });
    });
});
</script>





        </div>

        <button type="submit"  id="saveBtn"  class="btn px-4 mt-3" style="background-color: #163155; color: #fff">Save Changes</button>

    </form>
</div>


<style>
.category-box {
    display: flex;
    align-items: center;
    gap: 8px;
    border: 2px solid #ddd;
    padding: 10px 14px;
    border-radius: 10px;
    cursor: pointer;
}

.category-box input {
    display: none;
}

.category-box .icon-box {
    font-size: 22px;
}

.category-box input:checked + .icon-box,
.category-box input:checked ~ span {
    font-weight: bold;
    color: #163155;
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>


@endsection
