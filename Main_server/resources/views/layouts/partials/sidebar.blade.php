<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.index') active @endif" href="{{ route('user.index') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.pumps') active @endif" href="{{ route('user.pumps') }}">
                <i class="bi bi-droplet-half"></i>
                <span>Borewell</span>
            </a>
        </li><!-- End Pumps Nav -->


        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.data')) active @endif" href="{{ route('user.data') }}">
                <i class="bi bi-file-bar-graph"></i>
                <span>Live Data</span>
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
                    <a href="{{ route('user.datewisereport') }}">
                        <i class="bi bi-calendar3 text-primary"></i>
                        <span>Daily</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.pump.report') }}">
                        <i class="bi bi-calendar3 text-primary"></i>
                        <span>Monthly</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.annual') }}">
                        <i class="bi bi-calendar3 text-primary"></i>
                        <span>Annual</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.data')) active @endif" href="{{ route('user.contact') }}">
                <i class="bi bi-person-lines-fill"></i>
                <span>Contact_Us</span>
            </a>
        </li><!-- End Customer Nav -->

        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li><!-- End Customer Nav -->



    </ul>

</aside><!-- End Sidebar-->
