
@extends('admin.layouts.app')

@section('title', ' AMC /CMC')

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
                        <h5 class="card-title">AMC/CMC<span>| all</span></h5>
                        <a href="{{ route('admin.amc') }}" ><button type="button" class="btn btn-warning" > AMC</button></a>
                        <a href="{{route('admin.cmc')}}" ><button type="button" class="btn btn-success"> CMC</button></a>
                        <a href="{{route('admin.nothing')}}" ><button type="button" class="btn btn-danger">Nothing </button></a>
                        <hr>
                        <div class=" table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="text-light bg-secondary ">
                                        <th scope="col">S.No</th>
                                        <th scope="col">Borewell ID</th>
                                        <th scope="col">Name </th>
                                        <th scope="col">Company</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
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




