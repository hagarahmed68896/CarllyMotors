<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    
    <!-- Open Graph for WhatsApp/Social Media -->
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $image ?? asset('images/carlly-logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Carlly Motors">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $image ?? asset('images/carlly-logo.png') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 420px;
            width: 100%;
            background: rgba(255,255,255,0.15);
            padding: 40px 30px;
            border-radius: 24px;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        }
        
        .logo {
            width: 90px;
            height: 90px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: 700;
            color: #667eea;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border: 3px solid rgba(255,255,255,0.3);
        }
        
        h1 {
            font-size: 28px;
            margin-bottom: 12px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        p {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 35px;
            line-height: 1.6;
            color: rgba(255,255,255,0.95);
        }
        
        .btn {
            display: block;
            padding: 16px 32px;
            margin: 12px 0;
            background: #fff;
            color: #667eea;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.2);
        }
        
        .btn:active {
            transform: translateY(-1px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            font-size: 18px;
            margin-bottom: 20px;
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
        }
        
        .btn-primary:hover {
            box-shadow: 0 12px 30px rgba(40, 167, 69, 0.4);
        }
        
        .btn-secondary {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.3);
            font-size: 15px;
        }
        
        .btn-secondary:hover {
            background: rgba(255,255,255,0.3);
            border-color: rgba(255,255,255,0.5);
        }
        
        #status {
            margin: 25px 0;
            font-size: 14px;
            opacity: 0.8;
            min-height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .spinner {
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top: 2px solid white;
            width: 18px;
            height: 18px;
            animation: spin 1s linear infinite;
            margin-right: 12px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .type-icon {
            font-size: 24px;
            margin-right: 8px;
        }
        
        .btn-icon {
            margin-right: 10px;
            font-size: 18px;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
                margin: 10px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            .logo {
                width: 80px;
                height: 80px;
                font-size: 32px;
            }
        }
        
        /* Success state */
        .success {
            color: #28a745;
        }
        
        /* Warning state */
        .warning {
            color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            @if($type === 'car')
                🚗
            @elseif($type === 'spare-part')
                🔧
            @elseif($type === 'workshop')
                🔨
            @else
                C
            @endif
        </div>
        
        <h1>{{ $title }}</h1>
        <p>{{ $description }}</p>
        
        <div id="status">
            <div class="loading">
                <div class="spinner"></div>
                Opening in Carlly app...
            </div>
        </div>
        
        <a href="{{ $appUrl }}" class="btn btn-primary" id="openApp">
            <span class="btn-icon">📱</span>Open in Carlly App
        </a>
        
        <a href="{{ $fallbackUrl }}" class="btn btn-secondary">
            <span class="btn-icon">🌐</span>View in Browser
        </a>
        
        <a href="https://play.google.com/store/apps/details?id=com.carllymotors.carllyuser" class="btn btn-secondary">
            <span class="btn-icon">📥</span>Download Carlly App
        </a>
    </div>

    <script>
        // Configuration
        const config = {
            autoRedirectDelay: 1500,
            fallbackMessageDelay: 3500,
            appCheckDelay: 2000
        };

        // Auto-redirect to app
        function openApp() {
            const statusElement = document.getElementById('status');
            statusElement.innerHTML = '<div class="loading"><div class="spinner"></div>Redirecting to app...</div>';
            
            // Try to open the app
            window.location.href = '{{ $appUrl }}';
            
            // Set a timeout to show alternative message
            setTimeout(function() {
                statusElement.innerHTML = '<span class="warning">Tap "Open in Carlly App" if it didn\'t open automatically</span>';
            }, config.fallbackMessageDelay);
        }
        
        // Detect if user is on mobile
        const isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        const isInApp = /CarllyCars|CarllyApp/i.test(navigator.userAgent); // Custom user agent from your app
        
        // Initialize based on device type
        if (isInApp) {
            document.getElementById('status').innerHTML = '<span class="success">✅ You\'re already in the Carlly app!</span>';
        } else if (isMobile) {
            // Try to open app after a short delay on mobile
            setTimeout(openApp, config.autoRedirectDelay);
        } else {
            document.getElementById('status').innerHTML = '<span class="warning">📱 This link works best on mobile devices with the Carlly app installed</span>';
        }
        
        // Manual button click handler
        document.getElementById('openApp').addEventListener('click', function(e) {
            e.preventDefault();
            openApp();
        });
        
        // Enhanced app detection using page visibility
        let hidden = false;
        let startTime = Date.now();
        
        // Listen for visibility changes
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                hidden = true;
                startTime = Date.now();
            } else if (hidden) {
                const timeHidden = Date.now() - startTime;
                
                // If page was hidden for more than 2 seconds, app probably opened
                if (timeHidden > config.appCheckDelay) {
                    document.getElementById('status').innerHTML = '<span class="success">✅ Welcome back! App seems to be working.</span>';
                } else {
                    // Page became visible quickly, app probably didn't open
                    document.getElementById('status').innerHTML = '<span class="warning">App not installed? Download it below or view in browser</span>';
                }
            }
        });
        
        // Listen for blur/focus events (additional app detection)
        let blurTime;
        
        window.addEventListener('blur', function() {
            blurTime = Date.now();
        });
        
        window.addEventListener('focus', function() {
            if (blurTime) {
                const timeBlurred = Date.now() - blurTime;
                if (timeBlurred > config.appCheckDelay) {
                    document.getElementById('status').innerHTML = '<span class="success">✅ Great! The app opened successfully.</span>';
                }
            }
        });
        
        // Prevent right-click and long press on mobile for better UX
        document.addEventListener('contextmenu', function(e) {
            if (isMobile) {
                e.preventDefault();
            }
        });
        
        // Add some loading animation
        setTimeout(function() {
            if (document.getElementById('status').innerHTML.includes('spinner')) {
                document.getElementById('status').innerHTML = '<span class="warning">Taking longer than expected... Try the buttons below</span>';
            }
        }, 5000);
    </script>
</body>
</html>