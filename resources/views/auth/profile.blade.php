@extends('layouts.app')

@section('content')
<style>
.card {
    margin-top: 2em;
    margin-left: 40%;
    padding: 1.5em 0.5em 0.5em;
    border-radius: 2em;
    text-align: center;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);

}

.card img {
    width: 65%;
    border-radius: 50%;
    margin: 0 auto;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.card .card-title {
    font-weight: 700;
    font-size: 1.5em;
    margin-top: 15px;
}

.card .btn {
    border-radius: 2em;
    background-color: #760e13;
    color: #ffffff;
    padding: 0.5em 1.5em;
}

.card .btn:hover {
    background-color: rgb(128, 40, 45);
    color: #ffffff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    text-decoration: none;
}
</style>
<div class="card" style="width: 18rem;">
    {{-- @if(count($user->getMedia('profile')) == 0) --}}
    <img src="{{asset('user.png')}}" class="card-img-top" alt="...">
    {{-- @else
    <img src="{{asset(parse_url($user->getMedia('profile')[0]->getUrl(), PHP_URL_PATH))}}" class="card-img-top"
        alt="...">
    @endif --}}
    <div class="card-body">
        @if($user->fname != 'user')
        <h5 class="card-title">{{$user->fname . ' ' . $user->lname}}</h5>
        <p>{{$user->city}}</p>
        <p>{{$user->phone}}</p>
        <p>{{$user->email}}</p>
        <p>{{$user->userType}}</p>
        <br>
        <a href="{{route('users.edit', auth()->user()->id)}}" class="btn bg-carlly">Edit Profile</a>
        @else
        <a href="{{route('users.edit', auth()->user()->id)}}" class="btn bg-carlly">Complete Profile</a>
        @endif

    </div>
</div>

@endsection