<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('carllymotorsmainlogo_dark.png') }}" 
                 alt="Carl Motors Logo" 
                 class="img-fluid" 
                 loading="eager" 
                 style="max-height: 45px;">
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <!-- Links -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 d-flex align-items-lg-center gap-lg-1 text-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cars.index') ? 'active' : '' }}" href="{{ route('cars.index') }}">
                        <i class="fas fa-car me-1"></i>Cars
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('spareParts.index') ? 'active' : '' }}" href="{{ route('spareParts.index') }}">
                        <i class="fas fa-cog me-1"></i>Spare Parts
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('workshops.index') ? 'active' : '' }}" href="{{ route('workshops.index') }}">
                        <i class="fas fa-wrench me-1"></i>Workshops
                    </a>
                </li>
            </ul>

            <!-- 🔍 Search Bar -->
            {{-- <form action="{{ route('search') }}" method="GET" 
                  class="d-flex mx-auto mb-3 mb-lg-0" style="max-width: 400px;">
                <input class="form-control me-2" 
                       type="search" 
                       name="q" 
                       placeholder="Search cars, parts, workshops..." 
                       aria-label="Search"
                       value="{{ request('q') }}"
                       style="border-radius: 8px;">
                <button class="btn btn-success" type="submit" style="background-color: #185D31; border-color: #185D31;">
                    <i class="fas fa-search"></i>
                </button>
            </form> --}}

            <!-- Right Side -->
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0 justify-content-center justify-content-lg-end flex-column flex-lg-row">
                @guest
                    <a class="btn custom-btn" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                @else
                    <a href="{{ route('cars.create') }}" class="btn custom-btn" title="Add New Car" data-bs-toggle="tooltip">
                        <i class="fas fa-plus"></i>
                    </a>

                    <a href="{{ route('cars.favList') }}" class="btn custom-btn" title="My Favorites" data-bs-toggle="tooltip">
                        <i class="fas fa-heart"></i>
                    </a>

                    <a class="btn custom-btn" href="#" title="Place Your AD" data-bs-toggle="tooltip">
                        <i class="fas fa-bullhorn me-1"></i>Place Your AD
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <a class="btn custom-btn dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i>Profile
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="{{ route('profile', auth()->user()->id) }}" class="dropdown-item">
                                    <i class="fas fa-user-circle me-2"></i>My Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="post" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
