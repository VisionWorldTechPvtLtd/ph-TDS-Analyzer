@extends('layouts.app')

@section('title', 'Live Data')

@section('content')

@include('stp.layouts.partials.header')
@include('stp.layouts.partials.sidebar')

<main id="main" class="main">
    @include('stp.layouts.partials.breadcrums')
    @include('stp.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"> Analyzer Data <span>| all</span></h5>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr class="bg-info text-light">
                                        <th scope="col">S.No</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Serial No</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">COD</th>
                                        <th scope="col">BOD</th>
                                        <th scope="col">TOC</th>
                                        <th scope="col">Turbidity</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">Temperature</th>
                                        <th scope="col">TDS</th>
                                        <th scope="col">EC</th>
                                        <th scope="col">DateTime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($StpData as $pump)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $pump->id }}</td>
                                        <td>{{ $pump->serial_no }}</td>
                                        <td>{{ $pump->title }}</td>
                                        <td>{{ $pump->cod }}</td>
                                        <td>{{ $pump->bod }}</td>
                                        <td>{{ $pump->toc }}</td>
                                        <td>{{ $pump->tss }}</td>
                                        <td>{{ $pump->ph }}</td>
                                        <td>{{ $pump->temperature}}</td>
                                        <td>{{ $pump->h }}</td>
                                        <td>{{ $pump->i }}</td>
                                        @php
                                        $isToday = \Carbon\Carbon::parse($pump->updated_at)->isToday();
                                        @endphp

                                        <td class="{{ $isToday ? 'bg-success text-light' : 'bg-danger text-light' }}">
                                            {{ date('M d Y h:i:s A', strtotime($pump->updated_at)) }}
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('stp.layouts.partials.footer')

@endsection
