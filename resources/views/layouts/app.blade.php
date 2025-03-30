<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ url('assets/css/listing-detail.css') }}" />
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">

</head>
<style>
.navbar-nav .nav-link {
    color: #fff;
}

.dropend .dropdown-toggle {
    color: #760e13;
    margin-left: 1em;
}

.dropdown-toggle::after {
    color: #760e13;
}

.dropdown-item:hover {
    background-color: #760e13;
    color: #fff;
    border-radius: 20%;
 
}

.dropdown .dropdown-menu {
    display: none;
}

.dropdown-menu a:hover {
    text-decoration-color: #760e13;
    border-color: #760e13;
}

.dropdown-menu a:focus {
    border-color: #760e13;
}

.dropdown:hover>.dropdown-menu,
.dropend:hover>.dropdown-menu {
    display: block;
    margin-top: 0.125em;
    margin-left: 0.125em;
}

@media screen and (min-width: 769px) {
    .dropend:hover>.dropdown-menu {
        position: absolute;
        top: 0;
        left: 100%;
    }

    .dropend .dropdown-toggle {
        margin-left: 0.5em;
    }
}
</style>

<body class="relative h-screen bg-gray-100">
    <!-- Navbar -->
<nav class=" navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2 ">
    <div class="container "> 
        <!-- Logo -->
        <a class="navbar-brand" href="#">
            <img src="{{asset('carllymotorsmainlogo_dark.png')}}" alt="AutoDecar" class="img-fluid" style="height: 50px;">
        </a>

         <!-- Mobile Toggle Button -->
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link fw-semibold text-dark" href="{{route('home')}}">Home</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold text-dark" href="{{route('cars.index')}}">Cars</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold text-dark" href="{{route('spareParts.index')}}">Spare Parts</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold text-dark" href="{{route('aboutus')}}">About us</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold text-dark" href="{{route('contacts.index')}}">Contact</a></li>
            </ul>

            <!-- Icons & Buttons -->
            <div class="d-flex align-items-center gap-3">
                @if(auth()->check() == false)
                <a class="btn" href="{{route('login')}}" style="background-color: #760e13; color: white;">Login</a>
                @else
                <a href="{{route('cars.create')}}" class="btn btn-success text-white">
                    <i class="fas fa-plus"></i>
                </a>
                <a href="{{route('cars.favList')}}" class="btn btn-danger text-white " style="margin-right:2px ; margin-left:2px ;" >
                    <i class="fas fa-heart"></i>
                </a>

                <a class="btn btn-danger text-white mr-1 "   href="#"  role="button" 
                    
                         >
                       Place Your AD
                    </a>

                <div class="dropdown">
                    <a class="btn btn-light border dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="{{route('profile', auth()->user()->id)}}" class="dropdown-item">Profile</a>
                        </li>
                        <li>
                            <form method="post" action="{{route('logout')}}">
                                @csrf
                                <button class="dropdown-item" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</nav>

<style>
    .nav-link:hover, .nav-link:focus, .nav-link.active {
        color: #760e13 !important;
    }

   
</style>

<style>
    .nav-link:hover, .nav-link:focus, .nav-link.active {
        color: #760e13 !important;
        font-weight: bold !important;
    }
    .icons:hover{
        color: #760e13 !important;
    }
</style>


    <!-- breadcrumd-listting -->

<!-- -->

    @yield('content')

    <footer class="footer py-4">
        <div class="container">
            <!-- Top Icons -->
            {{--<div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-trophy me-3 fs-3"></i>
                        <div>
                            <h6 class="mb-0">Top 1 Americas</h6>
                            <p class="mb-0">Largest Auto portal</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-car me-3 fs-3"></i>
                        <div>
                            <h6 class="mb-0">Car Sold</h6>
                            <p class="mb-0">Every 5 minutes</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-tags me-3 fs-3"></i>
                        <div>
                            <h6 class="mb-0">Offers</h6>
                            <p class="mb-0">Stay updated, pay less</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fas fa-balance-scale me-3 fs-3"></i>
                        <div>
                            <h6 class="mb-0">Compare</h6>
                            <p class="mb-0">Decode the right car</p>
                        </div>
                    </div>
                </div>
            </div>--}}

            <!-- Footer Links -->
            <div class="row footer-links mt-4 g-4 text-md-start">
                <div class='col-12 col-md-3'>
                <a href="#" class="footer-logo">
                            <img src="{{asset('carllymotors_logo_white-2048x526.png')}}" alt="AutoDecar" class="img-fluid"
                                style="max-width: 150px;">
                        </a>
 <div class="col-md-6 text-md-end">
                        <div class="icons social-icons  d-flex justify-content-center justify-content-md-end gap-3 mt-3">
                            <a href="https://www.instagram.com/carllymotors?igsh=N3F5aHVpajd0ZnNk&utm_source=qr"><i
                                    class="fab fa-instagram fs-4" style="color:#fff ;"></i></a>
                            <a href="https://www.tiktok.com/@carllymotors"><i class="fab fa-tiktok fs-4"
                                    style="color:#fff"></i></a>
                            <a href="https://x.com/carllymotors?s=11&mx=2"><i class="fab fa-twitter fs-4"
                                    style="color:#fff"></i></a>
                            <a href="https://wa.me/971566350025"><i class="fab fa-whatsapp fs-4"
                                    style="color:#fff"></i></a>
                        </div>
            </div>
                </div>
                <div class="col-12 col-md-3">
                    <h5>About Auto Decar</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{route('aboutus')}}">About us</a></li>
                        <li><a href="{{route('contacts.index')}}">Contact us</a></li>
                        <li><a href="{{route('terms')}}">Terms & Conditions</a></li>
                        <li><a href="{{route('privacy')}}">Privacy Policy</a></li>
                        {{--<li><a href="{{route('faqs')}}">FAQs</a></li>--}}
                    </ul>
                </div>
                <div class="col-12 col-md-3">
                    <h5>Popular Used Cars</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Chevrolet</a></li>
                        <li><a href="#">Ford</a></li>
                        <li><a href="#">Toyota</a></li>
                        <li><a href="#">BMW</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-3">
                    <h5>Newsletter</h5>
                    <p>Stay on top of the latest car trends, tips, and tricks for selling your car.</p>

                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Your email address"
                            aria-label="Your email address">
                        <button class="btn bg-carlly" type="button">Send</button>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom mt-4">
                <div class="row">
                    <div class="col-md-12 mb-3 mb-md-0">
                        <!-- <a href="#" class="footer-logo">
                            <img src="{{asset('carllymotorsmainlogo_dark.png')}}" alt="AutoDecar" class="img-fluid"
                                style="max-width: 150px;">
                        </a> -->
                        <p class="mt-2 d-flex justify-content-center">© 2025 Carlly Motors. All rights reserved</p>
                    </div>
                    <!-- <div class="col-md-6 text-md-end">
                        <div class="d-flex justify-content-center justify-content-md-end gap-5">
                            <a href="https://www.instagram.com/carllymotors?igsh=N3F5aHVpajd0ZnNk&utm_source=qr"><i
                                    class="fab fa-instagram fs-4" style="color:#fff"></i></a>
                            <a href="https://www.tiktok.com/@carllymotors"><i class="fab fa-tiktok fs-4"
                                    style="color:#fff"></i></a>
                            <a href="https://x.com/carllymotors?s=11&mx=2"><i class="fab fa-twitter fs-4"
                                    style="color:#fff"></i></a>
                            <a href="https://wa.me/971566350025"><i class="fab fa-whatsapp fs-4"
                                    style="color:#fff"></i></a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('carlistingscript')
    {{-- Script related listing-details page --}}
    <script>
    $(document).ready(function() {
        // Toggle the icon when accordion is expanded/collapsed
        $('.accordion-button').on('click', function() {
            const icon = $(this).find('.icon');
            const isExpanded = $(this).attr('aria-expanded') === 'true';

            // Remove rotate class from all icons
            $('.icon').removeClass('rotate');

            // Add rotate class if this item is expanded
            if (!isExpanded) {
                icon.addClass('rotate');
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        let currentUrl = window.location.href;
        document.querySelectorAll(".nav-link").forEach(link => {
            if (link.href === currentUrl) {
                link.classList.add("active");
            }
        });
    });
    </script>

</body>

</html>