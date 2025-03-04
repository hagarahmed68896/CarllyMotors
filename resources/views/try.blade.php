@extends('layouts.app')

@section('content')

<style>
html,
body,
.container {
    height: 90%;
}

.login-form {
    width: 350px;
    padding: 2rem 1rem 1rem;
}

form {
    padding: 1rem;
}

input[type="text"]:focus {
    border-color: #760e13;
    border-radius: 15px;
}

input[type="text"],
.btn,
.login-form,
.alert {
    border-radius: 15px;
}
</style>

<body>
    <div class="container">
        <div class="wrapper d-flex align-items-center justify-content-center h-100">

            <div class="card login-form">
                <div class="card-body">
                    <h5 class="card-title text-center">Login Form</h5>
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
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>

                        <button type="submit" class="btn bg-carlly w-100">Submit</button>
                        <div class="sign-up mt-4">
                            Don't have an account? <a href="{{route('register')}}" style="color:#760e13">Create One</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

@endsection