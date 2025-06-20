@extends('admin.layouts.app')

@section('title', 'Borewell Report')

@section('content')

@include('admin.layouts.partials.header')
@include('admin.layouts.partials.sidebar')

<main id="main" class="main">
    @include('admin.layouts.partials.breadcrums')
    @include('admin.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="mb-4 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Borewell Report<span> | single</span></h5>
                        <hr>
                        <!-- Floating Labels Form -->
                        <form class="row g-3" method="POST" action="{{ route('pump.report.data') }}">
                            @csrf
                            <div class="col-md-4">
                                <div class="mb-3 form-floating">
                                    <select class="form-select" id="user_id" name="user_id">
                                        <option value="">Customer</option>
                                        @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }} ({{ $customer->company }})</option>
                                        @endforeach
                                    </select>
                                    <label for="user_id">Customer *</label>
                                </div>
                                @error('user_id')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 form-floating">
                                    <select class="form-select" id="pump_id" name="pump_id">
                                        <option value="" data-user="0">Borewell</option>
                                        @foreach ($pumps as $pump)
                                        <option value="{{ $pump->id }}" data-user="{{ $pump->user->id }}">{{ $pump->pump_title }}</option>
                                        @endforeach
                                    </select>
                                    <label for="pump_id">Borewell *</label>
                                </div>
                                @error('pump_id')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 form-floating">
                                    <input class="form-select" id="month" type="month" name="month" />
                                    <label for="month">Month *</label>
                                </div>
                                @error('month')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            <div class="text-left">
                                <button type="submit" class="btn btn-dark">SEARCH</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Report Data Section -->
            <div class="mb-4 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            <span>Report Data</span>
                            <button id="exportExcelBtn" class="btn btn-dark"> Excel</button>

                            @if(session('report_data') && session('report_data')->isNotEmpty())
                            <a href="{{ route('reports.data.edit', session('report_data')->first()->pdfd_id) }}" class="btn btn-dark btn-sm" style="margin-left:-745px;">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            @endif
                        </h5>

                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless datatable" id="report">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Borewell ID</th>
                                        <th scope="col">FLM S.No</th>
                                        <th scope="col">Borewell Title</th>
                                        <th scope="col">TF</th>
                                        <th scope="col">RF</th>
                                        <th scope="col">GWL</th>
                                        <th scope="col">TOT</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(session('report_data'))
                                    @foreach (session('report_data') as $reportData)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $reportData->first_name }} {{ $reportData->last_name }}</td>
                                        <td>{{ $reportData->id }}</td>
                                        <td>{{ $reportData->serial_no }}</td>
                                        <td>{{ $reportData->pump_title }}</td>
                                        <td>{{ $reportData->forward_flow }}</td>
                                        <td>{{ $reportData->reverse_flow }}</td>
                                        <td>{{ $reportData->ground_water_level }}</td>
                                        <td>{{ $reportData->totalizer }}</td>
                                        <td>{{ date('M d Y h:i:s A', strtotime($reportData->created_at)) }}</td>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter borewells based on customer selection
        let customerElement = document.getElementById('user_id');
        let pumpElement = document.getElementById('pump_id');

        customerElement.addEventListener('change', function() {
            pumpElement.value = '';
            Array.from(pumpElement.options).forEach(option => {
                option.style.display = option.dataset.user === customerElement.value ? 'block' : 'none';
            });
        });

        // Export table to Excel
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            var table = document.getElementById('report');
            if (!table) {
                console.error('Table element not found');
                return;
            }
            var wb = XLSX.utils.table_to_book(table, {
                sheet: "Sheet JS"
            });
            XLSX.writeFile(wb, 'Borewell Report.xlsx');
        });
    });

</script>

@endsection
