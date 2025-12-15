<style>
/* (لا توجد تغييرات في الـCSS) */
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
    
    /* تحديد لون التفعيل بشكل واضح */
    /* .nav-link.active {
        color: #5a0b0f !important; 
        border-bottom: 2px solid #5a0b0f;
    } */

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

        .navbar-brand {
            flex: 1;
            order: 1;
        }

        .navbar-toggler {
            order: 2;
            margin-left: auto;
        }

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

        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('carllymotorsmainlogo_dark.png') }}" 
                 alt="Carl Motors Logo" 
                 class="img-fluid" 
                 style="max-height: 45px;">
        </a>

        <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
            aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars fs-4"></i>
        </button>

        <div class="d-flex search-container">
            <form action="{{ route('global.search') }}" method="GET" 
                class="d-flex align-items-center w-100" 
                style="max-width: 700px;">
                <div class="input-group flex-grow-1 shadow-sm" style="border-radius: 10px; overflow: hidden; max-width: 500px;">
                    <span class="input-group-text bg-white border-0 d-none d-md-block">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="search" 
                        name="q" 
                        class="form-control border-0" 
                        placeholder="Search Cars"
                        value="{{ request('q') }}" 
                        style="box-shadow: none;">
                    <button type="submit" class="btn px-4" style="background-color:#5a0b0f; color:#fff; border-radius:0;">
                        Search 
                    </button>
                </div>
            </form>
        </div>

        <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
            <ul class="navbar-nav d-flex align-items-center gap-2 gap-lg-4 mb-0">

                <li class="nav-item">
                    {{-- 💡 تغيير الـhref لـ'#' إذا كان ضيفاً لمنع التفعيل التلقائي --}}
<a href="{{ auth()->check() ? route('cars.my') : route('login') }}"
   class="text-dark fw-semibold text-decoration-none nav-link d-flex align-items-center gap-1
          {{ auth()->check() && request()->routeIs('cars.my') ? 'active' : '' }}">

    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front-fill me-1" viewBox="0 0 16 16">
        <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17s3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z"/>
    </svg>
    My Listing
</a>

                </li>

                <li class="nav-item">
                    {{-- 💡 تغيير الـhref لـ'#' إذا كان ضيفاً لمنع التفعيل التلقائي --}}
<a href="{{ auth()->check() ? route('cars.favList') : route('login') }}"
   class="text-dark fw-semibold text-decoration-none nav-link d-flex align-items-center gap-1
          {{ auth()->check() && request()->routeIs('cars.favList') ? 'active' : '' }}">


    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-heart-fill me-1" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
    </svg>
    Favorites
</a>

                </li>

                @auth
                <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle profile-link d-flex align-items-center"
   href="#"
   data-bs-toggle="dropdown">
<img id="profileImage"
     src="{{ auth()->user()->image ? asset(auth()->user()->image) : asset('user-201.png') }}"
     class="profile-avatar rounded-circle shadow-sm"
     onerror="this.onerror=null;this.src='{{ asset('user-201.png') }}';">

</a>
<style>
    .profile-link,
.profile-link:hover,
.profile-link:focus,
.profile-link:active {
    text-decoration: none !important;
    outline: none !important;
    box-shadow: none !important;
}

/* إزالة سهم Bootstrap */
.profile-link::after {
    display: none !important;
}

.profile-avatar {
    width: 42px;
    height: 42px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #e5e7eb;
    transition: all 0.2s ease;
}

.profile-link:hover .profile-avatar {
    border-color: #792222;
}

.profile-link.show .profile-avatar {
    border-color: #792222;
}

</style>
                    <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm">
                        <li>
                            <a href="{{ route('profile', auth()->user()->id) }}" class="dropdown-item">
                                <i class="fas fa-user-circle me-2"></i> My Profile
                            </a>                    
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="post" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth

          

            @guest
            <a class="btn custom-btn ms-2 {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt me-1"></i> Login
            </a>
            @endguest
              </ul>
        </div>
    </div>
</nav>

