@extends('layouts.CarProvider')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg p-4">
        <h1 class="mb-4 text-center " style="color: #163155;">Privacy Policy</h1>

        <div class="privacy-content">
            {!! $cleanData !!}
        </div>
    </div>
</div>

<style>
    .privacy-content {
        font-size: 0.9rem; /* Smaller font size */
        line-height: 1.6; /* Improved spacing */
        color: #333;
    }

    .privacy-content h3 {
        margin-top: 20px;
        padding-bottom: 5px;
        border-bottom: 1.5px solid #163155;
        color: #163155;
        font-size: 1.1rem; /* Smaller headings */
        font-weight: 600;
    }

    .privacy-content p {
        margin-bottom: 10px; /* Reduced extra spaces */
    }

    .privacy-content ul {
        padding-left: 18px;
        margin-bottom: 10px; /* Reduced space */
    }

    .privacy-content li {
        margin-bottom: 5px; /* Compact list items */
    }

    .privacy-content a {
        color: #007bff;
        font-weight: 500;
        text-decoration: none;
    }

    .privacy-content a:hover {
        text-decoration: underline;
    }
</style>
@endsection
