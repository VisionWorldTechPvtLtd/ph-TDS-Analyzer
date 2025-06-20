@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@include('layouts.partials.header')
@include('layouts.partials.sidebar')

<main id="main" class="main">
    @include('layouts.partials.breadcrums')
    @include('layouts.partials.alerts')

    <section class="section dashboard">
        <x-pop-alert />

        <div class="row">
            <!-- Pump Selector -->
            <div class="col-md-3">
                <div class="mb-3 form-floatingclient">
                    <select class="form-select" id="pump_id" name="pump_id">
                        <option value="">Select Pump</option>
                        @foreach ($pumps as $pump)
                        <option value="{{ $pump->id }}" data-user="{{ $pump->user_id }}">
                            {{ $pump->pump_title }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @error('pump_id')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="status-box">
                <span style="color: green; font-weight: bold;">Online: {{ $onlineCount }}</span><br>
                <span style="color: red; font-weight: bold;">Offline: {{ $offlineCount }}</span>
            </div>

            <!-- COMMON BACKGROUND IMAGE CONTAINER -->
            <div class="mt-4 img-fluid" style="background-image: url('{{ asset('assets/img/contact.jpg') }}');">
                <div class="row">
                    <div class="col-md-5">
                        <h3 class="totalboreweell">Total Borewell
                            <hr>{{ $pumpCount }}
                        </h3>
                    </div>
                </div>

                <!-- PIEZOMETER SECTION -->
                <div class="piezometer-section" style="display: none;">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="piezometer3">Piezometer</h3>
                            <div id="forward_flow_container">
                                <h3 class="piezometer">
                                    <span id="piezometer_value">0</span>&nbsp;m
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NON-PIEZOMETER SECTION -->
                <div class="non-piezometer-section" style="display: none;">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="totalizer2">Totalizer</h3>
                            <div id="forward_flow_container">
                                <h3 class="totalizer">
                                    <span id="totalizer_value">0</span>&nbsp;m<sup>3</sup>
                                </h3>
                                <h3 class="todayflow2">Today Flow</h3>
                                <h3 class="todayflow"> <span id="todayflow_value"></span>&nbsp;m<sup>3</sup></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PLAN EXPIRY TABLE -->
            @if ($allPumpsPlanExpires11Months->isNotEmpty())
            <div class="mt-3 card">
                <div class="card-body">
                    <h5 class="card-title">Borewell Plan Expires Soon <span>| All</span></h5>
                    <div class="table-responsive">
                        <table class="table table-borderless datatable">
                            <thead>
                                <tr class="text-light bg-secondary">
                                    <th>S.No</th>
                                    <th>Borewell ID</th>
                                    <th>Title</th>
                                    <th>Sim Number</th>
                                    <th>Last Calibration Date</th>
                                    <th>Plan End</th>
                                    <th>Sim End</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allPumpsPlanExpires11Months as $pump)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pump->id }}</td>
                                    <td>{{ $pump->pump_title }}</td>
                                    <td>{{ $pump->sim_number ?? 'N/A' }}</td>
                                    <td class="bg-info text-light">{{ \Carbon\Carbon::parse($pump->last_calibration_date)->format('M d Y') }}</td>
                                    <td class="bg-success text-light">{{ \Carbon\Carbon::parse($pump->plan_end_date)->format('M d Y') }}</td>
                                    <td class="bg-danger text-light">{{ $pump->sim_end ? \Carbon\Carbon::parse($pump->sim_end)->format('M d Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('user.pump', $pump->id) }}" class="btn btn-info btn-sm"><i class="bi bi-eye-fill"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
    </section>
</main>

{{-- JS to toggle piezometer/non-piezometer --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#pump_id').change(function() {
        const pumpId = $(this).val();

        if (pumpId) {
            $.get(`/get-forward-flow/${pumpId}`, function(data) {
                $('.piezometer-section').hide();
                $('.non-piezometer-section').hide();

                if (data.piezometer == 1) {
                    $('#piezometer_value').text(data.groundWaterLevels.join(', '));
                    $('.piezometer-section').show();
                } else {
                    $('#totalizer_value').text(parseFloat(data.totalizer).toFixed(2));
                    $('#todayflow_value').text(parseFloat(data.todayFlow).toFixed(2));
                    $('.non-piezometer-section').show();
                }
            }).fail(function() {
                alert('Failed to fetch pump data');
            });
        } else {
            $('.piezometer-section, .non-piezometer-section').hide();
            $('#piezometer_value').text('0');
            $('#totalizer_value').text('0');
            $('#todayflow_value').text('0');
        }
    });

</script>

@include('layouts.partials.footer')

@endsection
