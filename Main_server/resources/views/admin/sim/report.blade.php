@extends('admin.layouts.app')

@section('title', 'Report')

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
                    <div class="filter  mr-4">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">report<span>|Sim </span></h5>
                        <a href="{{ route('sim.active') }}" ><button type="button" class="btn btn-danger" >Attach</button></a>
                        <a href="{{ route('sim.remaining') }}" ><button type="button" class="btn btn-success" >Non-Attach</button></a>
                        <hr>
                        <div class=" table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">B-Id</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Sim IMSI  </th>
                                        <th scope="col">Sim Number </th>
                                        <th scope="col">Sim Purchase</th>
                                        <th scope="col">Sim Start Date</th>
                                        <th scope="col">Sim End Date</th>
                                    </tr>
                                </thead>
                                <tbody>

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

