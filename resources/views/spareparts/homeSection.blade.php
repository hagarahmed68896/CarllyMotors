@extends('./home')

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Swiper.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@section('page')

<div class="filter-bar my-2">
    <form class="form-row" method="get">
        <!-- City Dropdown -->
        <div class="col-">
            <select class="form-control" name="city">
                <option value="" selected>City</option>
                @foreach($cities as $city)
                @if($city != null || $city != '')
                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                    {{ $city }}
                </option>
                @else
                @continue
                @endif
                @endforeach
            </select>
        </div>
       

        <!-- Make Dropdown -->
        <div class="col-">
            <select class="form-control" name="make">
                <option value="" selected>Make</option>
                @foreach($makes as $make)
                <option value="{{ $make }}" {{ request('make') == $make ? 'selected' : '' }}>
                    {{ $make }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Model Dropdown -->
        <div class="col-">
            <select class="form-control" name="model">
                <option value="" selected>Model</option>
                @foreach($models as $model)
                @if($model != null || $model != '')
                <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>
                    {{ $model }}
                </option>
                @else
                @continue
                @endif
                @endforeach
            </select>
        </div>

        <!-- Year Dropdown -->
        <div class="col-">
            <select class="form-control" name="year">
                <option value="" selected>Year</option>
                @foreach($years as $year)
                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Body Type Dropdown -->
        <div class="col-">
            <select class="form-control" name="category">
                <option value="" selected>Category</option>
                @foreach($categories as $category)
                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                    {{ $category }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Brands Dropdown -->
        <div class="col-">
            <select class="form-control" name="brand">
                <option value="" selected>Brands</option>
                @foreach($brands as $brand)
                <option value="{{ $brand->name }}" {{ request('brand') == $brand->name ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Price Dropdown -->
        <div class="col-">
            <select class="form-control" name="price">
                <option value="" selected>Price</option>
                @foreach($prices as $price)
                @if($price != null || $price != '')
                <option value="{{ $price }}" {{ request('price') == $price ? 'selected' : '' }}>
                    {{ $price }}
                </option>
                @else
                @continue
                @endif
                @endforeach
            </select>
        </div>

        <!-- Search Button -->
        <div class="col-">
            <button type="submit" class="btn btn-block">Search</button>
        </div>
    </form>
</div>

<div class="tab-content" id="bodyTypeTabsContent">
    <div class="container main-car-list-sec">
        <div class="row">
            @foreach ($spareParts as $key => $part)
            <div class="col-sm-3 col-sm-12 col-md-6 col-lg-4 col-xl-3">
                <div class="car-card border-0">
                    <div id="carouselExample_{{$key}}" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @if(count($part->images) != 0)
                            @foreach($part->images as $image)
                            @php
                            $image = Str::after($image->image, url('/').'/');
                            @endphp
                            <div class="carousel-item active">
                                <img src="{{config('app.file_base_url') . $image }}" class="d-block w-100"
                                    style="height: 219px;object-fit: cover;" alt="Car Image">
                                <div class="badge-featured">Featured</div>
                                <div class="badge-images"><img src="{{config('app.file_base_url') . $image }}"
                                        alt="icon"> 6
                                </div>
                                <div class="badge-year">{{ $part->brand }}</div>
                                <div class="overlay">
                                    <div class="icon-btn">
                                        <a href="#"><img src="https://carllymotors.com/demo/images/faviourt-icon.png"
                                                alt="Favorite"></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="carousel-item active">
                                <img src="https://backend.carllymotors.com/public/icon/sparepart.jpg" class="d-block w-100"
                                    style="height: 219px;object-fit: cover;" alt="Car Image">
                                <div class="badge-featured">Featured</div>
                                <div class="badge-images"><img src="https://backend.carllymotors.com/public/icon/sparepart.jpg"
                                        alt="icon"> 6
                                </div>
                                <div class="badge-year">{{ $image }}</div>
                                <div class="overlay">
                                    <div class="icon-btn">
                                        <a href="#"><img src="https://carllymotors.com/demo/images/faviourt-icon.png"
                                                alt="Favorite"></a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <!-- Add carousel controls -->
                        <a class="carousel-control-prev" href="#carouselExample_{{$key}}" role="button"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExample_{{$key}}" role="button"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <div class="car-list-content-sec">
                        <span class="featured">{{ $part->model }}</span>

                        <h5 class="car-listing-title"> {{ $part->title }}</h5>

                        <p class="price">AED {{ number_format($part->price, 2) }}</p>
                        @if($part->user)
                        @php
                        $path = parse_url($part->user->image, PHP_URL_PATH);
                        $image = ltrim($path, '/');
                        @endphp

                        <div class="row profile-home-pic-sec" style="margin:10px">
                            <div class="col-sm-8 d-flex p-0">
                                <div class="left-pic">
                                    <!-- <img class="w-100"  style="border-radius: 100%"
                                        src="{{ $part->user ? config('app.file_base_url') . $image : 'https://www.shutterstock.com/image-vector/user-profile-icon-vector-avatar-600nw-2220431045.jpg' }}"
                                        alt=""> -->
                                </div>
                                <div class="right-text align-items-center">
                                    <p><a href="https://wa.me/{{ $part->user->phone }}" target="_blank">{{ $part->user ? $part->user->fname . ' ' . $part->user->lname : "" }} </a></p>
                                </div>
                            </div>
                            <div class="col-sm-4 p-0 d-flex align-items-center">
                                <a href="{{ route('spareParts.show', $part->id) }}" 
                                    class="btn btn-view" >Details</a>

                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection