@extends('admin.layouts.app')

@section('title', 'Dashboard')

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
                        <h5 class="card-title">Reports <span>/Today</span></h5>

                        <!-- Line Chart -->
                        <div id="reportsChart"></div>

                        <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            new ApexCharts(document.querySelector("#reportsChart"), {
                            series: [{
                                name: 'Sales',
                                data: [31, 40, 28, 51, 42, 82, 56],
                            }, {
                                name: 'Revenue',
                                data: [11, 32, 45, 32, 34, 52, 41]
                            }, {
                                name: 'Customers',
                                data: [15, 11, 32, 18, 9, 24, 11]
                            }],
                            chart: {
                                height: 350,
                                type: 'area',
                                toolbar: {
                                show: false
                                },
                            },
                            markers: {
                                size: 4
                            },
                            colors: ['#4154f1', '#2eca6a', '#ff771d'],
                            fill: {
                                type: "gradient",
                                gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.3,
                                opacityTo: 0.4,
                                stops: [0, 90, 100]
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 2
                            },
                            xaxis: {
                                type: 'datetime',
                                categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                            },
                            tooltip: {
                                x: {
                                format: 'dd/MM/yy HH:mm'
                                },
                            }
                            }).render();
                        });
                        </script>
                        <!-- End Line Chart -->

                    </div>

                </div>


                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Unmounted Pumps <span>| all</span></h5>
                        <div class=" table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Pump ID</th>
                                        <th scope="col">Serial No.</th>
                                        <th scope="col">Pipe Size</th>
                                        <th scope="col">Last Calibration Date</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                    <th scope="row"><a href="#">1</a></th>
                                    <td><a href="#" class="text-primary">23</a></td>
                                    <td>ABD123</td>
                                    <td>2"</td>
                                    <td>DEC 12 2022</td>
                                    <td><span class="badge bg-success">Tested</span></td>
                                    </tr>
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
