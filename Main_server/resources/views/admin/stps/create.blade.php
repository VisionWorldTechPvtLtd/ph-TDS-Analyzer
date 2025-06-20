@extends('admin.layouts.app')

@section('title', 'Register Pump')

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
                        <h5 class="card-title">Register STP <span>| new</span></h5>
                        <hr>
                        <!-- Floating Labels Form -->
                        <form class="row g-3" method="POST" action="{{ route('stps.store') }}">
                            @csrf
                            <div class="col-md-3">
                                <div class="mb-3 form-floating">
                                    <select class="form-select" id="user_id" aria-label="Customer" name="user_id">
                                        @if($customers)
                                        @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <label for="user_id">Customer *</label>
                                </div>
                                @error('user_id')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                                    <label for="title">Title *</label>
                                </div>
                                @error('title')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="serial_no" name="serial_no" value="{{ old('serial_no') }}">
                                    <label for="serial_no">Serial No. *</label>
                                </div>
                                @error('serial_no')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="manufacturer" name="manufacturer" placeholder="" value="{{ old('manufacturer') }}">
                                    <label for="manufacturer">Manufacturer *</label>
                                </div>
                                @error('manufacturer')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="" value="{{ old('longitude') }}">
                                    <label for="longitude">Longitude</label>
                                </div>
                                @error('longitude')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="" value="{{ old('latitude') }}">
                                    <label for="latitude">Latitude</label>
                                </div>
                                @error('latitude')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="imei_no" name="imei_no" placeholder="" value="{{ old('imei_no') }}">
                                    <label for="imei_no">IMEI No. *</label>
                                </div>
                                @error('imei_no')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="" value="{{ old('mobile_no') }}">
                                    <label for="mobile_no">Mobile No. *</label>
                                </div>
                                @error('mobile_no')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="col-md-3">
                                <div class="mb-3 form-floating">
                                    <select class="form-select" id="plan_id" aria-label="Plan" name="plan_id">
                                        @if($plans)
                                        @foreach ($plans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->title }} ({{ $plan->duration }} Months)</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <label for="plan_id">Plan *</label>
                                </div>
                                @error('plan_id')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-6">
                                <div class="form-floating">
                                    <textarea class="form-control" name="address" placeholder="Address.." id="address" style="height: 70px;">{{ old('address') }}</textarea>
                                    <label for="address">Address</label>
                                </div>
                                @error('address ')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="user_key" name="user_key" placeholder="" value="{{ old('user_key') }}">
                                    <label for="user_key">User_Key *</label>
                                </div>
                                @error('user_key')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="checkbox" class="mx-4" id="on_off_status" name="on_off_status" placeholder="">
                                    <label for="on_off_status">On Off Status</label>
                                </div>
                                <p class="text-info input-info">Check if you want status to off !</p>
                                @error('on_off_status')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="checkbox" class="mx-4" id="auto_manual" name="auto_manual" placeholder="">
                                    <label for="auto_manual">Auto / Manual</label>
                                </div>
                                <p class="text-info input-info">Check if you want STP to be manual !</p>
                                @error('auto_manual')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="checkbox" class="mx-4" id="tested" name="tested" placeholder="">
                                    <label for="tested">Tested</label>
                                </div>
                                <p class="text-info input-info">Check if STP is tested !</p>
                                @error('tested')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="checkbox" class="mx-4" id="visiable" name="visiable" placeholder="">
                                    <label for="visiable">Visiable</label>
                                </div>
                                <p class="text-info input-info">Check if you don`t want to show STP in front !</p>
                                @error('visiable')
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
