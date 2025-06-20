@extends('admin.layouts.app')
@section('title', 'Alerts')
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
                    <div class="card-body">
                        <a href="{{ route('product.create') }}" class="mt-2 mb-3 btn btn-secondary">Product ++</a>
                        <br>

                        <div class=" table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="text-light bg-info">
                                        <th scope="col">S.No</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">URL</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($product && $product->count())
                                    @foreach ($product as $item)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $item->product_name }}</td>

                                        @php
                                        $words = explode(' ', $item->description);
                                        $chunks = array_chunk($words, 8);
                                        @endphp
                                        <td>
                                            @foreach ($chunks as $chunk)
                                            {{ implode(' ', $chunk) }}<br>
                                            @endforeach
                                        </td>

                                        <td>
                                            <img src="{{ asset($item->image) }}" class="rounded" width="50" />
                                        </td>

                                        <td>{{ $item->url }}</td>

                                        <td class="action">
                                            <a href="{{ route('product.edit',$item->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form method="POST" action="{{ route('product.destroy',$item->id) }}" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6" class="text-center">No products found.</td>
                                    </tr>
                                    @endif
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
