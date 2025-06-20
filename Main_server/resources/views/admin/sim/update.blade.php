@extends('admin.layouts.app')

@section('title', 'Sim Update')

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
                            <h5 class="card-title"><span> Sim | edit</span></h5>
                            <hr>
                            <form class="row g-3" method="POST" action="{{ route('sim.update', $sim->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="sim_number" name="sim_number"
                                                max=""value="{{ $sim->sim_number }}" readonly>
                                            <label for="sim_start">Sim Number *</label>
                                        </div>
                                        @error('sim_number')
                                            <div class="validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="sim_start" name="sim_start"
                                            value="{{ old('sim_start', $sim->sim_start ? $sim->sim_start->format('Y-m-d') : '') }}">
                                        <label for="sim_start">Sim Start Date *</label>
                                    </div>
                                    @error('sim_start')
                                        <div class="validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="sim_end" name="sim_end"
                                            value="{{ old('sim_end', $sim->sim_end ? $sim->sim_end->format('Y-m-d') : '') }}"
                                            required>
                                        <label for="sim_end">Sim End Date *</label>
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
