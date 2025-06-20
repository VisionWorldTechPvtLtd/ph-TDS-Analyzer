@extends('admin.layouts.app')

@section('title', 'Plan End ')

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
                    <div class="mr-4 filter">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"> Plan <span>| End</span></h5>

                        <div class=" table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="text-light bg-secondary ">
                                        <th scope="col">S.No</th>
                                        <th scope="col">B-ID</th>
                                        <th scope="col">Name </th>
                                        <th scope="col">Company Name </th>
                                        <th scope="col">Sim Number</th>
                                        <th scope="col">Plan End Date</th>
                                        <th scope="col">Sim End Date </th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($allPumpsPlanExpires)
                                    @foreach ($allPumpsPlanExpires as $pump)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $pump->id }}</td>
                                        <td>{{ $pump->first_name }} {{ $pump->last_name }}</td>
                                        <td style="word-wrap: break-word; max-width: 200px;">{{$pump->company }}</td>
                                        <td>{{ $pump->sim_number ?? 'N/A' }}</td>
                                        <td class="text-light bg-info">{{ date('M d Y', strtotime($pump->plan_end_date)) }}</td>
                                        <td class="text-light bg-danger">{{ $pump->sim_end ? date('M d Y', strtotime($pump->sim_end)) : 'N/A' }}</td>
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
