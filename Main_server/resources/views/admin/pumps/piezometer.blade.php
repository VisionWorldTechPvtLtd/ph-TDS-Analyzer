@extends('admin.layouts.app')

@section('title', 'Piezometer')

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
                        <h5 class="card-title"></h5>
                        <br>
                        <div class=" table-responsive" style="margin-top:-60px;">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="text-light bg-secondary">
                                        <th scope="col">S.NO</th>
                                        <th scope="col">Piezometer Title</th>
                                        <th scope="col">Piezometer-ID</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Last_Calibration</th>
                                        <th scope="col">Plan_End_Date </th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($pumps)
                                    @foreach ($pumps as $pump)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $pump->pump_title }}</td>
                                        <th>{{ $pump->id }}</th>
                                        <td style="word-wrap: break-word; max-width: 200px;">{{ $pump->user->company }}</td>
                                        <td>{{ date('M d Y', strtotime($pump->last_calibration_date)) }}</td>
                                        <td>{{ date('M d Y', strtotime($pump->plan_end_date)) }}
                                        <td class="action">
                                            <a href="{{ route('pumps.show', $pump->id) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="{{ route('pumps.edit', $pump->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form method="post" id="delete-form" action="{{ route('pumps.destroy', $pump->id) }}">
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
