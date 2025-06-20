@extends('admin.layouts.app')

@section('title', 'HWAR Piezometer API')

@section('content')

@include('admin.layouts.partials.header')


@include('admin.layouts.partials.sidebar')


<main id="main" class="main">

    @include('admin.layouts.partials.breadcrums')

    @include('layouts.partials.alerts')
    <section style="padding-top:60px; background-color: rgb(231, 231, 226);">
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            @if (Session::has('Message_sent'))
                            <div class="alert alert-success" role="alert">
                                {{Session::get('Message_sent')}}
                            </div>
                            @endif
                            <form method="POST" action="{{route('HWARstore') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mt-2 form-group">
                                    <input type="text" name="nocnumber" class="mt-3 form-control" id="nocnumber" placeholder="Noc Number" />
                                </div>
                                <div class="mt-2 form-group">
                                    <input type="text" name="userkey" class="mt-3 form-control" id="userkey" placeholder="User Key" />
                                </div>
                                <div class="mt-2 form-group">
                                    <input type="text" name="companyname" class="mt-3 form-control" id="companyname" placeholder="Company Name" />
                                </div>
                                <div class="mt-2 form-group">
                                    <input type="text" name="piezostructurenumber" class="mt-3 form-control" id="piezostructurenumber" placeholder="Piezo Structure Number" />
                                </div>
                                <div class="mt-2 form-group">
                                    <input type="text" name="latitude" class="mt-3 form-control" id="latitude" placeholder="Latitude" />
                                </div>
                                <div class="mt-2 form-group">
                                    <input type="text" name="longitude" class="mt-3 form-control" id="longitude" placeholder="Longitude" />
                                </div>
                                <div class="mt-2 form-group">
                                    <input type="text" name="vendorfirmsname" class="mt-3 form-control" id="vendorfirmsname" placeholder="Vendor Firms Name" />
                                </div>
                                <div class="mt-2 form-group">
                                    <select class="form-select" id="b_id" aria-label="b_id" name="b_id" placeholder="Borewell">
                                        <option value="" data-user="0">Select Borewell</option>
                                        @if($pump)
                                        @foreach ($pump as $p)
                                        <option value="{{ $p->id }}">{{ $p->pump_title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <button type="submit" class="float-right mt-3 btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->


@include('admin.layouts.partials.footer')

@endsection
