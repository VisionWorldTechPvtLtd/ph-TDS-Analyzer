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
            <!-- Right side columns -->
            <div class="col-lg-3">


                <div class="card info-card revenue-card">

                  <div class="card-body">
                    <h5 class="card-title">Customers <span>| all</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-badge"></i>
                      </div>
                      <div class="ps-3">
                        <h6>{{ count($allCustomers)}}</h6>
                      </div>
                    </div>
                  </div>

                </div>

            </div>

            <div class="col-lg-3">


                <div class="card info-card revenue-card">

                  <div class="card-body">
                    <h5 class="card-title">Plans <span>| all</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        @include('admin.layouts.partials.icons', ['icon' => 'inr', 'w' => 30, 'h' => 30 ])
                      </div>
                      <div class="ps-3">
                        <h6>{{ count($allPlans)}}</h6>
                      </div>
                    </div>
                  </div>

                </div>

            </div>

            <div class="col-lg-3">


                <div class="card info-card revenue-card">

                  <div class="card-body">
                    <h5 class="card-title">Total Borewell <span>| all</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-droplet"></i>
                      </div>
                      <div class="ps-3">
                        <h6>{{ count($allPumps)}}</h6>
                      </div>
                    </div>
                  </div>

                </div>

            </div>


            <div class="col-lg-3">


                <div class="card info-card customers-card">

                  <div class="card-body">
                    <h5 class="card-title">Plan Expires Soon<span>|all</span></h5>

                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        @include('admin.layouts.partials.icons', ['icon' => 'inr', 'w' => 30, 'h' => 30 ])
                      </div>
                      <div class="ps-3">
                        <h6>{{ count($allPumpsPlanExpires) }}</h6>
                      </div>
                    </div>
                  </div>

                </div>

            </div>

            <!-- Left side columns -->
            {{-- <div class="col-lg-12">

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

                </div> --}}
                <div style="height: 350px;">
                  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                  <canvas id="myChart" style="width: 100%; max-width: 630px; background-color: transparent;"></canvas>
                  <script>
                      var totalPumps = {{ $allPumps->count() }};
                      var customers = {{ $allCustomers->count() }};
                      var pumpDataCount = {{ $pumpdata->count() }};
                      var pumpofflineCount = {{ $pumpoffline->count() }};

                      // alert('{{ $pumpdata->count() }}');

                      var xValues = ["Online", "Offline", "Customers", "Total Pump"];
                      var yValues = [pumpDataCount, pumpofflineCount, customers, totalPumps];
                      var barColors = ["green", "red", "orange", "rgb(23, 162, 184)"];

                      new Chart("myChart", {
                          type: "bar",
                          data: {
                              labels: xValues,
                              datasets: [{
                                  backgroundColor: barColors,
                                  data: yValues,
                              }]
                          },
                          options: {
                              legend: {
                                  display: false
                              },
                              title: {
                                  display: true,
                                  text: "Borwell Live Data",
                              },
                              scales: {
                                  xAxes: [{
                                      gridLines: {
                                          display: false
                                      },
                                      barPercentage: 0.68,
                                      categoryPercentage: 0.68
                                  }],
                                  yAxes: [{
                                      gridLines: {
                                          display: false
                                      }
                                  }]
                              },
                              layout: {
                                  padding: {
                                      left: 0,
                                      right: 0,
                                      top: 0,
                                      bottom: 0
                                  }
                              }
                          }
                      });
                  </script>
              </div>
                {{-- <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Borewell Plan Expires soon <span>| all</span></h5>
                        <div class=" table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="text-light bg-danger">
                                        <th scope="col">#</th>
                                        <th scope="col">Borewell ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Serial No.</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Expiry Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @isset($allPumpsPlanExpires)
                                  @foreach ($allPumpsPlanExpires as $pump)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <th>{{ $pump->id }}</th>
                                            <td>{{ $pump->pump_title }}</td>
                                            <td>{{ $pump->serial_no }}</td>
                                            <td>{{ $pump->user->first_name }} {{ $pump->user->last_name }}</td>
                                            <td class="text-light bg-danger">{{ date('M d Y', strtotime($pump->plan_end_date)) }}</td>
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



          </div> --}}
        </section>

      </main><!-- End #main -->


    @include('admin.layouts.partials.footer')

@endsection
