@extends('layouts.app')

@section('title', 'Account')

@section('content')

    @include('layouts.partials.header')


    @include('layouts.partials.sidebar')


    <main id="main" class="main">

        @include('layouts.partials.breadcrums')

        @include('layouts.partials.alerts')

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="{{ asset(Auth::user()->profile_pic) }}" alt="Profile" class="rounded-circle">
                            <h2>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
                            <h3>User</h3>
                            {{-- <div class="social-links mt-2"> <a href="#" class="twitter"><i class="bi bi-twitter"></i></a> <a href="#" class="facebook"><i class="bi bi-facebook"></i></a> <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item"> <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Profile Details</button></li>
                                <li class="nav-item"> <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button></li>
                                <li class="nav-item"> <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button></li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Company</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->company }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Role</div>
                                        <div class="col-lg-9 col-md-8">User</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Phone</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->contact_no }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <form method="POST" action="{{ route('user.info.update', Auth::user()->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="first_name" class="col-md-4 col-lg-3 col-form-label">First Name *</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="first_name" type="text" class="form-control" id="first_name" value="{{ Auth::user()->first_name}}">
                                                @error('first_name')
                                                    <div class="validation-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="last_name" class="col-md-4 col-lg-3 col-form-label">Last Name *</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="last_name" type="text" class="form-control" id="last_name" value="{{ Auth::user()->last_name}}">
                                                @error('last_name')
                                                    <div class="validation-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="contact_no" class="col-md-4 col-lg-3 col-form-label">Contact No</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="contact_no" type="tel" class="form-control" id="contact_no" value="{{ Auth::user()->contact_no}}">
                                                @error('contact_no')
                                                    <div class="validation-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3"> <label for="profile-pic" class="col-md-4 col-lg-3 col-form-label">Profile Pic</label>
                                            <div class="col-md-8 col-lg-9"> <input name="profile_pic" type="file" class="form-control" id="profile_pic" ></div>
                                        </div>
                                        <div class="text-center"> <button type="submit" class="btn btn-primary" name="submit">Save Changes</button></div>
                                    </form>
                                </div>
                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <form method="POST" action="{{ route('user.password.update', Auth::user()->id) }}" >
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="oldPassword" class="col-md-4 col-lg-3 col-form-label">Old Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="oldpassword" type="oldpassword" class="form-control" id="currentPassword">
                                                @error('password')
                                                    <div class="validation-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control" id="currentPassword">
                                                @error('password')
                                                    <div class="validation-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="password_confirmation" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password_confirmation" type="password" class="form-control" id="password_confirmation">
                                                @error('password_confirmation')
                                                    <div class="validation-error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="text-center"> <button type="submit" class="btn btn-primary">Change Password</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

      </main><!-- End #main -->


    @include('layouts.partials.footer')

@endsection
