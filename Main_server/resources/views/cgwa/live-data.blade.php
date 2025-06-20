@extends('cgwa.layouts.app')

@section('title', 'Borewell Data')

@section('content')

@include('cgwa.layouts.partials.header')

@include('cgwa.layouts.partials.sidebar')

<main id="main" class="main">

    @include('cgwa.layouts.partials.breadcrums')

    @include('cgwa.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"> Borewell Data <span>| all</span></h5>
                        <a href="#" class="btn btn-success">Online</a>
                        <a href="#" class="btn btn-danger">Offline</a>
                        <button id="exportBtn" class="btn btn-dark">Excel</button>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless datatable" id="report">
                                <thead>
                                    <tr class="bg-info text-light">
                                        <th scope="col">S.No</th>
                                        <th scope="col" class="bg-info text-light">B-ID</th>
                                        <th scope="col">FLM S.No</th>
                                        <th scope="col">B-Title</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">CF</th>
                                        <th scope="col">TF</th>
                                        <th scope="col">FF</th>
                                        <th scope="col">GWL</th>
                                        <th scope="col">DateTime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($pumpData)
                                    @foreach ($pumpData as $index => $pump)
                                    @php
                                    $row_class = strtotime(date('Y-m-d', strtotime($pump->updated_at))) == strtotime(date('Y-m-d')) ? 'bg-success' : 'bg-danger';
                                    @endphp

                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="bg-info text-light">{{ $pump->id }}</td>
                                        <td>{{ $pump->serial_no }}</td>
                                        <td>{{ $pump->pump_title }}</td>
                                        <td>{{ $pump->company }}</td>
                                        <td>{{ $pump->current_flow }}</td>
                                        <td>{{ number_format($pump->forward_flow - $pump->morning_flow, 2) }}</td>
                                        <td>{{ $pump->forward_flow }}</td>
                                        <td>{{ $pump->ground_water_level }}</td>
                                        <td class="text-light {{ $row_class }}">
                                            {{ date('M d Y h:i:s A', strtotime($pump->updated_at)) }}
                                        </td>
                                    </tr>
                                    @endforeach
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

@include('cgwa.layouts.partials.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var rows = document.querySelectorAll('.datatable tbody tr');

        function showAllRows() {
            rows.forEach(function(row) {
                row.style.display = 'table-row';
            });
        }

        showAllRows();

        document.querySelector('.btn-success').addEventListener('click', function(e) {
            e.preventDefault();

            rows.forEach(function(row) {
                var dateStr = row.querySelector('td:last-child').textContent;
                var rowDate = new Date(dateStr);

                if (isToday(rowDate)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        document.querySelector('.btn-danger').addEventListener('click', function(e) {
            e.preventDefault();

            rows.forEach(function(row) {
                var dateStr = row.querySelector('td:last-child').textContent;
                var rowDate = new Date(dateStr);

                if (!isToday(rowDate)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        function isToday(date) {
            var today = new Date();
            return date.getDate() === today.getDate() &&
                date.getMonth() === today.getMonth() &&
                date.getFullYear() === today.getFullYear();
        }
    });


    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("exportBtn").addEventListener("click", function() {
            exportTableToExcel('report', 'CMC_Report.xlsx');
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
