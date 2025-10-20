<style>
    /* Custom Button Styles */
    .custom-btn {
        background-color: #185D31;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        transition: 0.3s ease;
    }
    .custom-btn:hover {
        background-color: #124b27;
        color: #fff;
    }

    /* Mega menu fix for full width */
    .nav-item.dropdown.position-static .dropdown-menu {
        left: 0;
        right: 0;
        transform: none !important;
        max-width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    /* Main Container Styles */
    .navbar-top-bar {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    /* Centering the Search Bar on Desktop (lg and up) */
    @media (min-width: 992px) {
        .search-container {
            flex-grow: 1; 
            display: flex;
            justify-content: center;
            margin: 0 5rem; 
        }
        .navbar-brand { order: 1; }
        .search-container { order: 2; }
        .navbar-collapse { order: 3; }
        .navbar-toggler { display: none; }
    }

    /* Mobile/Tablet Adjustments (Less than 992px) */
    @media (max-width: 991.98px) {
        .container-fluid {
            flex-wrap: wrap;
            align-items: center;
        }

        /* ✅ Logo and toggler in same row */
        .navbar-brand {
            flex: 1;
            order: 1;
        }

        .navbar-toggler {
            order: 2;
            margin-left: auto;
        }

        /* ✅ Search bar takes full width below */
        .search-container {
            width: 100%;
            margin: 0.75rem 0 !important;
            order: 3;
        }

        .navbar-collapse {
            order: 4;
            width: 100%;
        }

        .nav-item.dropdown.position-static .dropdown-menu {
            position: static !important;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm navbar-top-bar">
    <div class="container-fluid d-flex align-items-center">

        <!-- ✅ Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('carllymotorsmainlogo_dark.png') }}" 
                 alt="Carl Motors Logo" 
                 class="img-fluid" 
                 style="max-height: 45px;">
        </a>

        <!-- ✅ Burger icon (in same row on small screens) -->
        <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
            aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars fs-4"></i>
        </button>

        <!-- ✅ Search Bar -->
        <div class="d-flex search-container">
            <form action="{{ route('global.search') }}" method="GET" 
                class="d-flex align-items-center w-100" 
                style="max-width: 700px;">
                
                <select name="type" class="form-select me-2" style="max-width: 130px; border-radius: 8px;">
                    <option value="cars" {{ request('type') == 'cars' ? 'selected' : '' }}>Cars</option>
                    <option value="spareparts" {{ request('type') == 'spareparts' ? 'selected' : '' }}>Spare Parts</option>
                    <option value="workshops" {{ request('type') == 'workshops' ? 'selected' : '' }}>Workshops</option>
                </select>

                <div class="input-group flex-grow-1 shadow-sm" style="border-radius: 10px; overflow: hidden; max-width: 500px;">
                    <span class="input-group-text bg-white border-0 d-none d-md-block">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="search" 
                        name="q" 
                        class="form-control border-0" 
                        placeholder="Search cars, spare parts, workshops..."
                        value="{{ request('q') }}" 
                        style="box-shadow: none;">
                    <button type="submit" class="btn px-4" style="background-color:#5a0b0f; color:#fff; border-radius:0;">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- ✅ Collapsible Menu -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
            <div class="d-flex flex-column flex-lg-row align-items-center gap-4 text-center text-lg-start">
                <ul class="navbar-nav d-flex align-items-center gap-2 gap-lg-4 mb-0">
                    <li class="nav-item">
                        @guest
                            <a href="{{ route('login') }}" class="text-dark fw-semibold text-decoration-none nav-link">
                                Sell Your Car
                            </a>
                        @else
                            <a href="{{ route('cars.create') }}" class="text-dark fw-semibold text-decoration-none nav-link">
                                Sell Your Car
                            </a>
                        @endguest
                    </li>

                    <li class="nav-item dropdown position-static">
                        <a class="nav-link dropdown-toggle text-dark fw-semibold" href="#" id="dropdownMegaMenu" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Browse Cars
                        </a>

                        <div class="dropdown-menu p-4 shadow border-0 mt-2"
                            aria-labelledby="dropdownMegaMenu"
                            style="max-height: 400px; overflow-y: auto; border-radius: 12px; min-width: 650px;">
                            <div class="row g-4">
                                <div class="col-md-4 border-end">
                                    <h6 class="fw-bold mb-3 text-uppercase text-secondary small">By Model</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><a class="dropdown-item py-1 small" href="#">Toyota</a></li>
                                        <li><a class="dropdown-item py-1 small" href="#">Honda</a></li>
                                        <li><a class="dropdown-item py-1 small" href="#">BMW</a></li>
                                    </ul>
                                    <div class="mt-2">
                                        <a href="#" class="small fw-semibold text-decoration-none text-muted">Show All Models →</a>
                                    </div>
                                </div>
                                <div class="col-md-4 border-end">
                                    <h6 class="fw-bold mb-3 text-uppercase text-secondary small">By Year</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><a class="dropdown-item py-1 small" href="#">2024</a></li>
                                        <li><a class="dropdown-item py-1 small" href="#">2023</a></li>
                                        <li><a class="dropdown-item py-1 small" href="#">2022</a></li>
                                    </ul>
                                    <div class="mt-2">
                                        <a href="#" class="small fw-semibold text-decoration-none text-muted">Show All Years →</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold mb-3 text-uppercase text-secondary small">By Type</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><a class="dropdown-item py-1 small" href="#">Sedan</a></li>
                                        <li><a class="dropdown-item py-1 small" href="#">SUV</a></li>
                                        <li><a class="dropdown-item py-1 small" href="#">Truck</a></li>
                                    </ul>
                                    <div class="mt-2">
                                        <a href="#" class="small fw-semibold text-decoration-none text-muted">Show All Types →</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

                @guest
                    <a class="btn custom-btn" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                @else
                    <a href="{{ route('cars.favList') }}" class="btn custom-btn" title="My Favorites">
                        <i class="fas fa-heart"></i>
                    </a>
                    <a class="btn custom-btn" href="#">
                        <i class="fas fa-bullhorn me-1"></i>Place Your AD
                    </a>
                    <div class="dropdown">
                        <a class="btn custom-btn dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>Profile
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm">
                            <li><a href="{{ route('profile', auth()->user()->id) }}" class="dropdown-item"><i class="fas fa-user-circle me-2"></i>My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
