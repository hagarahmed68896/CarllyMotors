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


<div class="container my-5 custom-container">`
  <div class="row">
    
    <!-- ✅ FILTER SIDEBAR -->
    <aside class="col-lg-3 col-md-4">
      <div class="filter-sidebar">
        <h5 class="fw-bold mb-3 text-center" style="color:#760e13">
          <i class="fas fa-sliders-h me-2"></i> Filter Dealers
        </h5>

        <form id="filterForm" method="GET" action="{{ route('spareParts.index') }}">
          <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Make</label>
            <select class="form-select" id="brand" name="make">
              <option value="">All Makes</option>
              @foreach($makes as $make)
                <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>{{ $make }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Model</label>
            <select class="form-select" id="model" name="model">
              <option value="">All Models</option>
              @if(request('make') && request('model'))
                <option value="{{ request('model') }}" selected>{{ request('model') }}</option>
              @endif
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">City</label>
            <select class="form-select" name="city">
              <option value="">All Cities</option>
              @foreach($cities as $city)
                @if(!empty($city))
                  <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                @endif
              @endforeach
            </select>
          </div>

<div class="mb-3">
    <label class="form-label fw-semibold small text-muted">Category</label>
    <div class="custom-select-wrapper" style="position: relative;">

        <!-- Selected -->
        <div class="custom-select-selected border rounded p-2 d-flex justify-content-between align-items-center" style="cursor:pointer;">
            <span id="selectedCategory">{{ request('category') ?? 'All Categories' }}</span>
            <i class="fas fa-chevron-down"></i>
        </div>

        <!-- Options -->
        <div class="custom-select-options border rounded shadow-sm mt-1" 
             style="position:absolute; width:100%; max-height:300px; overflow-y:auto; background:#fff; display:none; z-index:1000; padding:8px; box-sizing:border-box;">

            <!-- Search -->
            <input type="text" id="categorySearch" class="form-control form-control-sm mb-2" placeholder="Search...">

            <!-- Categories Grid -->
            <div class="d-flex flex-wrap" id="categoryGrid">

                <!-- All Categories -->
                <div class="custom-select-item text-center m-1" data-value="" style="width:80px; cursor:pointer;">
                    <img src="https://via.placeholder.com/60?text=All" class="rounded mb-1" width="60" height="60">
                    <div style="font-size:0.75rem;">All</div>
                </div>

                @foreach($categories as $category)
                    @php
                        $name = $category->name;
                        $img = $category->image
                            ? config('app.file_base_url') . Str::after($category->image, url('/') . '/')
                            : 'https://via.placeholder.com/60';
                    @endphp
                    <div class="custom-select-item text-center m-1" data-value="{{ $name }}" style="width:80px; cursor:pointer;">
                        <img src="{{ $img }}" class="rounded mb-1" width="60" height="60">
                        <div style="font-size:0.75rem;">{{ $name }}</div>
                    </div>
                @endforeach

            </div>
        </div>

        <input type="hidden" name="category" id="categoryInput" value="{{ request('category') }}">
    </div>
</div>

<script>
const selected = document.querySelector('.custom-select-selected');
const optionsContainer = document.querySelector('.custom-select-options');
const hiddenInput = document.getElementById('categoryInput');
const searchInput = document.getElementById('categorySearch');
const categoryItems = document.querySelectorAll('.custom-select-item');

selected.addEventListener('click', () => {
    optionsContainer.style.display = optionsContainer.style.display === 'block' ? 'none' : 'block';
});

// اختيار عنصر
categoryItems.forEach(item => {
    item.addEventListener('click', () => {
        const value = item.getAttribute('data-value');
        hiddenInput.value = value;
        document.getElementById('selectedCategory').innerText = item.querySelector('div').innerText;
        optionsContainer.style.display = 'none';
        searchInput.value = '';
        filterCategories(''); // show all again
    });
});

// اغلاق الـ dropdown عند الضغط خارجها
document.addEventListener('click', function(e){
    if(!selected.parentElement.contains(e.target)){
        optionsContainer.style.display = 'none';
    }
});

// فلترة live أثناء الكتابة
searchInput.addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    filterCategories(filter);
});

function filterCategories(filter) {
    document.querySelectorAll('.custom-select-item').forEach(item => {
        const text = item.querySelector('div').innerText.toLowerCase();
        item.style.display = text.includes(filter) ? 'flex' : 'none';
    });
}
</script>

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
</style>


          <div class="mb-3">
            <label class="form-label fw-semibold small text-muted">Condition</label>
            <select class="form-select" name="condition">
              <option value="">All Conditions</option>
              <option value="New" {{ request('condition') == 'New' ? 'selected' : '' }}>New</option>
              <option value="Used" {{ request('condition') == 'Used' ? 'selected' : '' }}>Used</option>
            </select>
          </div>

          <div id="vin-input-container" class="mb-3" style="display:none;">
            <label class="form-label fw-semibold small text-muted">VIN Number</label>
            <input type="text" name="vin_number" id="vin-number" class="form-control" placeholder="Enter VIN Number">
          </div>

          <div class="d-flex gap-2 border-top pt-3">
            <button type="submit" class="btn flex-fill text-white fw-semibold" style="background-color:#760e13;">
              Apply Filters
            </button>
            <button type="button" onclick="resetFilters()" class="btn btn-outline-secondary flex-fill">
              Reset
            </button>
          </div>
        </form>
      </div>
    </aside>

    <!-- ✅ DEALERS GRID -->
    <section class="col-lg-9 col-md-8">
    <div class="dealers-grid">
@forelse ($dealers as $dealer)
    @php
        $image = $dealer->company_img
            ? config('app.file_base_url') . Str::after($dealer->company_img, url('/') . '/')
            : 'https://via.placeholder.com/350x219?text=No+Image';

        $dealerName = $dealer->company_name
            ? ucfirst(strtolower(substr($dealer->company_name, 0, 25))) . (strlen($dealer->company_name) > 25 ? '...' : '')
            : 'Unknown Dealer';

        $phone = $dealer->user ? $dealer->user->phone : 'N/A';
        $shareUrl = request()->url() . '?shop_id=' . ($dealer->id ?? '');
    @endphp

    <div class="card h-100 shadow-sm">
        <img src="{{ $image }}" 
             class="card-img-top"
             alt="Dealer Image"
             onerror="this.onerror=null; this.src='https://via.placeholder.com/350x219?text=No+Image';"
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
                    <a href="https://wa.me/{{ $phone }}" target="_blank" class="action-link">
                        <button class="btn btn-outline-success action-btn rounded-4">
                            <i class="fab fa-whatsapp"></i>
                        </button>
                    </a>

                    <a href="tel:{{ $phone }}" class="action-link">
                        <button class="btn btn-outline-danger action-btn rounded-4">
                            <i class="fas fa-phone"></i>
                        </button>
                    </a>
                @endif

                <a href="https://wa.me/?text={{ urlencode('Check this store: ' . $shareUrl) }}" 
                   target="_blank" class="action-link">
                    <button class="btn btn-outline-info action-btn rounded-4">
                        <i class="fa fa-share"></i>
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


@php
  use Illuminate\Pagination\LengthAwarePaginator;
@endphp

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
  </div>
</div>


{{-- ================= JS SCRIPT ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const brandSelect = document.getElementById('brand');
    const modelSelect = document.getElementById('model');

    brandSelect.addEventListener('change', function() {
        const brand = this.value;
        modelSelect.innerHTML = '<option value="">Loading...</option>';

        if (brand) {
            fetch(`/get-models?brand=${encodeURIComponent(brand)}`)
                .then(res => res.json())
                .then(models => {
                    modelSelect.innerHTML = '<option value="">All Models</option>';
                    models.forEach(model => {
                        modelSelect.innerHTML += `<option value="${model}">${model}</option>`;
                    });
                });
        } else {
            modelSelect.innerHTML = '<option value="">All Models</option>';
        }
    });
});

function resetFilters() {
    document.getElementById('filterForm').reset();
    document.getElementById('model').innerHTML = '<option value="">All Models</option>';
}
</script>
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

                            response.models.forEach(function (model) {
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