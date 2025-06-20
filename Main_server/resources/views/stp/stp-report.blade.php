@extends('stp.layouts.app')

@section('title', 'Analyzer Monthly Report')

@section('content')

@include('stp.layouts.partials.header')
@include('stp.layouts.partials.sidebar')

<main id="main" class="main">
    @include('stp.layouts.partials.breadcrums')
    @include('stp.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">
            <div class="mb-4 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <hr>
                        <form class="row g-3" method="POST" action="{{ route('stp.stp.report.data') }}">
                            @csrf

                            <input type="hidden" id="user_id" value="{{ Auth::user()->id }}" />
                            <div class="col-md-4">
                                <div class="mb-3 form-floating">
                                    <select class="form-select" id="stp_id" name="stp_id[]" required>
                                        <option value="" data-user="0">Select</option>
                                        @foreach ($stps as $stp)
                                        <option value="{{ $stp->id }}" data-user="{{ $stp->user_id }}">
                                            {{ $stp->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="stp_id">  Analyzer</label>
                                </div>
                                @error('stp_id')
                                <div class="validation-error text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3 form-floating">
                                    <input class="form-control" id="month" type="month" name="month" required />
                                    <label for="month">Month *</label>
                                </div>
                                @error('month')
                                <div class="validation-error text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-left">
                                <button type="submit" class="btn btn-dark">SEARCH</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @php
            $report_data = session('report_data');
            @endphp

            @if($report_data && count($report_data) > 0)
            <div class="mb-4 col-lg-12">
                <div class="card">
                    <h5 class="px-3 pt-3 card-title d-flex justify-content-between align-items-center">
                        <div>
                            <button class="btn btn-dark me-2" onclick="htmlTableToExcel('xlsx', 'stp-report')">Excel</button>
                            <button class="btn btn-dark" onclick="htmlTableToPDF('stp-report')">PDF</button>
                        </div>
                    </h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-borderless datatable" id="stp-report">
                            <thead>
                                @if($report_data && $report_data->isNotEmpty())
                                <tr>
                                    <th colspan="13" class="p-2">
                                        <div style="text-align: center;">
                                            <h3 style="margin: 0;">{{ Auth::user()->company }}</h3><br>
                                            <p style="margin: 0;">
                                                {{ session('month') ? date('M Y', strtotime(session('month'))) : '' }} Report
                                            </p><br>
                                            <div style="margin-bottom: 10px;">
                                                <img src="{{ asset($report_data->first()->profile_pic ?? 'uploads/customers/profile-pics/default-profile.png') }}" alt="Profile Picture" style="width: 125px; height: 89px; border-radius: 50%; object-fit: cover;">
                                            </div><br>
                                        </div>
                                    </th>
                                </tr>
                                @endif
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">STP ID</th>
                                    <th scope="col">FLM S.No</th>
                                    <th scope="col">S-Title</th>
                                    <th scope="col">COD</th>
                                    <th scope="col">BOD</th>
                                    <th scope="col">TOC</th>
                                    <th scope="col">Turbidity</th>
                                    <th scope="col">PH</th>
                                    <th scope="col">Temperature</th>
                                    <th scope="col">TDS</th>
                                    <th scope="col">EC</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($report_data as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->id }}</td>
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
                                    <td>{{ date('M d Y', strtotime($data->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
        </div>
    </section>
</main>

@include('stp.layouts.partials.footer')

{{-- Required Scripts --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    async function htmlTableToPDF(id) {
        const {
            jsPDF
        } = window.jspdf;
        const table = document.getElementById(id);
        html2canvas(table, {
            scale: 1, // Lower scale for smaller resolution (default is 2, you can reduce it further)
            logging: false, // Disable logging for better performance
            useCORS: true, // Ensure cross-origin images are handled
            width: table.offsetWidth
            , height: table.offsetHeight
        }).then(canvas => {
            const pdf = new jsPDF('p', 'mm', 'a4');
            const imgData = canvas.toDataURL('image/jpeg', 0.5); // Use JPEG with a quality of 0.5 (you can adjust this)
            const pageWidth = pdf.internal.pageSize.getWidth();
            const pageHeight = pdf.internal.pageSize.getHeight();
            const imgWidth = pageWidth;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;

            let y = 0;
            if (imgHeight <= pageHeight) {
                pdf.addImage(imgData, 'JPEG', 0, y, imgWidth, imgHeight);
            } else {
                while (y < imgHeight) {
                    pdf.addImage(imgData, 'JPEG', 0, -y, imgWidth, imgHeight);
                    y += pageHeight;
                    if (y < imgHeight) pdf.addPage();
                }
            }
            pdf.save(`${id}.pdf`);
        });
    }

    function htmlTableToExcel(type, id) {
        const data = document.getElementById(id);
        const wb = XLSX.utils.table_to_book(data, {
            sheet: "STP Report"
        });
        XLSX.writeFile(wb, `STP_Report.${type}`);
    }

</script>

@endsection
