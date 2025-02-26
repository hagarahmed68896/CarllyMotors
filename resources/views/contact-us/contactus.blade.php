@extends('layouts.app')

@section('content')
<style>
body {
    background: #fafbfb;
}
</style>

<!-- home slider -->
<div id="demo" class="carousel slide home-slider" data-bs-interval="false">

    <!-- The slideshow -->
    <div class="carousel-inner">
        <div class="carousel-item">
            <img class="img-fluid w-100 mx-auto" src="{{asset('1.jpg')}}" alt="Los Angeles">
        </div>
        <div class="carousel-item">
            <img class="img-fluid w-100 mx-auto" src="{{asset('2.jpg')}}" alt="Chicago">
        </div>
        <div class="carousel-item">
            <img class="img-fluid w-100 mx-auto" src="{{asset('3.jpg')}}" alt="Chicago">
        </div>
        <div class="carousel-item active">
            <img class="img-fluid w-100 mx-auto" src="{{asset('4.jpg')}}" alt="New York">
        </div>
    </div>
    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <h1 class="mb-3">Contact Us</h1>
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
            @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
            @endif
            <form action="{{route('contacts.store')}}" method="post">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="subject" class="form-label">Your Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Your Phone</label>
                        <input type="number" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="col-12">
                        <label for="body" class="form-label">Your Message</label>
                        <textarea class="form-control" id="body" name="body" rows="5" required></textarea>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="https://wa.me/971566350025">
                                    <button type="button" class="btn btn-success w-100 fw-bold">
                                        <i class="fab fa-whatsapp fs-4"></i>
                                        WhatsApp</button>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit"
                                    class="btn btn-outline-danger bg-carlly  w-100 fw-bold">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection