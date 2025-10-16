<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
  <div class="container-fluid">

    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
      <img src="{{ asset('carllymotorsmainlogo_dark.png') }}" 
           alt="Carl Motors Logo" 
           class="img-fluid" 
           style="max-height: 45px;">
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible Content -->
    <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbarNav">

      <!-- 🔍 Search Bar (CENTERED) -->
      <div class="mx-auto my-3 my-lg-0 d-flex justify-content-center w-100 w-lg-auto" style="max-width: 700px;">
        <form action="{{ route('global.search') }}" method="GET" class="d-flex align-items-center w-100">
          <select name="type" class="form-select me-2" style="max-width: 150px; border-radius: 8px;">
            <option value="cars" {{ request('type') == 'cars' ? 'selected' : '' }}>Cars</option>
            <option value="spareparts" {{ request('type') == 'spareparts' ? 'selected' : '' }}>Spare Parts</option>
            <option value="workshops" {{ request('type') == 'workshops' ? 'selected' : '' }}>Workshops</option>
          </select>

          <div class="input-group flex-grow-1 shadow-sm" style="border-radius: 10px; overflow: hidden;">
            <span class="input-group-text bg-white border-0">
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

      <!-- 🧍 Right Side Buttons -->
      <div class="d-flex align-items-center justify-content-end flex-column flex-lg-row gap-2 mt-3 mt-lg-0 text-center text-lg-start">

        @guest
          <a class="btn custom-btn" href="{{ route('login') }}">
            <i class="fas fa-sign-in-alt me-1"></i>Login
          </a>
        @else
          <a href="{{ route('cars.create') }}" class="btn custom-btn" title="Add New Car">
            <i class="fas fa-plus"></i>
          </a>

          <a href="{{ route('cars.favList') }}" class="btn custom-btn" title="My Favorites">
            <i class="fas fa-heart"></i>
          </a>

          <a class="btn custom-btn" href="#">
            <i class="fas fa-bullhorn me-1"></i>Place Your AD
          </a>

          <!-- Profile Dropdown -->
          <div class="dropdown">
            <a class="btn custom-btn dropdown-toggle" href="#" data-bs-toggle="dropdown">
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

<style>
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

  /* --- RESPONSIVE FIXES --- */
  @media (max-width: 991px) {
    .navbar-collapse {
      text-align: center;
    }
    .navbar .dropdown-menu {
      position: static !important;
      float: none;
      margin-top: 0.5rem;
    }
    .navbar .custom-btn {
      width: 100%;
    }
    .input-group span.input-group-text {
      display: none; /* hides icon to save space on mobile */
    }
    .input-group .form-control {
      font-size: 14px;
    }
  }
</style>
