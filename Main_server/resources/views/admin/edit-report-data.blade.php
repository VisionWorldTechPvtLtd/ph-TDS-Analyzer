@extends('admin.layouts.app')

@section('title', 'Edit Report Data')

@section('content')
@include('admin.layouts.partials.header')
@include('admin.layouts.partials.sidebar')

<main id="main" class="main">
    @include('admin.layouts.partials.breadcrums')
    @include('admin.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">
            <div class="mb-4 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><span>{{ $startDate->format('F Y') }}</span></h5>
                        <hr>
                        <form class="row g-3" method="POST" action="{{ route('reports.data.update', $pump_id) }}">
                            @csrf
                            @method('PUT')
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Forward Flow</th>
                                            <th>Reverse Flow</th>
                                            <th>Totalizer</th>
                                            <th>Ground Water Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($monthlyData as $data)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</td>
                                            <td>
                                                <input class="form-control" type="text" name="forward_flow[{{ $data->id }}]" value="{{ old('forward_flow.' . $data->id, $data->forward_flow) }}" />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="reverse_flow[{{ $data->id }}]" value="{{ old('reverse_flow.' . $data->id, $data->reverse_flow) }}" />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="totalizer[{{ $data->id }}]" value="{{ old('totalizer.' . $data->id, $data->totalizer) }}" />
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" name="ground_water_level[{{ $data->id }}]" value="{{ old('ground_water_level.' . $data->id, $data->ground_water_level) }}" />
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <hr>
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('admin.layouts.partials.footer')
@endsection
