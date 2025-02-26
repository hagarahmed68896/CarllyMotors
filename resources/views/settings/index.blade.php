@extends('layouts.app')
@section('content')

<style>
    .data-content {
        font-size: 0.9rem; /* Smaller font size */
        line-height: 1.6; /* Adjusted for better readability */
        color: #333;
    }

    .data-content h3 {
        margin-top: 20px;
        padding-bottom: 5px;
        border-bottom: 1.5px solid #760e13;
        color: #760e13;
        font-size: 1.1rem; /* Smaller heading */
        font-weight: 600;
    }

    .data-content p {
        margin-bottom: 10px; /* Reduce white space */
    }

    .data-content ul {
        padding-left: 18px;
        margin-bottom: 10px; /* Reduce space between lists */
    }

    .data-content li {
        margin-bottom: 5px; /* Less space between list items */
    }

    .data-content a {
        color: #760e13;
        font-weight: 500;
        text-decoration: none;
    }

    .data-content a:hover {
        text-decoration: underline;
    }
</style>

<div class="container my-5">
    <div class="card shadow-lg p-4">
        <h1 class="mb-4 text-center" style="color:#760e13">{{$title}}</h1>

        <div class="data-content">
            {!! $cleanData !!}
        </div>
    </div>
</div>

@endsection