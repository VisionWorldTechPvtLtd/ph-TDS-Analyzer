@extends('admin.layouts.app')

@section('title', $stp->title)

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
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('stps.edit', $stp->id) }}">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $stp->title }} <span>| {{ $stp->serial_no }}</span></h5>
                        <hr>

                        <div class="row g-3">

                            <div class="col-md-12">
                                <h6 class="font-bold bg-gray-200 px-2 py-2">Customer Details</h6>
                            </div>

                            <div class="col-md-2">
                               <img src="{{ asset($stp->user->profile_pic) }}" class="" width="50px" />
                            </div>

                            <div class="col-md-4">
                                <p class="m-0 text-label">Name : </p>
                                <p class="m-0">{{ $stp->user->first_name }} {{ $stp->user->last_name }}</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Contact No : </p>
                                <p class="m-0">{{ $stp->user->contact_no }}</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Email : </p>
                                <p class="m-0">{{ $stp->user->email }}</p>
                            </div>

                            <div class="col-md-12">
                                <h6 class="font-bold bg-gray-200 px-2 py-2">Plan Details
                                    <span class="badge bg-{{ $stp->plan->plan_status ? 'danger' : 'success' }}">{{ $stp->plan_status ? 'Expired' : 'Running' }}</span> </h6>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Title : </p>
                                <p class="m-0">{{ $stp->plan->title }}</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Duration : </p>
                                <p class="m-0">{{ $stp->plan->duration }} Months</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Started On : </p>
                                <p class="m-0">{{ date('M d Y', strtotime($stp->plan_start_date)) }}</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">End On : </p>
                                <p class="m-0">{{ date('M d Y', strtotime($stp->plan_end_date)) }}</p>
                            </div>


                            <div class="col-md-12">
                                <h6 class="font-bold bg-gray-200 px-2 py-2">Pump Details</h6>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">ID : </p>
                                <p class="m-0">{{ $stp->id }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Serial No. : </p>
                                <p class="m-0">{{ $stp->serial_no }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Mobile No. : </p>
                                <p class="m-0">{{ $stp->mobile_no }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">IMEI No. : </p>
                                <p class="m-0">{{ $stp->imei_no }}</p>
                            </div>


                            <div class="col-md-2">
                                <p class="m-0 text-label">Title : </p>
                                <p class="m-0">{{ $stp->title }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Manufacturer : </p>
                                <p class="m-0">{{ $stp->manufacturer }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Registered On : </p>
                                <p class="m-0">{{ date('M d Y', strtotime($stp->created_at)) }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Cordinates : </p>
                                <p class="m-0">Lat : {{ $stp->latitude }}</p>
                                <p class="m-0">Long : {{ $stp->longitude }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">On / Off Status : </p>
                                <span class="badge bg-{{ $stp->on_off_status ? 'danger' : 'success' }}">{{ $stp->on_off_status ? 'OFF' : 'ON' }}</span>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Auto / Manual : </p>
                                <span class="badge bg-{{ $stp->auto_manual ? 'danger' : 'success' }}">{{ $stp->auto_manual ? 'Manual' : 'Auto' }}</span>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Tested : </p>
                                <span class="badge bg-{{ $stp->tested ? 'danger' : 'success' }}">{{ $stp->tested ? 'Un-Tested' : 'Tested' }}</span>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">visiable : </p>
                                <span class="badge bg-{{ $stp->visiable ? 'danger' : 'success' }}">{{ $stp->visiable ? 'Hidden' : 'Visiable' }}</span>
                            </div>

                            <div class="col-md-12">
                                <p class="m-0 text-label">Address : </p>
                                <p class="m-0 ">{{ $stp->address }}</p>
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
