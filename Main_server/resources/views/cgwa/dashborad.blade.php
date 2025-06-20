@extends('cgwa.layouts.app')

@section('title', 'Dashboard')

@section('content')

    @include('cgwa.layouts.partials.header')


    @include('cgwa.layouts.partials.sidebar')


    <main id="main" class="main">

        @include('cgwa.layouts.partials.breadcrums')

        @include('cgwa.layouts.partials.alerts')

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
                        @include('cgwa.layouts.partials.icons', ['icon' => 'inr', 'w' => 30, 'h' => 30 ])
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
                        @include('cgwa.layouts.partials.icons', ['icon' => 'inr', 'w' => 30, 'h' => 30 ])
                      </div>
                      <div class="ps-3">
                        <h6>{{ count($allPumpsPlanExpires) }}</h6>
                      </div>
                    </div>
                  </div>

                </div>

            </div>
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
        </section>

      </main><!-- End #main -->


    @include('cgwa.layouts.partials.footer')

@endsection
