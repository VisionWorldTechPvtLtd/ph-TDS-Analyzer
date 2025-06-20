@extends('layouts.app')

@section('title','Analyzer')

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
                        <h5 class="card-title"> Analyzer <span>| all</span></h5>
                        <hr>
                        <div class=" table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="text-light bg-info">
                                        <th scope="col">S.No</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Serial No.</th>
                                        <th scope="col">Title</th>
                                        {{-- <th scope="col">Last Calibration Date</th> --}}
                                        <th scope="col">Plan</th>
                                        <th scope="col">Plan Status</th>
                                        <th scope="col">View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($pumps) && $pumps->count())
                                    @foreach ($pumps as $pump)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <th>{{ $pump->id }}</th>
                                        <td>{{ $pump->serial_no }}</td>
                                        <td>{{ $pump->title }}</td>
                                        <td>{{ $pump->plan->title }} ({{ $pump->plan->duration }} Months)</td>
                                        <td>
                                            @if ($pump->plan_status)
                                            <span class="badge bg-danger">Expired</span>
                                            @else
                                            <span class="badge bg-success">On-Going</span>
                                            @endif
                                        </td>
                                        <td class="action">
                                            <a href="{{ route('stp.stps', $pump->id) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="9" class="text-center">No STP pumps found.</td>
                                    </tr>
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


@include('stp.layouts.partials.footer')

@endsection
