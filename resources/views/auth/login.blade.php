@extends('layouts.app')

@section('content')

<style>
html, body {
    background: #fff;
    height: 100%;
}

.container {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.login-form {
    width: 400px; /* أكبر شويه */
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
select:focus {
    border-color: #760e13;
    box-shadow: 0 0 5px rgba(118,14,19,0.3);
}

input[type="text"],
select,
.btn,
.alert {
    border-radius: 15px;
}

input[type="text"], select {
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

<div class="container">
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

            {{-- Country Code Dropdown + Phone Input --}}
            <div class="mb-3">
                <label for="phone" class="form-label" style="font: bold">Phone</label>
                <div class="input-group">
                    <select name="country_code" class="form-select" style="max-width: 120px;" required>
                        <option value="91">India (+91)</option>
                        <option value="62">Indonesia (+62)</option>
                        <option value="98">Iran (+98)</option>
                        <option value="964">Iraq (+964)</option>
                        <option value="353">Ireland (+353)</option>
                        <option value="972">Israel (+972)</option>
                        <option value="39">Italy (+39)</option>
                        <option value="81">Japan (+81)</option>
                        <option value="962">Jordan (+962)</option>
                        <option value="254">Kenya (+254)</option>
                        <option value="965">Kuwait (+965)</option>
                        <option value="961">Lebanon (+961)</option>
                        <option value="218">Libya (+218)</option>
                        <option value="60">Malaysia (+60)</option>
                        <option value="212">Morocco (+212)</option>
                        <option value="31">Netherlands (+31)</option>
                        <option value="64">New Zealand (+64)</option>
                        <option value="234">Nigeria (+234)</option>
                        <option value="47">Norway (+47)</option>
                        <option value="968">Oman (+968)</option>
                        <option value="92">Pakistan (+92)</option>
                        <option value="970">Palestine (+970)</option>
                        <option value="507">Panama (+507)</option>
                        <option value="595">Paraguay (+595)</option>
                        <option value="51">Peru (+51)</option>
                        <option value="63">Philippines (+63)</option>
                        <option value="48">Poland (+48)</option>
                        <option value="351">Portugal (+351)</option>
                        <option value="974">Qatar (+974)</option>
                        <option value="40">Romania (+40)</option>
                        <option value="7">Russia (+7)</option>
                        <option value="966">Saudi Arabia (+966)</option>
                        <option value="221">Senegal (+221)</option>
                        <option value="381">Serbia (+381)</option>
                        <option value="65">Singapore (+65)</option>
                        <option value="27">South Africa (+27)</option>
                        <option value="82">South Korea (+82)</option>
                        <option value="34">Spain (+34)</option>
                        <option value="94">Sri Lanka (+94)</option>
                        <option value="963">Syria (+963)</option>
                        <option value="46">Sweden (+46)</option>
                        <option value="41">Switzerland (+41)</option>
                        <option value="66">Thailand (+66)</option>
                        <option value="216">Tunisia (+216)</option>
                        <option value="90">Turkey (+90)</option>
                        <option value="971">UAE (+971)</option>
                    </select>
                    <input type="text" class="form-control" id="phone" name="phone" required placeholder="Please enter phone">
                </div>
                @error('phone')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn bg-carlly w-100">Submit</button>

            <div class="sign-up mt-4">
                Don't have an account? <a href="{{ route('register') }}">Create One</a>
            </div>
        </form>
    </div>
</div>

@endsection
