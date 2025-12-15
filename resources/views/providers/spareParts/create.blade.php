@extends('layouts.CarProvider')

@section('content')

<div class="container mt-5 rounded-4" style="background-color: #fff; padding: 30px;">
    <h2 class="fw-bold mb-4" style="color: #163155;">Add New Part</h2>
    <form id="createPartForm" method="POST" action="{{ route('spareparts.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- 1. Car Brand (Select-One) --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Car Brand</label>
            <select class="form-select rounded-4" id="brand" name="brand" required>
                <option value="">All Brands</option>
                @foreach($sortedMakes as $make)
                @php $normalizedMake = strtolower(trim($make)); @endphp
                <option value="{{ $normalizedMake }}" {{ strtolower(request('brand'))==$normalizedMake ? 'selected' : ''
                    }}>
                    {{ $make }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- 2. Model (Multi-Select) --}}
        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Model</label>
            {{-- تم التأكد من وجود disabled و multiple و name="model[]" --}}
       <select class="form-select rounded-4" id="model" name="model[]" disabled multiple required>
    <option value="select_all_models" class="text-primary fw-bold">Select All</option>

    {{-- <option value="">Select Model(s)</option> --}}

    {{-- إذا كان هناك موديل محدد مسبقًا --}}
    @if(request('brand') && request('model'))
        <option value="{{ request('model') }}" selected>{{ request('model') }}</option>
    @endif
</select>

        </div>

     {{-- 3. Year (Multi-Select) --}}
<div class="mb-3">
    <label class="form-label fw-semibold small text-muted">Year</label>

    @php
        $currentYear = date('Y') + 1; // السنة القادمة
        $years = range($currentYear, 1984); // من السنة القادمة إلى 1984
    @endphp

    <select class="form-select rounded-4" id="yearSelect" name="year[]" disabled multiple required>
        <option value="select_all_years" class="text-primary fw-bold">
            Select All
        </option>

        @foreach($years as $year)
            <option value="{{ $year }}">{{ $year }}</option>
        @endforeach
    </select>
</div>

        {{-- Links and Scripts --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

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
        // 📌 مدن الإمارات الثابتة فقط
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

        sort($uaeCities); // ترتيب أبجدي
    @endphp
    <select class="form-select rounded-4" id="citySelect" name="city" required>
        <option value="">Select City</option>
        @foreach($cities as $city)
        <option value="{{ $city }}">{{ $city }}</option>
        @endforeach
    </select>
</div>


        <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Sparepart Type</label>

            <div class="d-flex gap-3 mt-1">

                <div class="condition-btn" data-value="New">
                    New
                </div>

                <div class="condition-btn" data-value="Used">
                    Used
                </div>

            </div>

            <input type="hidden" name="part_type" id="conditionInput" required>
        </div>

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
                <div class="text-center category-icon flex-shrink-0" data-id="{{ $category->id }}"
                    data-name="{{ $category->name }}" data-subs='@json($category->subcategories)'>
                    <img src="{{ $img }}" class="rounded mb-1" width="60" height="60">
                    <div style="font-size:0.75rem;">{{ $category->name }}</div>
                </div>
                @endforeach
            </div>

            <input type="hidden" name="category" id="categoryInput" required>
        </div>

        {{-- <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Subcategory</label>
            <select class="form-select rounded-4" id="subcategorySelect" name="subcategory" required>
                <option value="">Select Subcategory</option>
            </select>
        </div> --}}

        <button type="submit" class="btn text-white fw-semibold" style="background:#163155;">
            Add
        </button>
    </form>

</div>

        {{-- 🚨 هذا هو جزء JavaScript الصحيح والنهائي 🚨 --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
/* -------------------------------------------------------
      2.1 SELECT ALL for Models Logic
    -------------------------------------------------------- */
  /* -------------------------------------------------------
      2.1 SELECT ALL for Models Logic (New Logic)
    -------------------------------------------------------- */
    document.getElementById("model").addEventListener("change", function () {
        const selectElement = this;
        const selectedValues = modelSelect.getValue(true); // استخدام getValue للحصول على القيم المحددة في الواجهة

        if (selectedValues.includes("select_all_models")) {
            // 1. تحديد جميع الخيارات في حقل HTML الأصلي (لإرسالها للسيرفر)
            const allValues = [];
            Array.from(selectElement.options).forEach(opt => {
                if (opt.value !== "select_all_models" && opt.value !== "") {
                    opt.selected = true;
                    allValues.push(opt.value);
                } else {
                    opt.selected = false; // إلغاء تحديد "Select All" في الخلفية
                }
            });

            // 2. إزالة كل الـ Tags من الواجهة
            modelSelect.removeActiveItems();

            // 3. عرض "Select All" فقط كـ Tag في الواجهة
            // نحدد القيمة الوهمية هنا فقط للواجهة الرسومية
            modelSelect.setChoiceByValue(["select_all_models"]);

        } else if (selectedValues.length === 0) {
            // لو المستخدم ألغى كل التحديدات، نتأكد من إزالة Tag "Select All" لو كانت موجودة
            Array.from(selectElement.options).forEach(opt => opt.selected = false);
        } else {
            // لو تم اختيار عناصر عادية بعد إلغاء "Select All"، نتأكد من إلغاء تحديد "Select All" في الواجهة
            modelSelect.removeActiveItemsByValue('select_all_models');
        }
    });
    /* -------------------------------------------------------
      3.1 SELECT ALL for Years Logic
    -------------------------------------------------------- */
   /* -------------------------------------------------------
      3.1 SELECT ALL for Years Logic (New Logic)
    -------------------------------------------------------- */
    document.getElementById("yearSelect").addEventListener("change", function () {
        const selectElement = this;
        const selectedValues = yearSelect.getValue(true); // استخدام getValue للحصول على القيم المحددة في الواجهة

        if (selectedValues.includes("select_all_years")) {
            // 1. تحديد جميع الخيارات في حقل HTML الأصلي (لإرسالها للسيرفر)
            const allValues = [];
            Array.from(selectElement.options).forEach(opt => {
                if (opt.value !== "select_all_years" && opt.value !== "") {
                    opt.selected = true;
                    allValues.push(opt.value);
                } else {
                    opt.selected = false; // إلغاء تحديد "Select All" في الخلفية
                }
            });

            // 2. إزالة كل الـ Tags من الواجهة
            yearSelect.removeActiveItems();

            // 3. عرض "Select All" فقط كـ Tag في الواجهة
            // نحدد القيمة الوهمية هنا فقط للواجهة الرسومية
            yearSelect.setChoiceByValue(["select_all_years"]);

        } else if (selectedValues.length === 0) {
            // لو المستخدم ألغى كل التحديدات، نتأكد من إزالة Tag "Select All" لو كانت موجودة
            Array.from(selectElement.options).forEach(opt => opt.selected = false);
        } else {
            // لو تم اختيار عناصر عادية بعد إلغاء "Select All"، نتأكد من إلغاء تحديد "Select All" في الواجهة
            yearSelect.removeActiveItemsByValue('select_all_years');
        }
    });
    // Laravel variables
    const brandModels = @json($brandModels ?? []);
    const allYears = @json($years ?? []);

    // Initialize Choices.js
    const brandSelect = new Choices('#brand', {
        searchEnabled: true,
        shouldSort: false,
        itemSelectText: '',
        removeItemButton: false
    });

    // 🚨 أضف هذا الكود ضمن تهيئة Choices.js 🚨
const citySelect = new Choices('#citySelect', {
    searchEnabled: true,
    shouldSort: false,
    itemSelectText: '',
    removeItemButton: false, // لا نريد زر حذف لأنه اختيار واحد (Select-One)
    placeholderValue: 'Select City'
});

    const modelSelect = new Choices('#model', {
        searchEnabled: true,
        shouldSort: false,
        placeholderValue: 'Select Model(s)',
        itemSelectText: '',
        removeItemButton: true,
        delimiter: ','
    });

    const yearSelect = new Choices('#yearSelect', {
        searchEnabled: true,
        shouldSort: false,
        placeholderValue: 'Select Year(s)',
        itemSelectText: '',
        removeItemButton: true,
        delimiter: ','
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

    // Disable model & year initially
    toggleChoicesDisabled(modelSelect, true);
    toggleChoicesDisabled(yearSelect, true);


    /* -------------------------------------------------------
       1️⃣ BRAND CHANGE EVENT — using Choices events
    -------------------------------------------------------- */
    brandSelect.passedElement.element.addEventListener('change', function () {
        let brand = this.value.toLowerCase().trim();

        // Reset model + year
        modelSelect.clearStore();
        modelSelect.setChoiceByValue([]);
        yearSelect.clearStore();
        yearSelect.setChoiceByValue([]);
        toggleChoicesDisabled(modelSelect, true);
        toggleChoicesDisabled(yearSelect, true);

        if (brand && brandModels[brand]) {
            let modelChoices = brandModels[brand].map(m => ({
                value: m,
                label: m
            }));

// Add Select All option before the fetched models
            const finalModelChoices = [
                { value: 'select_all_models', label: 'Select All', customProperties: { class: 'text-primary fw-bold' }, selected: false },
                ...modelChoices
            ];
            
            modelSelect.setChoices(finalModelChoices, 'value', 'label', true);            toggleChoicesDisabled(modelSelect, false);
        }
    });


    /* -------------------------------------------------------
       2️⃣ MODEL CHANGE EVENT — using Choices events
    -------------------------------------------------------- */
    modelSelect.passedElement.element.addEventListener('change', function () {
        const selectedModels = modelSelect.getValue(true);

        yearSelect.clearStore();
        yearSelect.setChoiceByValue([]);
        toggleChoicesDisabled(yearSelect, true);

        if (selectedModels && selectedModels.length > 0) {
            let yearChoices = allYears.map(y => ({
                value: y,
                label: y
            }));

// Add Select All option before the available years
            const finalYearChoices = [
                { value: 'select_all_years', label: 'Select All', customProperties: { class: 'text-primary fw-bold' }, selected: false },
                ...yearChoices
            ];
            
            yearSelect.setChoices(finalYearChoices, 'value', 'label', true);            toggleChoicesDisabled(yearSelect, false);
        }
    });


    /* -------------------------------------------------------
       3️⃣ CATEGORY SELECTION
    -------------------------------------------------------- */
    const categoryIcons = document.querySelectorAll('.category-icon');
    const categoryInput = document.getElementById('categoryInput');
    const subcategorySelect = document.getElementById('subcategorySelect');

    categoryIcons.forEach(icon => {
        icon.addEventListener('click', function () {

            categoryIcons.forEach(i => i.classList.remove('selected'));
            this.classList.add('selected');

            const categoryId = this.dataset.id;
            const subs = JSON.parse(this.dataset.subs);

            categoryInput.value = categoryId;

            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';

            subs.forEach(sub => {
                let opt = document.createElement('option');
                opt.value = sub.id;
                opt.textContent = sub.name;
                subcategorySelect.appendChild(opt);
            });
        });
    });


    /* -------------------------------------------------------
       4️⃣ VIN Show/Hide
    -------------------------------------------------------- */
    document.querySelector('select[name="part_type"]').addEventListener('change', function () {
        const vinField = document.querySelector('#vinWrapper');
        if (vinField) {
            vinField.style.display = this.value === 'New' ? 'block' : 'none';
        }
    });


    /* -------------------------------------------------------
       5️⃣ Run logic if brand pre-selected
    -------------------------------------------------------- */
    if (brandSelect.getValue(true)) {
        brandSelect.passedElement.element.dispatchEvent(new Event('change'));
    }

});
        </script>
@endsection