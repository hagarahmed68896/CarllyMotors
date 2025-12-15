@extends('layouts.CarProvider')

@section('content')

<div class="container mt-5 rounded-4" style="background-color: #fff; padding: 30px;">
    <h2 class="fw-bold mb-4" style="color: #163155;">Edit {{ $part->name ??  'Spare Part'  }} </h2>

    {{-- 1. تغيير المسار واستخدام PUT/PATCH --}}
    <form id="editPartForm" method="POST" action="{{ route('spareparts.update', $part->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- مهم جداً لتجاوز متطلبات Laravel --}}

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
            <select class="form-select rounded-4" id="brand" name="brand" required>
                <option value="">All Brands</option>
                @foreach($sortedMakes as $make)
                @php $normalizedMake = strtolower(trim($make)); @endphp
                <option value="{{ $normalizedMake }}" {{ $selectedBrand == $normalizedMake ? 'selected' : '' }}>
                    {{ $make }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- 2. Model (Multi-Select) --}}
{{-- 2. Model (Multi-Select) --}}
<div class="mb-3">
    <label class="form-label fw-semibold small text-muted">Model</label>
    <select class="form-select rounded-4" id="model" name="model[]" multiple required>
        <option value="select_all_models" class="text-primary fw-bold">
            Select All
        </option>
        @foreach($brandModels[$selectedBrand] ?? [] as $model)
            {{-- يجب أن تكون فارغة من 'selected' --}}
            <option value="{{ $model }}">
                {{ $model }}
            </option>
        @endforeach
    </select>
</div>

{{-- 3. Year (Multi-Select) --}}
<div class="mb-3">
    <label class="form-label fw-semibold small text-muted">Year</label>
    {{-- ... (متغيرات السنوات) ... --}}
    <select class="form-select rounded-4" id="yearSelect" name="year[]" multiple required>
        <option value="select_all_years" class="text-primary fw-bold">
            Select All
        </option>
        @foreach($years as $year)
            {{-- يجب أن تكون فارغة من 'selected' --}}
            <option value="{{ $year }}">
                {{ $year }}
            </option>
        @endforeach
    </select>
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
            <select class="form-select rounded-4" id="citySelect" name="city" required>
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
       value="{{ $part->category_id ?? '' }}" required>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Laravel variables passed from PHP
        const brandModels = @json($brandModels ?? []);
        const allYears = @json($selectedYears ?? []);
        
        // القيم المحددة مسبقًا
        const selectedBrand = @json($selectedBrand ?? null);
        const selectedModels = @json($selectedModels ?? []);
        const selectedYears = @json($selectedYears ?? []).map(y => y.toString());
        // ... (بقية المتغيرات) ...

        /* -------------------------------------------------------
         * Initialize Choices.js
         * -------------------------------------------------------- */
        const brandSelect = new Choices('#brand', { /* ... */ });
        const citySelect = new Choices('#citySelect', { /* ... */ });

        const modelSelect = new Choices('#model', {
            searchEnabled: true, shouldSort: false, placeholderValue: 'Select Model(s)',
            itemSelectText: '', removeItemButton: true, delimiter: ','
        });

        const yearSelect = new Choices('#yearSelect', {
            searchEnabled: true, shouldSort: false, placeholderValue: 'Select Year(s)',
            itemSelectText: '', removeItemButton: true, delimiter: ','
        });
        
        // Enable/Disable helper
        function toggleChoicesDisabled(instance, disabled) {
            if (disabled) {
                instance.disable();
            } else {
                instance.enable();
            }
            instance.containerOuter.element.classList.toggle('is-disabled', disabled);
        }

        // دالة مساعدة لتحديد الخيارات في الـ Select الأصلي
        // هذه الدالة مهمة جداً لضمان إرسال البيانات الصحيحة عند إرسال النموذج.
        function setSelectedOptions(selectElementId, valuesToSelect) {
            const selectElement = document.getElementById(selectElementId);
            Array.from(selectElement.options).forEach(opt => {
                // إلغاء تحديد الجميع أولاً
                opt.selected = false;
                // ثم تحديد القيم المطلوبة
                if (valuesToSelect.includes(opt.value)) {
                    opt.selected = true;
                }
            });
        }

        // إيقاف التشغيل المبدئي
        toggleChoicesDisabled(modelSelect, true);
        toggleChoicesDisabled(yearSelect, true);
        

        /* -------------------------------------------------------
         * 2.1 SELECT ALL for Models Logic (On Change)
         * -------------------------------------------------------- */
         document.getElementById("model").addEventListener("change", function () {
            const selectElement = this;
            const selectedValues = modelSelect.getValue(true);
            
            // قائمة جميع الموديلات المتاحة في القائمة (عدا Select All)
            const allCurrentModels = modelSelect.config.choices
                .filter(c => c.value !== 'select_all_models' && c.value !== '')
                .map(c => c.value);

            if (selectedValues.includes("select_all_models")) {
                
                // 1. تحديد جميع الموديلات في الـ <select> الأصلي للحفظ
                setSelectedOptions("model", allCurrentModels);

                // 2. تحديث واجهة Choices.js (لإنشاء Tag Select All فقط)
                modelSelect.removeActiveItems();
                modelSelect.setChoiceByValue(["select_all_models"]);
            } else if (selectedValues.length === 0) {
                // إلغاء تحديد الجميع في الـ <select> الأصلي
                setSelectedOptions("model", []);
            } else {
                // تحديد القيم الفردية في الـ <select> الأصلي للحفظ
                setSelectedOptions("model", selectedValues.filter(v => v !== 'select_all_models'));

                // التأكد من إزالة Tag Select All إذا اختاروا شيئاً آخر
                modelSelect.removeActiveItemsByValue('select_all_models');
            }
            
            // استدعاء handleModelChange لتحديث قائمة السنوات بناءً على الاختيار الجديد
            // نمرر القيم التي تم تحديدها بالفعل في الـ <select> الأصلي
            handleModelChange(setSelectedOptions("model", selectedValues.filter(v => v !== 'select_all_models')), false);
        });

    /* -------------------------------------------------------
 * 3.1 SELECT ALL for Years Logic (On Change) - *تم التصحيح هنا*
 * -------------------------------------------------------- */
 document.getElementById("yearSelect").addEventListener("change", function () {
    const selectElement = this;
    const selectedValues = yearSelect.getValue(true);
    
    // قائمة جميع السنوات المتاحة في القائمة (عدا Select All)
    const allCurrentYears = yearSelect.config.choices
        .filter(c => c.value !== 'select_all_years' && c.value !== '')
        .map(c => c.value);


    if (selectedValues.includes("select_all_years")) {
        
        // 1. تحديد جميع السنوات في الـ <select> الأصلي للحفظ
        setSelectedOptions("yearSelect", allCurrentYears);
        
        // 2. تحديث واجهة Choices.js (لإنشاء Tag Select All فقط)
        yearSelect.removeActiveItems();
        // إعادة تعيين 'select_all_years' لضمان ظهوره كـ tag وحيد
        yearSelect.setChoiceByValue(["select_all_years"]);

    } else if (selectedValues.length === 0) {
        // إلغاء تحديد الجميع في الـ <select> الأصلي
        setSelectedOptions("yearSelect", []);
    } else {
        // تحديد القيم الفردية في الـ <select> الأصلي للحفظ
        // تأكد من فلترة 'select_all_years' في حالة كان موجوداً بالخطأ
        const finalSelection = selectedValues.filter(v => v !== 'select_all_years');
        setSelectedOptions("yearSelect", finalSelection);

        // التأكد من إزالة Tag Select All إذا اختاروا شيئاً آخر
        yearSelect.removeActiveItemsByValue('select_all_years');
    }
});

        /* -------------------------------------------------------
         * 1️⃣ BRAND CHANGE EVENT (معالجة التعبئة المسبقة للموديلات)
         * -------------------------------------------------------- */
        function handleBrandChange(brand, initialLoad = false) {
            
            if (!initialLoad) {
                modelSelect.clearStore();
                yearSelect.clearStore();
                toggleChoicesDisabled(yearSelect, true);
            }
            
            if (brand && brandModels[brand]) {
                
                const allModelValues = brandModels[brand]; 
                
                // لا نستخدم التصفية هنا، نترك Choices.js يتعامل مع القائمة الكاملة
                let modelChoices = allModelValues.map(m => ({
                    value: m,
                    label: m,
                    selected: false // لا تحديد مبدئي في Choices.js
                }));

                const finalModelChoices = [
                    { value: 'select_all_models', label: 'Select All', customProperties: { class: 'text-primary fw-bold' }, selected: false },
                    ...modelChoices
                ];
                
                // تحديث قائمة الخيارات المتاحة
                modelSelect.setChoices(finalModelChoices, 'value', 'label', true);
                toggleChoicesDisabled(modelSelect, false);
                
                // 🚨 خطوة 2: معالجة التعبئة المسبقة (Pre-selection)
                if (initialLoad && selectedModels.length > 0) {
                    
                    const isSelectAll = allModelValues.length > 0 && 
                                        selectedModels.length === allModelValues.length && 
                                        allModelValues.every(val => selectedModels.includes(val));
                    
                    setTimeout(() => {
                        
                        // 1. تحديد القيم في الـ <select> الأصلي للحفظ (سواء كانت Select All أو فردية)
                        // هذا يضمن إرسال جميع القيم الفردية الصحيحة للخادم
                        setSelectedOptions("model", selectedModels);
                        
                        // 2. تحديث واجهة Choices.js (لإنشاء Tags)
                        if (isSelectAll) {
                            // ننشئ Tag واحد هو "Select All"
                            modelSelect.setChoiceByValue(["select_all_models"]);
                        } else {
                            // ننشئ Tags فردية
                            modelSelect.setChoiceByValue(selectedModels);
                        }
                        
                        // استدعاء منطق تغيير الموديل لإعداد حقل السنة
                        // نمرر القيم الفردية المحددة مسبقاً (سواء كانت جميعها أو جزء منها)
                        handleModelChange(selectedModels, true); 
                    }, 50); 
                }
            }
        }
        
        brandSelect.passedElement.element.addEventListener('change', function () {
            let brand = this.value.toLowerCase().trim();
            handleBrandChange(brand, false);
        });


    /* -------------------------------------------------------
 * 2️⃣ MODEL CHANGE EVENT (معالجة التعبئة المسبقة للسنوات)
 * -------------------------------------------------------- */
/* -------------------------------------------------------
 * 2️⃣ MODEL CHANGE EVENT (معالجة التعبئة المسبقة للسنوات)
 * -------------------------------------------------------- */
function handleModelChange(selectedValues, initialLoad = false) {
    
    if (!initialLoad) {
        yearSelect.clearStore();
        toggleChoicesDisabled(yearSelect, true);
        setSelectedOptions("yearSelect", []);
    }
    
    // ... (تحديد القيم المحددة للموديل) ...
    const selectedModelValues = selectedValues.includes('select_all_models') 
        ? brandModels[selectedBrand] 
        : selectedValues.filter(v => v !== 'select_all_models'); 


    if (selectedModelValues && selectedModelValues.length > 0) {
        
        // 🚨 الخطوة 1: إعادة تهيئة الخيارات بناءً على ما هو موجود في PHP
   let yearChoices = selectedYears.map(y => ({
    value: y,
    label: y,
    selected: false
}));


        const finalYearChoices = [
            { value: 'select_all_years', label: 'Select All', customProperties: { class: 'text-primary fw-bold' }, selected: false },
            ...yearChoices
        ];
        
        yearSelect.setChoices(finalYearChoices, 'value', 'label', true);
        toggleChoicesDisabled(yearSelect, false);

        
        // 🚨 الخطوة 2: استخراج قائمة السنوات المتاحة *فعلياً* من Choices.js
        // const availableYears = yearSelect.config.choices
        //     .filter(c => c.value !== 'select_all_years' && c.value !== '')
        //     .map(c => c.value.toString()); // التأكد من أنها سلاسل نصية


        // // 🚨 خطوة 3: معالجة التعبئة المسبقة (Pre-selection)
        // if (initialLoad && selectedYears.length > 0) {
            
        //     // المقارنة الآن تتم بين availableYears (من Choices.js) و selectedYears (من DB)
        //     const isSelectAll = availableYears.length > 0 && 
        //                         selectedYears.length === availableYears.length && 
        //                         availableYears.every(val => selectedYears.includes(val));
            
        //     setTimeout(() => {
                
        //         setSelectedOptions("yearSelect", selectedYears); 

        //         if (isSelectAll) {
        //             yearSelect.setChoiceByValue(["select_all_years"]);
        //         } else {
        //             yearSelect.setChoiceByValue(selectedYears);
        //         }
        //     }, 50); 
        // }

        setTimeout(() => {
    setSelectedOptions("yearSelect", selectedYears);
    yearSelect.setChoiceByValue(selectedYears);
}, 50);

    }
}
        
        modelSelect.passedElement.element.addEventListener('change', function () {
            const selectedValues = modelSelect.getValue(true);
            handleModelChange(selectedValues, false);
        });
        
        // ... (منطق Category Selection) ...
        const categoryIcons = document.querySelectorAll('.category-icon');
        const categoryInput = document.getElementById('categoryInput');

        categoryIcons.forEach(icon => {
            icon.addEventListener('click', function () {
                categoryIcons.forEach(i => i.classList.remove('selected'));
                this.classList.add('selected');
                const categoryId = this.dataset.id;
                categoryInput.value = categoryId;
            });
        });

        /* -------------------------------------------------------
         * 4️⃣ RUN LOGIC IF BRAND PRE-SELECTED (للتعبئة المسبقة)
         * -------------------------------------------------------- */
        if (selectedBrand) {
            handleBrandChange(selectedBrand, true);
        }

    });
</script>
@endsection