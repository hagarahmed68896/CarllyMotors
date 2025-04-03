@extends('layouts.app')

@section('content')
<style>
body {
    background: #fafbfb;
}
.carousel-item img {
        position: absolute;
        top: 0;
        left: 0;
        min-width: 100vw !important; 
        height: 100vh;
        object-fit: cover ;
    }

    .carousel-inner {
        height: 70vh;
        background-color: #5a0b0f !important;
    }

    .carousel {
        position: relative;
    }
    .carousel-control-prev, .carousel-control-next {
            width: 3%;
            padding: 5px;
            background-color: rgba(0, 0, 0, 0.5) !important;
            
        }

        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5) !important;
            padding: 5px;
            width: 8%;
            border-radius: 50%;
            /* color: rgba(0, 0, 0, 0.5) !important; */
        }

        /* تخصيص النقاط */
        .carousel-indicators [data-bs-target] {
            background-color: #fff;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-bottom: 4px;
        }
        
.carousel-item img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100vw;  

    min-width: 100vw; 
    /* min-height: 100vh;  */
    object-fit: contain;

}
.carousel-inner {
    height: 70vh; 

}

.carousel {
    position: relative;
}

@media (max-width: 470px) {
    .carousel-inner {
    height: 18vh; 
    background-color: #5a0b0f !important;
}
} 

@media (min-width: 1600px) {
    .carousel {
        max-width: 1250px; 
        margin: 0 auto;
    }
    
}

    
</style>

<style>
    .custom-container {
    width: 100%; /*`container-fluid` */

}

/*`container` */
@media (min-width: 1400px) {
    .custom-container {
        max-width: 1250px; 
        margin: 0 auto;
    }


}
.carousel-item img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100vw;  

    min-width: 100vw; 
    /* min-height: 100vh;  */
    object-fit: contain;

}
.carousel-inner {
    height: 80vh;
    background-color: #5a0b0f !important;
}

.carousel {
    position: relative;
}

@media (max-width: 470px) {
    .carousel-inner {
    height: 18vh;
    background-color: #5a0b0f !important;
}
} 

@media (min-width: 1600px) {
    .carousel {
        max-width: 1250px; 
        margin: 0 auto;
        width: 100vw; 
        /* height: 30vh; */
    }
    .carousel-inner {
    height: 40vh; 
    background-color: #5a0b0f !important;
}
.carousel-item img {
    
    width: 100vw; 
    /* min-height: 100vh;  */
    object-fit: contain;

}
}

    
</style>

<!-- home slider -->
<!-- <div id="demo" class="carousel slide home-slider" data-bs-interval="false">

    
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
    
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div> -->

<div id="demo" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
    <!-- النقاط -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
    </div>

    <!-- الصور -->
    <div class="carousel-inner">
    <div class="carousel-item active">
            <img class="d-block   "   src="{{asset('1.jpg')}}" alt="Los Angeles">
        </div>
        <div class="carousel-item">
            <img class="d-block   "  src="{{asset('2.jpg')}}" alt="Chicago">
        </div>
        <div class="carousel-item">
            <img class="d-block   "  src="{{asset('3.jpg')}}" alt="Chicago">
        </div>
        <div class="carousel-item">
            <img class="d-block   "  src="{{asset('4.jpg')}}" alt="New York">
        </div>
    </div>

    <!-- أزرار التنقل -->
    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
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
                        <div class="row" style="margin-top:4px;">
                            <div class="col-md-4 flex flex-row">
                                <a href="https://wa.me/971566350025">
                                    <button type="button" class="btn btn-success w-40 fw-bold">
                                        <i class="fab fa-whatsapp fs-4"></i>
                                        WhatsApp</button>
                                </a>
                                <!-- <div class=""> -->
                                <button type="submit"
                                    class="btn btn-outline-danger bg-carlly  w-80 fw-bold text-decoration-none">Send</button>
                            <!-- </div> -->
                            </div>
                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection