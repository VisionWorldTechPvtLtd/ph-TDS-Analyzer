@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

    @include('layouts.partials.header')


    @include('layouts.partials.sidebar')


    <main id="main" class="main">

        @include('layouts.partials.breadcrums')

        @include('layouts.partials.alerts')

        <section class="section dashboard">
          <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12 mb-4">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">STP Report</h5>

                        <form method="POST" action="{{ route('export.report') }}">
                            @csrf
                            <input type="hidden" name="data" value="{{ session('report_data') }}">
                            <button type="submit" class="btn btn-success">Export</button>
                        </form>
                        <hr>
                        <!-- Floating Labels Form -->
                        <form class="row g-3" method="POST" action="{{ route('report.data') }}">
                            @csrf



                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="stp_id" aria-label="Customer" name="stp_id">
                                        <option value="" data-user="0">STP </option>
                                        @if($stps)
                                            @foreach ($stps as $stp)
                                                <option value="{{ $stp->id }}" >{{ $stp->title }} </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label for="stp_id">STP *</label>
                                </div>
                                @error('stp_id')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input class="form-select" id="from" type="date" name="from" />
                                    <label for="from">From *</label>
                                </div>
                                @error('from')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input class="form-select" id="to" type="date" name="to" />
                                    <label for="to">To *</label>
                                </div>
                                @error('to')
                                    <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form><!-- End floating Labels Form -->

                    </div>

                </div>

            </div><!-- End Left side columns -->



          </div>
        </section>

      </main><!-- End #main -->


    @include('layouts.partials.footer')


@endsection
