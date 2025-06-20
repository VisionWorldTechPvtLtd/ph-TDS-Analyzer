@extends('admin.layouts.app')

@section('title', $plan->title)

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
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('plans.edit', $plan->id) }}">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan->title }} &nbsp;&nbsp; <span class="badge bg-{{ $plan->visiable ? 'danger' : 'success' }}">{{ $plan->visiable ? 'Not-Visiable' : 'Visiable' }}</span> </h6></h5>
                        <hr>

                        <div class="row g-3">

                            <div class="col-md-4">
                                <p class="m-0 text-label">Duration : </p>
                                <p class="m-0">{{ $plan->duration }} Months</p>
                            </div>

                            <div class="col-md-3">
                                <p class="m-0 text-label">Price : </p>
                                <p class="m-0">Rs. {{ $plan->price }}/-</p>
                            </div>



                            <div class="col-md-12">
                                <p class="m-0 text-label">Descripion : </p>
                                <div class="m-0 ">{{ $plan->description }}</div>
                            </div>


                        </div>




                    </div>

                </div>

            </div><!-- End Left side columns -->


          </div>
        </section>

      </main><!-- End #main -->


    @include('admin.layouts.partials.footer')

@endsection
