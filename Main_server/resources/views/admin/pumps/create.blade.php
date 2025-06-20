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
                        <h5 class="card-title">Register Pumps <span>| new</span></h5>
                        <hr>
                        <!-- Floating Labels Form -->
                        <form class="row g-3" method="POST" action="{{ route('pumps.store') }}">
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
                                    <input type="text" class="form-control" id="pump_title" name="pump_title" value="{{ old('pump_title') }}">
                                    <label for="pump_title">Borewell Title *</label>
                                </div>
                                @error('pump_title')
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
                                    <input type="date" class="form-control" id="last_calibration_date" name="last_calibration_date" max="{{ date('Y-m-d') }}" value="{{ old('last_calibration_date') }}">
                                    <label for="last_calibration_date">Last Calibration Date *</label>
                                </div>
                                @error('last_calibration_date')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="pipe_size" name="pipe_size" placeholder="" value="{{ old('pipe_size') }}">
                                    <label for="pipe_size">pipe Size(mm) *</label>
                                </div>
                                @error('pipe_size')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select name="manufacturer" class="form-control" id="manufacturer">
                                        {{-- <option value="" disabled selected>Manufacturer *</option> --}}
                                        <option value="Vi-Flow" {{ old('manufacturer') == 'Vi-Flow' ? 'selected' : '' }}>Vi-Flow</option>
                                        <option value="UPC" {{ old('manufacturer') == 'UPC' ? 'selected' : '' }}>UPC</option>
                                        <option value="E-Flowmeter" {{ old('manufacturer') == ' E-Flowmeter' ? 'selected' : '' }}>E-Flowmeter</option>
                                        <option value="Krohne" {{ old('manufacturer') == 'Krohne' ? 'selected' : '' }}>Krohne</option>
                                        <option value="Accumax" {{ old('manufacturer') == 'Accumax ' ? 'selected' : '' }}>Accumax </option>
                                    </select>
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
                            {{-- <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="flow_limit" name="flow_limit" placeholder="" value="{{ old('flow_limit') }}">
                            <label for="flow_limit">Flow Limit </label>
                    </div>
                    @error('flow_limit')
                    <div class="validation-error">{{ $message }}</div>
                    @enderror
                </div> --}}
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
                    <div class="form-floating">
                        <input type="text" class="form-control" id="u_key" name="u_key" placeholder="" value="{{ old('u_key') }}">
                        <label for="u_key">Model Number*</label>
                    </div>
                    @error('u_key')
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
                {{-- <div class="col-md-3">
                    <div class="mb-3 form-floating">
                        <select class="form-select" id="sim_number" aria-label="sim_number" name="sim_number">
                            <option value="" disabled selected>Select Sim</option>
                            @if($sim)
                            @foreach ($sim as $sims)
                            <option value="{{ $sims->id }}">
                {{ $sims->sim_number }}
                </option>
                @endforeach
                @endif
                </select>
                <label for="sim_number">Select Sim</label>
            </div>
            @error('sim_number')
            <div class="validation-error">{{ $message }}</div>
            @enderror
        </div> --}}

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
                <input type="text" class="form-control" id="monitoring_unit_id" name="monitoring_unit_id" placeholder="" value="{{ old('monitoring_unit_id') }}">
                <label for="monitoring_unit_id">Monitoring Unit ID</label>
            </div>
            <p class="text-info input-info">Enter Zip/Excel Api`s Monitoring ID to add this unit in Zip/Excel !</p>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <input type="checkbox" class="mx-4" id="site_api_status" name="site_api_status" placeholder="">
                <label for="site_api_status">Site Api Staus</label>
            </div>
            <p class="text-info input-info">Check if you want to add this unit in Zip/Excel Api`s!</p>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <input type="checkbox" class="mx-4" id="panel_lock" name="panel_lock" placeholder="">
                <label for="panel_lock">AMC</label>
            </div>
            <p class="text-info input-info">Check if you want to AMC (Panel Lock) !</p>
            @error('panel_lock')
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
                <input type="checkbox" class="mx-4" id="external" name="external" placeholder="">
                <label for="external">CMC</label>
            </div>
            <p class="text-info input-info">Check if pump is CMC ( External) !</p>
            @error('external')
            <div class="validation-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <input type="checkbox" class="mx-4" id="auto_manual" name="auto_manual" placeholder="">
                <label for="auto_manual">Auto / Manual</label>
            </div>
            <p class="text-info input-info">Check if you want pump to be manual !</p>
            @error('auto_manual')
            <div class="validation-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <input type="checkbox" class="mx-4" id="tested" name="tested" placeholder="">
                <label for="tested">Tested</label>
            </div>
            <p class="text-info input-info">Check if pump is tested !</p>
            @error('tested')
            <div class="validation-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <input type="checkbox" class="mx-4" id="visiable" name="visiable" placeholder="">
                <label for="visiable">Visiable</label>
            </div>
            <p class="text-info input-info">Check if you don`t want to show pump in front !</p>
            @error('visiable')
            <div class="validation-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <input type="checkbox" class="mx-4" id="live_data" name="live_data" placeholder="">
                <label for="live_data">Live Data</label>
            </div>
            <p class="text-info input-info">Check if you don`t want to show pump live data in front !</p>
            @error('live_data')
            <div class="validation-error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <input type="checkbox" class="mx-4" id="piezometer" name="piezometer" placeholder="">
                <label for="piezometer">Piezometer</label>
            </div>
            <p class="text-info input-info">Check if you Piezometer and Borewell !</p>
            @error('piezometer')
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
