@section('Nav Menu')
<a class="nav-link" href="{{ route('jobs.index') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
    Dashboard
</a>
<a class="nav-link" href="{{ route('qualifications.index') }}">
    Qualifications
</a>
    <div class="sb-sidenav-menu-heading">Addons</div>
    <a class="nav-link" href="report.php">
        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
        Statistics
    </a>
@endsection