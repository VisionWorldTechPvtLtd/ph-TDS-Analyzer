@extends('admin.layouts.app')

@section('title', 'Edit Product')

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
                            <h5>Edit Product</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mt-3 form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name" value="{{ old('product_name', $product->product_name) }}" required>
                                </div>

                                <div class="mt-3 form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                                    @if($product->image)
                                        <br>
                                        <img src="{{ asset($product->image) }}" width="80" class="mt-2" />
                                    @endif
                                </div>

                                <div class="mt-3 form-group">
                                    <label for="url">Product URL</label>
                                    <input type="url" name="url" id="url" class="form-control" placeholder="Enter product URL" value="{{ old('url', $product->url) }}" required>
                                </div>

                                <div class="mt-3 form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter description..." required>{{ old('description', $product->description) }}</textarea>
                                </div>

                                <div class="mt-3 text-end">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form><!-- End form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

@include('admin.layouts.partials.footer')

@endsection
