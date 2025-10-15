@extends('layouts.app')

@section('title', $title)

@section('content')
<style>
    /* ===== Terms Page Styling ===== */
    .terms-hero {
        background: linear-gradient(135deg, #760e13, #a31218);
        color: white;
        text-align: center;
        padding: 80px 20px;
        border-radius: 0 0 40px 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .terms-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        letter-spacing: 1px;
    }

    .terms-hero p {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
    }

    .terms-content {
        background: #ffffff;
        margin-top: -40px;
        border-radius: 20px;
        padding: 60px 50px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
        line-height: 1.8;
    }

    .terms-content h2, .terms-content h3 {
        color: #760e13;
        font-weight: 700;
        margin-top: 40px;
        margin-bottom: 15px;
    }

    .terms-content p {
        color: #333;
        margin-bottom: 20px;
        font-size: 1.05rem;
    }

    .terms-content ul {
        margin-left: 20px;
    }

    .terms-content li {
        margin-bottom: 10px;
    }

    /* Breadcrumb */
    .breadcrumb {
        background: transparent;
        margin-bottom: 0;
        padding: 20px 0;
        font-size: 0.95rem;
    }

    .breadcrumb a {
        color: #760e13;
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb a:hover {
        color: #a31218;
        text-decoration: underline;
    }

    .breadcrumb-item.active {
        color: #555;
    }

    @media (max-width: 768px) {
        .terms-content {
            padding: 30px 20px;
        }
        .terms-hero h1 {
            font-size: 2rem;
        }
    }
</style>



<!-- ===== Hero Section ===== -->
<section class="terms-hero">
    <h1>{{ $title }}</h1>
    <p>Read our policies carefully to understand how we operate and protect your rights.</p>
</section>

<!-- ===== Terms Content ===== -->
<div class="container">
    <div class="terms-content">
        {!! $cleanData !!}
    </div>
</div>
@endsection
