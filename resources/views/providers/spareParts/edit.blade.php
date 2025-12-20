@extends('layouts.CarProvider')

@section('content')

<div class="container mt-5 rounded-4" style="background-color: #fff; padding: 30px;">
    <h2 class="fw-bold mb-4" style="color: #163155;">Edit {{ $part->name ??  'Spare Part'  }} </h2>

    {{-- 1. تغيير المسار واستخدام PUT/PATCH --}}
    <form id="editPartForm" method="POST" action="{{ route('spareparts.update', $part->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- مهم جداً لتجاوز متطلبات Laravel --}}
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
        {{-- متغيرات مساعدة لاستخدامها في JavaScript --}}
        @php
            // تحويل القيم المخزنة في قاعدة البيانات إلى مصفوفات جاهزة لـ JavaScript
            $selectedBrand = strtolower(trim($part->brand ?? ''));
            // Model و Year غالبًا ما يتم تخزينها كمصفوفة أو سلسلة JSON أو سلسلة مفصولة، سنفترض أنها مصفوفة في قاعدة البيانات
// ===============================================
    // 1. معالجة حقل الموديلات (car_model)
    // ===============================================
    $rawModels = $part->car_model ?? null;
    
    // محاولة فك ترميز JSON إلى مصفوفة PHP
    $decodedModels = $rawModels ? json_decode($rawModels, true) : null;
    
    // التأكد من أن القيمة النهائية هي مصفوفة، وإلا تكون مصفوفة فارغة
    $selectedModels = is_array($decodedModels) ? $decodedModels : [];$rawYears = $part->year ?? null; // يجب أن يكون حقل "year" في قاعدة البيانات
    $decodedYears = $rawYears ? json_decode($rawYears, true) : null;
    
    // التأكد من أن القيمة النهائية هي مصفوفة، وإلا تكون مصفوفة فارغة
    $selectedYears = is_array($decodedYears) ? $decodedYears : [];        @endphp


        {{-- 1. Car Brand (Select-One) --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Car Brand</label>
            {{-- تحديث: استخدام $selectedBrand للمقارنة --}}
            <select class="form-select rounded-4" id="brand" name="brand" >
                @foreach($sortedMakes as $make)
                @php $normalizedMake = strtolower(trim($make)); @endphp
                <option value="{{ $normalizedMake }}" {{ $selectedBrand == $normalizedMake ? 'selected' : '' }}>
                    {{ $make }}
                </option>
                @endforeach
            </select>
        </div>

{{-- 2. Model Dropdown (Multi-Select Checkboxes) --}}
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
                {{-- JavaScript will fill this --}}
            </div>
        </div>
    </div>
</div>

{{-- 3. Year Dropdown (Multi-Select Checkboxes) --}}
<div class="mb-3">
    <label class="form-label fw-semibold small text-muted">Year</label>
    <div class="dropdown custom-choices-dropdown" id="yearDropdown">
        <div class="custom-choices-inner dropdown-toggle" id="yearDropdownButton" data-bs-toggle="dropdown" data-bs-auto-close="outside">
            <span class="placeholder-text">Select Year(s)</span>
        </div>
        <div class="dropdown-menu shadow rounded-4 p-2" style="width: 100%;">
            <div class="px-2 pb-2 border-bottom mb-2">
                <input type="text" class="form-control form-control-sm dropdown-search" placeholder="Search years...">
            </div>
            <div class="checkbox-list p-2" id="year-checkbox-container" style="max-height: 250px; overflow-y: auto;">
                {{-- JavaScript will fill this --}}
            </div>
        </div>
    </div>
</div>

        {{-- Links and Scripts (نفس الكود) --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

        {{-- Styles (نفس الكود) --}}
        <style>
            /* ... (ضع كود الـ CSS بالكامل هنا) ... */
/* ============================================================= */
/* ===============   Choices.js Custom Styling   =============== */
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
/* ==================      Categories Icons      ================= */
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
    white-space: normal;      /* allow wrapping */
    overflow: visible;        /* show all text */
    text-overflow: unset;      /* remove ellipsis */
    word-wrap: break-word;    /* break long words if needed */
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


        {{-- City and other fields --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">City</label>
            <select class="form-select rounded-4" id="citySelect" name="city" >
                <option value="">Select City</option>
                @foreach($cities as $city)
                    {{-- تحديث: تحديد القيمة المخزنة --}}
                    <option value="{{ $city }}" {{ ($part->city ?? '') == $city ? 'selected' : '' }}>{{ $city }}</option>
                @endforeach
            </select>
        </div>


        {{-- Sparepart Type (New/Used) --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Sparepart Type</label>

            <div class="d-flex gap-3 mt-1">

                <div class="condition-btn {{ ($part->part_type ?? '') == 'New' ? 'selected' : '' }}" data-value="New">
                    New
                </div>

                <div class="condition-btn {{ ($part->part_type ?? '') == 'Used' ? 'selected' : '' }}" data-value="Used">
                    Used
                </div>

            </div>

            {{-- تحديث: تعبئة القيمة المخزنة --}}
            <input type="hidden" name="part_type" id="conditionInput" value="{{ $part->part_type ?? '' }}" required>
        </div>

        <style>
            /* ... (ضع كود الـ CSS الخاص بـ .condition-btn هنا) ... */
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

        {{-- تحديث بسيط في JavaScript للحفاظ على النمط --}}
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


        {{-- VIN Number --}}
        {{-- تحديث: التحكم في الإظهار بناءً على القيمة المخزنة --}}
        <div class="mb-3" id="vinWrapper" style="display: {{ ($part->part_type ?? '') == 'New' ? 'block' : 'none' }};">
            <label class="form-label fw-semibold small text-muted">VIN Number</label>
            {{-- تحديث: تعبئة القيمة المخزنة --}}
            <input type="text" name="vin_number" class="form-control rounded-4" placeholder="Enter VIN Number" value="{{ $part->vin_number ?? '' }}">
        </div>


        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Category</label>

            <div class="d-flex flex-wrap justify-content-start gap-3">
                @foreach($mainCategories as $category)
                @php
                $img = $category->image
                ? config('app.file_base_url') . Str::after($category->image, url('/') . '/')
                : 'https://via.placeholder.com/60';
                
                // تحديث: تحديد الفئة المختارة
                 $isSelected = ($part->category_id ?? null) == $category->id;                @endphp
                <div class="text-center category-icon flex-shrink-0 {{ $isSelected ? 'selected' : '' }}" data-id="{{ $category->id }}"
                    data-name="{{ $category->name }}" data-subs='@json($category->subcategories)'>
                    <img src="{{ $img }}" class="rounded mb-1" width="60" height="60">
                    <div style="font-size:0.75rem;">{{ $category->name }}</div>
                </div>
                @endforeach
            </div>

            {{-- تحديث: تعبئة القيمة المخزنة --}}
<input type="hidden" name="category" id="categoryInput"
       value="{{ $part->category_id ?? '' }}" >
        </div>

        {{-- Subcategory (إذا كنت تستخدمها - لم تكن موجودة في الـ HTML الرئيسي لصفحة الإنشاء لكن سأضيفها للاكتمال) --}}
        {{--
        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Subcategory</label>
            <select class="form-select rounded-4" id="subcategorySelect" name="subcategory" required>
                <option value="">Select Subcategory</option>
                // سيتم تعبئتها بواسطة JavaScript بناءً على الفئة المختارة مسبقًا
            </select>
        </div>
        --}}

        <button type="submit" class="btn text-white fw-semibold" style="background:#163155;">
            Update 
        </button>
    </form>

</div>
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
</style>
<style>
/* جعل الحاوية تبدو كحقل إدخال */
.custom-choices-inner {
    background-color: #fff;
    border: 1px solid #dee2e6; /* نفس لون حدود Bootstrap */
    border-radius: 0.5rem; /* حواف دائرية */
    padding: 0.6rem 1rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    min-height: 42px;
}

/* تأثير عند تمرير الماوس */
.custom-choices-inner:hover {
    border-color: #babbbc;
}

/* شكل الحقل عندما يكون معطلاً */
.custom-choices-inner.is-disabled {
    background-color: #e9ecef;
    cursor: not-allowed;
    opacity: 0.7;
}

/* إضافة سهم لأسفل (Chevron) ليعرف المستخدم أنها قائمة */
.custom-choices-inner::after {
    content: "";
    width: 0.8em;
    height: 0.5em;
    background-color: #6c757d;
    clip-path: polygon(100% 0%, 0 0%, 50% 100%); /* رسم سهم صغير */
    margin-left: 10px;
}

/* إخفاء السهم الافتراضي لـ Bootstrap إذا وجد */
.dropdown-toggle::after {
    display: none !important;
}

/* تغيير لون الحدود عند اختيار أي عنصر (اختياري) */
.custom-choices-dropdown .placeholder-text.fw-bold {
    color: #163155 !important;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. البيانات القادمة من لارافل (تأكد من تمريرها من الـ Controller)
    const brandModels = @json($brandModels ?? []);
    const allYearsList = @json($years ?? []); 
    const selectedBrand = @json($selectedBrand ?? null);
    const selectedModels = @json($selectedModels ?? []).map(m => m.toString());
    const selectedYears = @json($selectedYears ?? []).map(y => y.toString());

    const activeColor = "#163155";

    // 2. تهيئة البراند والمدينة باستخدام Choices.js (مثل الكريت)
    const brandSelect = new Choices('#brand', { searchEnabled: true, shouldSort: false, itemSelectText: '' });
    const citySelect = new Choices('#citySelect', { searchEnabled: true, shouldSort: false, itemSelectText: '' });

    // 3. تهيئة عناصر الموديل والسنة
    const modelBtn = document.getElementById('modelDropdownButton');
    const modelContainer = document.getElementById('model-checkbox-container');
    const yearBtn = document.getElementById('yearDropdownButton');
    const yearContainer = document.getElementById('year-checkbox-container');

    // 4. دالة البحث الداخلي
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

    // 5. دالة تحديث نص الزر
    function updateButtonLabel(button, container, defaultText) {
        const checkedCount = container.querySelectorAll('.item-checkbox:checked').length;
        const placeholder = button.querySelector('.placeholder-text');
        if (checkedCount > 0) {
            placeholder.innerText = checkedCount + " Selected";
            placeholder.classList.add('fw-bold');
            placeholder.style.color = activeColor;
        } else {
            placeholder.innerText = defaultText;
            placeholder.classList.remove('fw-bold');
            placeholder.style.color = "";
        }
    }

    // 6. بناء الـ HTML للـ Checkbox
    function createCheckboxHTML(name, value, label, isChecked = false, isAll = false) {
        const cleanId = `chk_${name}_${value.toString().replace(/[^a-z0-9]/gi, '_')}`;
        return `
            <div class="form-check p-2 mb-0" style="padding-left: 2.5rem !important;">
                <input class="form-check-input ${isAll ? 'select-all-trigger' : 'item-checkbox'}" 
                       type="checkbox" name="${name}[]" 
                       value="${value}" id="${cleanId}" 
                       ${isChecked ? 'checked' : ''} style="cursor:pointer;">
                <label class="form-check-label d-block w-100 ${isAll ? 'fw-bold' : 'small'}" 
                       for="${cleanId}" style="cursor:pointer; ${isAll ? 'color:' + activeColor + ';' : ''}">
                    ${label}
                </label>
            </div>`;
    }

    // 7. ربط منطق الاختيار
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

    // 8. تفعيل/تعطيل قائمة السنوات
    function toggleYearState() {
        const anyModelSelected = modelContainer.querySelectorAll('.item-checkbox:checked').length > 0;
        if (anyModelSelected) {
            yearBtn.classList.remove('is-disabled');
        } else {
            yearBtn.classList.add('is-disabled');
            yearContainer.querySelectorAll('input').forEach(i => i.checked = false);
            updateButtonLabel(yearBtn, yearContainer, 'Select Year(s)');
        }
    }

    // 9. تعبئة الموديلات (Edit Mode)
    function fillModelCheckboxes(brandName, selectedItems = []) {
        let brand = brandName ? brandName.toLowerCase().trim() : '';
        modelContainer.innerHTML = '';
        if (brand && brandModels[brand]) {
            let html = createCheckboxHTML('model', 'select_all_models', 'Select All', false, true);
            brandModels[brand].forEach(m => {
                html += createCheckboxHTML('model', m, m, selectedItems.includes(m.toString()));
            });
            modelContainer.innerHTML = html;
            bindCheckboxLogic(modelContainer, 'model', modelBtn, 'Select Model(s)');
            updateButtonLabel(modelBtn, modelContainer, 'Select Model(s)');
            toggleYearState();
        }
    }

    // 10. تعبئة السنوات (Edit Mode)
    function fillYearCheckboxes(selectedItems = []) {
        yearContainer.innerHTML = '';
        let html = createCheckboxHTML('year', 'select_all_years', 'Select All', false, true);
        allYearsList.forEach(y => {
            html += createCheckboxHTML('year', y.toString(), y.toString(), selectedItems.includes(y.toString()));
        });
        yearContainer.innerHTML = html;
        bindCheckboxLogic(yearContainer, 'year', yearBtn, 'Select Year(s)');
        updateButtonLabel(yearBtn, yearContainer, 'Select Year(s)');
    }

    // --- الأحداث (Events) ---

    // عند تغيير البراند (باستخدام Choices.js event)
    brandSelect.passedElement.element.addEventListener('change', function () {
        fillModelCheckboxes(this.value, []); // تصفير الموديلات عند تغيير البراند
        fillYearCheckboxes([]); // تصفير السنوات
    });

    // تحميل البيانات المحفوظة (عند فتح صفحة التعديل)
    if (selectedBrand) {
        fillModelCheckboxes(selectedBrand.toLowerCase(), selectedModels);
        fillYearCheckboxes(selectedYears);
    }
    
    // كود اختيار الأقسام (Category) كما هو
    const categoryInput = document.getElementById('categoryInput');
    const categoryIcons = document.querySelectorAll('.category-icon');
    categoryIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            categoryIcons.forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');
            categoryInput.value = this.getAttribute('data-id');
        });
    });
});
</script>
@endsection