@extends('admin.layouts.app')

@section('title', 'AMC')

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
                    <div class="mr-4 filter"></div>
                    <div class="card-body">
                        <h5 class="card-title">AMC<span>| all</span></h5>
                        <a href="{{ route('admin.amc') }}"><button type="button" class="btn btn-warning">AMC</button></a>
                        <a href="{{ route('admin.cmc') }}"><button type="button" class="btn btn-success">CMC</button></a>
                        <a href="{{ route('admin.nothing') }}"><button type="button" class="btn btn-danger">Nothing</button></a>

                        {{-- <h5 class="card-title" style="display: flex; justify-content: space-between;"> --}}
                        {{-- <span>Report Data</span> --}}
                        <button id="exportBtn" class="btn btn-dark">Excel</button>
                        </h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless datatable" id="report">
                                <thead>
                                    <tr class="text-light bg-secondary ">
                                        <th scope="col">S.No</th>
                                        <th scope="col">Borewell ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
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
                                        <td>{{ $pump->user->address }}</td>
                                        <td class="text-light bg-warning">{{ date('M d Y', strtotime($pump->created_at)) }}</td>
                                        <td class="action">
                                            <a href="{{ route('pumps.show', $pump->id) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye-fill"></i>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("exportBtn").addEventListener("click", function() {
            exportTableToExcel('report', 'AMC_Report.xlsx');
        });
    });

    function exportTableToExcel(tableID, filename = '') {
        var elt = document.getElementById(tableID);
        if (!elt) {
            console.error('Table element with ID ' + tableID + ' not found');
            alert("Table not found!");
            return;
        }
        var wb = XLSX.utils.table_to_book(elt, {
            sheet: "Sheet JS"
        });
        XLSX.writeFile(wb, filename || 'report.xlsx');
    }

</script>

@endsection
