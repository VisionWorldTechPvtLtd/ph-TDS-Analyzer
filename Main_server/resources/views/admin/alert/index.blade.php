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
                      <a href="{{ route('alert.create') }}" class="mt-2 mb-3 btn btn-secondary">Alert ++</a>
                        <br>
                        
                        <div class=" table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="text-light bg-info">
                                        <th scope="col">S.No</th>
                                        <th scope="col">Alert Message</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($alert)
                                    @foreach ($alert as $alerts)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        @php
                                        $words = explode(' ', $alerts->alert);
                                        $chunks = array_chunk($words, 8);
                                        @endphp
                                        <td>
                                            @foreach ($chunks as $chunk)
                                            {{ implode(' ', $chunk) }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $alerts->disable == 1 ? 'Enable' : 'Disable' }}</td>
                                        <td class="action">
                                            <a href="{{ route('alert.edit', $alerts->id) }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form method="post" id="delete-form" action="{{ route('alert.destroy', $alerts->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
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
