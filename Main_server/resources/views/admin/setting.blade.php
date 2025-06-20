@extends('admin.layouts.app')

@section('title', 'Setting')

@section('content')

@include('admin.layouts.partials.header')


@include('admin.layouts.partials.sidebar')


<main id="main" class="main">

    @include('admin.layouts.partials.breadcrums')

    @include('admin.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="container mt-3">
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <a href="http://visioncgwa.com/allplanend" onclick="return confirm('Are you sure you want to send the email?');" class="btn btn-info w-100">
                        Plan End Send Email Admin
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('admin.negative') }}" class="btn btn-danger w-100">
                        Negative Value
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('plans.index') }}" class="btn btn-danger w-100">
                        Plan End
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('admin.Haryana') }}" class="btn btn-secondary w-100">
                        HWRA FlowMeter
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('admin.HWRAPiezometer') }}" class="btn btn-secondary w-100">
                        HWRA PiezoMeter
                    </a>
                </div>

                <div class="col-12 col-md-4">
                    <a href="{{ route('alert.index') }}" class="btn btn-warning w-100">
                        Alerts
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('product.index') }}" class="btn btn-primary w-100">
                        Add Product
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('plans.index') }}" class="btn btn-primary w-100">
                        Add Plan
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('admin.overflow') }}" class="btn btn-info w-100">
                        OverFlow
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('admin.offline') }}" class="btn btn-secondary w-100">
                        Offline
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('admin.garbage') }}" class="btn btn-danger w-100">
                        Garbage Value
                    </a>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>

</main><!-- End #main -->


@include('admin.layouts.partials.footer')

@endsection
