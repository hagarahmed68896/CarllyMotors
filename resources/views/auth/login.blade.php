@extends('layouts.app')

@section('content')

<style>
html, body {
    background: #fff;
    height: 100%;
}

.login {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.login-form {
    width: 400px;
    padding: 2.5rem 2rem;
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    background: #fff;
}

.login-form h5 {
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    color: #760e13;
}

input[type="text"]:focus,
input[type="tel"]:focus,
select:focus {
    border-color: #760e13;
    box-shadow: 0 0 5px rgba(118,14,19,0.3);
}

input[type="text"],
input[type="tel"],
select,
.btn,
.alert {
    border-radius: 15px;
}

input[type="text"], 
input[type="tel"],
select {
    font-size: 1rem;
}

.btn.bg-carlly {
    background-color: #760e13;
    color: #fff;
    font-weight: 600;
}

.btn.bg-carlly:hover {
    background-color: #a31218;
    color: #fff;
    text-decoration: none;
}

.sign-up {
    text-align: center;
    margin-top: 1rem;
    font-size: 0.95rem;
}

.sign-up a {
    color: #760e13;
    font-weight: 500;
    text-decoration: none;
}

.sign-up a:hover {
    text-decoration: underline;
}
</style>

<div class="container login">
    <div class="login-form card p-4">
        <h5 class="text-center">Login Form</h5>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

       <div class="mb-3">
    <label for="phone" class="form-label fw-semibold">Phone</label>
    <div class="input-group">
        <span class="input-group-text bg-light">+971</span>

        <input 
            type="tel" 
            class="form-control" 
            id="phone" 
            name="phone" 
            placeholder="5xxxxxxxx"
            required
            pattern="[0-9]{9}" 
            maxlength="9"
            title="Enter 9 digits"
            value="{{ old('phone') }}"
        >
    </div>

    @error('phone')
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>

<script>
document.getElementById('phone').addEventListener('input', function (e) {
    let value = e.target.value;

    // لو الرقم يبدأ بـ 0 تجاهله
    if (value.startsWith('0')) {
        value = value.substring(1);
    }

    // خليه أرقام فقط وبحد أقصى 9
    value = value.replace(/\D/g, '').substring(0, 9);
    e.target.value = value;
});
</script>


            <button type="submit" class="btn bg-carlly w-100">Submit</button>

            <div class="sign-up mt-4">
                Don't have an account? <a href="{{ route('register') }}">Create One</a>
            </div>
        </form>
    </div>
</div>

@endsection
