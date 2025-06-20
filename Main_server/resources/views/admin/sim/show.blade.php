@extends('admin.layouts.app')

@section('title', $sim->pump->pump_title)

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
                        <div class="filter  mr-4">
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('sim.edit', $sim->id) }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{$sim->pump->pump_title}}<span>|Borewell</span></h5>
                            <hr>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <h6 class="font-bold bg-gray-200 px-2 py-2">Sim Details</h6>
                                </div>
                                <div class="col-md-3">
                                    <p class="m-0 text-label">Company:</p>
                                    <p class="m-0">{{ $sim->sim_company }}</p>
                                </div>
                                <div class="col-md-3">
                                    <p class="m-0 text-label">Sim Imei:</p>
                                    <p class="m-0">{{ $sim->sim_imei }}</p>
                                </div>

                                <div class="col-md-3">
                                    <p class="m-0 text-label">Sim Number:</p>
                                    <p class="m-0">{{ $sim->sim_number }}</p>
                                </div>

                                <div class="col-md-3">
                                    <p class="m-0 text-label">Sim Name:</p>
                                    <p class="m-0">{{ $sim->sim_name }}</p>
                                </div>
                                <div class="col-md-2">
                                    <p class="m-0 text-label">Sim Type:</p>
                                    <p class="m-0">
                                        @if($sim->sim_type == 1)
                                            Data Sim
                                        @elseif($sim->sim_type == 0)
                                            M2M Sim
                                        @elseif($sim->sim_type == 2)
                                            Mobile Data
                                        @else
                                            Unknown
                                        @endif
                                    </p>
                                </div>

                                <div class="col-md-2">
                                    <p class="m-0 text-label">Sim Active:</p>
                                    <p class="m-0">{{ $sim->sim_active ==1 ? 'Active':'Deactivate'}}</p>
                                </div>

                                <div class="col-md-2">
                                    <p class="m-0 text-label">Sim Purchase:</p>
                                    <p class="m-0">{{ $sim->sim_purchase }}</p>
                                </div>
                                <div class="col-md-2">
                                    <p class="m-0 text-label">Sim Start Date:</p>
                                    <p class="m-0">{{ date('M d Y', strtotime($sim->sim_start)) }}</p>
                                </div>
                                <div class="col-md-2">
                                    <p class="m-0 text-label">Sim End Date:</p>
                                    <p class="m-0">{{ date('M d Y', strtotime($sim->sim_end)) }}</p>
                                </div>

                                <div class="col-md-2">
                                    <p class="m-0 text-label">Created At:</p>
                                    <p class="m-0">{{ date('M d Y', strtotime($sim->created_at)) }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
            </div>
        </section>

    </main><!-- End #main -->


    @include('admin.layouts.partials.footer')

@endsection
