@extends('admin.layouts.app')

@section('title', $pump->pump_title)

@section('content')

@include('admin.layouts.partials.header')
@include('admin.layouts.partials.sidebar')

<main id="main" class="main">
    @include('admin.layouts.partials.breadcrums')
    @include('admin.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"> {{ $pump->pump_title }}<span>| edit</span></h5>
                        <hr>
                        <form class="row g-3" method="POST" action="{{route('nable.data.update',$pump->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-3">
                                <div class="mb-3 form-floating">
                                    <select class="form-select" id="user_id" aria-label="Customer" name="user_id">
                                        @if($customers)
                                        @foreach ($customers as $customer)
                                        <option @if($customer->id == $pump->user_id) selected @endif value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <label for="user_id">Customer *</label>
                                    @error('user_id')
                                    <div class="validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="last_calibration_date" name="last_calibration_date" max="{{ date('Y-m-d') }}" value="{{ $pump->last_calibration_date }}">
                                    <label for="last_calibration_date">NABL End Date *</label>
                                </div>
                                @error('last_calibration_date')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="checkbox" class="mx-4" id="panel_lock" name="panel_lock" {{ $pump->panel_lock ? 'checked' : '' }}>
                                    <label for="panel_lock">AMC</label>
                                </div>
                                <p class="text-info input-info">Check if you want to AMC (Panel Lock) !</p>
                                @error('panel_lock')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="checkbox" class="mx-4" id="external" name="external" {{ $pump->external ? 'checked' : '' }}>
                                    <label for="external">CMC</label>
                                </div>
                                <p class="text-info input-info">Check if pump is CMC ( External) !</p>
                                @error('external')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="plan_start_date" name="plan_start_date" value="{{ old('plan_start_date', $pump->plan_start_date ? $pump->plan_start_date->format('Y-m-d') : '') }}" required>
                                    <label for="plan_start_date">Plan Start Date *</label>
                                </div>
                                @error('plan_start_date')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="plan_end_date" name="plan_end_date" value="{{ old('plan_end_date', $pump->plan_end_date ? $pump->plan_end_date->format('Y-m-d') : '') }}" required>
                                    <label for="plan_end_date">Plan End Date *</label>
                                </div>
                                @error('plan_end_date')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="sim_start" name="sim_start" value="{{ old('sim_start', optional($sim)->sim_start ? \Carbon\Carbon::parse($sim->sim_start)->format('Y-m-d') : '') }}">
                                    <label for="sim_start">Sim Start Date</label>
                                </div>
                                @error('sim_start')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="sim_end" name="sim_end" value="{{ old('sim_end', optional($sim)->sim_end ? \Carbon\Carbon::parse($sim->sim_end)->format('Y-m-d') : '') }}">
                                    <label for="sim_end">Sim End Date</label>
                                </div>
                                @error('sim_end')
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
            </div>
        </div>
    </section>
</main><!-- End #main -->

@include('admin.layouts.partials.footer')

@endsection
