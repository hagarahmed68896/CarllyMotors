@extends('layouts.app')
@php
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Str;

@endphp
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

@section('content')
    <!-- home slider -->
<style>
/* ✅ General container adjustments */
.custom-container {
  width: 100%;
  max-width: 1250px;
  margin: 0 auto;
}

/* ✅ Card styling */
.card {
  border: none;
  border-radius: 1rem;
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
}

.object-fit-cover {
  object-fit: cover;
  object-position: center;
}




/* ✅ Filter sidebar styling */
/* Filter sidebar container */
.filter-sidebar {
  background-color: #fff;
  border-radius: 1rem;
  box-shadow: 0 4px 15px rgba(0,0,0,0.08);
  padding: 1.5rem;
  position: sticky;
  top: 100px;
  transition: all 0.3s ease;
}

/* Header */
.filter-sidebar h5 {
  font-size: 1.15rem;
  color: #760e13;
  margin-bottom: 1.5rem;
}

/* Form group spacing */
.filter-sidebar .mb-3 {
  margin-bottom: 1.25rem;
}

/* Labels */
.filter-sidebar label {
  font-weight: 600;
  font-size: 0.875rem;
  color: #6c757d;
  margin-bottom: 0.4rem;
  display: block;
}

/* Styled select dropdowns */
.filter-sidebar select.form-select {
  border-radius: 0.75rem;
  border: 1px solid #ddd;
  padding: 0.5rem 0.75rem;
  font-size: 0.9rem;
  transition: all 0.3s ease;
  box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
}

/* Focus effect on selects */
.filter-sidebar select.form-select:focus {
  border-color: #760e13;
  box-shadow: 0 0 5px rgba(118,14,19,0.3);
  outline: none;
}

/* Buttons container */
.filter-sidebar .d-flex.gap-2 {
  margin-top: 1rem;
}

/* Apply & Reset buttons */
.filter-sidebar button {
  border-radius: 0.75rem;
  font-weight: 600;
  font-size: 0.9rem;
  padding: 0.45rem 0.8rem;
  transition: all 0.3s ease;
}

/* Apply button */
.filter-sidebar button[type="submit"] {
  background-color: #760e13;
  color: #fff;
}

.filter-sidebar button[type="submit"]:hover {
  background-color: #5a0b0f;
}

/* Reset button */
.filter-sidebar .btn-outline-secondary {
  border-color: #ccc;
  color: #333;
}

.filter-sidebar .btn-outline-secondary:hover {
  background-color: #f1f1f1;
}

/* Responsive: stack sidebar on small screens */
@media (max-width: 991px) {
  .filter-sidebar {
    position: relative;
    top: 0;
    margin-bottom: 1.5rem;
  }
}


/* ✅ Dealer cards grid adjustments */
.dealers-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1.5rem;
}

/* ✅ Responsive image */
.card-img-top {
  height: 200px;
  width: 100%;
  object-fit: cover;
}

@media (max-width: 576px) {
  .card-img-top {
    height: 160px;
  }
}
</style>

  <style>
    /* ✅ Make category icons display 3 per row */
    #categoryGridIcons {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
    }

    .category-icon {
      text-align: center;
      border: 2px solid transparent;
      border-radius: 10px;
      padding: 6px;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .category-icon.selected {
      border-color: #760e13;
      background-color: #f8f1f2;
      box-shadow: 0 0 6px rgba(118, 14, 19, 0.4);
    }

    .category-icon img {
      display: block;
      margin: 0 auto 4px;
      border-radius: 8px;
    }
  </style>

<div class="container my-5 custom-container">
  <div class="row">
    
<!-- ✅ FILTER SIDEBAR -->
<aside class="col-lg-3 col-md-4">
  <div class="filter-sidebar">
    <h5 class="fw-bold mb-3 text-center" style="color:#760e13">
      <i class="fas fa-sliders-h me-2"></i> Filter Dealers
    </h5>

<form id="filterForm" method="GET" action="{{ route('spareParts.index') }}">
<!-- ✅ MAKE -->
<div class="mb-3">
  <label class="form-label fw-semibold small text-muted">Car Brand</label>

  @php
      $sortedMakes = collect($makes)->filter()->sort(function($a, $b) {
          return strcasecmp($a, $b);
      });
  @endphp

  <select class="form-select rounded-4" id="brand" name="make" required>
    <option value="">All Brands</option>
    @foreach($sortedMakes as $make)
      @php $normalizedMake = strtolower(trim($make)); @endphp
      <option value="{{ $normalizedMake }}" {{ strtolower(request('make')) == $normalizedMake ? 'selected' : '' }}>
        {{ $make }}
      </option>
    @endforeach
  </select>
</div>

<!-- ✅ MODEL -->
<div class="mb-3">
  <label class="form-label fw-semibold small text-muted">Model</label>
  <select class="form-select rounded-4" id="model" name="model" disabled required>
    <option value="">All Models</option>
    @if(request('make') && request('model'))
      <option value="{{ request('model') }}" selected>{{ request('model') }}</option>
    @endif
  </select>
</div>

<!-- ✅ Same Style for Brand & Model -->
<style>
  /* نفس الشكل والحجم */
  .form-select {
    border: 1px solid #dee2e6;
    border-radius: 0.75rem !important; /* rounded-4 */
    background-color: #fff;
    color: #333;
    padding: 10px 12px;
    font-size: 0.95rem;
    transition: all 0.2s ease-in-out;
  }

  .form-select:focus {
    border-color: #760e13;
    box-shadow: 0 0 0 0.2rem rgba(118, 14, 19, 0.15);
  }

  .form-label {
    color: #6c757d !important;
  }
</style>

<!-- ✅ Choices.js disabled (if you don’t want enhanced dropdown) -->
<!-- إذا عايز تحتفظ بخاصية البحث في البراند -->
<!-- ممكن تخلي نفس الشكل كده -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    new Choices('#brand', {
        searchEnabled: true,
        searchPlaceholderValue: 'Search brand...',
        shouldSort: false,
        itemSelectText: '',
        classNames: {
          containerOuter: 'choices form-select rounded-4',
        }
    });
});
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<style>
/* ✅ خلي الألوان والحواف زي الـ Model */
.choices__inner {
  border-radius: 0.75rem !important;
  border: 1px solid #dee2e6 !important;
  background-color: #fff !important;
  color: #333 !important;
  padding: 10px 12px !important;
  font-size: 0.95rem;
}

.choices__list--dropdown {
  border-radius: 0.75rem !important;
  border: 1px solid #dee2e6;
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  background-color: #fff;
  z-index: 1050;
}

.choices__list--dropdown .choices__item--selectable.is-highlighted {
  background-color: #760e13 !important;
  color: #fff !important;
}

.choices[data-type*=select-one]:after {
  border-color: #760e13 transparent transparent transparent !important;
}
</style>


      <!-- ✅ YEAR -->
      <div class="mb-3">
        <label class="form-label fw-semibold small text-muted">Year</label>
        <select class="form-select" id="yearSelect" name="year" disabled required>
          <option value="">All Years</option>
          @foreach($years as $year)
            <option value="{{ $year }}">{{ $year }}</option>
          @endforeach
        </select>
      </div>

   <!-- ✅ CITY -->
<div class="mb-3">
  <label class="form-label fw-semibold small text-muted">City</label>

  @php
      // 🏙️ نفس المدن الثابتة مثل المثال الثاني
      $uaeCities = [
          'Abu Dhabi',
          'Ajman',
          'Al Ain',
          'Dibba',
          'Dubai',
          'Fujairah',
          'Hatta',
          'Kalba',
          'Khor Fakkan',
          'Ras Al Khaimah',
          'Sharjah',
          'Umm Al Quwain',
      ];

      sort($uaeCities); // ✅ ترتيب أبجدي
  @endphp

  <select class="form-select rounded-4" id="city" name="city" required>
    <option value="" {{ empty(request('city')) ? 'selected' : '' }}>All Cities</option>
    @foreach($uaeCities as $city)
      <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
        {{ $city }}
      </option>
    @endforeach
  </select>
</div>

<!-- ✅ Choices.js Search for City (optional) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  new Choices('#city', {
    searchEnabled: true,
    searchPlaceholderValue: 'Search city...',
    shouldSort: false,
    itemSelectText: '',
    classNames: {
      containerOuter: 'choices form-select rounded-4',
    }
  });
});
</script>


    <!-- ✅ CATEGORY ICONS (always visible) -->
<div class="mb-3">
  <label class="form-label fw-semibold small text-muted">Category of spare</label>


  <div id="categoryGridIcons">
    @foreach($mainCategories as $category)
      @php
        $img = $category->image
            ? config('app.file_base_url') . Str::after($category->image, url('/') . '/')
            : 'https://via.placeholder.com/60';
      @endphp
      <div class="text-center category-icon"
           data-id="{{ $category->id }}"
           data-name="{{ $category->name }}"
           data-subs='@json($category->subcategories)'>
        <img src="{{ $img }}" class="rounded mb-1" width="60" height="60">
        <div style="font-size:0.75rem;">{{ $category->name }}</div>
      </div>
    @endforeach
  </div>

  <input type="hidden" name="category" id="categoryInput"required value="{{ request('category') }}">
  <input type="hidden" name="category_name" id="categoryNameInput" value="{{ request('category_name') }}">
</div>


      <!-- ✅ SUBCATEGORY -->
      <div id="subcategoryWrapper" class="mb-3">
        <label class="form-label fw-semibold small text-muted">Subcategory</label>
<div class="position-relative">
  <select class="form-select" name="subcategory" id="subcategorySelect" disabled required>
    <option value="">All Subcategories</option>
  </select>
  <div id="subcategoryDropdown" class="dropdown-menu w-100 shadow-sm" style="max-height: 250px; overflow-y: auto; display: none;"></div>
</div>

      </div>

      <!-- ✅ CONDITION -->
      <div class="mb-3">
        <label class="form-label fw-semibold small text-muted d-block mb-2">Condition</label>
        <div class="d-flex gap-2">
          <button type="button" class="btn btn-outline-secondary flex-fill condition-btn" data-value="New">New</button>
          <button type="button" class="btn btn-outline-secondary flex-fill condition-btn" data-value="Used">Used</button>
        </div>
        <input type="hidden" name="condition" id="conditionInput" required value="{{ request('condition') }}">
      </div>

      <!-- ✅ VIN -->
      <div id="vin-input-container" class="mb-3" style="display:none;">
        <label class="form-label fw-semibold small text-muted">VIN Number</label>
<input type="text" 
       name="vin_number" 
       id="vin-number" 
       class="form-control" 
       placeholder="Enter VIN Number"
       value="{{ request('vin_number') }}">
      </div>

      <!-- ✅ ACTION BUTTONS -->
      <div class="d-flex gap-2 border-top pt-3">
       <button 
  type="submit" 
  id="applyFiltersBtn"
  class="btn flex-fill text-white fw-semibold" 
  style="background-color:#760e13;" 
  disabled>
  Apply Filters
</button>

        <button type="button" onclick="resetFilters()" class="btn btn-outline-secondary flex-fill">
          Reset
        </button>
      </div>
    </form>
  </div>
</aside>

<!-- ✅ JS SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  const fileBaseUrl = "{{ config('app.file_base_url') ? rtrim(config('app.file_base_url'), '/') . '/' : '' }}";

  const categoryIcons = document.querySelectorAll('.category-icon');
  const conditionButtons = document.querySelectorAll('.condition-btn');
  const vinContainer = document.getElementById('vin-input-container');
  const conditionInput = document.getElementById('conditionInput');
  const subcategorySelect = document.getElementById('subcategorySelect');
  const subcategoryDropdown = document.getElementById('subcategoryDropdown');
  const categoryInput = document.getElementById('categoryInput');
  const categoryNameInput = document.getElementById('categoryNameInput');

  // ✅ CATEGORY CLICK
  categoryIcons.forEach(icon => {
    icon.addEventListener('click', () => {
      categoryIcons.forEach(i => i.classList.remove('selected'));
      icon.classList.add('selected');

      const subs = JSON.parse(icon.dataset.subs || '[]');

      categoryInput.value = icon.dataset.id;
      categoryNameInput.value = icon.dataset.name;

      // Reset subcategory dropdown
      subcategorySelect.innerHTML = '<option value="">All Subcategories</option>';
      subcategoryDropdown.innerHTML = '';
      subcategoryDropdown.style.display = 'none';

      if (subs.length) {
        subs.forEach(sub => {
          const opt = document.createElement('option');
          opt.value = sub.id;
          opt.textContent = sub.name;
          subcategorySelect.appendChild(opt);

          let imgSrc = sub.image
            ? fileBaseUrl + sub.image.replace("{{ url('/') }}/", '')
            : 'https://via.placeholder.com/40';

          const div = document.createElement('div');
          div.classList.add('sub-option');
          div.innerHTML = `
            <img src="${imgSrc}" alt="" width="35" height="35" style="border-radius:6px; object-fit:cover;">
            <span style="font-size:0.9rem; color:#333;">${sub.name}</span>
          `;
          div.addEventListener('click', () => {
            subcategorySelect.value = sub.id;
            subcategoryDropdown.style.display = 'none';
          });
          subcategoryDropdown.appendChild(div);
        });

        subcategorySelect.disabled = false;
      } else {
        subcategorySelect.disabled = true;
      }
    });
  });

  // ✅ SINGLE LISTENER for subcategory dropdown
  subcategorySelect.addEventListener('mousedown', (e) => {
    e.preventDefault();
    const selectedIcon = document.querySelector('.category-icon.selected');
    if (!selectedIcon) return;

    const subs = JSON.parse(selectedIcon.dataset.subs || '[]');

    // Rebuild dropdown every time it's opened
    subcategoryDropdown.innerHTML = '';
    subs.forEach(sub => {
      let imgSrc = sub.image
        ? fileBaseUrl + sub.image.replace("{{ url('/') }}/", '')
        : 'https://via.placeholder.com/40';

      const div = document.createElement('div');
      div.classList.add('sub-option');
      div.innerHTML = `
        <img src="${imgSrc}" alt="" width="35" height="35" style="border-radius:6px; object-fit:cover;">
        <span style="font-size:0.9rem; color:#333;">${sub.name}</span>
      `;
      div.addEventListener('click', () => {
        subcategorySelect.value = sub.id;
        subcategoryDropdown.style.display = 'none';
      });
      subcategoryDropdown.appendChild(div);
    });

    // Toggle visibility
    subcategoryDropdown.style.display =
      subcategoryDropdown.style.display === 'none' ? 'block' : 'none';
  });

  // ✅ Close dropdown when clicking outside
  document.addEventListener('click', (e) => {
    if (!subcategoryDropdown.contains(e.target) && e.target !== subcategorySelect) {
      subcategoryDropdown.style.display = 'none';
    }
  });

  // ✅ CONDITION BUTTONS
  conditionButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      conditionButtons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      conditionInput.value = btn.dataset.value;
      vinContainer.style.display = btn.dataset.value === 'New' ? 'block' : 'none';
    });
  });

  // ✅ BRAND / MODEL / YEAR logic
  const brandSelect = document.getElementById('brand');
  const modelSelect = document.getElementById('model');
  const yearSelect = document.getElementById('yearSelect');
  const brandModels = @json($brandModels);
  const years = @json($years);

  function updateModelAndYearDropdowns(make) {
    const normalizedMake = make.trim().toLowerCase();
    const models = brandModels[normalizedMake] || [];

    modelSelect.innerHTML = '<option value="">All Models</option>';
    yearSelect.innerHTML = '<option value="">All Years</option>';

    if (models.length > 0) {
      models.forEach(m => {
        const opt = document.createElement('option');
        opt.value = m;
        opt.textContent = m;
        modelSelect.appendChild(opt);
      });
      modelSelect.disabled = false;
    } else {
      modelSelect.disabled = true;
    }

    if (years.length > 0) {
      years.forEach(y => {
        const opt = document.createElement('option');
        opt.value = y;
        opt.textContent = y;
        yearSelect.appendChild(opt);
      });
      yearSelect.disabled = false;
    } else {
      yearSelect.disabled = true;
    }
  }

  brandSelect.addEventListener('change', function() {
    updateModelAndYearDropdowns(this.value);
  });

  // ✅ Restore state after reload
  const currentMake = "{{ request('make') }}";
  if (currentMake) {
    updateModelAndYearDropdowns(currentMake);
    const currentModel = "{{ request('model') }}";
    const currentYear = "{{ request('year') }}";
    if (currentModel) modelSelect.value = currentModel;
    if (currentYear) yearSelect.value = currentYear;
  }

  const currentCondition = "{{ request('condition') }}";
  if (currentCondition) {
    conditionButtons.forEach(btn => {
      if (btn.dataset.value === currentCondition) {
        btn.classList.add('active');
        conditionInput.value = currentCondition;
        vinContainer.style.display = currentCondition === 'New' ? 'block' : 'none';
      }
    });
  }

  const currentCategoryId = "{{ request('category') }}";
  const currentSubcategoryId = "{{ request('subcategory') }}";

  if (currentCategoryId) {
    const selectedIcon = document.querySelector(`.category-icon[data-id='${currentCategoryId}']`);
    if (selectedIcon) {
      selectedIcon.classList.add('selected');

      const subs = JSON.parse(selectedIcon.dataset.subs || '[]');
      subcategorySelect.innerHTML = '<option value="">All Subcategories</option>';
      subcategoryDropdown.innerHTML = '';

      if (subs.length > 0) {
        subs.forEach(sub => {
          const opt = document.createElement('option');
          opt.value = sub.id;
          opt.textContent = sub.name;
          subcategorySelect.appendChild(opt);

          let imgSrc = sub.image
            ? fileBaseUrl + sub.image.replace("{{ url('/') }}/", '')
            : 'https://via.placeholder.com/40';

          const div = document.createElement('div');
          div.classList.add('sub-option');
          div.innerHTML = `
            <img src="${imgSrc}" alt="" width="35" height="35" style="border-radius:6px; object-fit:cover;">
            <span style="font-size:0.9rem; color:#333;">${sub.name}</span>
          `;
          div.addEventListener('click', () => {
            subcategorySelect.value = sub.id;
            subcategoryDropdown.style.display = 'none';
          });
          subcategoryDropdown.appendChild(div);
        });

        subcategorySelect.disabled = false;

        if (currentSubcategoryId) {
          subcategorySelect.value = currentSubcategoryId;
        }
      } else {
        subcategorySelect.disabled = true;
      }
    }
  }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('filterForm');
  const applyBtn = document.getElementById('applyFiltersBtn');

  const requiredFields = [
    '[name="make"]',
    '[name="model"]',
    '[name="year"]',
    '[name="city"]',
    '[name="category"]',
    '[name="condition"]'
  ];

  function checkAllFilled() {
    let allFilled = true;
    for (let selector of requiredFields) {
      const el = document.querySelector(selector);
      if (!el || !el.value.trim()) {
        allFilled = false;
        break;
      }
    }
    applyBtn.disabled = !allFilled;
  }

  // راقب التغييرات على كل الفلاتر
  requiredFields.forEach(selector => {
    const el = document.querySelector(selector);
    if (el) {
      el.addEventListener('change', checkAllFilled);
      el.addEventListener('input', checkAllFilled);
    }
  });

  // لما يختار category من الأيقونات
  document.querySelectorAll('.category-icon').forEach(icon => {
    icon.addEventListener('click', () => {
      document.getElementById('categoryInput').value = icon.dataset.id;
      checkAllFilled();
    });
  });

  // لما يختار condition
  document.querySelectorAll('.condition-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.getElementById('conditionInput').value = btn.dataset.value;
      checkAllFilled();
    });
  });

  // تحقق أولي لو الصفحة اتفتحت ومعمول فلاتر
  checkAllFilled();
});
</script>


<!-- ✅ Add or keep this CSS -->
<style>
.sub-option {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 6px 10px;
  cursor: pointer;
  transition: background 0.2s;
  border-bottom: 1px solid #eee;
}
.sub-option:hover {
  background-color: #f8f8f8;
}
.sub-option img {
  width: 35px;
  height: 35px;
  border-radius: 6px;
  object-fit: cover;
}
</style>
<style>
.custom-select-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: all 0.2s;
}
.custom-select-item:hover {
  transform: scale(1.05);
  background-color: #f8f9fa;
  border-radius: 6px;
}
.custom-select-selected:hover {
  background-color: #f8f9fa;
}
</style>
<style>
/* Make categories in 3 columns */
#categoryGridIcons {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
}

/* Selected category border */
.category-icon.selected {
  border: 2px solid #760e13;
  border-radius: 10px;
  background: #fff;
  transition: 0.3s ease;
}
.category-icon:hover {
  border: 2px solid #aaa;
  transform: scale(1.05);
}
.condition-btn.active {
  background-color: #760e13 !important;
  color: #fff !important;
  border-color: #760e13 !important;
}

</style>
<style>
.sub-option {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 6px 10px;
  cursor: pointer;
  transition: background 0.2s;
}
.sub-option:hover {
  background-color: #f5f5f5;
}
.sub-option img {
  width: 35px;
  height: 35px;
  border-radius: 6px;
  object-fit: cover;
}
</style>

    <!-- ✅ DEALERS GRID -->
    @if(request()->has('make') && request()->has('model') && request()->has('year') && request()->has('city') && request()->has('category') && request()->has('condition'))

    <section class="col-lg-9 col-md-8">
<div class="dealers-grid">
@forelse ($dealers as $dealer)
    @php
        $companyImg = $dealer->company_img;

        // التحقق من أن الصورة صالحة ومش "notfound"
        if (!empty($companyImg) && !Str::contains($companyImg, ['notfound.png', 'noimage.png'])) {
            $image = config('app.file_base_url') . Str::after($companyImg, url('/') . '/');
        } else {
$image = asset('carllymotorsmainlogo.png');
        }

        $dealerName = $dealer->company_name
            ? ucfirst(strtolower(substr($dealer->company_name, 0, 25))) . (strlen($dealer->company_name) > 25 ? '...' : '')
            : 'Unknown Dealer';

        $phone = $dealer->user?->phone ?? 'N/A';
        $shareUrl = request()->url() . '?shop_id=' . ($dealer->id ?? '');
    @endphp

    <div class="card h-100 shadow-sm">
        <img src="{{ $image }}" 
             class="card-img-top"
             alt="Dealer Image"
             onerror="this.onerror=null; this.src='{{ asset('images/carllymotorsmainlogo_dark.png') }}';"
             loading="lazy">

        <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h6 class="fw-bold text-truncate mb-0" style="color:#760e13" title="{{ $dealer->company_name ?? 'Dealer' }}">
                    {{ $dealerName }}
                </h6>

                @if (!empty($dealer->company_address))
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($dealer->company_address) }}"
                       target="_blank"
                       class="text-decoration-none small text-muted">
                        <i class="fas fa-map-marker-alt text-danger me-1"></i> Location
                    </a>
                @endif
            </div>

            <div class="actions-dealer d-flex align-items-center mt-2">
                @if ($phone !== 'N/A')
 @php
    $dealerUrl = route('spareParts.index', [
        'dealer_id'   => $dealer->id,
        'make'        => request('make'),
        'model'       => request('model'),
        'year'        => request('year'),
        'category'    => request('category'),
        'sub-category'=> request('sub-category'),
        'city'        => request('city'),
        'condition'   => request('condition'),
    ]);

    $message = "((Carlly Motors))\n\n" .
               "I'm interested in buying your spare parts!\n\n" .
               "Car Type : " . (request('make') ?? '-') . "\n" .
               "Car Model : " . (request('model') ?? '-') . "\n" .
               "Car Year : " . (request('year') ?? '-') . "\n" .
               "Category : " . (request('category') ?? '-') . "\n" .
               "Sub-category : " . (request('sub-category') ?? '-') . "\n" .
               "City : " . (request('city') ?? '-') . "\n" .
               "Condition : " . (request('condition') ?? '-') . "\n\n" .
               "Spare Part Url : " . $dealerUrl;
@endphp

<a href="https://wa.me/{{ $phone }}?text={{ urlencode($message) }}"
   target="_blank"
   class="text-decoration-none flex-grow-1">
   <button class="btn btn-outline-success w-100 action-btn rounded-4">
       <i class="fab fa-whatsapp"></i>
   </button>
</a>




                    <a href="tel:{{ $phone }}" class="action-link">
                        <button class="btn btn-outline-danger action-btn rounded-4">
                            <i class="fas fa-phone"></i>
                        </button>
                    </a>
                @endif

     @php
    $dealerUrl = route('spareParts.index', [
        'dealer_id'   => $dealer->id,
        'make'        => request('make'),
        'model'       => request('model'),
        'year'        => request('year'),
        'category'    => request('category'),
        'sub-category'=> request('sub-category'),
        'city'        => request('city'),
        'condition'   => request('condition'),
    ]);

    $shareMessage = "Check out my latest find on Carlly! Great deals await. Don't miss out!: " . $dealerUrl;
@endphp

<a href="https://wa.me/?text={{ urlencode($shareMessage) }}" 
   target="_blank" 
   class="action-link">
  <button class="btn btn-outline-info w-100 action-btn rounded-4" title="Share via WhatsApp">
        <i class="fas fa-share-alt"></i>
    </button>
</a>


            </div>
        </div>
    </div>
@empty
    <p class="text-center text-muted mt-4">No dealers found.</p>
@endforelse
</div>


<style>
/* ✅ ACTION BUTTON STYLES */
.actions-dealer {
  display: flex;
  flex-wrap: nowrap;
  gap: 6px;
  width: 100%;
}

.action-link {
  flex: 1 1 0;
  min-width: 0;
  text-decoration: none;
}

.action-btn {
  width: 100%;
  height: 38px;
  font-size: 1rem;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}

.action-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}

.btn-outline-danger { border-color: #760e13; color: #760e13; }
.btn-outline-danger:hover { background-color: #760e13; color: #fff; }

.btn-outline-success { border-color: #28a745; color: #28a745; }
.btn-outline-success:hover { background-color: #28a745; color: #fff; }

.btn-outline-info { border-color: #0dcaf0; color: #0dcaf0; }
.btn-outline-info:hover { background-color: #0dcaf0; color: #fff; }

@media (max-width: 992px) {
  .action-btn { height: 36px; font-size: 0.95rem; }
}

@media (max-width: 576px) {
  .action-btn { height: 34px; font-size: 0.9rem; }
  .actions-dealer { gap: 4px; }
}

@media (max-width: 400px) {
  .action-btn { height: 30px; font-size: 0.85rem; }
}
</style>


{{-- @php
  use Illuminate\Pagination\LengthAwarePaginator;
@endphp --}}

@if ($dealers instanceof \Illuminate\Pagination\LengthAwarePaginator && $dealers->hasPages())
  @php
    $current = $dealers->currentPage();
    $last = $dealers->lastPage();
    $maxFull = 50; // if pages <= this -> show all pages
    $window = 2;   // pages to show around current when condensing
    $pages = [];

    if ($last <= $maxFull) {
        for ($p = 1; $p <= $last; $p++) {
            $pages[] = $p;
        }
    } else {
        $pages[] = 1;
        $pages[] = 2;

        $start = max(3, $current - $window);
        $end = min($last - 2, $current + $window);

        if ($start > 3) {
            $pages[] = '...';
        } else {
            for ($p = 3; $p < $start; $p++) $pages[] = $p;
        }

        for ($p = $start; $p <= $end; $p++) $pages[] = $p;

        if ($end < $last - 2) {
            $pages[] = '...';
        } else {
            for ($p = $end + 1; $p <= $last - 2; $p++) $pages[] = $p;
        }

        $pages[] = $last - 1;
        $pages[] = $last;

        $pages = array_values(array_unique($pages));
    }
  @endphp

  <nav aria-label="Page navigation" class="mt-4">
    <ul class="custom-pagination d-flex justify-content-center align-items-center flex-wrap">

      {{-- Previous --}}
      @if ($dealers->onFirstPage())
        <li class="disabled"><span class="page-btn" aria-hidden="true">‹</span></li>
      @else
        <li><a href="{{ $dealers->previousPageUrl() }}" class="page-btn" rel="prev" aria-label="Previous">‹</a></li>
      @endif

      {{-- Page Numbers --}}
      @foreach ($pages as $p)
        @if ($p === '...')
          <li><span class="page-btn dots">…</span></li>
        @else
          @php $p = (int) $p; @endphp
          @if ($p === $current)
            <li><span class="page-btn active" aria-current="page">{{ $p }}</span></li>
          @else
            <li><a href="{{ $dealers->url($p) }}" class="page-btn" aria-label="Go to page {{ $p }}">{{ $p }}</a></li>
          @endif
        @endif
      @endforeach

      {{-- Next --}}
      @if ($dealers->hasMorePages())
        <li><a href="{{ $dealers->nextPageUrl() }}" class="page-btn" rel="next" aria-label="Next">›</a></li>
      @else
        <li class="disabled"><span class="page-btn" aria-hidden="true">›</span></li>
      @endif
    </ul>
  </nav>

  {{-- Page Info --}}
  <div class="d-flex justify-content-center mt-3">
    <div class="page-info text-center" role="status" aria-live="polite">
      Page <strong>{{ $dealers->currentPage() }}</strong> of <strong>{{ $dealers->lastPage() }}</strong>
    </div>
  </div>
@endif


<style>
/* container */
.custom-pagination {
  gap: 6px;
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
}

/* item */
.custom-pagination li {
  display: inline-block;
}

/* buttons */
.page-btn {
  display: inline-flex;
  justify-content: center;
  align-items: center;
  min-width: 36px;
  height: 36px;
  padding: 0 8px;
  border-radius: 50px; /* pill */
  font-weight: 600;
  text-decoration: none;
  color: #760e13;           /* primary color */
  background-color: #fff;
  border: 1px solid #e6e6e6;
  transition: transform .18s ease, background-color .18s ease, color .18s ease, box-shadow .18s ease;
  box-shadow: 0 3px 6px rgba(0,0,0,0.05);
}

/* hover */
.page-btn:hover {
  background-color: #760e13;
  color: #fff;
  transform: translateY(-3px);
  box-shadow: 0 8px 18px rgba(118,14,19,0.22);
}

/* active */
.page-btn.active {
  background-color: #760e13;
  color: #fff;
  border-color: #760e13;
  box-shadow: 0 6px 14px rgba(118,14,19,0.28);
}

/* disabled/dots */
.custom-pagination li.disabled .page-btn,
.page-btn.dots {
  background: #f7f7f7;
  color: #888;
  border-color: #eee;
  transform: none;
  pointer-events: none;
  box-shadow: none;
}

/* page info pill */
.page-info {
  color: #760e13;
  font-weight: 600;
  font-size: 0.95rem;
  background: #fff;
  padding: 6px 16px;
  border-radius: 50px;
  border: 1px solid #eee;
  box-shadow: 0 3px 8px rgba(0,0,0,0.05);
  display: inline-block;
}

/* responsive sizing */
@media (max-width: 576px) {
  .page-btn { min-width: 32px; height: 32px; font-size: 0.87rem; padding: 0 6px; }
  .custom-pagination { gap: 6px; padding: 6px 8px; }
}

/* make container horizontally scrollable instead of wrapping (optional) */
/* Uncomment if you prefer a single-line horizontal scroll on mobile:
.custom-pagination {
  flex-wrap: nowrap;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
  padding-bottom: 4px;
}
.custom-pagination::-webkit-scrollbar { display: none; }
*/
</style>


    </section>
    @else
  <section class="col-lg-9 col-md-8 d-flex justify-content-center " >
    <div class="text-center">

      <h5 class="fw-bold" style="color:#760e13;">Find Your Perfect Spare Parts Dealer</h5>
      <p class="text-muted mb-3">Please fill in all filter fields and click <strong>Apply Filters</strong> to begin your search.</p>

      <button class="btn btn-outline-danger" disabled>
        <i class="fas fa-sliders-h me-2"></i> Waiting for Filters...
      </button>
    </div>
  </section>
@endif

  </div>
</div>


<script>
function resetFilters() {
    // إعادة ضبط كل الحقول إلى قيمها الافتراضية
    const form = document.getElementById('filterForm');
    form.reset();

    // أعد توجيه الصفحة إلى نفس route بدون أي query params
    window.location.href = "{{ route('spareParts.index') }}";
}
</script>

    @push('dealersscript')
        {{-- Script related filters on spareParts page --}}
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function () {
                // تطبيق Select2 على جميع select داخل #filterForm
                $('#filterForm select').select2({
                    width: 'resolve',
                    minimumResultsForSearch: 0, // يظهر حقل البحث دائمًا
                    dropdownAutoWidth: true
                });
            });
        </script>



        <script>
            $(document).ready(function () {
                function formatCategory(state) {
                    if (!state.id) return state.text; // لعنصر placeholder
                    let image = $(state.element).data('image');
                    let $state = $(`
              <div class="text-center">
                <img src="${image}" style="width: 40px; height: 40px; object-fit: cover;" class="mb-1 rounded-circle" />
                <div style="font-size: 13px;">${state.text}</div>
              </div>
            `);
                    return $state;
                }

                $('#category').select2({
                    templateResult: formatCategory,
                    templateSelection: formatCategory,
                    minimumResultsForSearch: 0, // لإظهار البحث دائمًا
                    width: 'resolve',
                    dropdownAutoWidth: true
                });
            });
        </script>


        <script>
            function copyUrl() {
                const url = window.location.href; // Get current URL

                navigator.clipboard.writeText(url).then(() => {
                    alert('URL copied : ' + url);
                }).catch(err => {
                    console.error('Failed to copy URL: ', err);
                });
            }

            $(document).on('change', '#brand', function () {
                let brand = $(this).val();

                if (brand) {
                    $.ajax({
                        url: "{{ route('getModels') }}", // Adjust this route as needed
                        method: "POST",
                        data: {
                            brand: brand,
                            _token: $('meta[name="csrf-token"]').attr(
                                'content') // CSRF token for security
                        },
                        success: function (response) {
                            // console.log(response);

                            // Populate the child select box
                            $('#model').empty().append('<option value="">Select Model</option>');

                            response.brandModels.forEach(function (model) {
                                let modelName = model ?? 'No Parent';

                                $('#model').append('<option value="' + modelName + '">' +
                                    modelName +
                                    '</option>');
                            });
                        },
                        error: function (xhr) {
                            console.error("Error fetching models:", xhr.responseText);
                        }
                    });
                } else {
                    // Reset the child select box if no item is selected
                    $('#model').empty().append('<option value="">model</option>');
                }


            });

            $(document).on('change', '#category', function () {
                let category = $(this).val();

                if (category) {
                    $.ajax({
                        url: "{{ route('getSubCategories') }}", // Adjust this route as needed
                        method: "POST",
                        data: {
                            category: category,
                            _token: $('meta[name="csrf-token"]').attr(
                                'content') // CSRF token for security
                        },
                        success: function (response) {
                            // console.log(response);

                            // Populate the child select box
                            $('#subCategory').empty().append('<option value="">Select subCategory</option>');

                            response.subCategories.forEach(function (subCategory) {
                                let subCategoryName = subCategory ?? 'No Parent';

                                $('#subCategory').append('<option value="' + subCategoryName + '">' +
                                    subCategoryName +
                                    '</option>');
                            });
                        },
                        error: function (xhr) {
                            console.error("Error fetching models:", xhr.responseText);
                        }
                    });
                } else {
                    // Reset the child select box if no item is selected
                    $('#model').empty().append('<option value="">model</option>');
                }


            });
        </script>

        <!-- ✅ JavaScript placed at the END of body -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const conditionSelect = document.getElementById('condition-select');
                const vinInputContainer = document.getElementById('vin-input-container');
                const vinInput = document.getElementById('vin-number');

                function toggleVINField() {
                    if (conditionSelect.value === 'New') {
                        vinInputContainer.style.display = 'block';
                        vinInput.setAttribute('required', 'required');
                    } else {
                        vinInputContainer.style.display = 'none';
                        vinInput.removeAttribute('required');
                        vinInput.value = '';
                    }
                }

                toggleVINField(); // Run once on page load
                conditionSelect.addEventListener('change', toggleVINField);
            });
        </script>
    @endpush
@endsection