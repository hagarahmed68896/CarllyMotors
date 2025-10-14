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
                <form id="filterForm" method="GET" action="{{ route('workshops.index') }}">
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
                        <select class="form-select" id="workshop" name="workshop_category_id">
                            <option value="">All Categories</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $key }}" {{ request('workshop_category_id') == $key ? 'selected' : '' }}>
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
            <div class="row">
                @foreach ($workshops as $workshop)
                @php
                    $shareUrl = request()->url() . '?id=' . $workshop->id;
                    $image = $workshop->workshop_logo
                        ? (Str::startsWith($workshop->workshop_logo, ['http://', 'https://'])
                            ? $workshop->workshop_logo
                            : env('CLOUDFLARE_R2_URL') . $workshop->workshop_logo)
                        : asset('workshopNotFound.png');
                @endphp

                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card workshop-card h-100">
                        <img src="{{ $image }}" onerror="this.onerror=null; this.src='{{ asset('workshopNotFound.png') }}';" class="card-img-top" alt="Workshop Image">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title text-truncate">{{ Str::limit($workshop->workshop_name, 25) }}</h5>
                                <p class="text-muted small mb-1"><i class="fas fa-map-marker-alt"></i>{{ $workshop->address }}</p>
                                @if(isset($workshop->days[0]))
                                    <p class="text-muted small mb-1"><i class="fas fa-clock"></i>{{ $workshop->days[0]->day }}: {{ $workshop->days[0]->from }} - {{ $workshop->days[0]->to }}</p>
                                @endif
                                       @if(count($workshop->days) > 1)
                    <div class="dropdown mb-2">
                        <a class="btn btn-sm btn-outline-secondary dropdown-toggle" href="#" id="dropdownDays"
                           data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 10px;">
                            More Days
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownDays">
                            @foreach($workshop->days as $key => $day)
                                @if($key == 0) @continue @endif
                                <li class="px-3 py-1 small text-muted">
                                    <i class="fas fa-clock me-1" style="color:#760e13;"></i>
                                    {{ $day->day }}: {{ $day->from }} - {{ $day->to }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                            </div>

                            <div class="actions">
                                <a href="https://wa.me/{{ $workshop->user?->phone }}" target="_blank" class="btn btn-outline-success">
                                    <i class="fab fa-whatsapp"></i>
                                </a>

                                @php
                                    $isMobile = Str::contains(request()->header('User-Agent'), ['Android', 'iPhone', 'iPad']);
                                @endphp

                                @if($isMobile)
                                    <a href="tel:{{ $workshop->user?->phone }}" class="btn btn-outline-danger">
                                        <i class="fas fa-phone"></i>
                                    </a>
                                @else
                                    <a href="https://wa.me/{{ $workshop->user?->phone }}" target="_blank" class="btn btn-outline-danger">
                                        <i class="fas fa-phone"></i>
                                    </a>
                                @endif

                                <a href="https://wa.me/?text={{ urlencode('Check this workshop: ' . $shareUrl) }}" target="_blank" class="btn btn-outline-primary">
                                    <i class="fa fa-share"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
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
