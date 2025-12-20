<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- External Dependencies -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Single Integrated CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}?v={{ filemtime(public_path('assets/css/app.css')) }}">
    
    <!-- Meta Tags for SEO -->
    <meta name="description" content="Find the best cars, spare parts, and workshops in UAE. Buy and sell cars with AutoDecar - Your trusted automotive partner.">
    <meta name="keywords" content="cars, automotive, UAE, spare parts, workshops, buy car, sell car">
    <meta name="author" content="AutoDecar">
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="{{ config('app.name', 'AutoDecar') }}">
    <meta property="og:description" content="Find the best cars, spare parts, and workshops in UAE">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <style>
        .footer-title-provider {
  color: white;
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  position: relative;
  
}
.footer-title-provider::after {
  content: '';
  position: absolute;
  bottom: -8px;
  left: 0;
  width: 40px;
  height: 2px;
  /* background: #7A8A9A; */
  border-radius: 1px;
  
}
.custom-btn-provider {
  background: #163155;
  color: white !important;
  font-weight: 600;
  padding: 0.6em 1.5em;
  border-radius: 15px;
  margin-right: 0.2em;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  border: 2px solid transparent;
  text-decoration: none;
  box-shadow: 0 2px 8px rgba(118, 14, 19, 0.2);

  /* 👇 خليه يغيّر الظل والحركة فقط */
  transition: box-shadow .3s ease, transform .3s ease;
}

.custom-btn-provider:hover {
  background: linear-gradient(135deg, #163155, #1b3f6d);
  box-shadow: 0 4px 12px rgba(118, 14, 19, 0.3);
  transform: translateY(-2px);
  color: white !important;
}

.custom-btn-provider:focus {
  box-shadow: 0 0 0 0.2rem rgba(118, 14, 19, 0.25);
  outline: none;
}

    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm navbar-top-bar">
    <div class="container-fluid d-flex align-items-center">

        {{-- Logo always visible --}}
  <a class="navbar-brand d-flex align-items-center" 
   href="@auth
            {{
                auth()->user()->usertype === 'dealer' ? route('cars.dashboard') :
                (auth()->user()->usertype === 'workshop_provider' ? route('workshops.dashboard') :
                (auth()->user()->usertype === 'shop_dealer' ? route('spareparts.dashboard') :
                route('home')))
            }}
        @else
            {{ route('home') }}
        @endauth">
    <img src="{{ asset('carllymotorsmainlogo_dark.png') }}" 
         alt="Carl Motors Logo" 
         class="img-fluid" 
         style="max-height: 45px;">
</a>



        {{-- Toggler for mobile --}}
        <button class="navbar-toggler border-0 d-lg-none" 
                type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <i class="fas fa-bars fs-4"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            {{-- CENTER MENU BASED ON USER ROLE --}}
        <ul class="navbar-nav mx-auto d-flex align-items-center gap-3 mb-0">
    @auth
        @if(auth()->user()->usertype === 'dealer')
            <li class="nav-item">
                <a href="{{ route('my.cars', ['carType' => 'used']) }}" class="nav-link-provider">
                    Used/New
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('my.cars', ['carType' => 'imported']) }}" class="nav-link-provider">
                    Imported
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('my.cars', ['carType' => 'auction']) }}" class="nav-link-provider">
                    Auction
                </a>
            </li>
        @endif
    @endauth
</ul>

@auth
    @if(auth()->user()->usertype === 'workshop_provider')
        <ul class="navbar-nav ms-auto d-flex align-items-center gap-3 mb-0">
            <li class="nav-item">
                <a href="{{ route('workshops.myWorkshop') }}" class="nav-link-provider">
                    My Workshop
                </a>
            </li>
        </ul>
    @endif
@endauth
@auth
    @if(auth()->user()->usertype === 'shop_dealer')
        <ul class="navbar-nav ms-auto d-flex align-items-center gap-3 mb-0">
            <li class="nav-item">

                <a href="{{ route('spareparts.create') }}" 
                   class="nav-link-provider">
                    Add Spare Parts
                </a>

</li>
        </ul>
    @endif
@endauth

            {{-- RIGHT SIDE: LOGIN / PROFILE --}}
            <ul class="navbar-nav d-flex align-items-center gap-3 mb-0">

                @guest
                    <li class="nav-item">
                        <a class="custom-btn-provider" href="{{ route('providers.cars.login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item dropdown">
<a class="nav-link-provider dropdown-toggle profile-link"
   href="#"
   data-bs-toggle="dropdown">

    <img src="{{ auth()->user()->image ?? asset('user-201.png') }}"
         alt="Profile"
         class="profile-avatar"
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
    border-color: #3b82f6;
}

.profile-link.show .profile-avatar {
    border-color: #2563eb;
}

</style>


<ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm">
    <li>
        @php
            $user = auth()->user();

            $profileRoute = match ($user->usertype) {
                'workshop_provider' => route('workshop.profile', $user->id),
                'shop_dealer'       => route('spareparts.profile', $user->id),
                default             => route('provider.profile', $user->id),
            };

            $logoutRoute = match ($user->usertype) {
                'workshop_provider' => route('workshops.logout'),
                'shop_dealer'       => route('spareparts.logout'),
                default             => route('providers.logout'),
            };
        @endphp

        <a href="{{ $profileRoute }}"
           class="dropdown-item-provider"
           style="text-decoration:none">
            <i class="fas fa-user-circle me-2"></i> My Profile
        </a>
    </li>

    <li><hr class="dropdown-divider"></li>

    <li>
        <form method="POST" action="{{ $logoutRoute }}">
            @csrf
            <button type="submit"
                    class="dropdown-item-provider w-100"
                    style="border:0;background:none;">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </li>
</ul>

                    </li>
                @endauth

            </ul>

        </div>
    </div>
</nav>




    <!-- Main Content with Consistent Layout -->
    <main role="main" class="main-content">
        @yield('content')
    </main>

    <!-- Enhanced Footer -->
    <footer class="footer py-5">
        <div class="container">
            <!-- Footer Content -->
            <div class="row footer-links g-4 text-md-start">
                <!-- Brand Column -->
                <div class="col-12 col-md-4">
              <a class="footer-logo d-block mb-3"
   href="{{ auth()->check() ? route('cars.dashboard') : route('home') }}">
    <img src="{{ asset('carllymotors_logo_white-2048x526.png') }}" 
         alt="AutoDecar"
         class="img-fluid"
         style="max-width: 150px;"
         loading="lazy">
</a>

                    <p class=" mb-3">Your trusted partner for buying and selling cars in the UAE. Find your perfect car or sell your current one with ease.</p>
                    
                    <!-- Social Media Links -->
                    <div class="social-icons d-flex gap-3">
                        <a href="https://www.instagram.com/carllymotors?igsh=N3F5aHVpajd0ZnNk&utm_source=qr" 
                           target="_blank" 
                           rel="noopener"
                           class="social-link-provider"
                           title="Follow us on Instagram"
                           aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.tiktok.com/@carllymotors" 
                           target="_blank" 
                           rel="noopener"
                           class="social-link-provider"
                           title="Follow us on TikTok"
                           aria-label="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="https://x.com/carllymotors?s=11&mx=2" 
                           target="_blank" 
                           rel="noopener"
                           class="social-link-provider"
                           title="Follow us on Twitter"
                           aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/971566350025" 
                           target="_blank" 
                           rel="noopener"
                           class="social-link-provider"
                           title="Contact us on WhatsApp"
                           aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- About Column -->
                <div class="col-12 col-md-4">
                    <h5 class="footer-title-provider">About Auto Decar</h5>
                    <ul class="list-unstyled footer-list">
                        <li><a href="{{ route('providers.aboutus') }}"><i class="fas fa-chevron-right me-2"></i>About us</a></li>
                        <li><a href="{{ route('providers.contacts.index') }}"><i class="fas fa-chevron-right me-2"></i>Contact us</a></li>
                        <li><a href="{{ route('providers.terms') }}"><i class="fas fa-chevron-right me-2"></i>Terms & Conditions</a></li>
                        <li><a href="{{ route('providers.privacy') }}"><i class="fas fa-chevron-right me-2"></i>Privacy Policy</a></li>
                    </ul>
                </div>



<!-- Providers Column -->
<div class="col-12 col-md-4">
    <h5 class="footer-title-provider">Providers</h5>
    <ul class="list-unstyled footer-list">
        <li>
        <a href="{{ route('providers.cars.login') }}">
    <i class="fas fa-chevron-right me-2"></i>Cars Provider
</a>

        </li>
        <li>
           <a href="{{ route('providers.workshops.login') }}">
                <i class="fas fa-chevron-right me-2"></i>Workshops Provider
            </a>
        </li>
        <li>
            <a href="{{ route('providers.spareparts.login') }}">
                <i class="fas fa-chevron-right me-2"></i>Spare Parts Provider
            </a>
        </li>
    </ul>
</div>

       
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom mt-5 pt-4 border-top">
                <div class="row align-items-center">
                    <div class="col-md-12 text-center">
                        <p class="mb-0">
                           © 2024 by Carsilla                             {{-- <span class="d-none d-md-inline">|</span> --}}
                            {{-- <br class="d-md-none"> --}}
                            {{-- Made with <i class="fas fa-heart text-danger"></i> in UAE --}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

</body>
</html>