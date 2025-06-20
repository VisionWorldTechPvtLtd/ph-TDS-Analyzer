<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.index') active @endif" href="{{ route('stp.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.pumps') active @endif" href="{{ route('stp.stppump') }}">
                <i class="bi bi-droplet-half"></i>
                <span>Analyzer</span>
            </a>
        </li><!-- End Pumps Nav -->


        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.data')) active @endif" href="{{ route('stp.stp.data') }}">
                <i class="bi bi-file-bar-graph"></i>
                <span>Data</span>
            </a>
        </li><!-- End Customer Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed @if(in_array(Route::currentroutename(), ['user.pump.report','reports.single.pumps.index'])) active @endif" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-file-earmark-spreadsheet"></i>
                <span>Reports</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="reports-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('stp.stpdailyreport') }}">
                        <i class="bi bi-calendar3 text-primary"></i>
                        <span>Range</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('stp.report') }}">
                        <i class="bi bi-calendar3 text-primary"></i>
                        <span>Monthly</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('stp.annualstpreport') }}">
                        <i class="bi bi-calendar3 text-primary"></i>
                        <span>Annual</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.data')) active @endif" href="{{ route('stp.contact') }}">
                <i class="bi bi-person-lines-fill"></i>
                <span>Contact_Us</span>
            </a>
        </li><!-- End Customer Nav -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('stp.logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
            <form id="logout" action="{{ route('stp.logout') }}" method="GET" class="d-none">
                @csrf
            </form>
        </li>
    </ul>

</aside><!-- End Sidebar-->
