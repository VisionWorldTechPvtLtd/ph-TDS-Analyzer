@extends('layouts.app')

@section('title', __('Reset Password'))

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
                        <h5 class="card-title text-center pb-0 fs-4">{{ __('Reset Password') }}</h5>
                        <p class="text-center small">Enter your email to get password reset link</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="row g-3 needs-validation" method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group has-validation">
                              <span class="input-group-text" id="inputGroupPrepend">@</span>
                              <input type="text" name="email" class="form-control" id="email" >
                              @error('email')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
      
                            </div>
                        </div>

                        <div class="col-12 mb-10">                            
                            <button class="btn btn-primary w-100" type="submit">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                        <div class="col-12">
                          <p class="small mb-0">
                              <a class="btn btn-link" href="{{ route('login') }}">
                                  {{ __('Back to login ?') }}
                              </a>
                          </p>
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
