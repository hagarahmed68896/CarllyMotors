@extends('layouts.app')

@section('content')

<style>
    /* ==== GLOBAL COLORS ==== */
    :root {
        --brand-color: #760e13;
        --brand-dark: #5a0b0f;
    }

    body {
        background-color: #fafafa;
        color: #333;
    }

    .section-title {
        font-weight: 700;
        text-transform: capitalize;
        margin-bottom: 1rem;
    }

    .text-brand {
        color: var(--brand-color) !important;
    }

    .section-subtitle {
        max-width: 700px;
        margin: 0 auto 2rem;
        color: #6c757d;
        font-size: 1.05rem;
    }

    /* ==== HERO SECTION ==== */
    .about-hero {
        background: linear-gradient(rgba(118, 14, 19, 0.85), rgba(118, 14, 19, 0.85)),
            url('{{ asset('aboutus.jpg') }}') center/cover no-repeat;
        color: #fff;
        text-align: center;
        padding: 100px 20px;
        border-radius: 0 0 30px 30px;
    }

    .about-hero h1 {
        font-size: 2.8rem;
        font-weight: 700;
    }

    .about-hero p {
        max-width: 800px;
        margin: 20px auto 0;
        font-size: 1.1rem;
        color: #f2f2f2;
    }

    /* ==== ICON BOX ==== */
    .feature-box {
        background: #fff;
        border-radius: 16px;
        padding: 40px 25px;
        transition: 0.3s ease;
        height: 100%;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .feature-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .feature-box i {
        color: var(--brand-color);
        font-size: 2rem;
        margin-bottom: 15px;
    }

    /* ==== INFO SECTION ==== */
    .info-image img {
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* ==== STATISTICS ==== */
    .stats-box {
        text-align: center;
        padding: 30px 20px;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: 0.3s ease;
        height: 100%;
    }

    .stats-box:hover {
        transform: translateY(-5px);
    }

    .stats-box i {
        color: var(--brand-color);
        font-size: 2rem;
        margin-bottom: 10px;
    }

    @media (max-width: 767px) {
        .about-hero {
            padding: 70px 15px;
        }
    }
</style>

<!-- ==== HERO SECTION ==== -->
<section class="about-hero">
    <h1>Welcome to <span class="text-warning">Carlly Motors</span></h1>
    <p>
        Driving innovation in the automotive world — connecting car owners and service providers
        through our modern dual-app ecosystem.
    </p>
</section>

<!-- ==== ABOUT CONTENT ==== -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <h2 class="section-title text-brand mb-3">Our Vision & Mission</h2>
                <p>
                    Founded in 2023 in the vibrant city of Dubai, Carlly Motors has rapidly emerged
                    as a trailblazer in the automotive service industry. Our mission is to provide
                    an all-encompassing platform for both car owners and service providers.
                </p>
                <p>
                    We aim to deliver unparalleled convenience, efficiency, and reliability through
                    our innovative mobile applications tailored for distinct user experiences.
                </p>
            </div>

            <div class="col-lg-6">
                <div class="info-image">
                    <img src="{{ asset('aboutus.jpg') }}" class="img-fluid" alt="About Carlly Motors">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==== SERVICES ==== -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <h2 class="section-title text-brand">Our Services</h2>
        <p class="section-subtitle">
            From buying and selling cars to roadside assistance, insurance, and repairs — Carlly
            Motors is your one-stop platform for all automotive needs.
        </p>

        <div class="row g-4 mt-4">
            <div class="col-md-6">
                <div class="feature-box">
                    <i class="bi bi-pencil-square"></i>
                    <h5 class="fw-bold mb-3 text-uppercase">Accessibility</h5>
                    <p class="text-secondary">
                        Our apps offer auctions, car parts, transport, insurance, and repair services
                        in one easy-to-use platform for every car owner.
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="feature-box">
                    <i class="bi bi-briefcase"></i>
                    <h5 class="fw-bold mb-3 text-uppercase">Quality & Excellence</h5>
                    <p class="text-secondary">
                        Every service provider is verified for quality and trustworthiness, ensuring
                        top-tier performance and customer satisfaction.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==== JOIN US ==== -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="section-title text-brand">Join Us on Our Journey</h2>
        <p class="section-subtitle">
            Whether you’re a car owner seeking reliable services or a provider expanding your reach,
            Carlly Motors gives you the tools to thrive in the automotive industry.
        </p>
    </div>
</section>

<!-- ==== STATISTICS ==== -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6">
                <div class="stats-box">
                    <i class="fas fa-trophy"></i>
                    <h5 class="fw-bold mt-2">Top 1 Americas</h5>
                    <p class="text-muted">Largest Auto Portal</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-box">
                    <i class="fas fa-car"></i>
                    <h5 class="fw-bold mt-2">Car Sold</h5>
                    <p class="text-muted">Every 5 minutes</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-box">
                    <i class="fas fa-tags"></i>
                    <h5 class="fw-bold mt-2">Offers</h5>
                    <p class="text-muted">Stay updated, pay less</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats-box">
                    <i class="fas fa-balance-scale"></i>
                    <h5 class="fw-bold mt-2">Compare</h5>
                    <p class="text-muted">Find the right car</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
