@extends('admin.layouts.app')

@section('title', 'STP Report')

@section('content')

@include('admin.layouts.partials.header')


@include('admin.layouts.partials.sidebar')


<main id="main" class="main">

    @include('admin.layouts.partials.breadcrums')

    @include('admin.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12 mb-4">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">STP Report</h5>
                        <hr>
                        <!-- Floating Labels Form -->
                        <form class="row g-3" method="POST" action="{{ route('stp.report.data') }}">
                            @csrf
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="user_id" aria-label="Customer" name="user_id">
                                        <option value="">Customer </option>
                                        @if($customers)
                                        @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <label for="user_id">Customer *</label>
                                </div>
                                @error('user_id')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="stp_id" aria-label="Customer" name="stp_id[]">
                                        <option value="" data-user="0">STP </option>
                                        @if($stps)
                                        @foreach ($stps as $stp)
                                        <option value="{{ $stp->id }}" data-user="{{ $stp->user->id}}">{{ $stp->title }} </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <label for="stp_id">STP *</label>
                                </div>
                                @error('stp_id')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input class="form-select" id="from" type="date" name="from" />
                                    <label for="from">From *</label>
                                </div>
                                @error('from')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating mb-3">
                                    <input class="form-select" id="to" type="date" name="to" />
                                    <label for="to">To *</label>
                                </div>
                                @error('to')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form><!-- End floating Labels Form -->

                    </div>

                </div>

            </div><!-- End Left side columns -->

            <!-- Left side columns -->
            <div class="col-lg-12 mb-4">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Report Data<span> | single</span></h5>
                        <hr>

                        <div class="table-responsive">
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">STP ID</th>
                                        <th scope="col">FLM S.No</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">COD</th>
                                        <th scope="col">BOD</th>
                                        <th scope="col">TOC</th>
                                        <th scope="col">TSS</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">Temperature</th>
                                        <th scope="col">I</th>
                                        <th scope="col">H</th>
                                        <th scope="col">Date</th>
                                        {{-- <th scope="col">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(session('report_data'))
                                    @foreach (session('report_data') as $data)
                                    <tr>
                                        <th scope="row">{{ $loop->index + 1 }}</th>
                                        <td>{{ $data->first_name }} {{ $data->last_name }}</td>
                                        <th>{{ $data->id }}</th>
                                        <td>{{ $data->serial_no }}</td>
                                        <td>{{ $data->title }}</td>
                                        <td>{{ $data->cod }}</td>
                                        <td>{{ $data->bod }}</td>
                                        <td>{{ $data->toc }}</td>
                                        <td>{{ $data->tss }}</td>
                                        <td>{{ $data->ph }}</td>
                                        <td>{{ $data->temperature }}</td>
                                        <td>{{ $data->i }}</td>
                                        <td>{{ $data->h }}</td>
                                        <td>{{ date('M d Y h:i:s A', strtotime($data->created_at)) }}</td>

                                        {{-- <td class="action">
                                                    <a href="{{ route('reports.data.edit', $data->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                        </a>
                                        </td> --}}
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

<script>
    let customerElement = document.querySelector('#user_id');
    let stpElement = document.querySelector('#stp_id');
    stpElement.querySelectorAll('option').forEach(option => option.style.display = 'none');
    customerElement.addEventListener('change', function() {
        document.querySelector('#stp_id').options[0].selected = true;
        stpElement.querySelectorAll('option').forEach(option => {
            if (customerElement.value === option.dataset.user) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
    });

</script>

@endsection
