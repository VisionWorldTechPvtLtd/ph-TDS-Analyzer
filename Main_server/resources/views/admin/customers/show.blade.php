@extends('admin.layouts.app')

@section('title', $customer->first_name." ".$customer->last_name)

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
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('customers.edit', $customer->id) }}">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $customer->first_name }} {{ $customer->last_name }} <span>| customer</span></h5>
                        <hr>

                        <div class="row g-3">

                            <div class="col-md-12">
                                <h6 class="font-bold bg-gray-200 px-2 py-2">Customer Details
                                    @if ($customer->status)
                                        <span class="badge bg-danger mx-4">In-Active</span>
                                    @else
                                    <span class="badge bg-success mx-4">Active</span>
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
                                <h6 class="font-bold bg-gray-200 px-2 py-2">Pump Details </h6>
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
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
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
                                                    <td>
                                                        @if ($pump->plan_status)
                                                            <span class="badge bg-danger">Expired</span>
                                                        @else
                                                            <span class="badge bg-success">On-Going</span>
                                                        @endif

                                                        @if ($pump->external)
                                                            <span class="badge bg-danger">External</span>
                                                        @else
                                                            <span class="badge bg-success">Internal</span>
                                                        @endif

                                                        @if ($pump->tested)
                                                            <span class="badge bg-success">Tested</span>
                                                        @else
                                                            <span class="badge bg-danger">Un-Tested</span>
                                                        @endif

                                                    </td>
                                                    <td class="action">
                                                        <a href="{{ route('pumps.show', $pump->id) }}" class="btn btn-info btn-sm">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </a>
                                                        <a href="{{ route('pumps.edit', $pump->id) }}" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        {{-- <form method="post" id="delete-form" action="{{ route('pumps.destroy', $pump->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </form> --}}
                                                    </td>
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


    @include('admin.layouts.partials.footer')

@endsection
