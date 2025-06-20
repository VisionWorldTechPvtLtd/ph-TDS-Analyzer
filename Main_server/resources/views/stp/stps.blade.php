@extends('stp.layouts.app')

@section('title', $pump->title)

@section('content')

    @include('stp.layouts.partials.header')


    @include('stp.layouts.partials.sidebar')


    <main id="main" class="main">

        @include('stp.layouts.partials.breadcrums')

        @include('stp.layouts.partials.alerts')

        <section class="section dashboard">
          <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $pump->title }} <span>| {{ $pump->serial_no }}</span></h5>
                        <hr>

                        <div class="row g-3">

                            <div class="col-md-12">
                                <h6 class="px-2 py-2 font-bold bg-gray-200">Plan Details
                                    <span class="badge bg-{{ $pump->plan->plan_status ? 'danger' : 'success' }}">{{ $pump->plan_status ? 'Expired' : 'Running' }}</span> </h6>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Title : </p>
                                <p class="m-0">{{ $pump->plan->title }}</p>
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
                                <h6 class="px-2 py-2 font-bold bg-gray-200">Panel Details</h6>
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
                                <p class="m-0">{{ $pump->user_key }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Title : </p>
                                <p class="m-0">{{ $pump->title }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Manufacturer : </p>
                                <p class="m-0">{{ $pump->manufacturer }}</p>
                            </div>

                            <div class="col-md-2">
                                <p class="m-0 text-label">Cordinates : </p>
                                <p class="m-0">Lat : {{ $pump->latitude }}</p>
                                <p class="m-0">Long : {{ $pump->longitude }}</p>
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


    @include('stp.layouts.partials.footer')

@endsection
