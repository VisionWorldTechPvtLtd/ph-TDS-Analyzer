@extends('admin.layouts.app')

@section('title', 'OverFlow Report')

@section('content')

@include('admin.layouts.partials.header')
@include('admin.layouts.partials.sidebar')

<main id="main" class="main">
    @include('admin.layouts.partials.breadcrums')
    @include('admin.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">
            <!-- Search Form -->
            <div class="mb-4 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <hr>
                        <form class="row g-3" method="POST" action="{{ route('overflow.report.data') }}">
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

            <!-- Report Table -->
            <div class="mb-4 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            Overflow Report
                            <button class="btn btn-dark" onclick="htmlTableToExcel('xlsx', 'report')">Export to Excel</button>
                        </h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless datatable" id="report">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Company Name</th>
                                        <th>Contact</th>
                                        <th>User Limit</th>
                                        <th>Total Flow</th>
                                        <th>Over Flow</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(session('report_data'))
                                        @foreach (session('report_data') as $reportData)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{ $reportData->company }}</td>
                                                <td>{{ $reportData->contact_no ?? 'N/A' }}</td>
                                                <td>{{ $reportData->user_limit }}</td>
                                                <td>{{ $reportData->today_flow }}</td>
                                                <td>{{ $reportData->overflow }}</td>
                                                <td>{{ \Carbon\Carbon::parse($reportData->created_at)->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">No data available</td>
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

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function htmlTableToExcel(type, id) {
        var data = document.getElementById(id);
        var excelFile = XLSX.utils.table_to_book(data, { sheet: "Overflow Report" });
        XLSX.writeFile(excelFile, 'Overflow_Report.' + type);
    }
</script>

@endsection
