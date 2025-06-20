@extends('admin.layouts.app')

@section('title', 'Customers')

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
                <div class="card-body">
                    <!-- <h5 class="card-title"> Customers <span>| all</span></h5> -->
                    <br>
                    <div class=" table-responsive">
                        <table class="table table-borderless datatable">
                            <thead>
                                <tr class="text-light bg-info">
                                    <th scope="col">S.No</th>
                                    <th scope="col">Profile Pic</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Contact No.</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Company</th>
                                    <th scope="col">Registered On</th>
                                    <!-- <th scope="col">Status</th> -->
                                    <th scope="col">Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($customers)
                                @foreach ($customers as $customer)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <th><img src="{{ asset($customer->profile_pic) }}" class="rounded" width="40" /></th>
                                    <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                                    <td>{{ $customer->contact_no }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->company }}</td>
                                    <td>{{ date('M d Y', strtotime($customer->created_at )) }}</td>
                                    <!-- <td>
                                        @if ($customer->status)
                                        <span class="badge bg-danger">Not Active</span>
                                        @else
                                        <span class="badge bg-success">Active</span>
                                        @endif

                                        @if ($customer->manual_settings)
                                        <span class="badge bg-danger">Manual On-Off</span>
                                        @else
                                        <span class="badge bg-success">Live Data</span>
                                        @endif

                                    </td> -->
                                    <td class="action">
                                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" id="delete-form" action="{{ route('customers.destroy', $customer->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div><!-- End Left side columns -->


        </div>
    </section>

</main><!-- End #main -->


@include('admin.layouts.partials.footer')

@endsection
