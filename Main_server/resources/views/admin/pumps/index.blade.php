@extends('admin.layouts.app')

@section('title', 'Borewell')

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

                {{-- <div class="card">
                    <div class="mr-4 filter">
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('pumps.create') }}">
                <i class="bi bi-plus"></i> Borewell
                </a>
            </div> --}}
            <div class="card-body">
                {{-- <h5 class="card-title"> Borewell <span>| all</span></h5> --}}
                <br>
                <div class=" table-responsive">
                    <table class="table table-borderless datatable">
                        <thead>
                            <tr class="text-light bg-secondary">
                                <th scope="col">S.NO</th>
                                <th scope="col">Borewell Title</th>
                                <th scope="col">Borewell-ID</th>
                                <th scope="col">Company</th>
                                {{-- <th scope="col">Alarm</th> --}}
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
                                <td>
                                    {{ date('M d Y', strtotime($pump->last_calibration_date)) }}
                                    @if($pump->show_calibration_alarm)
                                    <i class="bi bi-bell-fill" style="color:red; font-size:18px;" title="Calibration due in {{ $pump->calibration_remaining_days }} days"></i>
                                    @endif
                                </td>
                                <td>{{ date('M d Y', strtotime($pump->plan_end_date)) }}
                                    @if($pump->show_alarm)
                                    <i class="bi bi-bell-fill" style="color:red; font-size:18px;" title="Plan ends in {{ $pump->remaining_days }} days"></i>
                                    @endif
                                </td>
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
