@extends('admin.layouts.app')

@section('title', 'Negative Report')

@section('content')

@include('admin.layouts.partials.header')
@include('admin.layouts.partials.sidebar')

<main id="main" class="main">
    @include('admin.layouts.partials.breadcrums')
    @include('admin.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">
            <!-- Search Form Section -->
            <div class="mb-4 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <hr>
                        <form class="row g-3" method="POST" action="{{ route('negative.report.data') }}">
                            @csrf
                            <div class="col-md-4">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" id="month" type="month" name="month" required />
                                    <label for="month">Month *</label>
                                </div>
                                <div class="text-left">
                                    <button type="submit" class="btn btn-dark">SEARCH</button>
                                </div>
                                @error('month')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Report Data Section -->
            <div class="mb-4 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless datatable" id="report">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Borewell ID</th>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Forward Flow</th>
                                        <th scope="col">Reverse Flow</th>
                                        <th scope="col">Ground Water Level</th>
                                        <th scope="col">Totalizer</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(session('report_data'))
                                    @foreach (session('report_data') as $reportData)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $reportData->pump_id }}</td>
                                        <td>{{ $reportData->company }}</td>
                                        <td>{{ $reportData->forward_flow }}</td>
                                        <td>{{ $reportData->reverse_flow }}</td>
                                        <td>{{ $reportData->ground_water_level }}</td>
                                        <td>{{ $reportData->totalizer }}</td>
                                        <td>{{ date('M d Y', strtotime($reportData->created_at)) }}</td>
                                        <td class="action">
                                            <!-- Action buttons can be added here -->
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="11" class="text-center">No data available</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('admin.layouts.partials.footer')

@endsection
