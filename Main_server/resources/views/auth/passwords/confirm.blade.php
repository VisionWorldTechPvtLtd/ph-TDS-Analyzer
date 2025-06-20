@extends('layouts.app')

@section('title', __('Confirm Password'))

@section('content')
<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">



              <div class="card mb-3">

                <div class="card-body">

                    <div class="d-flex justify-content-center pt-4">
                        <a href="{{ route('login') }}" class="logo d-flex align-items-center w-auto">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="">
                        </a>
                    </div><!-- End Logo -->

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">{{ __('Confirm Password') }}</h5>
                    <p class="text-center small">{{ __('Please confirm your password before continuing.') }}</p>
                  </div>
              

                    <form method="POST" class="row g-3 needs-validation" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="col-12 mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                           
                        </div>

                        <div class="col-12">
                           
                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('Confirm Password') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                            
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
@endsection
