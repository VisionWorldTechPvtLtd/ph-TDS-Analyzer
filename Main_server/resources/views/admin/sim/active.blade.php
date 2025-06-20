@extends('admin.layouts.app')

@section('title', 'Active')

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
                        <h5 class="card-title">Active <span>| Sim</span></h5>
                        <a href="{{ route('sim.active') }}"><button type="button" class="btn btn-danger">Attach</button></a>
                        <a href="{{ route('sim.remaining') }}"><button type="button" class="btn btn-success">Non-Attach</button></a>

                        <button id="exportBtn" class="btn btn-dark">Excel</button>

                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless datatable" id="report">
                                <thead>
                                    <tr class="text-light bg-secondary">
                                        <th scope="col">S.No</th>
                                        <th scope="col">B-ID</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Sim IMSI</th>
                                        <th scope="col">Sim Number</th>
                                        <th scope="col">Sim Purchase</th>
                                        <th scope="col">Sim Start Date</th>
                                        <th scope="col">Sim End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($sims)
                                    @foreach ($sims as $sim)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $sim->pump_id }}</td>
                                        <td>{{ $sim->first_name }} {{$sim->last_name}} </td>
                                        <td>{{ $sim->company }}</td>
                                        <td>{{ $sim->sim_imei }}</td>
                                        <td>{{ $sim->sim_number }}</td>
                                        <td>{{ date('M d Y', strtotime($sim->sim_purchase)) }}</td>
                                        <td>{{ date('M d Y', strtotime($sim->sim_start)) }}</td>
                                        <td class="text-light bg-danger">{{ date('M d Y', strtotime($sim->sim_end))}}</td>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("exportBtn").addEventListener("click", function() {
            exportTableToExcel('report', 'active_Report.xlsx');
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
