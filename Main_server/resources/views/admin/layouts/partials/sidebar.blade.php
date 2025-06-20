<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'dashboard.index') active @endif" href="{{ route('dashboard.index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link @if(in_array(Route::currentRouteName(), ['customers.index', 'customers.create', 'customers.edit', 'customers.show'])) active @endif" data-bs-toggle="collapse" href="#customers-nav" aria-expanded="false">
                <i class="bi bi-person-badge"></i>
                <span>Customers</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="customers-nav" class="nav-content collapse">
                <li>
                    <a href="{{ route('customers.index') }}" class="nav-link">
                        <i class="bi bi-pass-fill"></i>
                        <span> All Customers </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customers.create') }}" class="nav-link">
                        <i class="bi bi-file-plus"></i>
                        <span> Add Customer</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed @if(in_array(Route::currentroutename(), ['pumps.index', 'pumps.create', 'pumps.edit', 'pumps.show'])) active @endif" data-bs-target="#borewell-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-droplet-half"></i>
                <span>Borewell Data </span>
                <i class="bi bi-chevron-down ms-auto"></i>

            </a>
            <ul id="borewell-nav" class="nav-content collapse " data-bs-parent="#borewell-nav">
                <li>
                    <a href="{{ route('pumps.index') }}">
                        <i class="bi bi-droplet"></i>
                        <span>All Borewell </span>

                    </a>
                </li>
                <li>
                    <a href="{{route('pumps.piezometer')}}">
                        <i class="bi bi-thermometer-high"></i>
                        <span>Piezometer</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('pumps.flowmeter')}}">
                        <i class="bi bi-speedometer"></i>
                        <span>Flowmeter</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pumps.create') }}">
                        <i class="bi bi-file-plus"></i>
                        <span>Add Borewell</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pump.data') }}">
                        <i class="bi bi-dice-1"></i>
                        <span> Live Data </span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link @if(in_array(Route::currentRouteName(), ['stps.index', 'stps.create', 'stps.edit', 'stps.show'])) active @endif" href="#" data-bs-toggle="collapse" data-bs-target="#stp-nav" aria-expanded="false" aria-controls="stp-nav">
                <i class="bi bi-droplet-half"></i>
                <span>STP</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="stp-nav" class="nav-content collapse @if(in_array(Route::currentRouteName(), ['stps.index', 'stps.create', 'stps.edit', 'stps.show'])) show @endif">
                <li>
                    <a href="{{ route('stps.index') }}">
                        <i class="bi bi-droplet"></i>
                        <span>All STP</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('stps.create') }}">
                        <i class="bi bi-file-plus"></i>
                        <span>Add STP</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('stp.data') }}">
                        <i class="bi bi-dice-6"></i>
                        <span>STP Live </span>
                    </a>
                </li>
            </ul> <!-- End nav-content -->
        </li> <!-- End nav-item -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#documents-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-book"></i>
                <span>Status</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="documents-nav" class="nav-content collapse " data-bs-parent="#documents-nav">
                <li>
                    <a href="{{route('admin.planend')}}">
                        <i class="bi bi-calendar-date"></i>
                        <span>Plan /SIM</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.nable') }}">
                        <i class="bi bi-pass-fill"></i>
                        <span> NABL </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.amc_cmc')}}">
                        <i class="bi bi-bar-chart"></i>
                        <span>AMC\CMC</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#sim-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-sim"></i>
                <span>SIM </span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="sim-nav" class="nav-content collapse " data-bs-parent="#sim-nav">
                <li>
                    <a href="{{route('sim.index')}}">
                        <i class="bi bi-sim"></i>
                        <span>Create Sim</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('viewindex')}}">
                        <i class="bi bi-sim"></i>
                        <span> Update Sim Plan </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('sim.create')}}">
                        <i class="bi bi-sim"></i>
                        <span>Attach Sim </span>
                    </a>
                </li>
                <li>
                    <a href="{{route('report')}}">
                        <i class="bi bi-bar-chart"></i>
                        <span>Sim Report </span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed @if(in_array(Route::currentroutename(), ['pump.repport.index','stp.report.index'])) active @endif" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-earmark-spreadsheet"></i>
                <span>Reports</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="reports-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('pump.report.index') }}">
                        <i class="bi bi-dice-1"></i>
                        <span>Borewell Report</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('stp.report.index') }}">
                        <i class="bi bi-dice-6"></i>
                        <span>STP Report</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.setting') }}">
                <i class="bi bi-gear"></i>
                <span>Setting</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
        </li><!-- End Customer Nav -->



    </ul>

</aside><!-- End Sidebar-->
