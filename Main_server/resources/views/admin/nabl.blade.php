@extends('admin.layouts.app')

@section('title', 'NABL')

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
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"> Nabl <span>| all</span></h5>
                        <hr>
                        <div class=" table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="text-light bg-secondary ">
                                        <th scope="col">S.No</th>
                                        <th scope="col">B-ID</th>
                                        <th scope="col">Name </th>
                                        <th scope="col">Company Name </th>
                                        <th scope="col">Contact</th>
                                        <th scope="col">NABL Calibration On </th>
                                        <th scope="col">Action</th>
                                        {{-- <th scope="col">Created At</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($allPumpsPlanExpires)
                                    @foreach ($allPumpsPlanExpires as $pump)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $pump->id }}</td>
                                        <td>{{ $pump->user->first_name }} {{ $pump->user->last_name }}</td>
                                        <td>{{ $pump->user->company }}</td>
                                        <td>{{ $pump->user->contact_no }}</td>
                                        <td class="text-light bg-warning">{{ date('M d Y', strtotime($pump->last_calibration_date)) }}</td>
                                        {{-- <td class="text-light bg-info">{{ date('M d Y', strtotime($pump->created_at)) }}</td> --}}
                                        <td class="action">
                                            <a href="{{ route('pumps.show', $pump->id) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="{{ route('nable.data.edit', $pump->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endisset
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
