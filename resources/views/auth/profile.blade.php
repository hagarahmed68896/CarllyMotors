@extends('layouts.app')

@section('content')
<style>
    .card {
        margin: 2em auto;
        padding: 2em 1.5em;
        border-radius: 1.5em;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        max-width: 350px;
        background: #fff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }

    .card img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
    }

    .card img:hover {
        transform: scale(1.05);
    }

    .card-title {
        font-weight: 700;
        font-size: 1.5em;
        margin-top: 10px;
        color: #333;
    }

    .card p {
        margin: 5px 0;
        color: #666;
        font-size: 0.95em;
    }

    .btn {
        border-radius: 2em;
        background: linear-gradient(135deg, #760e13, #a01b20);
        color: #ffffff;
        padding: 0.6em 1.8em;
        font-size: 1em;
        font-weight: bold;
        transition: background 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }

    .btn:hover {
        background: linear-gradient(135deg, #8b1a1f, #b22226);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        text-decoration: none;
    }
</style>

<div class="card">
    <img src="{{ asset('user.png') }}" class="card-img-top" alt="User Profile Picture">
    
    <div class="card-body">
        @if($user->fname != 'user')
            <h5 class="card-title">{{ $user->fname . ' ' . $user->lname }}</h5>
            <p><i class="fas fa-map-marker-alt"></i> {{ $user->city }}</p>
            <p><i class="fas fa-phone"></i> {{ $user->phone }}</p>
            <p><i class="fas fa-envelope"></i> {{ $user->email }}</p>
            <p><i class="fas fa-user"></i> {{ $user->userType }}</p>
            <br>
            <a href="{{ route('users.edit', auth()->user()->id) }}" class="btn">Edit Profile</a>
        @else
            <a href="{{ route('users.edit', auth()->user()->id) }}" class="btn">Complete Profile</a>
        @endif
    </div>
</div>

@endsection
