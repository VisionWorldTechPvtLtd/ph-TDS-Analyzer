@extends('admin.layouts.app')

@section('title', 'Login')

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
                        <a href="{{ route('admin.login') }}" class="logo d-flex align-items-center w-auto">
                            <img src="{{ asset('assets/img/logo2.png') }}" alt="">
                        </a>
                    </div><!-- End Logo -->

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Admin Login </h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  @include('admin.layouts.partials.alerts')

                  <form class="row g-3 needs-validation"  method="post" action="{{ route('admin.auth') }}">
                    @csrf
                    <div class="col-12">
                      <label for="email" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="email" class="form-control" id="email" >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                      </div>
                    </div>

                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" >

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
                    {{-- <div class="col-12">
                      <p class="small mb-0">Forgot password ? <a href="#">click here...</a></p>
                    </div> --}}
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
