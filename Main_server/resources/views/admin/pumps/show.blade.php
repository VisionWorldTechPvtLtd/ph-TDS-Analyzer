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

            <!-- Left side columns -->
            <div class="col-lg-12">

                <div class="card">
                    <div class="filter  mr-4">
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('pumps.edit', $pump->id) }}">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $pump->pump_title }} <span>| {{ $pump->serial_no }}</span></h5>
                        <hr>

                        <div class="row g-3">

                            <div class="col-md-12">
                                <h6 class="font-bold bg-gray-200 px-2 py-2">Customer Details</h6>
                            </div>

                            <div class="col-md-2">
                               <img src="{{ asset($pump->user->profile_pic) }}" class="" width="50px" />
                            </div>

                            <div class="col-md-4">
                                <p class="m-0 text-label">Name : </p>
                                <p class="m-0">{{ $pump->user->first_name }} {{ $pump->user->last_name }}</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Contact No : </p>
                                <p class="m-0">{{ $pump->user->contact_no }}</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Email : </p>
                                <p class="m-0">{{ $pump->user->email }}</p>
                            </div>

                            <div class="col-md-12">
                                <h6 class="font-bold bg-gray-200 px-2 py-2">Plan Details
                                    <span class="badge bg-{{ $pump->plan->plan_status ? 'danger' : 'success' }}">{{ $pump->plan_status ? 'Expired' : 'Running' }}</span> </h6>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Title : </p>
                                <p class="m-0">{{ $pump->plan->title }} </p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Duration : </p>
                                <p class="m-0">{{ $pump->plan->duration }} Months</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Started On : </p>
                                <p class="m-0">{{ date('M d Y', strtotime($pump->plan_start_date)) }}</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">End On : </p>
                                <p class="m-0">{{ date('M d Y', strtotime($pump->plan_end_date)) }}</p>
                            </div>


                            <div class="col-md-12">
                                <h6 class="font-bold bg-gray-200 px-2 py-2">Pump Details</h6>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">ID : </p>
                                <p class="m-0">{{ $pump->id }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Serial No. : </p>
                                <p class="m-0">{{ $pump->serial_no }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Mobile No. : </p>
                                <p class="m-0">{{ $pump->mobile_no }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">IMEI No. : </p>
                                <p class="m-0">{{ $pump->imei_no }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">U Key : </p>
                                <p class="m-0">{{ $pump->u_key }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Title : </p>
                                <p class="m-0">{{ $pump->pump_title }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Last Calibration Date : </p>
                                <p class="m-0">{{ date('M d Y', strtotime($pump->last_calibration_date)) }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Pipe Size : </p>
                                <p class="m-0">{{ $pump->pipe_size }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Flow Limit : </p>
                                <p class="m-0">{{ $pump->flow_limit }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Manufacturer : </p>
                                <p class="m-0">{{ $pump->manufacturer }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Registered On : </p>
                                <p class="m-0">{{ date('M d Y', strtotime($pump->created_at)) }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Cordinates : </p>
                                <p class="m-0">Lat : {{ $pump->latitude }}</p>
                                <p class="m-0">Long : {{ $pump->longitude }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Monitoring ID : </p>
                                <p class="m-0">{{ $pump->monitoring_unit_id }}</p>
                            </div>


                            <div class="col-md-2">
                                <p class="m-0 text-label">Panel Lock : </p>
                                <span class="badge bg-{{ $pump->panel_lock ? 'danger' : 'success' }}">{{ $pump->panel_lock ? 'Lock' : 'Un-Lock' }}</span>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">On / Off Status : </p>
                                <span class="badge bg-{{ $pump->on_off_status ? 'danger' : 'success' }}">{{ $pump->on_off_status ? 'OFF' : 'ON' }}</span>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">External : </p>
                                <span class="badge bg-{{ $pump->external ? 'danger' : 'success' }}">{{ $pump->external ? 'Yes' : 'No' }}</span>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Auto / Manual : </p>
                                <span class="badge bg-{{ $pump->auto_manual ? 'danger' : 'success' }}">{{ $pump->auto_manual ? 'Manual' : 'Auto' }}</span>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Tested : </p>
                                <span class="badge bg-{{ $pump->tested ? 'danger' : 'success' }}">{{ $pump->tested ? 'Un-Tested' : 'Tested' }}</span>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">visiable : </p>
                                <span class="badge bg-{{ $pump->visiable ? 'danger' : 'success' }}">{{ $pump->visiable ? 'Hidden' : 'Visiable' }}</span>
                            </div>

                            <div class="col-md-12">
                                <p class="m-0 text-label">Address : </p>
                                <p class="m-0 ">{{ $pump->address }}</p>
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
