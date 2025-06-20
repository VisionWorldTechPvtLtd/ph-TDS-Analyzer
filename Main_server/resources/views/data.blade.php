@extends('layouts.app')

@section('title', 'Live Data')

@section('content')

@include('layouts.partials.header')
@include('layouts.partials.sidebar')

<main id="main" class="main">
    @include('layouts.partials.breadcrums')
    @include('layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <x-pop-alert />
                        <h5 class="card-title"> Borewell Data <span>| all</span></h5>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="bg-info text-light">
                                        <th scope="col">S.No</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Serial No</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">CF</th>
                                        <th scope="col">Consumption(KL)</th>
                                        <th scope="col">FF</th>
                                        <th scope="col">RF</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">DateTime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $totalTF = 0;
                                    $totalFF = 0;
                                    @endphp

                                    @foreach ($pumpData as $pump)
                                    @php
                                    $totalTF += $pump->forward_flow - $pump->morning_flow;
                                    $totalFF += $pump->forward_flow;
                                    $row_class = strtotime(date('Y-m-d', strtotime($pump->updated_at))) == strtotime(date('Y-m-d')) ? 'bg-success' : 'bg-danger';
                                    @endphp

                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $pump->id }}</td>
                                        <td>{{ $pump->serial_no }}</td>
                                        <td>{{ $pump->pump_title }}</td>
                                        <td>{{ $pump->current_flow }}</td>
                                        <td>{{ number_format($pump->forward_flow - $pump->morning_flow, 2) }}</td>
                                        <td>{{ $pump->forward_flow }}</td>
                                        <td>{{ $pump->reverse_flow }}</td>
                                        <td>
                                            @if ($pump->plan_status)
                                            <span class="badge bg-danger">Expired</span>
                                            @else
                                            <span class="badge bg-success">On-Going</span>
                                            @endif
                                        </td>
                                        <td class="text-light {{ $row_class }}">
                                            {{ date('M d Y h:i:s A', strtotime($pump->updated_at)) }}
                                        </td>
                                    </tr>
                                    @endforeach

                                    <tr>
                                        <th scope="row">#</th>
                                        <th colspan="4">Total</th>
                                        <td>{{ number_format($totalTF,2) }}</td>
                                        <td>{{ number_format($totalFF,2) }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if($piezometer)
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"> Piezometer Ground Water Data <span>| all</span></h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="bg-info text-light">
                                        <th scope="col">S.No</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Serial No</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">GWL</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">DateTime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($piezometerData as $pump)
                                    @php
                                    $row_class = strtotime(date('Y-m-d', strtotime($pump->updated_at))) == strtotime(date('Y-m-d')) ? 'bg-success' : 'bg-danger';
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $pump->id }}</td>
                                        <td>{{ $pump->serial_no }}</td>
                                        <td>{{ $pump->pump_title }}</td>
                                        <td>{{ $pump->ground_water_level }}</td>
                                        <td>
                                            @if ($pump->plan_status)
                                            <span class="badge bg-danger">Expired</span>
                                            @else
                                            <span class="badge bg-success">On-Going</span>
                                            @endif
                                        </td>
                                        <td class="text-light {{ $row_class }}">
                                            {{ date('M d Y h:i:s A', strtotime($pump->updated_at)) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </section>
</main>

@include('layouts.partials.footer')

@endsection
