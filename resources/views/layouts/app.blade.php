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
</head>

<body>
    <!-- Enhanced White Header -->
   @include('partials.navbar')

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
                <div class="col-12 col-md-3">
                    <a href="{{ route('home') }}" class="footer-logo d-block mb-3">
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
                           class="social-link"
                           title="Follow us on Instagram"
                           aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.tiktok.com/@carllymotors" 
                           target="_blank" 
                           rel="noopener"
                           class="social-link"
                           title="Follow us on TikTok"
                           aria-label="TikTok">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="https://x.com/carllymotors?s=11&mx=2" 
                           target="_blank" 
                           rel="noopener"
                           class="social-link"
                           title="Follow us on Twitter"
                           aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/971566350025" 
                           target="_blank" 
                           rel="noopener"
                           class="social-link"
                           title="Contact us on WhatsApp"
                           aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- About Column -->
                <div class="col-12 col-md-3">
                    <h5 class="footer-title">About Auto Decar</h5>
                    <ul class="list-unstyled footer-list">
                        <li><a href="{{ route('aboutus') }}"><i class="fas fa-chevron-right me-2"></i>About us</a></li>
                        <li><a href="{{ route('contacts.index') }}"><i class="fas fa-chevron-right me-2"></i>Contact us</a></li>
                        <li><a href="{{ route('terms') }}"><i class="fas fa-chevron-right me-2"></i>Terms & Conditions</a></li>
                        <li><a href="{{ route('privacy') }}"><i class="fas fa-chevron-right me-2"></i>Privacy Policy</a></li>
                    </ul>
                </div>

           <!-- Popular Cars Column -->
<div class="col-12 col-md-3">
    <h5 class="footer-title">Popular Used Cars</h5>

    {{-- @if(isset($brands) && count($brands) > 0)
        <ul class="list-unstyled footer-list">
 @foreach (collect($brands)->reject(fn($brand) => !in_array($brand, [
    'BMW', 'Chevrolet', 'Ford', 'Hyundai', 'Jeep', 'Kia',
    'Land Rover', 'Lexus', 'Mercedes', 'Mitsubishi', 'Nissan', 'Toyota'
]))->take(8) as $brand)


                @php
                    $logos = [
                        'BMW' => 'bmw-svgrepo-com.svg',
                        'Chevrolet' => 'chevrolet-svgrepo-com.svg',
                        'Ford' => 'ford-svgrepo-com.svg',
                        'Hyundai' => 'hyundai-svgrepo-com.svg',
                        'Jeep' => 'jeep-alt-svgrepo-com.svg',
                        'Kia' => 'kia-svgrepo-com.svg',
                        'Land Rover' => 'land-rover-svgrepo-com.svg',
                        'Lexus' => 'lexus-svgrepo-com.svg',
                        'Mercedes' => 'mercedes-benz-svgrepo-com.svg',
                        'Mitsubishi' => 'mitsubishi-svgrepo-com.svg',
                        'Nissan' => 'nissan-svgrepo-com.svg',
                        'Toyota' => 'toyota-svgrepo-com.svg',
                    ];
                    $fileName = $logos[$brand->name] ?? null;

                    // ✅ Generate link to cars page
                    $brandUrl = route('cars.index', ['make' => $brand->name]);
                @endphp

                <li class="d-flex align-items-center mb-2">
                    @if($fileName && file_exists(public_path('images/brands/' . $fileName)))
                        <img src="{{ asset('images/brands/' . $fileName) }}" 
                             alt="{{ $brand->name }}" 
                             style="width:22px; height:22px; margin-right:8px;">
                    @else
                        <i class="fas fa-car text-danger me-2"></i>
                    @endif

                    <a href="{{ $brandUrl }}" 
                       class="text-decoration-none text-light small">
                        {{ $brand->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    @else --}}
        <ul class="list-unstyled footer-list">
            <li><a href="{{ route('cars.index', ['make' => 'Chevrolet']) }}"><i class="fas fa-chevron-right me-2"></i>Chevrolet</a></li>
            <li><a href="{{ route('cars.index', ['make' => 'Ford']) }}"><i class="fas fa-chevron-right me-2"></i>Ford</a></li>
            <li><a href="{{ route('cars.index', ['make' => 'Toyota']) }}"><i class="fas fa-chevron-right me-2"></i>Toyota</a></li>
            <li><a href="{{ route('cars.index', ['make' => 'BMW']) }}"><i class="fas fa-chevron-right me-2"></i>BMW</a></li>
        </ul>
    {{-- @endif --}}
</div>


                <!-- Newsletter Column -->
                <div class="col-12 col-md-3">
                    <h5 class="footer-title">Newsletter</h5>
                    <p class=" mb-3">Stay on top of the latest car trends, tips, and tricks for selling your car.</p>

                    <form class="newsletter-form" action="#" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" 
                                   class="form-control" 
                                   placeholder="Your email address"
                                   aria-label="Your email address"
                                   required>
                            <button class="btn bg-carlly" type="submit">
                                <i class="fas fa-paper-plane me-1"></i>Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom mt-5 pt-4 border-top">
                <div class="row align-items-center">
                    <div class="col-md-12 text-center">
                        <p class="mb-0">
                            © {{ date('Y') }} Carlly Motors. All rights reserved. 
                            {{-- <span class="d-none d-md-inline">|</span> --}}
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
    
    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Enhanced accordion toggle
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

            // Active navigation highlighting
            let currentUrl = window.location.href;
            document.querySelectorAll(".nav-link").forEach(link => {
                if (link.href === currentUrl) {
                    link.classList.add("active");
                }
            });

            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                }
            });

            // Newsletter form enhancement
            $('.newsletter-form').on('submit', function(e) {
                e.preventDefault();
                const email = $(this).find('input[type="email"]').val();
                
                // Add your newsletter subscription logic here
                console.log('Newsletter subscription for:', email);
                
                // Show success message
                const btn = $(this).find('.btn');
                const originalText = btn.html();
                btn.html('<i class="fas fa-check me-1"></i>Sent!');
                btn.prop('disabled', true);
                
                setTimeout(() => {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                    $(this).find('input[type="email"]').val('');
                }, 2000);
            });

            // Enhanced dropdown behavior
            $('.dropdown').hover(
                function() {
                    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(300);
                },
                function() {
                    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(300);
                }
            );

            // Add loading state to buttons
            $('.btn').on('click', function(e) {
                if (!$(this).hasClass('no-loading') && !$(this).hasClass('dropdown-toggle')) {
                    $(this).addClass('loading');
                    setTimeout(() => {
                        $(this).removeClass('loading');
                    }, 1000);
                }
            });

            // Navbar scroll effect
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.navbar').addClass('scrolled');
                } else {
                    $('.navbar').removeClass('scrolled');
                }
            });

            // Mobile menu auto-close on link click
            $('.navbar-nav .nav-link').on('click', function() {
                if ($('.navbar-toggler').is(':visible')) {
                    $('.navbar-collapse').collapse('hide');
                }
            });
        });

        // Performance optimization: Lazy load images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Enhanced error handling for images
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('img').forEach(img => {
                img.addEventListener('error', function() {
                    this.src = '{{ asset("workshopNotFound.png") }}';
                    this.alt = 'Image not available';
                    this.classList.add('error-image');
                });
            });
        });

        // Accessibility: Skip to main content
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab' && e.target.tagName === 'BODY') {
                const skipLink = document.createElement('a');
                skipLink.href = '#main-content';
                skipLink.textContent = 'Skip to main content';
                skipLink.className = 'skip-link';
                skipLink.style.cssText = 'position: absolute; top: -40px; left: 6px; background: #000; color: #fff; padding: 8px; z-index: 1000; text-decoration: none; border-radius: 4px;';
                skipLink.addEventListener('focus', function() {
                    this.style.top = '6px';
                });
                skipLink.addEventListener('blur', function() {
                    this.style.top = '-40px';
                });
                document.body.insertBefore(skipLink, document.body.firstChild);
            }
        });

        // Service Worker registration for PWA capabilities
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(function(err) {
                        console.log('ServiceWorker registration failed');
                    });
            });
        }

        // Toast notification system
        window.showToast = function(message, type = 'info', duration = 3000) {
            const toast = document.createElement('div');
            toast.className = `toast-notification toast-${type}`;
            toast.innerHTML = `
                <div class="toast-content">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 10000;
                animation: slideInRight 0.3s ease-out;
                max-width: 300px;
                word-wrap: break-word;
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(() => {
                    if (document.body.contains(toast)) {
                        document.body.removeChild(toast);
                    }
                }, 300);
            }, duration);
        };

        // Global error handler
        window.addEventListener('error', function(e) {
            console.error('Global error:', e.error);
            // Don't show toast for script errors in production
        });

        // Add CSS animations for toast and other effects
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
            .toast-content {
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .error-image {
                filter: grayscale(100%);
                opacity: 0.7;
            }
            .navbar.scrolled {
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                backdrop-filter: blur(10px);
            }
            .skip-link:focus {
                outline: 3px solid #760e13;
                outline-offset: 2px;
            }
        `;
        document.head.appendChild(style);
    </script>

    <!-- Page-specific scripts -->
    @stack('carlistingscript')
    
    <!-- Analytics (if needed) -->
    @if(config('app.env') === 'production')
        <!-- Add your analytics code here -->
    @endif
</body>
</html>