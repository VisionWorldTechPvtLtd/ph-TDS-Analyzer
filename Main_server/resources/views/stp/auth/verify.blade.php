@extends('layouts.app')

@section('title', __('Verify Your Email Address'))

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
                    {{-- <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5> --}}
                    <p class="text-center small">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                        <p class="text-center small">{{ __('If you did not receive the email') }},</p>
                  </div>

                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
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
