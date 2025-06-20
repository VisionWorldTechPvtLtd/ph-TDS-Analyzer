@extends('stp.layouts.app')

@section('title', 'Dashboard')

@section('content')
@include('stp.layouts.partials.header')
@include('stp.layouts.partials.sidebar')

<main id="main" class="main" style="background-color: white; min-height: 100vh;">
    @include('stp.layouts.partials.breadcrums')
    @include('stp.layouts.partials.alerts')

    <section class="section dashboard">
        <!-- Pump Selection -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <select class="form-select" id="stp_id" name="stp_id" style="height: 3rem; background-color:white;">
                    <option value="">Select Analyzer</option>
                    @foreach ($pumps as $pump)
                    <option value="{{ $pump->id }}" data-user="{{ $pump->user_id }}">{{ $pump->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Static Cards Container -->
        <div id="stp-data-cards">
            <div class="row">
                <div class="col-md-3">
                    <div class="mt-4 text-white card bg-primary" style="width: 15rem; height: 10rem;">
                        <div class="text-center card-body d-flex align-items-center justify-content-center">
                            <h3 class="mb-0 fs-3">COD<br><br><span id="cod-value"></span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mt-4 text-white card bg-success" style="width: 15rem; height: 10rem;">
                        <div class="text-center card-body d-flex align-items-center justify-content-center">
                            <h3 class="mb-0 fs-3">BOD<br><br><span id="bod-value"></span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mt-4 text-white card bg-warning" style="width: 15rem; height: 10rem;">
                        <div class="text-center card-body d-flex align-items-center justify-content-center">
                            <h3 class="mb-0 fs-3">TOC<br><br><span id="toc-value"></span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mt-4 text-white card bg-secondary" style="width: 15rem; height: 10rem;">
                        <div class="text-center card-body d-flex align-items-center justify-content-center">
                            <h3 class="mb-0 fs-3">TSS<br><br><span id="tss-value"></span></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="mt-4 text-white card bg-info" style="width: 15rem; height: 10rem;">
                        <div class="text-center card-body d-flex align-items-center justify-content-center">
                            <h3 class="mb-0 fs-3">PH<br><br><span id="ph-value"></span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mt-4 text-white card bg-danger" style="width: 15rem; height: 10rem;">
                        <div class="text-center card-body d-flex align-items-center justify-content-center">
                            <h3 class="mb-0 fs-3">Temperature <br><br><span id="temperature-value"></span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mt-4 text-white card bg-dark" style="width: 15rem; height: 10rem;">
                        <div class="text-center card-body d-flex align-items-center justify-content-center">
                            <h3 class="mb-0 fs-3">EC<br><br><span id="ec-value"></span></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mt-4 text-white card bg-success" style="width: 15rem; height: 10rem;">
                        <div class="text-center card-body d-flex align-items-center justify-content-center">
                            <h3 class="mb-0 fs-3">TDS<br><br><span id="tds-value"></span></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AJAX Handler -->
<script>
    function resetValues() {
        $('#cod-value, #bod-value, #toc-value, #tss-value, #ph-value, #temperature-value, #tds-value, #ec-value').text('');
    }

    $('#stp_id').on('change', function() {
        const stpId = $(this).val();

        resetValues();

        if (stpId) {
            $.ajax({
                url: "{{ url('/stp/data') }}/" + stpId
                , method: 'GET'
                , success: function(data) {
                    $('#cod-value').text(data.cod || '');
                    $('#bod-value').text(data.bod || '');
                    $('#toc-value').text(data.toc || '');
                    $('#tss-value').text(data.tss || '');
                    $('#ph-value').text(data.ph || '');
                    $('#temperature-value').text(data.temperature || '');
                    $('#ec-value').text(data.h || '');
                    $('#tds-value').text(data.i || '');
                }
                , error: function() {
                    alert('No data available for this STP.');
                }
            });
        }
    });

</script>

@include('stp.layouts.partials.footer')
@endsection
