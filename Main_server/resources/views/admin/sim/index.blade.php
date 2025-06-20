@extends('admin.layouts.app')

@section('title', 'Sim')

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
                            <a class="btn btn-outline-primary btn-sm" href="{{route('sim.create')}}">
                                <i class="bi bi-pencil-square"></i> Attach Sim
                            </a>
                        </div>
                        <div class="filter mr-4"></div>
                        <div class="card-body">
                            <h5 class="card-title"> Sim <span>| all</span></h5>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr class="text-light bg-secondary">
                                            <th scope="col">S.No</th>
                                            <th scope="col">B-Id</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">Company</th>
                                            <th scope="col">Sim Number </th>
                                            <th scope="col">Sim Purchase</th>
                                            <th scope="col">Sim Start Date</th>
                                            <th scope="col">Sim End Date</th>
                                            <th scope="col"></th>
                                            <th scope="col">Action</th>

                                    </thead>
                                    <tbody>
                                        @if ($sims)
                                            @foreach ($sims as $sim)
                                                <tr>
                                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                                    <td>{{ $sim->pump_id }}</td>
                                                    <td>{{ $sim->first_name }} {{$sim->last_name}} </td>
                                                    <td>{{ $sim->company }}</td>
                                                    <td>{{ $sim->sim_number }} </td>
                                                    <td>{{ date('M d Y', strtotime($sim->sim_purchase)) }}</td>
                                                    <td>{{ date('M d Y', strtotime($sim->sim_start)) }}</td>
                                                    <td>{{ date('M d Y', strtotime($sim->sim_end)) }}</td>
                                                    <td>
                                                    </td>
                                                    <td class="action">
                                                        <a href="{{ route('sim.edit', $sim->id)}}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <a href="{{route('sim.show',$sim->id)}}"
                                                        class="btn btn-info btn-sm">
                                                            <i class="bi bi-eye-fill"></i>
                                                        </a>
                                                        <form method="post" id="delete-form" action="{{ route('sim.destroy', $sim->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                            <a href="{{route('deattach',$sim->id)}}" class="btn btn-secondary btn-sm">
                                                                <i class="bi bi-radioactive"></i>
                                                            </a>
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
