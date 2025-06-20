@extends('admin.layouts.app')

@section('title', $customer->first_name.' '.$customer->last_name)

@section('content')

    @include('admin.layouts.partials.header')


    @include('admin.layouts.partials.sidebar')


    <main id="main" class="main">

        @include('admin.layouts.partials.breadcrums')

        @include('admin.layouts.partials.alerts')

        <section class="section dashboard">
          <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Customer <span>| edit</span></h5>
                        <hr>
                        <!-- Floating Labels Form -->
                        <form class="row g-3" method="POST" action="{{ route('customers.update', $customer->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $customer->first_name }}">
                                    <label for="first_name">First Name *</label>
                                </div>
                                @error('first_name')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $customer->last_name }}">
                                    <label for="last_name">Last Name *</label>
                                </div>
                                @error('last_name')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="test" class="form-control" id="contact_no" name="contact_no"  max="{{ date('Y-m-d') }}" value="{{ $customer->contact_no }}">
                                    <label for="contact_no">Contact No. *</label>
                                </div>
                                @error('contact_no')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="test" class="form-control" id="company" name="company"  max="{{ date('Y-m-d') }}" value="{{ $customer->company }}">
                                    <label for="company">Company *</label>
                                </div>
                                @error('company')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 text-center">
                                <img src="{{ asset($customer->profile_pic) }}" class="mx-auto" width="50px" />
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="file" class="form-control" id="profile_pic" name="profile_pic" placeholder="" >

                                </div>
                                @error('profile_pic')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="city" name="city" placeholder="" value="{{ $customer->city }}">
                                    <label for="city">City *</label>
                                </div>
                                @error('city')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="state" name="state" placeholder="" value="{{ $customer->state }}">
                                    <label for="state">State *</label>
                                </div>
                                @error('state')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="pincode" name="pincode" placeholder="" value="{{ $customer->pincode }}">
                                    <label for="pincode">Pincode</label>
                                </div>
                                @error('pincode')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="checkbox" class="mx-4" id="status" name="status" @if($customer->status) checked @endif >
                                    <label for="status">Send Email (Status)</label>
                                </div>
                                <p class="text-info input-info">Check if you don`t want to de-activate send email !</p>
                                @error('status')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="checkbox" class="mx-4" id="manual_settings" name="manual_settings" placeholder="" >
                                    <label for="manual_settings">Manual On-Off</label>
                                </div>
                                <p class="text-info input-info">Check if you want to give manual on off option to user on data page !</p>
                            </div>

                            <div class="col-9">
                                <div class="form-floating">
                                    <textarea class="form-control" name="address" placeholder="Address.." id="address" style="height: 70px;">{{ $customer->address }}</textarea>
                                    <label for="address">Address</label>
                                </div>
                                @error('address ')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="test" class="form-control" id="user_flow_limit" name="user_flow_limit" placeholder="" value="{{ $customer->user_flow_limit }}">
                                    <label for="user_flow_limit">User Flow Limit *</label>
                                </div>
                                @error('user_flow_limit')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form><!-- End floating Labels Form -->

                    </div>

                </div>

            </div><!-- End Left side columns -->


          </div>
        </section>

      </main><!-- End #main -->


    @include('admin.layouts.partials.footer')

@endsection
