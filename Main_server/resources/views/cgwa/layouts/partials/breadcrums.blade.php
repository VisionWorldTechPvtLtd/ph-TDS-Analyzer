<div class="pagetitle">
    <h1>@yield('title')</h1>
    @if (Route::currentroutename() != 'dashboard.index')
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">@yield('title')</li>
            </ol>
        </nav>
    @endif
    
  </div><!-- End Page Title -->