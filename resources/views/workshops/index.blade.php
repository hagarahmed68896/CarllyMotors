@extends('layouts.app')

@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
@endphp

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    body {
        background-color: #f8f9fa;
        font-family: "Poppins", sans-serif;
    }

    /* Sidebar */
    .filter-sidebar {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 25px;
        position: sticky;
        top: 90px;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .filter-sidebar h5 {
        font-weight: 700;
        color: #760e13;
        border-bottom: 2px solid #f1f1f1;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .btn-apply {
        background-color: #760e13;
        color: white;
        border: none;
        transition: 0.3s;
    }

    .btn-apply:hover {
        background-color: #5a0b0f;
        color: white;
    }

    /* Workshop Cards */
    .workshop-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .workshop-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .workshop-card img {
        height: 200px;
        object-fit: cover;
    }

    .workshop-card h5 {
        color: #760e13;
        font-weight: 600;
    }

    .workshop-card .text-muted i {
        color: #760e13;
        margin-right: 5px;
    }

    /* Action Buttons */
    .actions {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 15px;
    }

    .actions .btn {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-outline-danger {
        border-color: #760e13;
        color: #760e13;
    }

    .btn-outline-danger:hover {
        background-color: #760e13;
        color: white;
    }

    .btn-outline-primary {
        border-color: #5a0b0f;
        color: #5a0b0f;
    }

    .btn-outline-primary:hover {
        background-color: #5a0b0f;
        color: #fff;
    }
</style>

@section('content')
<div class="container my-4">
    <div class="row g-4">
        
        <!-- Sidebar Filter -->
        <aside class="col-lg-3 col-md-4">
            <div class="filter-sidebar">
                <h5><i class="fas fa-sliders-h me-2"></i>Filter Workshops</h5>
<form id="filterForm" method="GET" 
      action="{{ request()->routeIs('global.search') ? route('global.search') : route('workshops.index') }}">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">Make</label>
                        <select class="form-select" id="brand" name="brand_id">
                            <option value="">All Makes</option>
                            @foreach($brands as $key => $brand)
                                <option value="{{ $key }}" {{ request('brand_id') == $key ? 'selected' : '' }}>
                                    {{ $brand }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-muted">Category</label>
                        <select class="form-select" id="workshop" name="category_id">
                            <option value="">All Categories</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $key }}" {{ request('category_id') == $key ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold small text-muted">City</label>
                        <select class="form-select" id="city" name="city">
                            <option value="">All Cities</option>
                            @foreach($cities as $city)
                                @if(!empty($city))
                                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex gap-2 border-top pt-3">
<button type="submit" class="btn flex-fill rounded-3 text-white" style="background-color: #760e13; border-color: #760e13;">
                            Apply Filters</button>
                        <button type="button" onclick="resetFilters()" class="btn btn-light flex-fill border">Reset</button>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Workshops List -->
     <div class="col-lg-9 col-md-8">
    <div class="row g-4">
        @forelse ($workshops as $workshop)
            @php
                $shareUrl = request()->url() . '?id=' . $workshop->id;
                $image = $workshop->workshop_logo
                    ? (Str::startsWith($workshop->workshop_logo, ['http://', 'https://'])
                        ? $workshop->workshop_logo
                        : env('CLOUDFLARE_R2_URL') . $workshop->workshop_logo)
                    : asset('workshopNotFound.png');
            @endphp

            <div class="col-sm-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden workshop-card">
                    <img src="{{ $image }}" 
                         onerror="this.onerror=null; this.src='{{ asset('workshopNotFound.png') }}';" 
                         class="card-img-top" 
                         alt="Workshop Image" 
                         style="height:200px; object-fit:cover;">

                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title fw-bold text-truncate">{{ Str::limit($workshop->workshop_name, 25) }}</h5>
                            <p class="text-muted small mb-1">
                                <i class="fas fa-map-marker-alt me-1 text-danger"></i>{{ $workshop->address }}
                            </p>

                            @if(isset($workshop->days[0]))
                                <p class="text-muted small mb-2">
                                    <i class="fas fa-clock me-1 text-success"></i>
                                    {{ $workshop->days[0]->day }}: {{ $workshop->days[0]->from }} - {{ $workshop->days[0]->to }}
                                </p>
                            @endif

                            @if(count($workshop->days) > 1)
                                <div class="dropdown mb-2">
                                    <a class="btn btn-sm btn-outline-secondary dropdown-toggle w-100" href="#" id="dropdownDays{{ $workshop->id }}"
                                       data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 10px;">
                                        More Days
                                    </a>
                                    <ul class="dropdown-menu w-100" aria-labelledby="dropdownDays{{ $workshop->id }}">
                                        @foreach($workshop->days as $key => $day)
                                            @if($key == 0) @continue @endif
                                            <li class="px-3 py-1 small text-muted">
                                                <i class="fas fa-clock me-1" style="color:#5a0b0f;"></i>
                                                {{ $day->day }}: {{ $day->from }} - {{ $day->to }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                        <a href="https://wa.me/{{ $workshop->user->phone }}?text={{ urlencode(
    'Hello, I’m interested in your workshop services. Are you still available for maintenance or repair work?' . "\n\n" .
    'Workshop Name: ' . $workshop->workshop_name . "\n" .
    'Address: ' . ($workshop->address ?? 'Not specified') . "\n\n" .
    'View Workshop on Website: ' . $shareUrl
) }}"
   target="_blank"
   class="text-decoration-none flex-grow-1">
    <button class="btn btn-outline-success w-100 action-btn rounded-4">
        <i class="fab fa-whatsapp"></i>
    </button>
</a>


                            @php
                                $isMobile = Str::contains(request()->header('User-Agent'), ['Android', 'iPhone', 'iPad']);
                            @endphp

                            @if($isMobile)
                                <a href="tel:{{ $workshop->user?->phone }}" 
                                   class="btn btn-outline-danger flex-fill mx-1 rounded-3">
                                    <i class="fas fa-phone"></i>
                                </a>
                            @else
                                <a href="https://wa.me/{{ $workshop->user?->phone }}" 
                                   target="_blank" 
                                   class="btn btn-outline-danger flex-fill mx-1 rounded-3">
                                    <i class="fas fa-phone"></i>
                                </a>
                            @endif

                            <a href="https://wa.me/?text={{ urlencode('Check this workshop: ' . $shareUrl) }}" 
                               target="_blank" 
                               class="btn btn-outline-info flex-fill mx-1 rounded-3">
                                <i class="fa fa-share"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted mt-4">No workshops found.</p>
        @endforelse
    </div>
    @php
  use Illuminate\Pagination\LengthAwarePaginator;
@endphp

@if ($workshops instanceof LengthAwarePaginator && $workshops->hasPages())
  @php
    $current = $workshops->currentPage();
    $last = $workshops->lastPage();
    $maxFull = 50; // if pages <= this -> show all pages
    $window = 2;   // pages to show around current when condensing
    // build pages array to render
    $pages = [];

    if ($last <= $maxFull) {
        for ($p = 1; $p <= $last; $p++) {
            $pages[] = $p;
        }
    } else {
        // always show first 2
        $pages[] = 1;
        $pages[] = 2;

        // determine left and right window
        $start = max(3, $current - $window);
        $end = min($last - 2, $current + $window);

        if ($start > 3) {
            $pages[] = '...';
        } else {
            // include 3 if window touches
            for ($p = 3; $p < $start; $p++) $pages[] = $p;
        }

        for ($p = $start; $p <= $end; $p++) $pages[] = $p;

        if ($end < $last - 2) {
            $pages[] = '...';
        } else {
            for ($p = $end + 1; $p <= $last - 2; $p++) $pages[] = $p;
        }

        // always show last 2
        $pages[] = $last - 1;
        $pages[] = $last;

        // remove duplicates while preserving order
        $pages = array_values(array_unique($pages));
    }
  @endphp

  <nav aria-label="Page navigation" class="mt-4">
    <ul class="custom-pagination d-flex justify-content-center align-items-center flex-wrap">

      {{-- Previous --}}
      @if ($workshops->onFirstPage())
        <li class="disabled"><span class="page-btn" aria-hidden="true">‹</span></li>
      @else
        <li><a href="{{ $workshops->previousPageUrl() }}" class="page-btn" rel="prev" aria-label="Previous">‹</a></li>
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
            <li><a href="{{ $workshops->url($p) }}" class="page-btn" aria-label="Go to page {{ $p }}">{{ $p }}</a></li>
          @endif
        @endif
      @endforeach

      {{-- Next --}}
      @if ($workshops->hasMorePages())
        <li><a href="{{ $workshops->nextPageUrl() }}" class="page-btn" rel="next" aria-label="Next">›</a></li>
      @else
        <li class="disabled"><span class="page-btn" aria-hidden="true">›</span></li>
      @endif
    </ul>
  </nav>

  {{-- Page Info --}}
  <div class="d-flex justify-content-center mt-3">
    <div class="page-info text-center" role="status" aria-live="polite">
      Page <strong>{{ $workshops->currentPage() }}</strong> of <strong>{{ $workshops->lastPage() }}</strong>
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

</div>


    </div>
</div>

<script>
function resetFilters() {
  const url = new URL(window.location.href);
  url.search = ''; // يحذف كل الاستعلامات
  window.location.href = url.toString();
}
</script>

@endsection
