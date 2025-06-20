@extends('stp.layouts.app')

@section('title', 'Analyzer Daily Report')

@section('content')

@include('stp.layouts.partials.header')
@include('stp.layouts.partials.sidebar')

<main id="main" class="main">

    @include('stp.layouts.partials.breadcrums')
    @include('stp.layouts.partials.alerts')

    <section class="section dashboard">
        <div class="row">
            <!-- Form to Filter STP Data -->
            <div class="mb-4 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Analyzer Report</h5>
                        <hr>
                        <!-- Form for STP Report -->
                        <form class="row g-3" method="POST" action="{{ route('stp.stp.stpdailyreport') }}">
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
                                    <label for="stp_id">Select Analyzer *</label>
                                </div>
                                @error('stp_id')
                                <div class="validation-error text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 form-floating">
                                    <input class="form-select" id="from" type="date" name="from" required onchange="updateToDate()" />
                                    <label for="from">From *</label>
                                </div>
                                @error('from')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 form-floating">
                                    <input class="form-select" id="to" type="date" name="to" required />
                                    <label for="to">To *</label>
                                </div>
                                @error('to')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            <div class="text-left">
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Display Report Data -->
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
                                                @if(session('from_date') && session('to_date')) Report
                                                <p>{{ \Carbon\Carbon::parse(session('from_date'))->format('d M Y') }} - {{ \Carbon\Carbon::parse(session('to_date'))->format('d M Y') }}</p>
                                                @endif
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
                                @foreach (session('report_data') as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->serial_no }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->cod }}</td>
                                    <td>{{ $row->bod }}</td>
                                    <td>{{ $row->toc }}</td>
                                    <td>{{ $row->tss }}</td>
                                    <td>{{ $row->ph }}</td>
                                    <td>{{ $row->temperature }}</td>
                                    <td>{{ $row->tds }}</td>
                                    <td>{{ $row->ec }}</td>
                                    <td>{{ date('M d Y', strtotime($row->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
        </div>

        </div>
    </section>

</main><!-- End #main -->

@include('stp.layouts.partials.footer')
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
