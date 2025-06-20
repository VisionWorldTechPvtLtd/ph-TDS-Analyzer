@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('content')

@include('admin.layouts.partials.header')
@include('admin.layouts.partials.sidebar')

<main id="main" class="main">

    @include('admin.layouts.partials.breadcrums')
    @include('admin.layouts.partials.alerts')

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>Create New Product</h5>
                        </div>
                        <div class="card-body">
                            @if (Session::has('Message_sent'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('Message_sent') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="mt-3 form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name" required>
                                </div>

                                <div class="mt-3 form-group">
                                    <label for="image"></label>
                                    <input type="file" name="image" id="image" class="form-control-file" accept="image/*" required>
                                </div>

                                <div class="mt-3 form-group">
                                    <label for="url">Product URL</label>
                                    <input type="url" name="url" id="url" class="form-control" placeholder="Enter product URL" required>
                                </div>

                                <div class="mt-3 form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter description..." required></textarea>
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
