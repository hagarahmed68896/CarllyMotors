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

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="https://carllymotors.com/wp-content/uploads/2024/04/carllymotors_logo_white-1024x263.png.webp"
                    alt="AutoDecar">
            </a>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{route('home')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('cars.index')}}">Cars</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('spareParts.index')}}">Spare Parts</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('aboutus')}}">About us</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{route('contactus')}}">Contact</a></li>
                </ul>

                <!-- Icons & Buttons -->
                <div class="d-flex align-items-center right-sidebar-nav">
                    <i class="search-icon fas fa-search"></i>
                    <i class="fav-icon fas fa-heart"></i>
                    <i class="login-icon fas fa-user"></i>
                    @guest
                        <a class="nav-link login-nav" href="{{route('login')}}">Login / Register</a>
                    @else
                        <a href="#" class="btn btn-add-listing">Add listing</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    <!-- breadcrumd-listting -->

    @yield('content')

    <footer class="footer">
        <div class="container">
            <!-- Top Icons -->
            <div class="row text-center ">
                <div class="col-md-3 icon-box">
                    <div class="row align-items-center">
                        <div class="col-sm-3">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="col-sm-9">
                            <h6>Top 1 Americas</h6>
                            <p>Largest Auto portal</p>
                        </div>
                    </div>

                </div>
                <div class="col-md-3 icon-box">
                    <div class="row align-items-center">
                        <div class="col-sm-3">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="col-sm-9">
                            <h6>Car Sold</h6>
                            <p>Every 5 minutes</p>
                        </div>
                    </div>



                </div>
                <div class="col-md-3 icon-box">
                    <div class="row align-items-center">
                        <div class="col-sm-3">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="col-sm-9">
                            <h6>Offers</h6>
                            <p>Stay updated, pay less</p>
                        </div>
                    </div>



                </div>
                <div class="col-md-3 icon-box">
                    <div class="row align-items-center">
                        <div class="col-sm-3">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <div class="col-sm-9">
                            <h6>Compare</h6>
                            <p>Decode the right car</p>
                        </div>
                    </div>



                </div>
            </div>
            <!-- Footer Links -->
            <div class="row footer-links">
                <div class="col-md-3">
                    <h5>About Auto Decar</h5>
                    <ul>
                        <li><a href="{{route('aboutus')}}">About us</a></li>
                        <li><a href="{{route('terms')}}">Terms &amp; Conditions</a></li>
                        <li><a href="{{route('privacy')}}">Privacy Policy</a></li>
                        <li><a href="{{route('faqs')}}">FAQs</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Popular Used Cars</h5>
                    <ul>
                        <li><a href="">Chevrolet</a></li>
                        <li><a href="">Ford</a></li>
                        <li><a href="">Toyota</a></li>
                        <li><a href="">BMW</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3 newsletter">
                    <h5>Newsletter</h5>
                    <p>Stay on top of the latest car trends, tips, and tricks for selling your car.</p>
                    <input type="email" placeholder="Your email address">
                    <button class="btn btn-send">Send</button>
                </div>
            </div>


            <!-- Footer Bottom -->
            <div class="footer-bottom mt-4">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <a href="#" class="footer-logo">
                            <img src="https://carllymotors.com/wp-content/uploads/2024/04/carllymotors_logo_white-1024x263.png.webp"
                                alt="AutoDecar">
                        </a>
                        <p class="mt-2">© 2025 Carlly Motors. All rights reserved</p>
                    </div>
                    <div class="col-md-6 text-right social-icons">
                        <a href="https://www.instagram.com/carllymotors?igsh=N3F5aHVpajd0ZnNk&utm_source=qr"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.tiktok.com/@carllymotors"><i class="fab fa-tiktok"></i></a>
                        <a href="https://x.com/carllymotors?s=11&mx=2"><i class="fab fa-twitter"></i></a>
                        <a href="https://wa.me/971566350025"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('carlistingscript')
    {{-- Script related listing-details page --}}
    <script>
        $(document).ready(function () {
          // Toggle the icon when accordion is expanded/collapsed
          $('.accordion-button').on('click', function () {
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
    </script>

    </body>

</html>
