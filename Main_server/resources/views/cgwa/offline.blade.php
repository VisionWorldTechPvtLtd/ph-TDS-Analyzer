@php use Carbon\Carbon; @endphp

@extends('cgwa.layouts.app')

@section('title', 'Offline Data')

@section('content')

@include('cgwa.layouts.partials.header')
@include('cgwa.layouts.partials.sidebar')

<main id="main" class="main">

    @include('cgwa.layouts.partials.breadcrums')
    @include('cgwa.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Offline Data <span>| All</span></h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-borderless datatable" id="report">
                                <thead>
                                    <tr class="bg-info text-light">
                                        <th>S.No</th>
                                        <th>User</th>
                                        <th>Company</th>
                                        <th>B-ID</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $index = 1; @endphp
                                    @foreach ($pumpData as $userId => $userPumps)
                                    @php
                                    $firstPump = $userPumps->first(); // For user info
                                    $pumpIds = $userPumps->pluck('pump_id')->map(fn($id) => (string)$id)->toArray();
                                    @endphp
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $firstPump->first_name }}</td>
                                        <td>{{ $firstPump->company }}</td>
                                        <td>[{{ implode(', ', $pumpIds) }}]</td>
                                        <td>
                                            <a href="{{ route('cgwa.emailoffline', ['user' => $userId]) }}" class="btn btn-primary btn-sm" onclick="event.preventDefault(); confirmSendEmail(this);">
                                                Email
                                            </a>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmSendEmail(element) {
        const url = element.getAttribute('href');

        Swal.fire({
            title: 'Are you sure?'
            , text: "Do you want to send the offline email now?"
            , icon: 'question'
            , showCancelButton: true
            , confirmButtonText: 'Yes'
            , cancelButtonText: 'No'
            , confirmButtonColor: '#3085d6'
            , cancelButtonColor: '#d33'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url; // proceed to send email
            }
        });
    }

    // Show result after redirect
    @if(session('success'))
    Swal.fire({
        icon: 'success'
        , title: 'Success!'
        , text: '{{ session('
        success ') }}'
    , });
    @elseif(session('warning'))
    Swal.fire({
        icon: 'info'
        , title: 'No Offline Pumps'
        , text: '{{ session('
        warning ') }}'
    , });
    @endif

</script>

@include('cgwa.layouts.partials.footer')

@endsection
