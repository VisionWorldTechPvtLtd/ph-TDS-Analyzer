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
        background: linear-gradient(135deg, #89f7fe, #66a6ff),
        url('{{ asset('assets/img/cgwa.jpg') }}') no-repeat center center;
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
        margin-left: 778px;
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
            margin-top: -274px;
        }

        .logo img {
            height: 40px;
        }
    }

</style>

<main class="login-page">
    <div class="login-card">
        <div class="mb-4 text-center">
            <a href="{{ route('cgwa.doLogin') }}" class="logo d-flex justify-content-center">
                <img src="{{ asset('assets/img/logo2.png') }}" alt="Logo">
            </a>
        </div>

        <h5 class="mb-2 text-center">CGWA Login</h5>
        <p class="mb-4 text-center small">Enter your username & password to login</p>

        @include('layouts.partials.alerts')

        <form method="post" action="{{ route('cgwa.doLogin') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text">@</span>
                    <input type="text" name="email" id="email" class="form-control" required>
                </div>
                @error('email')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>

            <div class="mt-3 text-center">
                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">Forgot Your Password?</a>
                @endif
            </div>
        </form>
    </div>
</main>
@endsection
