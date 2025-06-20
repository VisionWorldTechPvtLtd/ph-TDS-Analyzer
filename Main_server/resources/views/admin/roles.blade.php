@extends('admin.layouts.app')

@section('title', 'Create_Roles')

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
                            <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mt-2 form-group">
                                    <input type="text" name="roles" class="mt-3 form-control" id="roles" placeholder="Roles" />
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
