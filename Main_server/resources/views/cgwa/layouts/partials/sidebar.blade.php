<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.index') active @endif" href="{{ route('cgwa.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.index') active @endif" href="{{ route('cgwa.cgwacustomer') }}">
                <i class="bi bi-person-badge"></i>
                <span>Customers</span>
            </a><!-- End Customer Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed @if(in_array(Route::currentroutename(), ['pumps.index', 'pumps.create', 'pumps.edit', 'pumps.show'])) active @endif" data-bs-target="#data-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-droplet-half"></i>
                <span>Data </span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="data-nav" class="nav-content collapse " data-bs-parent="#borewell-nav">
                <li>
                    <a href="{{ route('cgwa.livedata') }}">
                        <i class="bi bi-droplet"></i>
                        <span>Live Data</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cgwa.offline') }}">
                        <i class="bi bi-dice-1"></i>
                        <span>Offline</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cgwa.negative') }}">
                        <i class="bi bi-dice-1"></i>
                        <span>Negative</span>
                    </a>
                </li>
            </ul>
        </li>



        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.index') active @endif" href="{{ route('cgwa.pumpReport') }}">
                <i class="bi bi-file-earmark-spreadsheet"></i>
                <span>Reports</span>
            </a><!-- End Customer Nav -->



        <li class="nav-item">
            <a class="nav-link @if(Route::currentroutename() == 'user.data')) active @endif" href="{{ route('cgwa.overflow') }}">
                <i class="bi bi-stack-overflow"></i>
                <span>OverFlow</span>
            </a>
        </li><!-- End Contact Nav -->

        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('cgwa-logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
        </a>
        <form id="cgwa-logout-form" action="{{ route('cgwa.logout') }}" method="GET" class="d-none">
            @csrf
        </form>
        </li>
    </ul>

</aside><!-- End Sidebar-->
