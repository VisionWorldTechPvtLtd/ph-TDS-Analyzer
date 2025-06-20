@extends('cgwa.layouts.app')

@section('title', $customer->first_name." ".$customer->last_name)

@section('content')

    @include('cgwa.layouts.partials.header')


    @include('cgwa.layouts.partials.sidebar')


    <main id="main" class="main">

        @include('cgwa.layouts.partials.breadcrums')

        @include('cgwa.layouts.partials.alerts')

        <section class="section dashboard">
          <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">

                <div class="card">
                    <div class="mr-4 filter">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $customer->first_name }} {{ $customer->last_name }} <span>| customer</span></h5>
                        <hr>

                        <div class="row g-3">

                            <div class="col-md-12">
                                <h6 class="px-2 py-2 font-bold bg-gray-200">Customer Details
                                    @if ($customer->status)
                                        <span class="mx-4 badge bg-danger">In-Active</span>
                                    @else
                                    <span class="mx-4 badge bg-success">Active</span>
                                    @endif

                                    @if ($customer->manual_settings)
                                        <span class="badge bg-danger">Manual On-Off</span>
                                    @else
                                        <span class="badge bg-success">Live Data</span>
                                    @endif
                                </h6>
                            </div>

                            <div class="col-md-2">
                               <img src="{{ asset($customer->profile_pic) }}" class="" width="50px" />
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Email : </p>
                                <p class="m-0">{{ $customer->email }}</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Contact No : </p>
                                <p class="m-0">{{ $customer->contact_no }}</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Company : </p>
                                <p class="m-0">{{ $customer->company }}</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Address : </p>
                                <p class="m-0">{{ $customer->address }} {{ $customer->city }} {{ $customer->state }} {{ $customer->pincode }}</p>
                            </div>


                            <div class="col-md-12">
                                <h6 class="px-2 py-2 font-bold bg-gray-200">Pump Details </h6>
                            </div>

                            <div class=" table-responsive">
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Pump ID</th>
                                            <th scope="col">Serial No.</th>
                                            <th scope="col">Pump Title</th>
                                            <th scope="col">Pipe Size</th>
                                            <th scope="col">Last Calibration Date</th>
                                            <th scope="col">Plan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($customer->pumps)
                                            @foreach ($customer->pumps as $pump)
                                                <tr>
                                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                                    <th>{{ $pump->id }}</th>
                                                    <td>{{ $pump->serial_no }}</td>
                                                    <td>{{ $pump->pump_title }}</td>
                                                    <td>{{ $pump->pipe_size }}</td>
                                                    <td>{{ date('M d Y', strtotime($pump->last_calibration_date)) }}</td>
                                                    <td>{{ $pump->plan->title }} ({{ $pump->plan->duration }} Months)</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>


                        </div>




                    </div>

                </div>

            </div><!-- End Left side columns -->


          </div>
        </section>

      </main><!-- End #main -->


    @include('cgwa.layouts.partials.footer')

@endsection
