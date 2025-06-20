@extends('layouts.app')

@section('title','Daily Borewell Report')

@section('content')

@include('layouts.partials.header')
@include('layouts.partials.sidebar')

<main id="main" class="main">
    @include('layouts.partials.alerts')
    <section class="section dashboard">
        <x-pop-alert />
        <div class="row">
            <div class="mb-4 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Annual Borewell Report</h5>
                        <hr>
                        <form id="monthwise-form" class="row g-3" method="POST" action="{{ route('user.annual-report-data') }}">
                            @csrf
                            <input type="hidden" id="user_id" value="{{ Auth::user()->id }}" />
                            <div class="col-md-4">
                                <div class="mb-3 form-floating">
                                    <select class="form-select" id="pump_id_monthwise" name="pump_id[]" required>
                                        <option value="" data-user="0">Select</option>
                                        @foreach ($pumps as $pump)
                                        <option value="{{ $pump->id }}" data-user="{{ $pump->user->id }}">
                                            {{ $pump->pump_title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('pump_id')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3 form-floating">
                                    <select class="form-control" id="year" name="year" required>
                                        <option value="" disabled selected>Select Year *</option>
                                        @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                        <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                        @endfor
                                    </select>
                                    <label for="year">Year *</label>
                                </div>
                                @error('year')
                                <div class="validation-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-left">
                                <button type="submit" class="btn btn-dark">SEARCH</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Report Display Section -->
        @if (session('report_data'))
        @if (!empty(session('report_data')['piezometer']))
        @foreach (session('report_data')['piezometer'] as $key => $pumpReport)
        <div class="mb-4 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <button class="btn btn-dark me-2" onclick="htmlTableToExcel('xlsx', 'piezometer-report-{{ $key }}')">Excel</button>
                            <button class="btn btn-dark" style="margin-left:-8px;" onclick="htmlTableToPDF('piezometer-report-{{ $key }}')">PDF</button>
                        </div>
                    </h5>
                    <hr>
                    <div class="table-responsive" style="padding-right:125px;">
                        <table class="table table-borderless datatable" id="piezometer-report-{{ $key }}">
                            <thead>
                                <tr>
                                    <th colspan="5" class="p-2">
                                        <h3 class="text-center">{{ Auth::user()->company }}</h3>
                                        <p class="text-center">
                                            {{ session('month') ? date('M Y', strtotime(session('month'))) : '' }}
                                            Report
                                        </p>
                                        <div class="center" style="margin-left: auto; margin-right: auto; text-align: center;">
                                            @if($pumpReport->isNotEmpty())
                                            <img src="{{ asset($pumpReport->first()->profile_pic ?? 'uploads/customers/profile-pics/default-profile.png') }}" alt="Profile Picture" style="width: 125px; height:89px; border-radius: 50%;">
                                            @endif
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">B-ID</th>
                                    <th scope="col">Borewell-Title</th>
                                    <th scope="col">Ground Water Level</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pumpReport as $data)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <th>{{ $data->id }}</th>
                                    <td>{{ $data->pump_title }}</td>
                                    <td>{{ $data->ground_water_level }}</td>
                                    <td>{{ date('M d Y', strtotime($data->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
        @if (!empty(session('report_data')['non_piezometer']))
        @foreach (session('report_data')['non_piezometer'] as $key => $pumpReport)
        <div class="mb-4 col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title" style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <button class="btn btn-dark me-2" onclick="htmlTableToExcel('xlsx', 'non-piezometer-report-{{ $key }}')">Excel</button>
                            <button class="btn btn-dark" style="margin-left:-8px;" onclick="htmlTableToPDF('non-piezometer-report-{{ $key }}')">PDF</button>
                        </div>
                    </h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-borderless datatable" id="non-piezometer-report-{{ $key }}">
                            <thead>
                                <tr>
                                    <th colSpan="8" class="p-4">
                                        <h3 class="text-center">{{ Auth::user()->company }}</h3>
                                        <p class="text-center">
                                            {{ session('month') ? date('M Y', strtotime(session('month'))) : '' }}
                                            Report
                                        </p>
                                        <div class="center" style="margin-left: auto; margin-right: auto; text-align: center;">
                                            @if($pumpReport->isNotEmpty())
                                            <img src="{{ asset($pumpReport->first()->profile_pic ?? 'uploads/customers/profile-pics/default-profile.png') }}" alt="Profile Picture" style="width: 125px; height:89px; border-radius: 50%;">
                                            @endif
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="col">S.No</th>
                                    <th scope="col">B-ID</th>
                                    <th scope="col">FLM S.No</th>
                                    <th scope="col">B-Title</th>
                                    <th scope="col">Consumption(KL)</th>
                                    <th scope="col">RF</th>
                                    <th scope="col">ToT(m3)</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pumpReport as $data)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <th>{{ $data->id }}</th>
                                    <td>{{ $data->serial_no }}</td>
                                    <td>{{ $data->pump_title }}</td>
                                    <td>{{ $data->forward_flow }}</td>
                                    <td>{{ $data->reverse_flow }}</td>
                                    <td>{{ $data->totalizer }}</td>
                                    <td>{{ date('M d Y', strtotime($data->created_at)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
        @endif
    </section>
</main>

@include('layouts.partials.footer')
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
        var data = document.getElementById(id);
        var excelFile = XLSX.utils.table_to_book(data, {
            sheet: "sheet1"
        });
        XLSX.write(excelFile, {
            bookType: type
            , bookSST: true
            , type: 'base64'
        });
        XLSX.writeFile(excelFile, 'ExportedFile:Borewell report.' + type);
    }

</script>
@endsection
