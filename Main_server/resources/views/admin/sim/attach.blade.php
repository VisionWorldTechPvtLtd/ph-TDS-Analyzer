@extends('admin.layouts.app')

@section('title', 'Sim Attach')

@section('content')

    @include('admin.layouts.partials.header')
    @include('admin.layouts.partials.sidebar')

    <main id="main" class="main">

        @include('admin.layouts.partials.breadcrums')

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <section class="section dashboard">
          <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sim Attach </h5>
                        <hr>
                        <form class="row g-3" method="POST" action="{{ route('connect') }}">
                            @csrf
                            <!-- Customer Selection -->
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="user_id" name="user_id">
                                        <option value="">Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="user_id">Customer *</label>
                                </div>
                                @error('user_id')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pump Selection -->
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="pump_id" name="pump_id">
                                        <option value="">Borewell</option>
                                        @foreach ($pumps as $pump)
                                            <option value="{{ $pump->id }}" data-user="{{ $pump->user->id }}">{{ $pump->pump_title }}</option>
                                        @endforeach
                                    </select>
                                    <label for="pump_id">Borewell *</label>
                                </div>
                                @error('pump_id')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- SIM Selection -->
                            <div class="col-md-4">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="sim_number" name="sim_number">
                                        <option value="">Sim</option>
                                        @foreach ($sims as $sim)
                                            <option value="{{ $sim->sim_number }}" data-bid="{{ $sim->pump_id }}">{{ $sim->sim_number }}</option>
                                        @endforeach
                                    </select>
                                    <label for="sim_number">Select Sim *</label>
                                </div>
                                @error('sim_number')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
          </div>
        </section>
      </main>

    @include('admin.layouts.partials.footer')

    <script>
        let customerElement = document.querySelector('#user_id');
        let pumpElement = document.querySelector('#pump_id');
        pumpElement.querySelectorAll('option').forEach(option => option.style.display = 'none');
        customerElement.addEventListener('change', function() {
            document.querySelector('#pump_id').options[0].selected = true;
            pumpElement.querySelectorAll('option').forEach(option => {
                if (customerElement.value === option.dataset.user) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        });
    </script>

@endsection
