@extends('admin.layouts.app')

@section('title', 'Plans')

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
                    <div class="filter  mr-4">
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('plans.create') }}">
                            <i class="bi bi-plus"></i> Plan
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"> Plans <span>| all</span></h5>
                        <hr>
                        <div class=" table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Price (Rs.)</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($plans)
                                        @foreach ($plans as $plan)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <td>{{ $plan->title }}</td>
                                                <td>{{ $plan->price }}/- </td>
                                                <td>{{ $plan->duration }} Months </td>
                                                <td>{{ date('M d Y', strtotime($plan->created_at)) }}</td>
                                                <td>
                                                    @if ($plan->status)
                                                        <span class="badge bg-danger">Not Visiable</span>
                                                    @else
                                                        <span class="badge bg-success">Visiable</span>
                                                    @endif

                                                </td>
                                                <td class="action">
                                                    <a href="{{ route('plans.show', $plan->id) }}" class="btn btn-info btn-sm">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </a>
                                                    <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form method="post" id="delete-form" action="{{ route('plans.destroy', $plan->id) }}">
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
