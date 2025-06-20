@extends('admin.layouts.app')

@section('title', 'STP')

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
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('stps.create') }}">
                            <i class="bi bi-plus"></i> STP
                        </a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"> STPs <span>| all</span></h5>
                        <hr>
                        <div class=" table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="text-light bg-secondary">
                                        <th scope="col">S.No</th>
                                        <th scope="col">STP ID</th>
                                        <th scope="col">FLM S.No</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Plan</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($stps)
                                        @foreach ($stps as $stp)
                                            <tr>
                                                <th scope="row">{{ $loop->index + 1 }}</th>
                                                <th>{{ $stp->id }}</th>
                                                <td>{{ $stp->serial_no }}</td>
                                                <td>{{ $stp->title }}</td>
                                                <td>{{ $stp->user->first_name }} {{ $stp->user->last_name }}</td>
                                                <td>{{ $stp->plan->title }} ({{ $stp->plan->duration }} Months)</td>
                                                <td>
                                                    @if ($stp->plan_status)
                                                        <span class="badge bg-danger">Expired</span>
                                                    @else
                                                        <span class="badge bg-success">On-Going</span>
                                                    @endif

                                                    @if ($stp->tested)
                                                        <span class="badge bg-success">Tested</span>
                                                    @else
                                                        <span class="badge bg-danger">Un-Tested</span>
                                                    @endif

                                                </td>
                                                <td class="action">
                                                    <a href="{{ route('stps.show', $stp->id) }}" class="btn btn-info btn-sm">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </a>
                                                    <a href="{{ route('stps.edit', $stp->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form method="post" id="delete-form" action="{{ route('stps.destroy', $stp->id) }}">
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
