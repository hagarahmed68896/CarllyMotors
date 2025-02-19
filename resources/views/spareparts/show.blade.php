@extends('layouts.app')
@section('content')
@php
$str = $sparePart->car_model;
$arr = json_decode($str, true);
$carModels = json_decode($arr, true);
@endphp

<!-- #strat breadcrums-->
<div class="car-list-details-breadcrums container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('home')}}">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Spare Part for sale
            </li>
        </ol>
    </nav>
    <hr />
</div>

<div class="container mt-4 listing-detail">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="carCarousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @php
                            $images = array_filter($images); // Remove null values -->
                            @endphp

                            @foreach ($images as $index => $image)
                            @php
                            $image = Str::after($image, url('/').'/');
                            @endphp
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset(env('FILE_BASE_URL').$image) }}" class="d-block w-100"
                                    alt="Car Image">

                            </div>
                            @endforeach
                        </div>

                        <a class="carousel-control-prev" href="#carCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#carCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                    </div>
                    <ul class="nav nav-tabs mt-3" id="carTabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#overview" role="tab"
                                aria-selected="true">Overview</a></li>

                    </ul>
                    <div class="tab-content mt-3">
                        <div class="tab-pane fade active show" id="overview" role="tabpanel">
                            <h5 class="mt-3">Description</h5>
                            <p>{{$sparePart->desc}}</p>


                            <div class="overview-title mt-5">Overview</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="overview-item">
                                        <i class="fas fa-car"></i>
                                        <span>Brand:</span>
                                        <span style="font-weight:bold">{{$sparePart->brand}}</span>
                                    </div>

                                    <div class="overview-item">
                                        <i class="fas fa-barcode"></i>
                                        <span>VIN number:</span>
                                        <span style="font-weight:bold">{{$sparePart->vin_number}}</span>
                                    </div>
                                    <div class="overview-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        
                                        <a data-bs-toggle="modal" data-bs-target="#yearsModal" href=""><span>Years</span></a>
                                        <!-- years Modal -->
                                        <div class="modal fade" id="yearsModal" tabindex="-1"
                                            aria-labelledby="yearsModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="yearsModalLabel">Years</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul>
                                                            @foreach(json_decode($sparePart->year, true) as $year)
                                                            <li>{{ $year }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="overview-item">
                                        <i class="fas fa-users"></i>
                                        <span>Model:</span>
                                        <span style="font-weight:bold">{{$sparePart->model}}</span>
                                    </div>
                                    <div class="overview-item">
                                        <i class="fas fa-city"></i>
                                        <span>City:</span>
                                        <span style="font-weight:bold">{{$sparePart->city}}</span>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="overview-item">
                                        <i class="fas fa-cogs"></i>
                                        <span>Part Type:</span>
                                        <span style="font-weight:bold">{{$sparePart->part_type}}</span>
                                    </div>
                                    <div class="overview-item">
                                        <i class="fas fa-gas-pump"></i>
                                        <span class="text text-sm">Car Models:</span>
                                        <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <span style="font-weight:bold">view</span>
                                        </a>
                                        <div class="modal fade" id="exampleModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                            Car Models
                                                        </h1>
                                                    </div>
                                                    <div class="modal-body">
                                                        @foreach($carModels as $model)
                                                        <li>{{$model}}</li>
                                                        @endforeach
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="overview-item">
                                        <i class="fas fa-door-closed"></i>
                                        <span>Engine:</span>
                                        <span style="font-weight:bold">{{$sparePart->engine}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="right-listing-detail-section">
                <!-- Car Details Section -->
                <div class="card">
                    <h4 class="mb-2">{{$sparePart->title}}</h4>
                    <p class="text-muted mb-4">
                        <i class="fas fa-road"></i>
                        {{$sparePart->total_views}} views &nbsp;
                        <i class="fas fa-gas-pump"></i>
                        {{$sparePart->category->name}} &nbsp;
                        <br>

                        <i class="fas fa-user"></i>
                        {{$sparePart->user->fname}}{{$sparePart->user->lname}}
                    </p>
                    <p class="price">AED {{$sparePart->price}}</p>
                    <div class="icon-group mt-3">
                        <button title="add to fav" class="btn btn-outline-secondary"><i
                                class="fas fa-heart"></i></button>
                        <button title="copyUrl" onclick="copyUrl()" class="btn btn-outline-secondary">
                            <i class="fa fa-copy"></i>
                        </button>
                    </div>
                </div>

                <!-- Dealer Details Section -->
                @php
                $userImage = Str::after($sparePart->user->image, url('/').'/');
                @endphp
                <div class="card">

                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-light" style="width: 60px; height: 60px;">
                            <img src="{{env('FILE_BASE_URL'.$userImage)}}" alt="User-Image">
                        </div>
                        <div class="ml-3">
                            <h6 class="">{{$sparePart->user->fname . ' ' . $sparePart->user->lname}}</h6>
                            <span class="verified-badge">Verified dealer</span>
                        </div>
                    </div>
                    <h6 class="mb-3">Contact Dealer</h6>

                    <div class="d-flex justify-content-between">
                        <a href="tel:{{$sparePart->user->phone}}"><button
                                class="contact-btn btn-call">{{$sparePart->user->phone}}</button></a>
                    </div>
                </div>
            </div>

            <!-- <div class="report-list-car-right">
                <ul>
                    <li>
                        <a href="#"><i class="fa fa-light fa-flag"></i>Report this Dealer</a>
                    </li>
                </ul>
            </div> -->
        </div>
    </div>
</div>

<script>
function copyUrl() {
    const url = window.location.href; // Get current URL
    navigator.clipboard.writeText(url).then(() => {
        alert('URL copied to clipboard!' + url);
    }).catch(err => {
        console.error('Failed to copy URL: ', err);
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection