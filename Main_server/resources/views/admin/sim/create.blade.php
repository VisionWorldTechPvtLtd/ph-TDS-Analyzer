@extends('admin.layouts.app')

@section('title', 'Create SIM ')

@section('content')

    @include('admin.layouts.partials.header')
    @include('admin.layouts.partials.sidebar')

    <main id="main" class="main">
        @include('admin.layouts.partials.breadcrums')
        @include('layouts.partials.alerts')

        <section style="padding-top:60px; background-color: rgb(231, 231, 226);">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card">
                            <div class="card-header"></div>
                            <div class="card-body">
                                @if (Session::has('Message_sent'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('Message_sent') }}
                                    </div>
                                @endif
                                <form method="POST" action="{{route('sim.store')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mt-2">
                                        <input type="text" name="sim_company" class="form-control mt-3" id="sim_company"
                                            placeholder=" Company" />
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="text" name="sim_imei" class="form-control mt-3" id="sim_imei"
                                            placeholder="Sim Imei Number" value="{{ old('sim_imei') }}" />
                                        @error('sim_imei')
                                            <div class="validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-2">
                                        <input type="text" name="sim_number" class="form-control mt-3" id="sim_number"
                                            placeholder="Sim Number" value="{{ old('sim_number') }}" />
                                        @error('sim_number')
                                            <div class="validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <input type="text" name="sim_name" class="form-control mt-3" id="sim_name"
                                            placeholder="Sim Name" />
                                    </div>
                                    <div class="form-group mt-2">
                                        <select name="sim_type" class="form-control mt-3" id="sim_type">
                                            <option value="" disabled selected>Sim Type*</option>
                                            <option value="1">Data Sim </option>
                                            <option value="0">M2M Sim </option>
                                            <option value="2">Mobile Data </option>
                                        </select>
                                        @error('sim_type')
                                            <div class="validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-2">
                                        <select name="sim_active" class="form-control mt-3" id="sim_active">
                                            <option value="" disabled selected>Sim Active*</option>
                                            <option value="1">Active</option>
                                            <option value="0">Deactivate</option>
                                        </select>
                                        @error('sim_active')
                                            <div class="validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-2">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="sim_purchase" name="sim_purchase"
                                                value="">
                                            <label for="sim_purchase">Sim purchase Date*</label>
                                        </div>
                                        @error('sim_purchase')
                                            <div class="validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="sim_start" name="sim_start"
                                                value="">
                                            <label for="sim_start">Sim start Date*</label>
                                        </div>
                                        @error('sim_start')
                                            <div class="validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="sim_end " name="sim_end"
                                                value="">
                                            <label for="sim_end">Sim End Date*</label>
                                        </div>
                                        @error('sim_end')
                                            <div class="validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary float-right mt-3">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('admin.layouts.partials.footer')

@endsection
