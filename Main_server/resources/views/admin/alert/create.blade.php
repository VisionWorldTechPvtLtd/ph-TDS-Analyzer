++@extends('admin.layouts.app')

@section('title', 'Create Alert')

@section('content')

@include('admin.layouts.partials.header')


@include('admin.layouts.partials.sidebar')


<main id="main" class="main">

    @include('admin.layouts.partials.breadcrums')

    @include('admin.layouts.partials.alerts')

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
                           {{-- <form method="POST" action="{{ route('alert.store') }}" enctype="multipart/form-data"> --}}
                            <form method="POST" action="{{ route('alert.store') }}" enctype="multipart/form-data">
                                @csrf                              
                                <div class="mt-2 form-group">
                                    <textarea name="alert" id="alert" class="mt-3 form-control" rows="4" placeholder="Enter alert message here..."></textarea>
                                </div>
                                <div class="mt-2 form-group">
                                    <select name="disable" id="disable" class="mt-3 form-control">
                                        <option value="1">Enable</option>
                                        <option value="0">Disable</option>
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
