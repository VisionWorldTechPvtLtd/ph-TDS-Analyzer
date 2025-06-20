{{-- @extends('layouts.app')

@section('title', 'Login')

@section('content')
<main>
    <div class="container">

        <section class="py-4 section register min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">



                        <div class="mb-3 card">

                            <div class="card-body">

                                <div class="pt-4 d-flex justify-content-center">
                                    <a href="{{ route('login') }}" class="w-auto logo d-flex align-items-center">
<img src="{{ asset('assets/img/logo2.png') }}" alt="">
</a>
</div><!-- End Logo -->

<div class="pt-4 pb-2">
    <h5 class="pb-0 text-center card-title fs-4">Customer Login</h5>
    <p class="text-center small">Enter your username & password to login</p>
</div>

@include('layouts.partials.alerts')

<form class="row g-3 needs-validation" method="post" action="{{ route('login') }}">
    @csrf
    <div class="col-12">
        <label for="email" class="form-label">Email</label>
        <div class="input-group has-validation">
            <span class="input-group-text" id="inputGroupPrepend">@</span>
            <input type="text" name="email" class="form-control" id="email">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

        </div>
    </div>

    <div class="col-12">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password">

        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Remember me</label>
        </div>
    </div>
    <div class="col-12">
        <button class="btn btn-primary w-100" type="submit">Login</button>
    </div>
    <div class="col-12">
        <p class="mb-0 small">
            @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
            @endif
        </p>
        <a href="https://docs.google.com/forms/d/e/1FAIpQLScINLkDx3Uh0FI0pXhwe3PvCH7cGTLH-5vMNlgDNHM2E4Drzw/viewform" class="btn btn-info" style="margin-left: 237px; margin-top: -66px;" role="button">
            Raise Request
        </a>
    </div>
</form>


</div>
</div>

</div>
</div>
</div>

</section>

</div>
</main><!-- End #main -->
@endsection --}}
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
    }

    .login-page {
        min-height: 100vh;
        background: linear-gradient(135deg, rgba(137, 247, 254, 0.6), rgba(102, 166, 255, 0.6)),
        url('{{ asset('assets/img/clientlogin3.jfif') }}') no-repeat center center;
        background-size: cover;
        background-blend-mode: overlay;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .login-card {
        background: linear-gradient(135deg, #89f7fe, #66a6ff);
        padding: 2rem;
        border-radius: 12px;
        width: 100%;
        max-width: 420px;
        margin-left: -940px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .raise-request-btn {
        display: block;
        width: 100%;
        margin-top: 1rem;
        text-align: center;
    }

    .logo img {
        height: 50px;
    }

    @media (max-width: 576px) {
        .login-card {
            padding: 1.5rem;
            margin-left: 0px;
            margin-top: 0px;
        }

        .logo img {
            height: 40px;
        }
    }

</style>

<main class="login-page">
    <section class="py-4 section register d-flex flex-column align-items-center justify-content-center w-100">
        <div class="login-card">

            <div class="card-body">
                <div class="d-flex justify-content-center mb-3">
                    <a href="{{ route('login') }}" class="w-auto logo d-flex align-items-center">
                        <img src="{{ asset('assets/img/logo2.png') }}" alt="Logo">
                    </a>
                </div>

                <div class="pb-2 text-center">
                    <h5 class="card-title fs-4">Customer Login</h5>
                    <p class="small">Enter your username & password to login</p>
                </div>

                @include('layouts.partials.alerts')

                <form class="row g-3 needs-validation" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text">@</span>
                            <input type="text" name="email" class="form-control" id="email" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>

                    <div class="col-12 d-flex justify-content-between align-items-center mt-2">
                        @if (Route::has('password.request'))
                        <a class="small" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                        @endif

                        <a href="https://docs.google.com/forms/d/e/1FAIpQLScINLkDx3Uh0FI0pXhwe3PvCH7cGTLH-5vMNlgDNHM2E4Drzw/viewform" class="btn btn-info btn-sm" role="button">
                            Raise Request
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
