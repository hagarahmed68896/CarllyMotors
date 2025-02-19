@extends('layouts.app')
@php
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
@endphp
@section('content')

<head>
    <script data-no-optimize="1">
    var litespeed_docref = sessionStorage.getItem("litespeed_docref");
    litespeed_docref && (Object.defineProperty(document, "referrer", {
        get: function() {
            return litespeed_docref
        }
    }), sessionStorage.removeItem("litespeed_docref"));
    </script>
    <meta charset="UTF-8" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <link rel="pingback" href="https://carllymotors.com/xmlrpc.php" />
    <script
        src="data:text/javascript;base64,KGZ1bmN0aW9uKGh0bWwpe2h0bWwuY2xhc3NOYW1lPWh0bWwuY2xhc3NOYW1lLnJlcGxhY2UoL1xibm8tanNcYi8sJ2pzJyl9KShkb2N1bWVudC5kb2N1bWVudEVsZW1lbnQp"
        defer></script>
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    <style>
    img:is([sizes="auto"i], [sizes^="auto,"i]) {
        contain-intrinsic-size: 3000px 1500px
    }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Premier Car Services and Solutions - Carlly Motors</title>
    <meta name="description"
        content="Discover top-notch automotive services with Carlly Motors. From car sales and auctions to repairs and roadside assistance." />
    <link rel="canonical" href="https://carllymotors.com/" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Premier Car Services and Solutions - Carlly Motors" />
    <meta property="og:description"
        content="Discover top-notch automotive services with Carlly Motors. From car sales and auctions to repairs and roadside assistance." />
    <meta property="og:url" content="https://carllymotors.com/" />
    <meta property="og:site_name" content="Carlly Motors" />
    <meta property="article:modified_time" content="2024-10-14T12:21:28+00:00" />
    <meta property="og:image"
        content="https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo.png" />
    <meta property="og:image:width" content="512" />
    <meta property="og:image:height" content="512" />
    <meta property="og:image:type" content="image/png" />
    <meta name="twitter:card" content="summary_large_image" />
    <script type="application/ld+json" class="yoast-schema-graph">
    {
        "@context": "https://schema.org",
        "@graph": [{
            "@type": "WebPage",
            "@id": "https://carllymotors.com/",
            "url": "https://carllymotors.com/",
            "name": "Premier Car Services and Solutions - Carlly Motors",
            "isPartOf": {
                "@id": "https://carllymotors.com/#website"
            },
            "about": {
                "@id": "https://carllymotors.com/#organization"
            },
            "primaryImageOfPage": {
                "@id": "https://carllymotors.com/#primaryimage"
            },
            "image": {
                "@id": "https://carllymotors.com/#primaryimage"
            },
            "thumbnailUrl": "https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo.png",
            "datePublished": "2024-04-17T15:52:24+00:00",
            "dateModified": "2024-10-14T12:21:28+00:00",
            "description": "Discover top-notch automotive services with Carlly Motors. From car sales and auctions to repairs and roadside assistance.",
            "breadcrumb": {
                "@id": "https://carllymotors.com/#breadcrumb"
            },
            "inLanguage": "en-US",
            "potentialAction": [{
                "@type": "ReadAction",
                "target": ["https://carllymotors.com/"]
            }]
        }, {
            "@type": "ImageObject",
            "inLanguage": "en-US",
            "@id": "https://carllymotors.com/#primaryimage",
            "url": "https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo.png",
            "contentUrl": "https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo.png",
            "width": 512,
            "height": 512,
            "caption": "Discover top-notch automotive services with Carlly Motors. From car sales and auctions to repairs and roadside assistance carlly motors"
        }, {
            "@type": "BreadcrumbList",
            "@id": "https://carllymotors.com/#breadcrumb",
            "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "name": "Home"
            }]
        }, {
            "@type": "WebSite",
            "@id": "https://carllymotors.com/#website",
            "url": "https://carllymotors.com/",
            "name": "Carlly Motors",
            "description": "",
            "publisher": {
                "@id": "https://carllymotors.com/#organization"
            },
            "potentialAction": [{
                "@type": "SearchAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "https://carllymotors.com/?s={search_term_string}"
                },
                "query-input": {
                    "@type": "PropertyValueSpecification",
                    "valueRequired": true,
                    "valueName": "search_term_string"
                }
            }],
            "inLanguage": "en-US"
        }, {
            "@type": "Organization",
            "@id": "https://carllymotors.com/#organization",
            "name": "Carlly Motors",
            "url": "https://carllymotors.com/",
            "logo": {
                "@type": "ImageObject",
                "inLanguage": "en-US",
                "@id": "https://carllymotors.com/#/schema/logo/image/",
                "url": "https://carllymotors.com/wp-content/uploads/2024/04/carllymotorslogo.png",
                "contentUrl": "https://carllymotors.com/wp-content/uploads/2024/04/carllymotorslogo.png",
                "width": 2322,
                "height": 596,
                "caption": "Carlly Motors"
            },
            "image": {
                "@id": "https://carllymotors.com/#/schema/logo/image/"
            }
        }]
    }
    </script>
    <link rel='prefetch'
        href='https://carllymotors.com/wp-content/themes/flatsome/assets/js/flatsome.js?ver=a0a7aee297766598a20e' />
    <link rel='prefetch'
        href='https://carllymotors.com/wp-content/themes/flatsome/assets/js/chunk.slider.js?ver=3.18.7' />
    <link rel='prefetch'
        href='https://carllymotors.com/wp-content/themes/flatsome/assets/js/chunk.popups.js?ver=3.18.7' />
    <link rel='prefetch'
        href='https://carllymotors.com/wp-content/themes/flatsome/assets/js/chunk.tooltips.js?ver=3.18.7' />
    <link rel="alternate" type="application/rss+xml" title="Carlly Motors &raquo; Feed"
        href="https://carllymotors.com/feed/" />
    <link rel="alternate" type="application/rss+xml" title="Carlly Motors &raquo; Comments Feed"
        href="https://carllymotors.com/comments/feed/" />
    <link data-optimized="1" rel='stylesheet' id='contact-form-7-css'
        href='https://carllymotors.com/wp-content/litespeed/css/33351cb21ddd841ffd567159ce28471b.css?ver=8471b'
        type='text/css' media='all' />
    <link data-optimized="1" rel='stylesheet' id='joinchat-css'
        href='https://carllymotors.com/wp-content/litespeed/css/aee82f9c05ab748a5614fbea801da12d.css?ver=da12d'
        type='text/css' media='all' />
    <link data-optimized="1" rel='stylesheet' id='flatsome-main-css'
        href='https://carllymotors.com/wp-content/litespeed/css/18213c7411e11f3aeae114ba934eb90a.css?ver=eb90a'
        type='text/css' media='all' />
    <style id='flatsome-main-inline-css' type='text/css'>
    @font-face {
        font-family: "fl-icons";
        font-display: block;
        src: url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.eot?v=3.18.7);
        src:
            url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.eot#iefix?v=3.18.7) format("embedded-opentype"),
            url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.woff2?v=3.18.7) format("woff2"),
            url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.ttf?v=3.18.7) format("truetype"),
            url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.woff?v=3.18.7) format("woff"),
            url(https://carllymotors.com/wp-content/themes/flatsome/assets/css/icons/fl-icons.svg?v=3.18.7#fl-icons) format("svg");
    }
    </style>
    <link data-optimized="1" rel='stylesheet' id='flatsome-style-css'
        href='https://carllymotors.com/wp-content/litespeed/css/0349c25e4ae5ade685c7395774c30983.css?ver=30983'
        type='text/css' media='all' />
    <script type="text/javascript" src="https://carllymotors.com/wp-includes/js/jquery/jquery.min.js"
        id="jquery-core-js"></script>
    <link rel="https://api.w.org/" href="https://carllymotors.com/wp-json/" />
    <link rel="alternate" title="JSON" type="application/json" href="https://carllymotors.com/wp-json/wp/v2/pages/2" />
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="https://carllymotors.com/xmlrpc.php?rsd" />
    <meta name="generator" content="WordPress 6.7.2" />
    <link rel='shortlink' href='https://carllymotors.com/' />
    <link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed"
        href="https://carllymotors.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fcarllymotors.com%2F" />
    <link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed"
        href="https://carllymotors.com/wp-json/oembed/1.0/embed?url=https%3A%2F%2Fcarllymotors.com%2F&#038;format=xml" />
    <style>
    .bg {
        opacity: 0;
        transition: opacity 1s;
        -webkit-transition: opacity 1s;
    }

    .bg-loaded {
        opacity: 1;
    }
    </style>
    <link rel="icon" href="https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo-32x32.png"
        sizes="32x32" />
    <link rel="icon" href="https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo-192x192.png"
        sizes="192x192" />
    <link rel="apple-touch-icon"
        href="https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo-180x180.png" />
    <meta name="msapplication-TileImage"
        content="https://carllymotors.com/wp-content/uploads/2024/04/cropped-carlly_Main_Logo-270x270.png" />
    <style id="custom-css" type="text/css">
    :root {
        --primary-color: #ed1c24;
        --fs-color-primary: #ed1c24;
        --fs-color-secondary: #3d3d3d;
        --fs-color-success: #7a9c59;
        --fs-color-alert: #b20000;
        --fs-experimental-link-color: #334862;
        --fs-experimental-link-color-hover: #111;
    }

    .tooltipster-base {
        --tooltip-color: #fff;
        --tooltip-bg-color: #000;
    }

    .off-canvas-right .mfp-content,
    .off-canvas-left .mfp-content {
        --drawer-width: 300px;
    }

    .header-main {
        height: 90px
    }

    #logo img {
        max-height: 90px
    }

    #logo {
        width: 152px;
    }

    .header-top {
        min-height: 30px
    }

    .transparent .header-main {
        height: 90px
    }

    .transparent #logo img {
        max-height: 90px
    }

    .has-transparent+.page-title:first-of-type,
    .has-transparent+#main>.page-title,
    .has-transparent+#main>div>.page-title,
    .has-transparent+#main .page-header-wrapper:first-of-type .page-title {
        padding-top: 90px;
    }

    .header.show-on-scroll,
    .stuck .header-main {
        height: 70px !important
    }

    .stuck #logo img {
        max-height: 70px !important
    }

    .header-bottom {
        background-color: #f1f1f1
    }

    @media (max-width: 549px) {
        .header-main {
            height: 70px
        }

        #logo img {
            max-height: 70px
        }
    }

    .main-menu-overlay {
        background-color: #dd3333
    }

    body {
        font-family: Lato, sans-serif;
    }

    body {
        font-weight: 400;
        font-style: normal;
    }

    .nav>li>a {
        font-family: Lato, sans-serif;
    }

    .mobile-sidebar-levels-2 .nav>li>ul>li>a {
        font-family: Lato, sans-serif;
    }

    .nav>li>a,
    .mobile-sidebar-levels-2 .nav>li>ul>li>a {
        font-weight: 700;
        font-style: normal;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .heading-font,
    .off-canvas-center .nav-sidebar.nav-vertical>li>a {
        font-family: Lato, sans-serif;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .heading-font,
    .banner h1,
    .banner h2 {
        font-weight: 700;
        font-style: normal;
    }

    .alt-font {
        font-family: "Dancing Script", sans-serif;
    }

    .alt-font {
        font-weight: 400 !important;
        font-style: normal !important;
    }

    .nav-vertical-fly-out>li+li {
        border-top-width: 1px;
        border-top-style: solid;
    }

    .label-new.menu-item>a:after {
        content: "New";
    }

    .label-hot.menu-item>a:after {
        content: "Hot";
    }

    .label-sale.menu-item>a:after {
        content: "Sale";
    }

    .label-popular.menu-item>a:after {
        content: "Popular";
    }
    </style>
    <style id="kirki-inline-styles">
    /* latin-ext */
    @font-face {
        font-family: 'Lato';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/lato/S6uyw4BMUTPHjxAwXjeu.woff2) format('woff2');
        unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    /* latin */
    @font-face {
        font-family: 'Lato';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/lato/S6uyw4BMUTPHjx4wXg.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    /* latin-ext */
    @font-face {
        font-family: 'Lato';
        font-style: normal;
        font-weight: 700;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/lato/S6u9w4BMUTPHh6UVSwaPGR_p.woff2) format('woff2');
        unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    /* latin */
    @font-face {
        font-family: 'Lato';
        font-style: normal;
        font-weight: 700;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/lato/S6u9w4BMUTPHh6UVSwiPGQ.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    /* vietnamese */
    @font-face {
        font-family: 'Dancing Script';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/dancing-script/If2cXTr6YS-zF4S-kcSWSVi_sxjsohD9F50Ruu7BMSo3Rep8ltA.woff2) format('woff2');
        unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
    }

    /* latin-ext */
    @font-face {
        font-family: 'Dancing Script';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/dancing-script/If2cXTr6YS-zF4S-kcSWSVi_sxjsohD9F50Ruu7BMSo3ROp8ltA.woff2) format('woff2');
        unicode-range: U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    /* latin */
    @font-face {
        font-family: 'Dancing Script';
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://carllymotors.com/wp-content/fonts/dancing-script/If2cXTr6YS-zF4S-kcSWSVi_sxjsohD9F50Ruu7BMSo3Sup8.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }
    </style>
</head>

<body
    class="home page-template page-template-page-transparent-header-light page-template-page-transparent-header-light-php page page-id-2 lightbox nav-dropdown-has-arrow nav-dropdown-has-shadow nav-dropdown-has-border">
    <a class="skip-link screen-reader-text" href="#main">Skip to content</a>
    <div id="wrapper">
        <main id="main" class="">
            <div id="content" role="main">


                <section class="section" id="section_1670176664">
                    <div class="bg section-bg fill bg-fill  bg-loaded"></div>
                    <div class="section-content relative">
                        <div class="row" id="row-525618025">
                            <div id="col-74343800" class="col small-12 large-12">
                                <div class="col-inner">
                                    <div class="row align-middle align-center" id="row-2144816574">
                                        <div id="col-549661236" class="col medium-8 small-12 large-8">
                                            <div class="col-inner">
                                                <p style="text-align: center;"><strong><span
                                                            style="color: #000000;">Carlly Motors streamlines automotive
                                                            services by connecting car owners with trusted providers
                                                            through our innovative dual-app platform.</span></strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="scroll-to" data-label="Scroll to: #Features" data-bullet="false"
                                        data-link="#Features" data-title="Features"><a name="Features"></a></span>
                                    <h2 style="text-align: center;"><span style="color: #ed1c24; font-size: 100%;">Our
                                            Services </span></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row row-small align-equal row-box-shadow-2 row-box-shadow-3-hover"
                            id="row-1054119973">
                            <div id="col-1617890573" class="col medium-4 small-12 large-4">
                                <div class="col-inner">
                                    <div class="box has-hover   has-hover box-text-bottom">
                                        <div class="box-image" style="border-radius:10%;width:60%;">
                                            <div class="">
                                                <img decoding="async" width="1024" height="1024"
                                                    src="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-20.50.30-A-vibrant-scene-at-a-car-auction-with-bidders-and-a-variety-of-cars-on-display-capturing-the-excitement-and-diversity-of-the-auction.-The-image-shoul.webp"
                                                    class="attachment- size-" alt=""
                                                    srcset="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-20.50.30-A-vibrant-scene-at-a-car-auction-with-bidders-and-a-variety-of-cars-on-display-capturing-the-excitement-and-diversity-of-the-auction.-The-image-shoul.webp 1024w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-20.50.30-A-vibrant-scene-at-a-car-auction-with-bidders-and-a-variety-of-cars-on-display-capturing-the-excitement-and-diversity-of-the-auction.-The-image-shoul-300x300.webp 300w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-20.50.30-A-vibrant-scene-at-a-car-auction-with-bidders-and-a-variety-of-cars-on-display-capturing-the-excitement-and-diversity-of-the-auction.-The-image-shoul-150x150.webp 150w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-20.50.30-A-vibrant-scene-at-a-car-auction-with-bidders-and-a-variety-of-cars-on-display-capturing-the-excitement-and-diversity-of-the-auction.-The-image-shoul-768x768.webp 768w"
                                                    sizes="(max-width: 1024px) 100vw, 1024px" />
                                            </div>
                                        </div>
                                        <div class="box-text text-center">
                                            <div class="box-text-inner">
                                                <h3><span style="color: #000000;">Car Listings And Auctions</span></h3>
                                                <p><span style="color: #000000;">Access a diverse range of new and used
                                                        cars at your fingertips. Find auctions or browse through our
                                                        curated listings to find your perfect ride.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                #col-1617890573>.col-inner {
                                    padding: 5px 5px 5px 5px;
                                    margin: 5px 5px 5px 5px;
                                }
                                </style>
                            </div>
                            <div id="col-1789288247" class="col medium-4 small-12 large-4">
                                <div class="col-inner">
                                    <div class="box has-hover   has-hover box-text-bottom">
                                        <div class="box-image" style="border-radius:10%;width:60%;">
                                            <div class="">
                                                <img loading="lazy" decoding="async" width="1024" height="1024"
                                                    src="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-20.59.20-Stacks-of-car-parts-neatly-arranged-in-a-warehouse-or-a-user-browsing-car-parts-on-a-digital-device.-The-image-should-depict-an-organized-and-modern-a.webp"
                                                    class="attachment- size-" alt=""
                                                    srcset="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-20.59.20-Stacks-of-car-parts-neatly-arranged-in-a-warehouse-or-a-user-browsing-car-parts-on-a-digital-device.-The-image-should-depict-an-organized-and-modern-a.webp 1024w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-20.59.20-Stacks-of-car-parts-neatly-arranged-in-a-warehouse-or-a-user-browsing-car-parts-on-a-digital-device.-The-image-should-depict-an-organized-and-modern-a-300x300.webp 300w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-20.59.20-Stacks-of-car-parts-neatly-arranged-in-a-warehouse-or-a-user-browsing-car-parts-on-a-digital-device.-The-image-should-depict-an-organized-and-modern-a-150x150.webp 150w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-20.59.20-Stacks-of-car-parts-neatly-arranged-in-a-warehouse-or-a-user-browsing-car-parts-on-a-digital-device.-The-image-should-depict-an-organized-and-modern-a-768x768.webp 768w"
                                                    sizes="auto, (max-width: 1024px) 100vw, 1024px" />
                                            </div>
                                        </div>
                                        <div class="box-text text-center">
                                            <div class="box-text-inner">
                                                <h3><span style="color: #000000;">Car Parts</span></h3>
                                                <p><span style="color: #000000;">Find both new and used car parts
                                                        easily. Our app ensures you get the right part at the right
                                                        price.</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                #col-1789288247>.col-inner {
                                    padding: 5px 5px 5px 5px;
                                    margin: 5px 5px 5px 5px;
                                }
                                </style>
                            </div>
                            <div id="col-1839681432" class="col medium-4 small-12 large-4">
                                <div class="col-inner">
                                    <div class="box has-hover   has-hover box-text-bottom">
                                        <div class="box-image" style="border-radius:10%;width:60%;">
                                            <div class="">
                                                <img loading="lazy" decoding="async" width="1024" height="1024"
                                                    src="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.05.08-A-mechanic-at-work-in-a-modern-repair-shop-with-a-car-on-the-lift.-The-image-should-feature-a-professional-mechanic-actively-engaged-in-repairing-a-ve.webp"
                                                    class="attachment- size-" alt=""
                                                    srcset="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.05.08-A-mechanic-at-work-in-a-modern-repair-shop-with-a-car-on-the-lift.-The-image-should-feature-a-professional-mechanic-actively-engaged-in-repairing-a-ve.webp 1024w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.05.08-A-mechanic-at-work-in-a-modern-repair-shop-with-a-car-on-the-lift.-The-image-should-feature-a-professional-mechanic-actively-engaged-in-repairing-a-ve-300x300.webp 300w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.05.08-A-mechanic-at-work-in-a-modern-repair-shop-with-a-car-on-the-lift.-The-image-should-feature-a-professional-mechanic-actively-engaged-in-repairing-a-ve-150x150.webp 150w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.05.08-A-mechanic-at-work-in-a-modern-repair-shop-with-a-car-on-the-lift.-The-image-should-feature-a-professional-mechanic-actively-engaged-in-repairing-a-ve-768x768.webp 768w"
                                                    sizes="auto, (max-width: 1024px) 100vw, 1024px" />
                                            </div>
                                        </div>
                                        <div class="box-text text-center">
                                            <div class="box-text-inner">
                                                <h3><span style="color: #000000;">Repair Shop Services</span></h3>
                                                <p><strong><span style="color: #ed1c24;">Soon..</span></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                #col-1839681432>.col-inner {
                                    padding: 5px 5px 5px 5px;
                                    margin: 5px 5px 5px 5px;
                                }
                                </style>
                            </div>
                            <div id="col-1596145458" class="col medium-4 small-12 large-4">
                                <div class="col-inner">
                                    <div class="box has-hover   has-hover box-text-bottom">
                                        <div class="box-image" style="border-radius:10%;width:60%;">
                                            <div class="">
                                                <img loading="lazy" decoding="async" width="1024" height="1024"
                                                    src="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.08.30-A-home-car-service-scenario-showcasing-a-mechanic-performing-vehicle-maintenance-in-a-residential-driveway.-The-image-should-capture-a-professional-me.webp"
                                                    class="attachment- size-" alt=""
                                                    srcset="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.08.30-A-home-car-service-scenario-showcasing-a-mechanic-performing-vehicle-maintenance-in-a-residential-driveway.-The-image-should-capture-a-professional-me.webp 1024w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.08.30-A-home-car-service-scenario-showcasing-a-mechanic-performing-vehicle-maintenance-in-a-residential-driveway.-The-image-should-capture-a-professional-me-300x300.webp 300w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.08.30-A-home-car-service-scenario-showcasing-a-mechanic-performing-vehicle-maintenance-in-a-residential-driveway.-The-image-should-capture-a-professional-me-150x150.webp 150w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.08.30-A-home-car-service-scenario-showcasing-a-mechanic-performing-vehicle-maintenance-in-a-residential-driveway.-The-image-should-capture-a-professional-me-768x768.webp 768w"
                                                    sizes="auto, (max-width: 1024px) 100vw, 1024px" />
                                            </div>
                                        </div>
                                        <div class="box-text text-center">
                                            <div class="box-text-inner">
                                                <h3><span style="color: #000000;">Home And Roadside Assistance</span>
                                                </h3>
                                                <p><strong><span style="color: #ed1c24;">Soon..</span></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                #col-1596145458>.col-inner {
                                    padding: 5px 5px 5px 5px;
                                    margin: 5px 5px 5px 5px;
                                }
                                </style>
                            </div>
                            <div id="col-524502421" class="col medium-4 small-12 large-4">
                                <div class="col-inner">
                                    <div class="box has-hover   has-hover box-text-bottom">
                                        <div class="box-image" style="border-radius:10%;width:60%;">
                                            <div class="">
                                                <img loading="lazy" decoding="async" width="1024" height="1024"
                                                    src="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.11.46-A-transporter-truck-loaded-with-cars-on-a-highway-showcasing-vehicle-logistics.-The-image-should-depict-a-modern-large-transporter-truck-in-motion-o.webp"
                                                    class="attachment- size-" alt=""
                                                    srcset="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.11.46-A-transporter-truck-loaded-with-cars-on-a-highway-showcasing-vehicle-logistics.-The-image-should-depict-a-modern-large-transporter-truck-in-motion-o.webp 1024w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.11.46-A-transporter-truck-loaded-with-cars-on-a-highway-showcasing-vehicle-logistics.-The-image-should-depict-a-modern-large-transporter-truck-in-motion-o-300x300.webp 300w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.11.46-A-transporter-truck-loaded-with-cars-on-a-highway-showcasing-vehicle-logistics.-The-image-should-depict-a-modern-large-transporter-truck-in-motion-o-150x150.webp 150w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.11.46-A-transporter-truck-loaded-with-cars-on-a-highway-showcasing-vehicle-logistics.-The-image-should-depict-a-modern-large-transporter-truck-in-motion-o-768x768.webp 768w"
                                                    sizes="auto, (max-width: 1024px) 100vw, 1024px" />
                                            </div>
                                        </div>
                                        <div class="box-text text-center">
                                            <div class="box-text-inner">
                                                <h3><span style="color: #000000;">Vehicle Transportation</span></h3>
                                                <p><strong><span style="color: #ed1c24;">Soon..</span></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                #col-524502421>.col-inner {
                                    padding: 5px 5px 5px 5px;
                                    margin: 5px 5px 5px 5px;
                                }
                                </style>
                            </div>
                            <div id="col-836203519" class="col medium-4 small-12 large-4">
                                <div class="col-inner">
                                    <div class="box has-hover   has-hover box-text-bottom">
                                        <div class="box-image" style="border-radius:10%;width:60%;">
                                            <div class="">
                                                <img loading="lazy" decoding="async" width="1024" height="1024"
                                                    src="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.11.53-A-happy-family-in-their-car-interacting-with-an-insurance-agent-through-a-mobile-device.-The-image-should-convey-a-sense-of-security-and-convenience.webp"
                                                    class="attachment- size-" alt=""
                                                    srcset="https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.11.53-A-happy-family-in-their-car-interacting-with-an-insurance-agent-through-a-mobile-device.-The-image-should-convey-a-sense-of-security-and-convenience.webp 1024w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.11.53-A-happy-family-in-their-car-interacting-with-an-insurance-agent-through-a-mobile-device.-The-image-should-convey-a-sense-of-security-and-convenience-300x300.webp 300w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.11.53-A-happy-family-in-their-car-interacting-with-an-insurance-agent-through-a-mobile-device.-The-image-should-convey-a-sense-of-security-and-convenience-150x150.webp 150w, https://carllymotors.com/wp-content/uploads/2024/04/DALL·E-2024-04-17-21.11.53-A-happy-family-in-their-car-interacting-with-an-insurance-agent-through-a-mobile-device.-The-image-should-convey-a-sense-of-security-and-convenience-768x768.webp 768w"
                                                    sizes="auto, (max-width: 1024px) 100vw, 1024px" />
                                            </div>
                                        </div>
                                        <div class="box-text text-center">
                                            <div class="box-text-inner">
                                                <h3><span style="color: #000000;">Car Insurance</span></h3>
                                                <p><strong><span style="color: #ed1c24;">Soon..</span></strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                #col-836203519>.col-inner {
                                    padding: 5px 5px 5px 5px;
                                    margin: 5px 5px 5px 5px;
                                }
                                </style>
                            </div>
                            <style>
                            #row-1054119973>.col>.col-inner {
                                border-radius: 10px;
                            }
                            </style>
                        </div>
                    </div>
                    <style>
                    #section_1670176664 {
                        padding-top: 30px;
                        padding-bottom: 30px;
                    }
                    </style>
                </section>

                <span class="scroll-to" data-label="Scroll to: #Download_App" data-bullet="false"
                    data-link="#Download_App" data-title="Download app"><a name="Download_App"></a></span>
                <span class="scroll-to" data-label="Scroll to: #FAQ" data-bullet="false" data-link="#FAQ"
                    data-title="FAQ"><a name="FAQ"></a></span>
                <section class="section" id="section_1638493729">
                    <div class="bg section-bg fill bg-fill  bg-loaded"></div>
                    <div class="section-content relative">
                        <div class="row" id="row-745413539">
                            <div id="col-477478841" class="col small-12 large-12">
                                <div class="col-inner">
                                    <h2><span style="color: #ed1c24;">Frequently Asked Questions (FAQs)<br />
                                        </span></h2>
                                    <p><span style="color: #000000;">Got questions? We&#8217;ve got answers! Browse
                                            through our FAQs to find quick information about using Carlly Motors, both
                                            as a customer and a provider.</span></p>
                                    <div class="row" id="row-2118839603">
                                        <div id="col-1193436687" class="col medium-6 small-12 large-6">
                                            <div class="col-inner">
                                                <div class="accordion">
                                                    <div id="accordion-3002530645" class="accordion-item">
                                                        <a id="accordion-3002530645-label" class="accordion-title plain"
                                                            href="#accordion-item-how-do-i-sign-up-for-carlly-motors?"
                                                            aria-expanded="false"
                                                            aria-controls="accordion-3002530645-content">
                                                            <button class="toggle" aria-label="Toggle"></button>
                                                            <span>How do I sign up for Carlly Motors?</span>
                                                        </a>
                                                        <div id="accordion-3002530645-content" class="accordion-inner"
                                                            aria-labelledby="accordion-3002530645-label">
                                                            <p>Customers and providers can sign up directly through the
                                                                app after downloading it from the App Store or Google
                                                                Play. Follow the in-app instructions to create an
                                                                account.</p>
                                                        </div>
                                                    </div>
                                                    <div id="accordion-2239541545" class="accordion-item">
                                                        <a id="accordion-2239541545-label" class="accordion-title plain"
                                                            href="#accordion-item-what-services-does-carlly-motors-offer?"
                                                            aria-expanded="false"
                                                            aria-controls="accordion-2239541545-content">
                                                            <button class="toggle" aria-label="Toggle"></button>
                                                            <span>What services does Carlly Motors offer?</span>
                                                        </a>
                                                        <div id="accordion-2239541545-content" class="accordion-inner"
                                                            aria-labelledby="accordion-2239541545-label">
                                                            <p>Our app offers a wide range of automotive services,
                                                                including car buying and selling, auctions, car part
                                                                purchases, roadside assistance, vehicle transportation,
                                                                insurance, and repair services.</p>
                                                        </div>
                                                    </div>
                                                    <div id="accordion-3778414775" class="accordion-item">
                                                        <a id="accordion-3778414775-label" class="accordion-title plain"
                                                            href="#accordion-item-is-there-a-fee-to-use-the-carlly-motors-app?"
                                                            aria-expanded="false"
                                                            aria-controls="accordion-3778414775-content">
                                                            <button class="toggle" aria-label="Toggle"></button>
                                                            <span>Is there a fee to use the Carlly Motors app?</span>
                                                        </a>
                                                        <div id="accordion-3778414775-content" class="accordion-inner"
                                                            aria-labelledby="accordion-3778414775-label">
                                                            <p>Downloading and browsing the app are free. Charges apply
                                                                for specific services like roadside assistance, vehicle
                                                                transportation, and repair bookings.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <style>
                                            #col-1193436687>.col-inner {
                                                margin: 0px 0px -30px 0px;
                                            }
                                            </style>
                                        </div>
                                        <div id="col-2079931678" class="col medium-6 small-12 large-6">
                                            <div class="col-inner">
                                                <div class="accordion">
                                                    <div id="accordion-738258557" class="accordion-item">
                                                        <a id="accordion-738258557-label" class="accordion-title plain"
                                                            href="#accordion-item-how-can-i-become-a-service-provider-on-carlly-motors?"
                                                            aria-expanded="false"
                                                            aria-controls="accordion-738258557-content">
                                                            <button class="toggle" aria-label="Toggle"></button>
                                                            <span>How can I become a service provider on Carlly
                                                                Motors?</span>
                                                        </a>
                                                        <div id="accordion-738258557-content" class="accordion-inner"
                                                            aria-labelledby="accordion-738258557-label">
                                                            <p>To become a provider, download the provider version of
                                                                our app, complete the registration process, and submit
                                                                the required documents to verify your service offerings.
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div id="accordion-3872386774" class="accordion-item">
                                                        <a id="accordion-3872386774-label" class="accordion-title plain"
                                                            href="#accordion-item-what-should-i-do-if-i-encounter-an-issue-with-the-app?"
                                                            aria-expanded="false"
                                                            aria-controls="accordion-3872386774-content">
                                                            <button class="toggle" aria-label="Toggle"></button>
                                                            <span>What should I do if I encounter an issue with the
                                                                app?</span>
                                                        </a>
                                                        <div id="accordion-3872386774-content" class="accordion-inner"
                                                            aria-labelledby="accordion-3872386774-label">
                                                            <p>You can contact our support team through the app’s help
                                                                section or email us directly. We&#8217;re here to help
                                                                resolve any issues promptly.</p>
                                                        </div>
                                                    </div>
                                                    <div id="accordion-3793694842" class="accordion-item">
                                                        <a id="accordion-3793694842-label" class="accordion-title plain"
                                                            href="#accordion-item-how-does-carlly-motors-ensure-the-quality-of-service-providers?"
                                                            aria-expanded="false"
                                                            aria-controls="accordion-3793694842-content">
                                                            <button class="toggle" aria-label="Toggle"></button>
                                                            <span>How does Carlly Motors ensure the quality of service
                                                                providers?</span>
                                                        </a>
                                                        <div id="accordion-3793694842-content" class="accordion-inner"
                                                            aria-labelledby="accordion-3793694842-label">
                                                            <p>All service providers on our platform are thoroughly
                                                                vetted through a strict verification process to ensure
                                                                reliability and quality service to our customers.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                    #section_1638493729 {
                        padding-top: 30px;
                        padding-bottom: 30px;
                        background-color: rgb(244, 244, 244);
                    }
                    </style>
                </section>

            </div>
        </main>

    </div>
    <div id="main-menu" class="mobile-sidebar no-scrollbar mfp-hide">
        <div class="sidebar-menu no-scrollbar ">
            <ul class="nav nav-sidebar nav-vertical nav-uppercase" data-tab="1">
                <li
                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-2 current_page_item menu-item-20">
                    <a href="https://carllymotors.com/" aria-current="page">Home</a>
                </li>
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-21"><a
                        href="#Features">Features</a></li>
                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-23"><a
                        href="#Download_App">Download App</a></li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-101"><a
                        href="https://carllymotors.com/about-us/">About US</a></li>
                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-100"><a
                        href="https://carllymotors.com/contact-us/">Contact Us</a></li>
            </ul>
        </div>
    </div>
    <div class="joinchat joinchat--right"
        data-settings='{"telephone":"971566350025","mobile_only":false,"button_delay":3,"whatsapp_web":false,"qr":false,"message_views":2,"message_delay":-10,"message_badge":false,"message_send":"Hi *Carlly Motors*! I need more info about Carlly Motors https://carllymotors.com","message_hash":"d9a13fe0"}'>
        <div class="joinchat__button">
            <div class="joinchat__button__open"></div>
            <div class="joinchat__button__sendtext">Open chat</div>
            <svg class="joinchat__button__send" width="60" height="60" viewbox="0 0 400 400" stroke-linecap="round"
                stroke-width="33">
                <path class="joinchat_svg__plain"
                    d="M168.83 200.504H79.218L33.04 44.284a1 1 0 0 1 1.386-1.188L365.083 199.04a1 1 0 0 1 .003 1.808L34.432 357.903a1 1 0 0 1-1.388-1.187l29.42-99.427" />
                <path class="joinchat_svg__chat"
                    d="M318.087 318.087c-52.982 52.982-132.708 62.922-195.725 29.82l-80.449 10.18 10.358-80.112C18.956 214.905 28.836 134.99 81.913 81.913c65.218-65.217 170.956-65.217 236.174 0 42.661 42.661 57.416 102.661 44.265 157.316" />
            </svg>
        </div>
        <div class="joinchat__box">
            <div class="joinchat__header">
                <a class="joinchat__powered"
                    href="https://join.chat/en/powered/?site=Carlly%20Motors&#038;url=https%3A%2F%2Fcarllymotors.com"
                    rel="nofollow noopener" target="_blank">
                    Powered by <svg width="81" height="18" viewbox="0 0 1424 318">
                        <title>Joinchat</title>
                        <path
                            d="m171 7 6 2 3 3v5l-1 8a947 947 0 0 0-2 56v53l1 24v31c0 22-6 43-18 63-11 19-27 35-48 48s-44 18-69 18c-14 0-24-3-32-8-7-6-11-13-11-23a26 26 0 0 1 26-27c7 0 13 2 19 6l12 12 1 1a97 97 0 0 0 10 13c4 4 7 6 10 6 4 0 7-2 10-6l6-23v-1c2-12 3-28 3-48V76l-1-3-3-1h-1l-11-2c-2-1-3-3-3-7s1-6 3-7a434 434 0 0 0 90-49zm1205 43c4 0 6 1 6 3l3 36a1888 1888 0 0 0 34 0h1l3 2 1 8-1 8-3 1h-35v62c0 14 2 23 5 28 3 6 9 8 16 8l5-1 3-1c2 0 3 1 5 3s3 4 2 6c-4 10-11 19-22 27-10 8-22 12-36 12-16 0-28-5-37-15l-8-13v1h-1c-17 17-33 26-47 26-18 0-31-13-39-39-5 12-12 22-21 29s-19 10-31 10c-11 0-21-4-29-13-7-8-11-18-11-30 0-10 2-17 5-23s9-11 17-15c13-7 35-14 67-21h1v-11c0-11-2-19-5-26-4-6-8-9-14-9-3 0-5 1-5 4v1l-2 15c-2 11-6 19-11 24-6 6-14 8-23 8-5 0-9-1-13-4-3-3-5-8-5-13 0-11 9-22 26-33s38-17 60-17c41 0 62 15 62 46v58l1 11 2 8 2 3h4l5-3 1-1-1-13v-88l-3-2-12-1c-1 0-2-3-2-7s1-6 2-6c16-4 29-9 40-15 10-6 20-15 31-25 1-2 4-3 7-3zM290 88c28 0 50 7 67 22 17 14 25 34 25 58 0 26-9 46-27 61s-42 22-71 22c-28 0-50-7-67-22a73 73 0 0 1-25-58c0-26 9-46 27-61s42-22 71-22zm588 0c19 0 34 4 45 12 11 9 17 18 17 29 0 6-3 11-7 15s-10 6-17 6c-13 0-24-8-33-25-5-11-10-18-13-21s-6-5-9-5c-8 0-11 6-11 17a128 128 0 0 0 32 81c8 8 16 12 25 12 8 0 16-3 24-10 1-1 3 0 6 2 2 2 3 3 3 5-5 12-15 23-29 32s-30 13-48 13c-24 0-43-7-58-22a78 78 0 0 1-22-58c0-25 9-45 27-60s41-23 68-23zm-402-3 5 2 3 3-1 10a785 785 0 0 0-2 53v76c1 3 2 4 4 4l11 3 11-3c3 0 4-1 4-4v-82l-1-2-3-2-11-1-2-6c0-4 1-6 2-6a364 364 0 0 0 77-44l5 2 3 3v12a393 393 0 0 0-1 21c5-10 12-18 22-25 9-8 21-11 34-11 16 0 29 5 38 14 10 9 14 22 14 39v88c0 3 2 4 4 4l11 3c1 0 2 2 2 6 0 5-1 7-2 7h-1a932 932 0 0 1-49-2 462 462 0 0 0-48 2c-2 0-3-2-3-7 0-3 1-6 3-6l8-3 3-1 1-3v-62c0-14-2-24-6-29-4-6-12-9-22-9l-7 1v99l1 3 3 1 8 3h1l2 6c0 5-1 7-3 7a783 783 0 0 1-47-2 512 512 0 0 0-51 2h-1a895 895 0 0 1-49-2 500 500 0 0 0-50 2c-1 0-2-2-2-7 0-4 1-6 2-6l11-3c2 0 3-1 4-4v-82l-1-3-3-1-11-2c-1 0-2-2-2-6l2-6a380 380 0 0 0 80-44zm539-75 5 2 3 3-1 9a758 758 0 0 0-2 55v42h1c5-9 12-16 21-22 9-7 20-10 32-10 16 0 29 5 38 14 10 9 14 22 14 39v88c0 2 2 3 4 4l11 2c1 0 2 2 2 7 0 4-1 6-2 6h-1a937 937 0 0 1-49-2 466 466 0 0 0-48 2c-2 0-3-2-3-6s1-7 3-7l8-2 3-2 1-3v-61c0-14-2-24-6-29-4-6-12-9-22-9l-7 1v99l1 2 3 2 8 2h1c1 1 2 3 2 7s-1 6-3 6a788 788 0 0 1-47-2 517 517 0 0 0-51 2c-1 0-2-2-2-6 0-5 1-7 2-7l11-2c3-1 4-2 4-5V71l-1-3-3-1-11-2c-1 0-2-2-2-6l2-6a387 387 0 0 0 81-43zm-743 90c-8 0-12 7-12 20a266 266 0 0 0 33 116c3 3 6 4 9 4 8 0 12-6 12-20 0-17-4-38-11-65-8-27-15-44-22-50-3-4-6-5-9-5zm939 65c-6 0-9 4-9 13 0 8 2 16 7 22 5 7 10 10 15 10l6-2v-22c0-6-2-11-7-15-4-4-8-6-12-6zM451 0c10 0 18 3 25 10s10 16 10 26a35 35 0 0 1-35 36c-11 0-19-4-26-10-7-7-10-16-10-26s3-19 10-26 15-10 26-10zm297 249c9 0 16-3 22-8 6-6 9-12 9-20s-3-15-9-21-13-8-22-8-16 3-22 8-9 12-9 21 3 14 9 20 13 8 22 8z" />
                    </svg>
                </a>
                <div class="joinchat__close" title="Close"></div>
            </div>
            <div class="joinchat__box__scroll">
                <div class="joinchat__box__content">
                    <div class="joinchat__message">Hello 👋<br>Can we help you?</div>
                </div>
            </div>
        </div>
        <svg style="width:0;height:0;position:absolute">
            <defs>
                <clipPath id="joinchat__peak_l">
                    <path
                        d="M17 25V0C17 12.877 6.082 14.9 1.031 15.91c-1.559.31-1.179 2.272.004 2.272C9.609 18.182 17 18.088 17 25z" />
                </clipPath>
                <clipPath id="joinchat__peak_r">
                    <path
                        d="M0 25.68V0c0 13.23 10.92 15.3 15.97 16.34 1.56.32 1.18 2.34 0 2.34-8.58 0-15.97-.1-15.97 7Z" />
                </clipPath>
            </defs>
        </svg>
    </div>
    <style id='global-styles-inline-css' type='text/css'>
    :root {
        --wp--preset--aspect-ratio--square: 1;
        --wp--preset--aspect-ratio--4-3: 4/3;
        --wp--preset--aspect-ratio--3-4: 3/4;
        --wp--preset--aspect-ratio--3-2: 3/2;
        --wp--preset--aspect-ratio--2-3: 2/3;
        --wp--preset--aspect-ratio--16-9: 16/9;
        --wp--preset--aspect-ratio--9-16: 9/16;
        --wp--preset--color--black: #000000;
        --wp--preset--color--cyan-bluish-gray: #abb8c3;
        --wp--preset--color--white: #ffffff;
        --wp--preset--color--pale-pink: #f78da7;
        --wp--preset--color--vivid-red: #cf2e2e;
        --wp--preset--color--luminous-vivid-orange: #ff6900;
        --wp--preset--color--luminous-vivid-amber: #fcb900;
        --wp--preset--color--light-green-cyan: #7bdcb5;
        --wp--preset--color--vivid-green-cyan: #00d084;
        --wp--preset--color--pale-cyan-blue: #8ed1fc;
        --wp--preset--color--vivid-cyan-blue: #0693e3;
        --wp--preset--color--vivid-purple: #9b51e0;
        --wp--preset--color--primary: #ed1c24;
        --wp--preset--color--secondary: #3d3d3d;
        --wp--preset--color--success: #7a9c59;
        --wp--preset--color--alert: #b20000;
        --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg, rgba(6, 147, 227, 1) 0%, rgb(155, 81, 224) 100%);
        --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg, rgb(122, 220, 180) 0%, rgb(0, 208, 130) 100%);
        --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg, rgba(252, 185, 0, 1) 0%, rgba(255, 105, 0, 1) 100%);
        --wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg, rgba(255, 105, 0, 1) 0%, rgb(207, 46, 46) 100%);
        --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg, rgb(238, 238, 238) 0%, rgb(169, 184, 195) 100%);
        --wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg, rgb(74, 234, 220) 0%, rgb(151, 120, 209) 20%, rgb(207, 42, 186) 40%, rgb(238, 44, 130) 60%, rgb(251, 105, 98) 80%, rgb(254, 248, 76) 100%);
        --wp--preset--gradient--blush-light-purple: linear-gradient(135deg, rgb(255, 206, 236) 0%, rgb(152, 150, 240) 100%);
        --wp--preset--gradient--blush-bordeaux: linear-gradient(135deg, rgb(254, 205, 165) 0%, rgb(254, 45, 45) 50%, rgb(107, 0, 62) 100%);
        --wp--preset--gradient--luminous-dusk: linear-gradient(135deg, rgb(255, 203, 112) 0%, rgb(199, 81, 192) 50%, rgb(65, 88, 208) 100%);
        --wp--preset--gradient--pale-ocean: linear-gradient(135deg, rgb(255, 245, 203) 0%, rgb(182, 227, 212) 50%, rgb(51, 167, 181) 100%);
        --wp--preset--gradient--electric-grass: linear-gradient(135deg, rgb(202, 248, 128) 0%, rgb(113, 206, 126) 100%);
        --wp--preset--gradient--midnight: linear-gradient(135deg, rgb(2, 3, 129) 0%, rgb(40, 116, 252) 100%);
        --wp--preset--font-size--small: 13px;
        --wp--preset--font-size--medium: 20px;
        --wp--preset--font-size--large: 36px;
        --wp--preset--font-size--x-large: 42px;
        --wp--preset--spacing--20: 0.44rem;
        --wp--preset--spacing--30: 0.67rem;
        --wp--preset--spacing--40: 1rem;
        --wp--preset--spacing--50: 1.5rem;
        --wp--preset--spacing--60: 2.25rem;
        --wp--preset--spacing--70: 3.38rem;
        --wp--preset--spacing--80: 5.06rem;
        --wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);
        --wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);
        --wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);
        --wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);
        --wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);
    }

    :where(body) {
        margin: 0;
    }

    .wp-site-blocks>.alignleft {
        float: left;
        margin-right: 2em;
    }

    .wp-site-blocks>.alignright {
        float: right;
        margin-left: 2em;
    }

    .wp-site-blocks>.aligncenter {
        justify-content: center;
        margin-left: auto;
        margin-right: auto;
    }

    :where(.is-layout-flex) {
        gap: 0.5em;
    }

    :where(.is-layout-grid) {
        gap: 0.5em;
    }

    .is-layout-flow>.alignleft {
        float: left;
        margin-inline-start: 0;
        margin-inline-end: 2em;
    }

    .is-layout-flow>.alignright {
        float: right;
        margin-inline-start: 2em;
        margin-inline-end: 0;
    }

    .is-layout-flow>.aligncenter {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .is-layout-constrained>.alignleft {
        float: left;
        margin-inline-start: 0;
        margin-inline-end: 2em;
    }

    .is-layout-constrained>.alignright {
        float: right;
        margin-inline-start: 2em;
        margin-inline-end: 0;
    }

    .is-layout-constrained>.aligncenter {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    .is-layout-constrained> :where(:not(.alignleft):not(.alignright):not(.alignfull)) {
        margin-left: auto !important;
        margin-right: auto !important;
    }

    body .is-layout-flex {
        display: flex;
    }

    .is-layout-flex {
        flex-wrap: wrap;
        align-items: center;
    }

    .is-layout-flex> :is(*, div) {
        margin: 0;
    }

    body .is-layout-grid {
        display: grid;
    }

    .is-layout-grid> :is(*, div) {
        margin: 0;
    }

    body {
        padding-top: 0px;
        padding-right: 0px;
        padding-bottom: 0px;
        padding-left: 0px;
    }

    a:where(:not(.wp-element-button)) {
        text-decoration: none;
    }

    :root :where(.wp-element-button, .wp-block-button__link) {
        background-color: #32373c;
        border-width: 0;
        color: #fff;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        padding: calc(0.667em + 2px) calc(1.333em + 2px);
        text-decoration: none;
    }

    .has-black-color {
        color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-color {
        color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-color {
        color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-color {
        color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-color {
        color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-color {
        color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-color {
        color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-color {
        color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-color {
        color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-color {
        color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-color {
        color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-color {
        color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-primary-color {
        color: var(--wp--preset--color--primary) !important;
    }

    .has-secondary-color {
        color: var(--wp--preset--color--secondary) !important;
    }

    .has-success-color {
        color: var(--wp--preset--color--success) !important;
    }

    .has-alert-color {
        color: var(--wp--preset--color--alert) !important;
    }

    .has-black-background-color {
        background-color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-background-color {
        background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-background-color {
        background-color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-background-color {
        background-color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-background-color {
        background-color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-background-color {
        background-color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-background-color {
        background-color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-background-color {
        background-color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-background-color {
        background-color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-background-color {
        background-color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-background-color {
        background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-background-color {
        background-color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-primary-background-color {
        background-color: var(--wp--preset--color--primary) !important;
    }

    .has-secondary-background-color {
        background-color: var(--wp--preset--color--secondary) !important;
    }

    .has-success-background-color {
        background-color: var(--wp--preset--color--success) !important;
    }

    .has-alert-background-color {
        background-color: var(--wp--preset--color--alert) !important;
    }

    .has-black-border-color {
        border-color: var(--wp--preset--color--black) !important;
    }

    .has-cyan-bluish-gray-border-color {
        border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
    }

    .has-white-border-color {
        border-color: var(--wp--preset--color--white) !important;
    }

    .has-pale-pink-border-color {
        border-color: var(--wp--preset--color--pale-pink) !important;
    }

    .has-vivid-red-border-color {
        border-color: var(--wp--preset--color--vivid-red) !important;
    }

    .has-luminous-vivid-orange-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-amber-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
    }

    .has-light-green-cyan-border-color {
        border-color: var(--wp--preset--color--light-green-cyan) !important;
    }

    .has-vivid-green-cyan-border-color {
        border-color: var(--wp--preset--color--vivid-green-cyan) !important;
    }

    .has-pale-cyan-blue-border-color {
        border-color: var(--wp--preset--color--pale-cyan-blue) !important;
    }

    .has-vivid-cyan-blue-border-color {
        border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
    }

    .has-vivid-purple-border-color {
        border-color: var(--wp--preset--color--vivid-purple) !important;
    }

    .has-primary-border-color {
        border-color: var(--wp--preset--color--primary) !important;
    }

    .has-secondary-border-color {
        border-color: var(--wp--preset--color--secondary) !important;
    }

    .has-success-border-color {
        border-color: var(--wp--preset--color--success) !important;
    }

    .has-alert-border-color {
        border-color: var(--wp--preset--color--alert) !important;
    }

    .has-vivid-cyan-blue-to-vivid-purple-gradient-background {
        background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;
    }

    .has-light-green-cyan-to-vivid-green-cyan-gradient-background {
        background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;
    }

    .has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background {
        background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;
    }

    .has-luminous-vivid-orange-to-vivid-red-gradient-background {
        background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;
    }

    .has-very-light-gray-to-cyan-bluish-gray-gradient-background {
        background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;
    }

    .has-cool-to-warm-spectrum-gradient-background {
        background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;
    }

    .has-blush-light-purple-gradient-background {
        background: var(--wp--preset--gradient--blush-light-purple) !important;
    }

    .has-blush-bordeaux-gradient-background {
        background: var(--wp--preset--gradient--blush-bordeaux) !important;
    }

    .has-luminous-dusk-gradient-background {
        background: var(--wp--preset--gradient--luminous-dusk) !important;
    }

    .has-pale-ocean-gradient-background {
        background: var(--wp--preset--gradient--pale-ocean) !important;
    }

    .has-electric-grass-gradient-background {
        background: var(--wp--preset--gradient--electric-grass) !important;
    }

    .has-midnight-gradient-background {
        background: var(--wp--preset--gradient--midnight) !important;
    }

    .has-small-font-size {
        font-size: var(--wp--preset--font-size--small) !important;
    }

    .has-medium-font-size {
        font-size: var(--wp--preset--font-size--medium) !important;
    }

    .has-large-font-size {
        font-size: var(--wp--preset--font-size--large) !important;
    }

    .has-x-large-font-size {
        font-size: var(--wp--preset--font-size--x-large) !important;
    }
    </style>
    <script data-optimized="1" type="text/javascript"
        src="https://carllymotors.com/wp-content/litespeed/js/a259d7e65ad0382d4dec5758ac502786.js?ver=02786"
        id="wp-hooks-js" defer data-deferred="1"></script>
    <script data-optimized="1" type="text/javascript"
        src="https://carllymotors.com/wp-content/litespeed/js/b004ebadffdf36d17902bc4f660f8047.js?ver=f8047"
        id="wp-i18n-js" defer data-deferred="1"></script>
    <script type="text/javascript" id="wp-i18n-js-after"
        src="data:text/javascript;base64,d3AuaTE4bi5zZXRMb2NhbGVEYXRhKHsndGV4dCBkaXJlY3Rpb25cdTAwMDRsdHInOlsnbHRyJ119KQ=="
        defer></script>
    <script data-optimized="1" type="text/javascript"
        src="https://carllymotors.com/wp-content/litespeed/js/decf0673cdb6e634df664e5c3aa844f5.js?ver=844f5" id="swv-js"
        defer data-deferred="1"></script>
    <script type="text/javascript" id="contact-form-7-js-before"
        src="data:text/javascript;base64,dmFyIHdwY2Y3PXsiYXBpIjp7InJvb3QiOiJodHRwczpcL1wvY2FybGx5bW90b3JzLmNvbVwvd3AtanNvblwvIiwibmFtZXNwYWNlIjoiY29udGFjdC1mb3JtLTdcL3YxIn0sImNhY2hlZCI6MX0="
        defer></script>
    <script data-optimized="1" type="text/javascript"
        src="https://carllymotors.com/wp-content/litespeed/js/d2344765bea7ebff6b4e9f21e9d31699.js?ver=31699"
        id="contact-form-7-js" defer data-deferred="1"></script>
    <script data-optimized="1" type="text/javascript"
        src="https://carllymotors.com/wp-content/litespeed/js/6e72a5d7b813438547c51df732eec93d.js?ver=ec93d"
        id="flatsome-live-search-js" defer data-deferred="1"></script>
    <script data-optimized="1" type="text/javascript"
        src="https://carllymotors.com/wp-content/litespeed/js/fb55d03d5982a1da426f569bc8092717.js?ver=92717"
        id="joinchat-js" defer data-deferred="1"></script>
    <script data-optimized="1" type="text/javascript"
        src="https://carllymotors.com/wp-content/litespeed/js/38ca22efd32f977a596b177b4c6a9923.js?ver=a9923"
        id="hoverIntent-js" defer data-deferred="1"></script>
    <script type="text/javascript" id="flatsome-js-js-extra"
        src="data:text/javascript;base64,dmFyIGZsYXRzb21lVmFycz17InRoZW1lIjp7InZlcnNpb24iOiIzLjE4LjcifSwiYWpheHVybCI6Imh0dHBzOlwvXC9jYXJsbHltb3RvcnMuY29tXC93cC1hZG1pblwvYWRtaW4tYWpheC5waHAiLCJydGwiOiIiLCJzdGlja3lfaGVpZ2h0IjoiNzAiLCJzdGlja3lIZWFkZXJIZWlnaHQiOiIwIiwic2Nyb2xsUGFkZGluZ1RvcCI6IjAiLCJhc3NldHNfdXJsIjoiaHR0cHM6XC9cL2NhcmxseW1vdG9ycy5jb21cL3dwLWNvbnRlbnRcL3RoZW1lc1wvZmxhdHNvbWVcL2Fzc2V0c1wvIiwibGlnaHRib3giOnsiY2xvc2VfbWFya3VwIjoiPGJ1dHRvbiB0aXRsZT1cIiV0aXRsZSVcIiB0eXBlPVwiYnV0dG9uXCIgY2xhc3M9XCJtZnAtY2xvc2VcIj48c3ZnIHhtbG5zPVwiaHR0cDpcL1wvd3d3LnczLm9yZ1wvMjAwMFwvc3ZnXCIgd2lkdGg9XCIyOFwiIGhlaWdodD1cIjI4XCIgdmlld0JveD1cIjAgMCAyNCAyNFwiIGZpbGw9XCJub25lXCIgc3Ryb2tlPVwiY3VycmVudENvbG9yXCIgc3Ryb2tlLXdpZHRoPVwiMlwiIHN0cm9rZS1saW5lY2FwPVwicm91bmRcIiBzdHJva2UtbGluZWpvaW49XCJyb3VuZFwiIGNsYXNzPVwiZmVhdGhlciBmZWF0aGVyLXhcIj48bGluZSB4MT1cIjE4XCIgeTE9XCI2XCIgeDI9XCI2XCIgeTI9XCIxOFwiPjxcL2xpbmU+PGxpbmUgeDE9XCI2XCIgeTE9XCI2XCIgeDI9XCIxOFwiIHkyPVwiMThcIj48XC9saW5lPjxcL3N2Zz48XC9idXR0b24+IiwiY2xvc2VfYnRuX2luc2lkZSI6ITF9LCJ1c2VyIjp7ImNhbl9lZGl0X3BhZ2VzIjohMX0sImkxOG4iOnsibWFpbk1lbnUiOiJNYWluIE1lbnUiLCJ0b2dnbGVCdXR0b24iOiJUb2dnbGUifSwib3B0aW9ucyI6eyJjb29raWVfbm90aWNlX3ZlcnNpb24iOiIxIiwic3dhdGNoZXNfbGF5b3V0IjohMSwic3dhdGNoZXNfZGlzYWJsZV9kZXNlbGVjdCI6ITEsInN3YXRjaGVzX2JveF9zZWxlY3RfZXZlbnQiOiExLCJzd2F0Y2hlc19ib3hfYmVoYXZpb3Jfc2VsZWN0ZWQiOiExLCJzd2F0Y2hlc19ib3hfdXBkYXRlX3VybHMiOiIxIiwic3dhdGNoZXNfYm94X3Jlc2V0IjohMSwic3dhdGNoZXNfYm94X3Jlc2V0X2xpbWl0ZWQiOiExLCJzd2F0Y2hlc19ib3hfcmVzZXRfZXh0ZW50IjohMSwic3dhdGNoZXNfYm94X3Jlc2V0X3RpbWUiOjMwMCwic2VhcmNoX3Jlc3VsdF9sYXRlbmN5IjoiMCJ9fQ=="
        defer></script>
    <script data-optimized="1" type="text/javascript"
        src="https://carllymotors.com/wp-content/litespeed/js/315ef2c4b72375a2ff0073604344f2f7.js?ver=4f2f7"
        id="flatsome-js-js" defer data-deferred="1"></script>
</body>

@endsection
<!-- Page optimized by LiteSpeed Cache @2025-02-12 13:48:12 -->

<!-- Page cached by LiteSpeed Cache 6.5.4 on 2025-02-12 13:48:11 -->