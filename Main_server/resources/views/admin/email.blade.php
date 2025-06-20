<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if ($flowLimitPercentage < 100) <div style="font-weight: bold; font-size: 14px;color:blue;">
                        *Your Borewell Flow Limit is {{ number_format($flowLimitPercentage, 2) }}% Completed!*
                </div>
                @else
                <div style="font-weight: bold; font-size: 14px; color: red;">
                    Your Borewell Flow Limit is Overflow!
                </div>
                @endif
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Company Name</th>
                                <th>Borewell Name</th>
                                <th>Address</th>
                                <th>Today Flow</th>
                                <th>GWL (M)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pumps as $index => $pump)
                            <tr>
                                <th>{{ $index + 1 }}</th>
                                <td><strong>&nbsp;&nbsp;{{ $pump['company'] }}&nbsp;&nbsp;</strong></td>
                                {{-- <td><strong>{{ $pump['company'] }}</strong></td> --}}
                                <td>{{ $pump['pump_title'] }}</td>
                                <td>{{ $pump['address'] }}</td>
                                <td style="color: blue; text-align: center;">{{ number_format($pump['today_flow'], 2) }}</td>
                                <td style="text-align: center;">{{ $pump['ground_water_level'] }}</td>
                                <td style="text-align: center;">
                                    @if (isset($pump['flow_status']) && $pump['flow_status'] === 'online')
                                    <span style="color:green; font-weight: bold;">Online</span>
                                    @else
                                    <span style="color:red; font-weight: bold;">Offline</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="text-align: center;">No data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div style="text-align:right; font-weight: bold; font-size: 18px;">
                        <hr>
                        Total Flow: {{ number_format($totalFlow ,2) }}
                    </div>
                    <div class="col-md-4">
                        <p style="font-size: 18px;"><strong>Thanks & Regards</strong></p>
                        <p style="color:rgb(5, 104, 252); font-size: 16px;">
                            Vision World Tech Pvt. Ltd Jaipur Rajasthan.
                        </p>
                        <p><i class="fa-regular fa-envelope"></i> <strong>Email:</strong> admin@visionworldtech.com</p>
                        <p><strong>Website:</strong> www.visionworldtech.com</p>
                        <p><strong>Address:</strong> A-15 Jai Ambey Nagar in front of Jaipur Hospital Tonk Road Jaipur Rajasthan 302018</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
