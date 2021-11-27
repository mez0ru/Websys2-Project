<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Demo to for creating job posts" />
        <meta name="author" content="Al-washali, Hamzah" />
        <title>@yield('title', 'default')</title>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/all.min.js') }}" crossorigin="anonymous"></script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
            <a class="navbar-brand" href="{{ route('jobs') }}">UB Job Hiring System</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <div class="d-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group d-none" id="searchBar">
                    <input class="form-control" type="text" placeholder="Search jobs..." aria-label="Search" id="searchInput" aria-describedby="basic-addon2" value="<?php echo (isset($_GET['search']) ? $_GET['search'] : ''); ?>"/>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="searchBtn"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#!" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
               
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    @auth
                    <a class="dropdown-item" href="{{ route('dashboard') }}">Profile Settings</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item"
                    >{{ __('Logout') }}</a>
                    @endauth
                    @guest
                    <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                    <a class="dropdown-item" href={{ route('login') }}>Login</a>
                    @endguest
                    <!-- <a class="dropdown-item" href="#!">Activity Log</a> -->
                    <!-- <div class="dropdown-divider"></div> -->
                </div> </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            @includeWhen(Auth::guest() || Auth::user()->role == Roles::CANDIDATE,'layouts.candidate_nav')
                            @includeWhen(Auth::check() && Auth::user()->role == Roles::HIRER, 'layouts.hirer_nav')
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as: 
                        @guest
                            {{ 'Guest' }}
                        @endguest
                        @auth
                        @switch(Auth::user()->role)
                            @case(Roles::HIRER)
                            {{ 'Hirer' }}
                            @break
                            @case(Roles::CANDIDATE)
                                {{ 'Candidate' }}
                            @break
                            @default
                                {{ 'Guest' }}
                        @endswitch
                        @endauth</div>
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2021</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>

        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{ asset('js/Chart.min.js') }}"></script>
    </body>
</html>
