@extends('layouts.CarProvider')
@section('content')

<style>
    .terms-content {
        font-size: 0.9rem; /* Smaller font size */
        line-height: 1.6; /* Adjusted for better readability */
        color: #333;
    }

    .terms-content h3 {
        margin-top: 20px;
        padding-bottom: 5px;
        border-bottom: 1.5px solid #163155;
        color: #163155;
        font-size: 1.1rem; /* Smaller heading */
        font-weight: 600;    }

    .terms-content p {
        margin-bottom: 10px; /* Reduce white space */
    }

    .terms-content ul {
        padding-left: 18px;
        margin-bottom: 10px; /* Reduce space between lists */
    }

    .terms-content li {
        margin-bottom: 5px; /* Less space between list items */
    }

    .terms-content a {
        color: #163155;
        font-weight: 500;
        text-decoration: none;
    }

    .terms-content a:hover {
        text-decoration: underline;
    }
</style>

<div class="container my-5">
    <div class="card shadow-lg p-4">
        <h1 class="mb-4 text-center" style="color:#163155">Terms and Conditions</h1>

        <div class="terms-content">
            {!! $cleanData !!}
        </div>
    </div>
</div>

@endsection