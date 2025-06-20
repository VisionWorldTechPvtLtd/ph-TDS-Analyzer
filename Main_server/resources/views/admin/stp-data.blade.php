@extends('admin.layouts.app')

@section('title', 'STP Data')

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
                        <h5 class="card-title"> STP Data <span>| all</span></h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="bg-info text-light">
                                        <th scope="col">S.No</th>
                                        <th scope="col" class="bg-info text-light">ID</th>
                                        <th scope="col">FLM S.No</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">COD</th>
                                        <th scope="col">BOD</th>
                                        <th scope="col">TOC</th>
                                        <th scope="col">Turbidity</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">Temperature</th>
                                        <th scope="col">TDS</th>
                                        <th scope="col">EC</th>
                                        {{-- <th scope="col">Status</th> --}}
                                        <th scope="col">DateTime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($stpData)
                                    @foreach ($stpData as $stp)

                                    @php
                                    $row_class = strtotime(date('Y-m-d', strtotime($stp->updated_at))) == strtotime(date('Y-m-d')) ? 'bg-success' : 'bg-danger' ;
                                    @endphp

                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <th class="bg-info text-light">{{ $stp->id }}</th>
                                        <td>{{ $stp->serial_no }}</td>
                                        <td>{{ $stp->title }}</td>
                                        <td>{{ $stp->first_name }} {{ $stp->last_name }}</td>
                                        <td>{{ $stp->cod }}</td>
                                        <td>{{ $stp->bod }}</td>
                                        <td>{{ $stp->toc }}</td>
                                        <td>{{ $stp->tss }}</td>
                                        <td>{{ $stp->ph }}</td>
                                        <td>{{ $stp->temperature }}</td>
                                        <td>{{ $stp->i }}</td>
                                        <td>{{ $stp->h }}</td>
                                        {{-- <td>
                                            @if ($stp->plan_status)
                                            <span class="badge bg-danger">Expired</span>
                                            @else
                                            <span class="badge bg-success">On-Going</span>
                                            @endif

                                        </td> --}}
                                        <td class="text-light {{ $row_class }}">
                                            {{ date('M d Y h:i:s A', strtotime($stp->updated_at)) }}
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
